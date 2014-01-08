<?
// Initializes a global PDO connection $db to the database.
require_once "config.php";

try {
  $db = new PDO(
    "mysql:host=$DB_HOST;dbname=$DB_NAME;", $DB_USERNAME, $DB_PASSWORD);
  $setTimeZone = $db->prepare(
    "SET time_zone = :time_zone;"
  );
  $setTimeZone->execute(array(":time_zone" => $DB_TIME_ZONE));
} catch (PDOException $e) {
  exit("<pre>Database error:\n" . $e->getMessage());
}
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>
