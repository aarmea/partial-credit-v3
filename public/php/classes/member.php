<?
require_once('php/db/init.php');
require_once('php/api_calls/rpi_directory_app.php');

$VOICE_PARTS = array('soprano', 'alto', 'tenor', 'bass');
$PHOTO_DIRECTORY = 'photos/members/';
$PHOTO_EXTENSION = '.jpg';
$PHOTO_MAX_SIZE = 1048576; // bytes

class Member {
  private $rcsid = "";
  private $isAdmin = false;
  private $firstName = "";
  private $fullName = "";
  private $nickname = "";
  private $voicePart = "";
  private $major = "";
  private $yog = -1;
  private $bio = "";

  public function __construct($rcsid) {
    // TODO: Performance: Add a lightweight constructor that doesn't get all of
    // these parameters
    global $db;
    $query = $db->prepare(
      "SELECT `rcsid`, `is_admin`, `first_name`, `full_name`,
      `nickname`, `voice_part`, `major`, `yog`, `bio`
      FROM `members` WHERE `rcsid` = :rcsid;"
    );
    $query->execute(array(":rcsid" => $rcsid));
    $member = $query->fetch();
    if (!$member) return;

    $this->rcsid = $member->rcsid;
    $this->isAdmin = $member->is_admin;
    $this->firstName = $member->first_name;
    $this->fullName = $member->full_name;
    $this->nickname = $member->nickname;
    $this->voicePart = $member->voice_part;
    $this->major = $member->major;
    $this->yog = $member->yog;
    $this->bio = $member->bio;
  }

  public function exists() {
    return !empty($this->rcsid);
  }

  public function rcsid() {
    return $this->rcsid;
  }

  public function isAdmin() {
    return $this->isAdmin;
  }

  public function firstName() {
    return $this->firstName;
  }

  public function fullName() {
    return $this->fullName;
  }

  public function nickname() {
    return $this->nickname;
  }

  public function voicePart() {
    return $this->voicePart;
  }

  public function major() {
    return $this->major;
  }

  public function yog() {
    return $this->yog;
  }

  public function bio() {
    return $this->bio;
  }

  public function photoURL() {
    global $PHOTO_DIRECTORY, $PHOTO_EXTENSION;
    $path = $PHOTO_DIRECTORY . $this->rcsid . $PHOTO_EXTENSION;
    if (file_exists($path)) {
      return $path;
    } else {
      return false;
    }
  }

  public function replacePhoto($newFileInfo) {
    global $PHOTO_DIRECTORY, $PHOTO_MAX_SIZE, $PHOTO_EXTENSION;

    // Sanity checking
    if ($newFileInfo['size'] == 0) {
      die('No file received.');
    } elseif ($newFileInfo['size'] > $PHOTO_MAX_SIZE) {
      die('Uploaded photo is too large.');
    } elseif (exif_imagetype($newFileInfo['tmp_name']) != IMAGETYPE_JPEG) {
      die('Invalid image format');
    }

    // Move the new file into place
    if (!move_uploaded_file($newFileInfo['tmp_name'],
      $PHOTO_DIRECTORY . $this->rcsid . $PHOTO_EXTENSION))
    {
      die('Could not move the uploaded file');
    }
  }
}

function addMemberFromDirectory($rcsid) {
  global $db;

  $memberInfo = getUserFromDirectory($rcsid);
  if (!$memberInfo) {
    die('User does not exist in the RPI Directory');
  }

  $addMember = $db->prepare(
    'INSERT INTO `members`(
      `rcsid`, `first_name`, `full_name`, `major`, `yog`
    ) VALUES (
      :rcsid, :first_name, :full_name, :major, :yog
    );'
  );
  $addMember->execute(array(
    ':rcsid' => $memberInfo->rcsid,
    ':first_name' => ucwords($memberInfo->first_name),
    ':full_name' => $memberInfo->name,
    ':major' => ucwords($memberInfo->major),
    ':yog' => getYogFromClass($memberInfo->year)
  ));
}

function editMember($memberInfo) {
  global $db;

  $editUser = $db->prepare(
    "UPDATE `members`
    SET `first_name`=:first_name, `full_name`=:full_name, `nickname`=:nickname,
    `voice_part`=:voice_part, `major`=:major, `yog`=:yog, `bio`=:bio
    WHERE `rcsid`=:rcsid;"
  );
  $editUser->execute(array(
    ':rcsid' => htmlspecialchars($memberInfo['rcsid']),
    ':first_name' => htmlspecialchars($memberInfo['first_name']),
    ':full_name' => htmlspecialchars($memberInfo['full_name']),
    ':nickname' => htmlspecialchars($memberInfo['nickname']),
    ':voice_part' => strtolower(htmlspecialchars($memberInfo['voice_part'])),
    ':major' => htmlspecialchars($memberInfo['major']),
    ':yog' => htmlspecialchars($memberInfo['yog']),
    ':bio' => htmlspecialchars($memberInfo['bio'])
  ));
}
?>