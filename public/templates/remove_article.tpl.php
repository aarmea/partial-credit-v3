<? $articleEdited = new Article($_GET['article']);
?><div class="row">
  <div class="large-12 columns">
    <h1>Remove Article: <?=$articleEdited->title()?></h1>
<? if ($articleEdited->exists()) { ?>

    <p>Are you sure you want to remove "<?=$articleEdited->title()?>"? This cannot be undone.</p>
    <form action="post.php" method="post">
      <input type="hidden" name="article_id" value="<?=$articleEdited->articleId()?>">
      <button type="submit" name="action" value="remove_article" class="alert">Remove</button>
    </form>
<? } else { ?>

    <p>The requested article does not exist.</p>
<? } ?>

  </div>
</div>
