<?
require_once('php/classes/photo.php');
?><div class="row">
  <div class="large-12 columns">
    <h1>Photos</h1>
    <ul class="clearing-thumbs" data-clearing>
<? foreach(getAllPhotos() as $photo) { ?>

      <li><a href="<?=$photo->path()?>">
        <img src="<?=$photo->thumbnailPath()?>" data-caption="<?=$photo->caption()?>">
      </a></li>
<? } ?>

    </ul>
  </div>
</div>
