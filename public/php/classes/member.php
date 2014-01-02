<?
require_once('php/db/init.php');

$VOICE_PARTS = array('soprano', 'alto', 'tenor', 'bass');

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
  private $photoURL = "";

  public function __construct($rcsid) {
    // TODO: Performance: Add a lightweight constructor that doesn't get all of
    // these parameters
    global $db;
    $query = $db->prepare(
      "SELECT `rcsid`, `is_admin`, `first_name`, `full_name`,
      `nickname`, `voice_part`, `major`, `yog`, `bio`, `photo_url`
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
    $this->photoURL = $member->photo_url;
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
    return $this->photoURL;
  }
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
