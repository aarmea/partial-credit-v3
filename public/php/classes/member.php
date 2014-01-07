<?
require_once('php/db/init.php');
require_once('php/api_calls/rpi_directory_app.php');

$VOICE_PARTS = array('soprano', 'alto', 'tenor', 'bass');
$MEMBER_PHOTO_DIRECTORY = 'photos/members/';
$MEMBER_PHOTO_EXTENSION = '.jpg';
$MEMBER_PHOTO_MAX_SIZE = 1048576; // bytes
$DEFAULT_MEMBER_PHOTO = 'images/member-placeholder.jpg';

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
    if (empty($rcsid)) return; // This will always be invalid, so don't bother querying
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

  public static function fromRow($row) {
    $member = new Member('');
    $member->rcsid = $row->rcsid;
    $member->isAdmin = $row->is_admin;
    $member->firstName = $row->first_name;
    $member->fullName = $row->full_name;
    $member->nickname = $row->nickname;
    $member->voicePart = $row->voice_part;
    $member->major = $row->major;
    $member->yog = $row->yog;
    $member->bio = $row->bio;
    return $member;
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
    global $MEMBER_PHOTO_DIRECTORY, $MEMBER_PHOTO_EXTENSION, $DEFAULT_MEMBER_PHOTO;
    $path = $MEMBER_PHOTO_DIRECTORY . $this->rcsid . $MEMBER_PHOTO_EXTENSION;
    if (file_exists($path)) {
      return $path;
    } else {
      return $DEFAULT_MEMBER_PHOTO;
    }
  }

  public function replacePhoto($newFileInfo) {
    global $MEMBER_PHOTO_DIRECTORY, $MEMBER_PHOTO_MAX_SIZE, $MEMBER_PHOTO_EXTENSION;

    // Sanity checking
    if ($newFileInfo['size'] == 0) {
      die('No file received.');
    } elseif ($newFileInfo['size'] > $MEMBER_PHOTO_MAX_SIZE) {
      die('Uploaded photo is too large.');
    } elseif (exif_imagetype($newFileInfo['tmp_name']) != IMAGETYPE_JPEG) {
      die('Invalid image format');
    }

    // Move the new file into place
    if (!move_uploaded_file($newFileInfo['tmp_name'],
      $MEMBER_PHOTO_DIRECTORY . $this->rcsid . $MEMBER_PHOTO_EXTENSION))
    {
      die('Could not move the uploaded file');
    }
  }

  function setAdmin($makeAdmin) {
    global $db;
    $query = $db->prepare(
      'UPDATE `members` SET `is_admin`=:is_admin WHERE `rcsid`=:rcsid'
    );
    $query->execute(array(
      ':rcsid' => $this->rcsid,
      ':is_admin' => $makeAdmin
    ));
  }

  function deleteFromDB() {
    global $db, $DEFAULT_MEMBER_PHOTO;
    if (!$this->exists()) {
      die('This member does not exist');
    }

    // Attempt to delete the DB row first
    $query = $db->prepare("DELETE FROM `members` WHERE `rcsid`=:rcsid");
    $query->execute(array(':rcsid' => $this->rcsid));
    // If the DB row deletion fails, the rest of this is not run
    if ($this->photoURL() != $DEFAULT_MEMBER_PHOTO) {
      unlink($this->photoURL());
    }
  }
}

function addMemberFromDirectory($rcsid) {
  global $db;

  $memberInfo = getUserFromDirectory($rcsid);
  if (!$memberInfo) {
    // User was not found in the directory. Fill in default data.
    $memberInfo = new stdClass();
    $memberInfo->{'rcsid'} = $rcsid;
    $memberInfo->{'first_name'} = 'unknown';
    $memberInfo->{'name'} = 'Unknown RPI student';
    $memberInfo->{'major'} = '';
    $memberInfo->{'year'} = '';
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

function listMembersAlpha() {
  global $db;
  $query = $db->prepare("SELECT `rcsid`, `full_name` FROM `members`");
  $query->execute();
  return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getAllInVoicePart($voicePart) {
  global $db;
  // Request needed columns from `members`
  $query = $db->prepare(
    'SELECT `rcsid`, `is_admin`, `first_name`, `full_name`,
    `nickname`, `voice_part`, `major`, `yog`, `bio`
    FROM `members` WHERE `voice_part` = :voice_part;'
  );
  $query->execute(array(':voice_part' => strtolower($voicePart)));

  // Create corresponding Member objects using Member::fromRow()
  $members = array();
  while ($row = $query->fetch()) {
    $members[] = Member::fromRow($row);
  }
  return $members;
}
?>
