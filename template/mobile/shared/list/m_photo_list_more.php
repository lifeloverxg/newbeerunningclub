<?php
	class m_photo_list_more {
		public static function render($list, $eid) {
			$id = $random = substr( md5(rand()), 0, 7);
?>
<div class="m-list-photo m-list4" id="<?php echo $id; ?>">
  <div class="m-list-photo-panel" id="<?php echo $id; ?>-left">
<?php
	        for ($i = 0; $i < 4; $i++) {
?>
	<div class="m-list-photo-item m-list-item4">
<?php
	          if (isset($list[$i])) {
?>
	  <a class="m-list-photo-link" href="<?php echo $list[$i]['logo']; ?>">
		<img class="m-list-photo-logo" src="<?php echo $list[$i]['logo']; ?>"></img>
	  </a>
<?php
              }
?>
	</div>
<?php
		    }
?>
    <div class="m-list-photo-arrow m-list-arrow4">
<?php
 	        if (count($list) >= 4) {
?>
      <a class="m-list-photo-arrowlink" href="javascript:show_album_event('<?php echo $eid; ?>');">
        <span class="glyphicon glyphicon-chevron-right" style="margin: 25px 0 0 5px;"></span>
      </a>
<?php
	        }
?>
    </div>
  </div>
</div>
<?php
		}
	}
?>
