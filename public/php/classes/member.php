<?
require_once('php/db/init.php');

class Member {
  private $rcsid = "";
  private $isAdmin = false;
  private $firstName = "";
  private $fullName = "";
  private $nickname = "";
  private $major = "";
  private $yog = -1;
  private $photoURL = "";

  public function __construct($rcsid) {
    global $db;
    $query = $db->prepare(
      "SELECT `rcsid`, `is_admin`, `first_name`, `full_name`,
      `nickname`, `major`, `yog`, `photo_url`
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
    $this->major = $member->major;
    $this->yog = $member->yog;
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

  public function major() {
    return $this->major;
  }

  public function yog() {
    return $this->yog;
  }

  public function photoURL() {
    return $this->photoURL;
  }
}
?>
