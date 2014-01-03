<?
require_once('php/classes/member.php');

$profileEdited = new Member($_GET['member']);
if (!$currentUser->isAdmin() || !$profileEdited->exists()) {
  $profileEdited = $currentUser;
}

function voiceParts($selectedPart, $indent=0) {
  global $INDENT, $VOICE_PARTS;
  $prefix = str_repeat('  ', $indent);
  $count = 0;
  foreach ($VOICE_PARTS as $part) {
    if ($count > 0) {
      // Templating system does not indent this properly normally
      echo $INDENT;
    }
    echo $prefix . "<option value='$part'";
    if ($part == $selectedPart) {
      echo ' selected';
    }
    echo '>' . ucfirst($part) . '</option>' . PHP_EOL;
    ++$count;
  }
}
?><div class="row">
  <div class="large-12 columns">
    <h1>Edit Profile: <?=$profileEdited->rcsid()?></h1>
    <p>These values are displayed publicly on the "About Us" page.</p>
    <form action="post.php" method="post">
      <input type="hidden" name="rcsid" value="<?=$profileEdited->rcsid()?>">
      <div class="row">
        <div class="medium-8 columns">
          <div class="row">
            <div class="small-4 columns">
              <label for="first-name" class="right inline">First Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="first-name" name="first_name"
                value="<?=$profileEdited->firstName()?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="full-name" class="right inline">Full Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="full-name" name="full_name"
                value="<?=$profileEdited->fullName()?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="nickname" class="right inline">Nickname</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="nickname" name="nickname"
                value="<?=$profileEdited->nickname()?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="voice-part" class="right inline">Voice Part</label>
            </div>
            <div class="small-8 columns">
              <select id="voice-part" name="voice_part">
<? voiceParts($profileEdited->voicePart(), 8); ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="major" class="right inline">Major</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="major" name="major"
                value="<?=$profileEdited->major()?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="yog" class="right inline">Year of graduation</label>
            </div>
            <div class="small-8 columns">
              <input type="number" inputmode="numeric" min="2014" id="yog" name="yog"
                value="<?=$profileEdited->yog()?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="bio" class="right inline">Bio</label>
            </div>
            <div class="small-8 columns">
              <textarea id="bio" name="bio" rows="8"><?=$profileEdited->bio()?></textarea>
            </div>
          </div>
          <div class="row">
            <div class="small-offset-4 small-8">
              <button type="submit" name="action"
                value="profile_edit">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
