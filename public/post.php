<?
require_once('php/auth/cas_init.php');
require_once('php/classes/article.php');
require_once('php/classes/member.php');
require_once('php/classes/photo.php');

$ACTIONS = array(
  'add_article' => array(
    'execute' => function() {
      addArticle(array_map('stripslashes', $_POST));
    },
    'redirect' => './?p=manage_articles',
    'needs_auth' => true,
    'verify_rcsid' => true,
    'needs_admin' => false
  ),
  'profile_edit' => array(
    'execute' => function() {
      editMember(array_map('stripslashes', $_POST));
    },
    'redirect' => './?p=about',
    'needs_auth' => true,
    'verify_rcsid' => true,
    'needs_admin' => false
  ),
  'profile_photo_edit' => array(
    'execute' => function() {
      $profileEdited = new Member($_POST['rcsid']);
      $profileEdited->replacePhoto($_FILES['new_profile_photo']);
    },
    'redirect' => './?p=about',
    'needs_auth' => true,
    'verify_rcsid' => true,
    'needs_admin' => false
  ),
  'add_member' => array(
    'execute' => function() {
      addMemberFromDirectory($_POST['rcsid']);
    },
    'redirect' => './?p=profile_edit&member=' . $_POST['rcsid'],
    'needs_auth' => true,
    'verify_rcsid' => false,
    'needs_admin' => true
  ),
  'change_member_permissions' => array(
    'execute' => function() {
      $profileEdited = new Member($_POST['rcsid']);
      // Checkboxes are only sent if checked
      $profileEdited->setAdmin(isset($_POST['admin']));
    },
    'redirect' => './?p=manage_members',
    'needs_auth' => true,
    'verify_rcsid' => false,
    'needs_admin' => true
  ),
  'remove_member' => array(
    'execute' => function() {
      $profileEdited = new Member($_POST['rcsid']);
      $profileEdited->deleteFromDB();
    },
    'redirect' => './?p=manage_members',
    'needs_auth' => true,
    'verify_rcsid' => false,
    'needs_admin' => true
  ),
  'add_photo' => array(
    'execute' => function() {
      addPhoto(array_merge($_POST, $_FILES['photo-file']));
    },
    'redirect' => './?p=manage_photos',
    'needs_auth' => true,
    'verify_rcsid' => true,
    'needs_admin' => false
  ),
  'edit_photo' => array(
    'execute' => function() {
      editPhoto($_POST);
    },
    'redirect' => './?p=manage_photos',
    'needs_auth' => true,
    'verify_rcsid' => false,
    'needs_admin' => false
  ),
  'delete_photo' => array(
    'execute' => function() {
      $photoEdited = new Photo($_POST['photo_id']);
      $photoEdited->deleteFromDB();
    },
    'redirect' => './?p=manage_photos',
    'needs_auth' => true,
    'verify_rcsid' => false,
    'needs_admin' => false
  )
);

// Check if the action is valid and that the user is authorized for this action
$action = $_POST['action'];
if (!array_key_exists($action, $ACTIONS)) {
  die('Invalid action');
}
if ($ACTIONS[$action]['needs_auth']) {
  phpCAS::forceAuthentication();
  $currentUser = new Member(phpCAS::getUser());
  if (!$currentUser->exists()) {
    die('You must be a current member of Partial Credit to post this request');
  }
} else {
  $currentUser = false;
}
if ($ACTIONS[$action]['verify_rcsid']) {
  if ($currentUser->rcsid() != $_POST['rcsid'] && !$currentUser->isAdmin()) {
    die('You do not have write access to this user\'s data');
  }
}
if ($ACTIONS[$action]['needs_admin'] && !$currentUser->isAdmin()) {
  die('You must be an administrator to post this request');
}

// Requested action and user are okay, so attempt to run the request
try {
  $ACTIONS[$action]['execute']();
} catch (Exception $e) {
  die($e);
}

// Action successful, so show the user the result
header('Location: ' . $ACTIONS[$action]['redirect']);
?>
