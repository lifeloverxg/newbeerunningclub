<?php
	class m_across_list {
		public static function render($list) {
	      foreach ($list as $list_item) {
		?>
<div class="m-list-across">
  <a class="m-list-across-link" href="<?php echo $list_item['url']; ?>">
    <div class="m-list-across-logo">
      <img class="m-list-across-logoimage" src="<?php echo $list_item['logo']; ?>" />
    </div>
    <div class="m-list-across-text">
      <h4 class="m-list-across-title"><?php echo $list_item['title']; ?></h4>
      <h6 class="m-list-across-desc"><?php echo $list_item['sub_title']; ?></h6>
    </div>
    <div class="m-list-across-arrow">
      <img class="m-list-across-arrowimage" src="#" />
    </div>
  </a>
</div>
<?php
	}
	}
	}
	?>