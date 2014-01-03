<?
require_once('php/classes/member.php');

$profileEdited = new Member($_GET['member']);
if (!$currentUser->isAdmin() || !$profileEdited->exists()) {
  $profileEdited = $currentUser;
}

?><div class="row">
  <div class="large-12 columns">
    <h1>Edit Profile Picture: <?=$profileEdited->rcsid()?></h1>
    <p>This picture is displayed publicly on the "About Us" page:</p>
    <img src="<?=$profileEdited->photoURL()?>" alt="<?=$profileEdited->fullName()?>">
    <p>The new image must be a JPEG (*.jpg) file smaller than 1 MB.</p>
    <form enctype="multipart/form-data" action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$profileEdited->rcsid()?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="1048576">
      <div class="row">
        <div class="medium-8 columns">
          <input name="new_profile_photo" type="file">
          <button type="submit" name="action"
            value="profile_photo_edit">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>
