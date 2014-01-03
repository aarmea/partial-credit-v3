<?
require_once('php/auth/cas_init.php');
require_once('php/classes/member.php');

$SITE_TITLE = 'Partial Credit';
$TEMPLATES = array(
  'news' => array(
    'title' => 'News',
    'filename' => 'news.tpl.php',
    'needs_auth' => False,
    'needs_admin' => False
  ),
  'about' => array(
    'title' => 'About Us',
    'filename' => 'about.tpl.php',
    'needs_auth' => False,
    'needs_admin' => False
  ),
  'photos' => array(
    'title' => 'Photos',
    'filename' => 'photos.tpl.php',
    'needs_auth' => False,
    'needs_admin' => False
  ),
  'auditions' => array(
    'title' => 'Auditions',
    'filename' => 'auditions.tpl.php',
    'needs_auth' => False,
    'needs_admin' => False
  ),
  'contact' => array(
    'title' => 'Contact',
    'filename' => 'contact.tpl.php',
    'needs_auth' => False,
    'needs_admin' => False
  ),
  'member_home' => array(
    'title' => 'Member Home',
    'filename' => 'member_home.tpl.php',
    'needs_auth' => True,
    'needs_admin' => False
  ),
  'profile_edit' => array(
    'title' => 'Edit Profile',
    'filename' => 'profile_edit.tpl.php',
    'needs_auth' => True,
    'needs_admin' => False
  ),
  'profile_photo_edit' => array(
    'title' => 'Edit Profile Picture',
    'filename' => 'profile_photo_edit.tpl.php',
    'needs_auth' => True,
    'needs_admin' => False
  ),
  'add_member' => array(
    'title' => 'Add New Member',
    'filename' => 'add_member.tpl.php',
    'needs_auth' => True,
    'needs_admin' => True
  ),
  'manage_members' => array(
    'title' => 'Manage Members',
    'filename' => 'list_members.tpl.php',
    'needs_auth' => True,
    'needs_admin' => True
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

// Authenticate with phpCAS if the template requires authentication
if ($TEMPLATES[$templateName]['needs_auth']) {
  phpCAS::forceAuthentication();
  $currentUser = new Member(phpCAS::getUser());
} else {
  $currentUser = false;
}

function pageTitle($templateName) {
  global $SITE_TITLE, $TEMPLATES;
  return $SITE_TITLE . ': ' . $TEMPLATES[$templateName]['title'];
}

// Includes a named template, adding the specified level of indentation.
// Based heavily on TemplatePrint by @Diogenesthecynic in
// https://github.com/Diogenesthecynic/Bookswap/blob/master/PHP/templates.inc.php
function templatePrint($templateName, $indent=0) {
  global $TEMPLATES, $DEFAULT_TEMPLATE, $TEMPLATE_PATH, $SITE_TITLE, $currentUser;
  $prefix = str_repeat('  ', $indent);

  // Check if the user is authorized for this page
  if ($TEMPLATES[$templateName]['needs_auth'] && !$currentUser->exists()) {
    echo $prefix .
      "<div class='row'>You must be a current member of $SITE_TITLE to access this area.</div>";
    return;
  }
  if ($TEMPLATES[$templateName]['needs_admin'] && !$currentUser->isAdmin()) {
    echo $prefix .
      "<div class='row'>You must be an administrator to access this area.</div>";
    return;
  }

  $content = trim(
    file_get_contents($TEMPLATE_PATH . $TEMPLATES[$templateName]['filename']));

  // Indent all lines of $content.
  $content =
    $prefix . str_replace(PHP_EOL, PHP_EOL . $prefix, $content) . PHP_EOL;

  // Include the indented template.
  // eval() is okay here because:
  // * The $TEMPLATES whitelist ensures that there is no way for a user to edit
  //   the 'eval'ed code.
  // * This is the cleanest way to include code and indent it properly.
  eval('global $INDENT; $INDENT = "' . $prefix . '";?>' . $content);
}
?>
