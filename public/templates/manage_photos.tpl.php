<div class="row">
  <div class="large-12 columns">
    <h1>Manage Photos</h1>
    <a href="?p=add_photo" class="button">Upload a photo</a>
    <ul class="small-block-grid-3 medium-block-grid-4 large-block-grid-5">
<? foreach(getAllPhotos() as $photo) { ?>

      <li><a href="?p=edit_photo&photo=<?=$photo->photoId()?>">
        <img src="<?=$photo->thumbnailPath()?>">
      </a></li>
<? } ?>

    </ul>
  </div>
</div>
