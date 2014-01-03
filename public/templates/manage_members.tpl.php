<div class="row">
  <div class="large-12 columns">
    <h1>Manage Members</h1>
    <div class="row">
      <div class="medium-10 columns">
        <ul class="member-list">
<? foreach(listMembersAlpha() as $member) { ?>

          <li>
            <?=$member['full_name']?> (<?=$member['rcsid']?>)
            <ul class="actions-list">
              <li><a href="?p=profile_edit&member=<?=$member['rcsid']?>">Edit Profile</a></li>
              <li><a href="?p=profile_photo_edit&member=<?=$member['rcsid']?>">Change Photo</a></li>
              <li><a href="?p=member_permissions&member=<?=$member['rcsid']?>">Permissions</a></li>
              <li><a href="?p=remove_member&member=<?=$member['rcsid']?>">Remove</a></li>
            </ul>
          </li>
<? } ?>

        </ul>
        <a href="?p=add_member">Add a member</a>
      </div>
    </div>
  </div>
</div>
