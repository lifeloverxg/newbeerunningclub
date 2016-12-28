<?php
	class m_text_list {
		public function render($list) {
			foreach ($list as $list_item) {
?>
<div class="m-text-down">
<?php
	if ($list_item['fold']) {
?>
  <div class="m-text-down-text">
    <h4 class="m-list-down-content"><?php echo $list_item['title']; ?></h4>
  </div>
  <div class="m-list-text-arrow">
  </div>
<?php
	}
	else {
?>
  <div class="m-text-down-text">
    <h4 class="m-list-down-content"><?php echo $list_item['content_full']; ?></h4>
  </div>
  <div class="m-list-text-arrow">
  </div>
<?php
	}
?>
</div>
<?php
	}
	}
	}
	?>