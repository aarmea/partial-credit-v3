<div class="row">
  <div class="large-12 columns">
    <h1>Upload a Photo</h1>
    <p>
      The pictures uploaded through this form will be displayed publicly on the
      "Photos" page. New photos must be JPEG images 10 MB or smaller.
    </p>
    <form enctype="multipart/form-data" action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$currentUser->rcsid()?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
      <div class="medium-8 columns">
        <div class="row">
          <div class="small-4 columns">
            <label for="photo-file" class="right inline">Photo file</label>
          </div>
          <div class="small-8 columns">
            <input id="photo-file" name="photo-file" type="file">
          </div>
        </div>
        <div class="row">
          <div class="small-4 columns">
            <label for="photo-caption" class="right inline">Caption</label>
          </div>
          <div class="small-8 columns">
            <textarea id="photo-caption" name="photo-caption" rows="3"></textarea>
          </div>
        </div>
        <div class="row">
          <div class="small-offset-4 small-8">
            <button type="submit" name="action" value="add_photo">Submit</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
