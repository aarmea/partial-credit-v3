<?
// This configuration is valid only for the included Vagrant testing
// environment. For production use, it is highly recommended to create a new
// non-root MySQL user that only has access to $DB_NAME.
$DB_HOST = "localhost";
$DB_NAME = "partial_site_v3";
$DB_USERNAME = "myadmin";
$DB_PASSWORD = "myadmin";
$DB_TIME_ZONE = "America/New_York";

date_default_timezone_set($DB_TIME_ZONE);
?>
