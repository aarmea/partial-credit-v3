<?
require_once('php/auth/cas_init.php');
require_once('php/classes/member.php');

$ACTIONS = array(
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
if ($actions[$action]['verify_rcsid']) {
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
