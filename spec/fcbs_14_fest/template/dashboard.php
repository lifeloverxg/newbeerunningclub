<div class="div-dashboard">
  <header>
    <h1>FCBS春节晚会成员表</h1>
  </header>
  <ul class="ul-member-list">
<?php foreach ($dashboard as $member) { ?>
    <li>
      <div class="member-left">
        <a href="<?php echo $home.$member['url'] ; ?>">
          <img class="logo-small" src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
        </a>
    </div>
	<div class="member-middle">
	  <a href="<?php echo $home.$member['url']; ?>">
		<span class="list-title-member"><?php echo $member['title']; ?></span>
	  </a>
	  <span class="member-description"><?php echo $member['description']; ?></span>
	</div>
    <div class="member-right">
<?php if (!empty($member['button'])) { ?>
<?php   foreach ($member['button'] as $m_button) { ?>
      <button class="button_list_small_title" onclick="<?php echo $m_button['action']; ?>"><?php echo $m_button['title']; ?></button>
<?php   } ?>
<?php } ?>
      <button class="button_list_small_lottery"><?php echo $member['lottery']; ?></button>
    </div>
    </li>
<?php } ?>
  </ul>
  <footer>
    <button href="javascript:" onclick="refreshPage()" class="button_list_large">刷新列表</button>
  </footer>
</div>