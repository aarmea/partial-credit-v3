<?
$profileEdited = new Member($_GET['member']);
?><div class="row">
  <div class="large-12 columns">
    <h1>Remove Member: <?=$profileEdited->rcsid()?></h1>
<? if ($profileEdited->rcsid() != $currentUser->rcsid()) { ?>

    <p>Are you sure you want to remove <?=$profileEdited->fullName()?>? This cannot be undone.</p>
    <form action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$profileEdited->rcsid()?>">
      <button type="submit" name="action" value="remove_member">Remove</button>
    </form>
<? } else { ?>

    <p>You cannot remove yourself.</p>
<? } ?>

  </div>
</div>
