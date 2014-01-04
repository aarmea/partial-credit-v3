<?
require_once('php/classes/member.php');
?><div class="row">
  <div class="large-12 columns">
    <h1>About Us</h1>
    <p>
      Many moons ago in 2003, a ragtag group of brave Rensselaer Polytechnic
      Institute students joined forces to fight off the bitter winds of Troy,
      NY through the power of music. Among them, they shared a love for singing
      a cappella and procrastinating on homework. Thus, Partial Credit was born.
      The Troy winters may still be cold, but the group lives on, spreading the
      warmth and joy of a cappella music through a wide range of musical tastes.
      Whether an indie tune, a comedic musical salute, or a unique ballad,
      Partial Credit takes pride in entertaining others while having fun
      performing.
    </p>
<?
foreach(array(
  'soprano' => 'Sopranos', 'alto' => 'Altos',
  'tenor' => 'Tenors', 'bass' => 'Basses'
) as $part => $title) {
  $members = getAllInVoicePart($part);
?>

      <h2><?=$title?></h2>
<?
  foreach($members as $member) {
?>

      <div class="member">
        <div class="member-image" style="background-image: url('<?=$member->photoURL()?>')">
        </div>
        <div class="member-text">
          <h3><?=$member->fullName()?> <span class="member-nickname"><?=$member->nickname()?></span></h3>
          <div class="member-class"><?=$member->major()?>, Class of <?=$member->yog()?></div>
          <p class="member-bio"><?=$member->bio()?></p>
        </div>
      </div>
<?
  }
}
?>

    </div>
  </div>
</div>
