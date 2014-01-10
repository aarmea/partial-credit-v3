<?
// This script sets up the database and required tables for the site. For
// production use, it is highly recommended to delete this file after
// installation.
require_once('vendor/autoload.php');
require_once('php/api_calls/rpi_directory_app.php');
require_once('php/auth/cas_init.php');
require_once('php/db/config.php');

phpCAS::forceAuthentication();
$rcsid = phpCAS::getUser();
echo "<html><pre>";
echo "Successfully authenticated initial admin user $rcsid\n";

try {
  // Connect to the database server and create the database
  $dbh = new PDO("mysql:host=$DB_HOST", $DB_USERNAME, $DB_PASSWORD);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Successfully connected to the database server\n";

  $dbh->exec(
    "CREATE DATABASE if not exists `$DB_NAME`
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;"
  );
} catch (PDOException $e) {
  die("Database error:\n". $e->getMessage());
}

try {
  $sql = "USE $DB_NAME";
  $dbh->exec($sql);
  echo "Successfully created database $DB_NAME\n";

  // Create the members table
  $sql = "CREATE TABLE IF NOT EXISTS `members` (
    `rcsid` VARCHAR(10) NOT NULL,
    `is_admin` BOOLEAN NOT NULL DEFAULT FALSE,
    `first_name` VARCHAR(64) NOT NULL,
    `full_name` VARCHAR(64) NOT NULL,
    `nickname` VARCHAR(64),
    `voice_part` VARCHAR(10),
    `major` VARCHAR(64),
    `yog` YEAR,
    `bio` TEXT(1024),
    PRIMARY KEY (`rcsid`)
  ) ENGINE=InnoDB;";
  $dbh->exec($sql);
  echo "Successfully created the members table\n";

  // Create the photos table
  // `uploader_rcsid` is not a FOREIGN KEY because we don't want to delete
  // pictures that a graduating member uploaded
  $sql = "CREATE TABLE IF NOT EXISTS `photos` (
    `photo_id` INT NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(24) NOT NULL,
    `uploader_rcsid` VARCHAR(10) NOT NULL,
    `date_uploaded` DATETIME NOT NULL,
    `caption` VARCHAR(1024),
    PRIMARY KEY(`photo_id`)
  ) ENGINE=InnoDB;";
  $dbh->exec($sql);
  echo "Successfully created the photos table\n";

  // Create the news articles table
  // `author_rcsid` is not a FOREIGN KEY because we don't want to delete
  // articles that a graduating member wrote
  // `text` is Markdown formatted text
  $sql = "CREATE TABLE IF NOT EXISTS `articles` (
    `article_id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(128) NOT NULL,
    `date_written` DATETIME NOT NULL,
    `author_rcsid` VARCHAR(10) NOT NULL,
    `author_full_name` VARCHAR(64) NOT NULL,
    `photo_filename` VARCHAR(24),
    `text` TEXT NOT NULL,
    PRIMARY KEY(`article_id`)
  ) ENGINE=InnoDB;";
  $dbh->exec($sql);
  echo "Successfully created the articles table\n";

  // Create the initial administrator user
  $adminUserInfo = getUserFromDirectory($rcsid);
  if (!$adminUserInfo) {
    $adminUserInfo = new stdClass();
    $adminUserInfo->{'rcsid'} = $rcsid;
    $adminUserInfo->{'first_name'} = 'unknown';
    $adminUserInfo->{'name'} = 'Unknown RPI student';
    $adminUserInfo->{'major'} = '';
    $adminUserInfo->{'year'} = '';
  }
  $createAdmin = $dbh->prepare(
    "INSERT INTO `members`(
      `rcsid`, `is_admin`, `first_name`, `full_name`, `major`, `yog`
    ) VALUES (
      :rcsid, TRUE, :first_name, :full_name, :major, :yog
    );"
  );
  $createAdmin->execute(array(
    ":rcsid" => $adminUserInfo->rcsid,
    ":first_name" => ucwords($adminUserInfo->first_name),
    ":full_name" => $adminUserInfo->name,
    ":major" => ucwords($adminUserInfo->major),
    ":yog" => getYogFromClass($adminUserInfo->year)
  ));
  echo "Successfully created administrative user $rcsid\n";
} catch (PDOException $e) {
  die("Database error:\n" . $e->getMessage());
}

echo "Installation succeeded.";
?>
