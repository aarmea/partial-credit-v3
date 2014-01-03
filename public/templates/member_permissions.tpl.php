<?
$profileEdited = new Member($_GET['member']);
?><div class="row">
  <div class="large-12 columns">
    <h1>Change Permissions: <?=$profileEdited->rcsid()?></h1>
<? if ($profileEdited->rcsid() != $currentUser->rcsid()) { ?>

    <form action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$profileEdited->rcsid()?>">
      <div class="row">
        <div class="medium-8 columns">
          <div class="row">
          <input type="checkbox" id="admin" name="admin"<? if ($profileEdited->isAdmin()) { echo ' checked'; } ?>>
            <label for="admin">Administrator</label>
          </div>
          <div class="row">
            <button type="submit" name="action" value="change_member_permissions">Change permissions</button>
          </div>
        </div>
      </div>
    </form>
<? } else { ?>

    <p>You cannot change your own permissions.</p>
<? } ?>

  </div>
</div>
