<?
// CAS initialization for logged-in pages
require_once "config.php";

phpCAS::client(CAS_VERSION_2_0, $CAS_HOST, $CAS_PORT, $CAS_URI);
phpCAS::setCasServerCACert($CAS_CA_CERT_PATH);

?>
