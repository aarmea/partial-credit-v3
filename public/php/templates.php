<?
$SITE_TITLE = 'Partial Credit';
$TEMPLATES = array(
  'news' => array(
    'title' => 'News',
    'filename' => 'news.tpl.php'
  ),
  'about' => array(
    'title' => 'About Us',
    'filename' => 'about.tpl.php'
  ),
  'photos' => array(
    'title' => 'Photos',
    'filename' => 'photos.tpl.php'
  ),
  'auditions' => array(
    'title' => 'Auditions',
    'filename' => 'auditions.tpl.php'
  ),
  'contact' => array(
    'title' => 'Contact',
    'filename' => 'contact.tpl.php'
  )
);
$DEFAULT_TEMPLATE = 'news';
$TEMPLATE_PATH = 'templates/';

// If the provided template name is invalid, use the default template
if (array_key_exists($_GET['p'], $TEMPLATES)) {
  $templateName = $_GET['p'];
} else {
  $templateName = $DEFAULT_TEMPLATE;
}

function pageTitle($templateName) {
  global $SITE_TITLE, $TEMPLATES;
  return $SITE_TITLE . ': ' . $TEMPLATES[$templateName]['title'];
}

// Includes a named template, adding the specified level of indentation.
// Based heavily on TemplatePrint by @Diogenesthecynic in
// https://github.com/Diogenesthecynic/Bookswap/blob/master/PHP/templates.inc.php
function templatePrint($templateName, $indent=0) {
  global $TEMPLATES, $DEFAULT_TEMPLATE, $TEMPLATE_PATH;
  $content = trim(
    file_get_contents($TEMPLATE_PATH . $TEMPLATES[$templateName]['filename']));

  // Indent all lines of $content.
  $prefix = str_repeat('  ', $indent);
  $content =
    $prefix . str_replace(PHP_EOL, PHP_EOL . $prefix, $content) . PHP_EOL;

  // Include the indented template.
  // eval() is okay here because:
  // * The $TEMPLATES whitelist ensures that there is no way for a user to edit
  //   the 'eval'ed code.
  // * This is the cleanest way to include code and indent it properly.
  eval('$TEMPLATE_PREFIX = "' . $prefix . '"?>' . $content);
}
?>
