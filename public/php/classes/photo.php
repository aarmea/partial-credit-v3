<?
require_once('php/db/init.php');

$PHOTO_DIRECTORY = 'photos/photos_page/';
$PHOTO_THUMBNAIL_DIRECTORY = 'photos/thumbnails/';
$PHOTO_THUMBNAIL_WIDTH = 240;
$PHOTO_EXTENSION = '.jpg';
$PHOTO_MAX_SIZE = 10485760;

class Photo {
  private $photoId = -1;
  private $filename = "";
  private $uploader = "";
  private $dateUploaded = false;
  private $caption = "";

  public function __construct($photoId) {
    global $db;
    $query = $db->prepare(
      'SELECT `photo_id`, `filename`, `uploader_rcsid`, `date_uploaded`, `caption`
      FROM `photos` WHERE `photo_id` = :photo_id;'
    );
    $query->execute(array(':photo_id' => $photoId));
    $photo = $query->fetch();
    if (!$photo) return;

    $this->photoId = $photo->photo_id;
    $this->filename = $photo->filename;
    $this->uploader = $photo->uploader_rcsid;
    $this->dateUploaded = new DateTime($photo->date_uploaded);
    $this->caption = $photo->caption;
  }

  public static function fromRow($row) {
    $photo = new Photo(-1);
    $photo->photoId = $row->photo_id;
    $photo->filename = $row->filename;
    $photo->uploader = $row->uploader_rcsid;
    $photo->dateUploaded = new DateTime($row->date_uploaded);
    $photo->caption = $row->caption;
    return $photo;
  }

  public function exists() {
    return $this->photoId > 0;
  }

  public function photoId() {
    return $this->photoId;
  }

  public function path() {
    global $PHOTO_DIRECTORY;
    return $PHOTO_DIRECTORY . $this->filename;
  }

  public function thumbnailPath() {
    global $PHOTO_THUMBNAIL_DIRECTORY;
    return $PHOTO_THUMBNAIL_DIRECTORY . $this->filename;
  }

  public function uploader() {
    return $this->uploader;
  }

  public function dateUploaded() {
    return $this->dateUploaded;
  }

  public function caption() {
    return $this->caption;
  }
}

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

function getAllPhotos() {
  global $db;
  // Request needed columns from `photos`
  $query = $db->prepare(
    'SELECT `photo_id`, `filename`, `uploader_rcsid`, `date_uploaded`, `caption`
    FROM `photos` ORDER BY `date_uploaded` DESC;'
  );
  $query->execute();

  // Create corresponding Photo objects using Photo::fromRow()
  $photos = array();
  while ($row = $query->fetch()) {
    $photos[] = Photo::fromRow($row);
  }
  return $photos;
}
?>
