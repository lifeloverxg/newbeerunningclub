<?php
	class m_photo_list {
		public static function render($list) {
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
 	        if (count($list) > 4) {
?>
      <a class="m-list-photo-arrowlink" href="javascript:mPhotoListTabRight('<?php echo $id; ?>');">
        <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
<?php
	        }
?>
    </div>
  </div>
  <div class="m-list-photo-panel back" id="<?php echo $id; ?>-right">
    <div class="m-list-photo-arrow m-list-arrow4">
<?php
	        if (count($list) > 4) {
?>
      <a class="m-list-photo-arrowlink" href="javascript:mPhotoListTabLeft('<?php echo $id; ?>');">
        <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
<?php
    	    }
?>
    </div>
<?php
            for ($i = 4; $i < 8; $i++) {
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
  </div>
</div>
<?php
		}
	}
?>
