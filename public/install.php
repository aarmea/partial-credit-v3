<?
// This script sets up the database and required tables for the site. For
// production use, it is highly recommended to delete this file after
// installation.
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
    `major` VARCHAR(64),
    `yog` YEAR,
    `photo_url` VARCHAR(64),
    PRIMARY KEY (`rcsid`)
  ) ENGINE=InnoDB;";
  $dbh->exec($sql);
  echo "Successfully created the members table\n";

  // Create the initial administrator user
  $adminUserInfo = getUserFromDirectory($rcsid);
  if (!$adminUserInfo) {
    die("User $rcsid does not exist in the directory.");
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
