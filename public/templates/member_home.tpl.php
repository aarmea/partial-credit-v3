<div class="row">
  <div class="large-12 columns">
    <h1>Welcome, <?=$currentUser->firstName()?></h1>
    <ul>
      <li><a href="?p=manage_articles">Manage news articles</a></li>
      <li><a href="?p=profile_edit">Edit your name or bio</a></li>
      <li><a href="?p=profile_photo_edit">Change your profile picture</a></li>
<? if ($currentUser->isAdmin()) { ?>
      <li><a href="?p=manage_members">Manage members</a></li>
<? } ?>
      <li><a href="?p=manage_photos">Manage photos</a></li>
      <li><a href="logout.php">Log out</a></li>
    </ul>
  </div>
</div>
