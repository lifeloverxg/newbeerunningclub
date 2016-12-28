<?php
	class m_down_list {
		public static function render($list, $more = '') {
?>
<div class="m-list-down m-list4">
<?php
		  for ($i = 0; $i < 4; $i++) {
?>
  <div class="m-list-down-item m-list-item4">
<?php
			if (isset($list[$i])) {
?>
    <a class="m-list-down-link" href="<?php echo $list[$i]['url']; ?>">
	  <img class="m-list-down-logoimage" src="<?php echo $list[$i]['logo']; ?>" />
	  <span class="m-list-down-title"><?php echo $list[$i]['title']; ?></span>
    </a>
<?php
			}
?>
  </div>
<?php
	      }
?>
  <div class="m-list-down-arrow m-list-arrow4">
<?php
		if ($more) {
?>
    <a class="m-list-down-arrowlink" href="<?php echo $more; ?>">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
<?php
		  }
?>
  </div>
</div>
<?php
		}
	}
?>