<?
require_once('templates/templates.php');

$SITE_TITLE = 'Partial Credit';
function pageTitle($templateName) {
  global $SITE_TITLE, $TEMPLATES;
  return $SITE_TITLE . ': ' . $TEMPLATES[$templateName]['title'];
}
?>
