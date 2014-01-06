<?
require_once('php/db/init.php');

$PHOTO_DIRECTORY = 'photos/photos_page/';
$PHOTO_THUMBNAIL_DIRECTORY = 'photos/thumbnails/';
$PHOTO_THUMBNAIL_WIDTH = 240;
$PHOTO_EXTENSION = '.jpg';
$PHOTO_MAX_SIZE = 10485760;

// TODO: Add a Photo class

// make_thumb from http://davidwalsh.name/create-image-thumbnail-php
function simpleJPEGThumbnail($src, $dest, $desired_width) {
  /* read the source image */
  $source_image = imagecreatefromjpeg($src);
  $width = imagesx($source_image);
  $height = imagesy($source_image);

  /* find the "desired height" of this thumbnail, relative to the desired width  */
  $desired_height = floor($height * ($desired_width / $width));

  /* create a new, "virtual" image */
  $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

  /* copy source image at a resized size */
  imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

  /* create the physical thumbnail image to its destination */
  imagejpeg($virtual_image, $dest);
}

function addPhoto($photoInfo) {
  global $db, $PHOTO_DIRECTORY, $PHOTO_THUMBNAIL_DIRECTORY,
    $PHOTO_THUMBNAIL_WIDTH, $PHOTO_EXTENSION, $PHOTO_MAX_SIZE;

  // Sanity checking
  if ($photoInfo['size'] == 0) {
    die('No file received.');
  } elseif ($photoInfo['size'] > $PHOTO_MAX_SIZE) {
    die('Uploaded photo is too large.');
  } elseif (exif_imagetype($photoInfo['tmp_name']) != IMAGETYPE_JPEG) {
    // TODO: Replace exif_imagetype with something from GD, which the Union's
    // server actually has
    die('Invalid image format');
  }

  $filename = uniqid() . $PHOTO_EXTENSION;
  if (!move_uploaded_file($photoInfo['tmp_name'], $PHOTO_DIRECTORY . $filename)) {
    die('Could not move the uploaded file');
  }
  simpleJPEGThumbnail($PHOTO_DIRECTORY . $filename,
    $PHOTO_THUMBNAIL_DIRECTORY . $filename, $PHOTO_THUMBNAIL_WIDTH);
  $addPhoto = $db->prepare(
    'INSERT INTO `photos`(
      `filename`, `uploader_rcsid`, `date_uploaded`, `caption`
    ) VALUES (
      :filename, :uploader_rcsid, NOW(), :caption
    );'
  );
  $addPhoto->execute(array(
    ':filename' => $filename,
    ':uploader_rcsid' => $photoInfo['rcsid'],
    ':caption' => htmlspecialchars($photoInfo['photo-caption'])
  ));
}
?>
