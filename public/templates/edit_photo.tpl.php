<? $photoEdited = new Photo($_GET['photo']);
?><div class="row">
  <div class="large-12 columns">
    <h1>Edit Photo</h1>
<? if ($photoEdited->exists()) { ?>

    <img class="editing" src="<?=$photoEdited->path()?>">
    <div class="row">
      <div class="medium-8 columns">
        <form action="post.php" method="post">
          <input type="hidden" name="photo_id" value="<?=$photoEdited->photoId()?>">
          <div class="row">
            <div class="small-3 columns">
              <label for="caption" class="right inline">Caption</label>
            </div>
            <div class="small-9 columns">
              <textarea id="caption" name="caption" rows="4"><?=$photoEdited->caption()?></textarea>
            </div>
          </div>
          <div class="row">
            <div class="small-offset-3 small-9">
              <button type="submit" name="action"
                value="edit_photo">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
<? } else { ?>

    <p>The requested photo does not exist.</p>
<? } ?>

  </div>
</div>
