	<div class="common-share-frame">
			<div class="display-block-small">
				<div class="display-block-title">
					分享
					<!-- <img src="<?php echo $home . "theme/images/logo_blue.png"; ?>"> -->
				</div>
				<div class="nycuni-wechat-public">
					<div class="div-share-content">
						<div class="div-logo-large-back">
							<img class="logo-large-qr" onclick="show_qr('qr', '<?php if ( isset($large_logo) ) {echo $large_logo['qr_code'];}?>', '<?php echo $home; ?>')" src="<?php echo $home . "theme/images/Nycuni_wechat.jpg"; ?>" alt="<?php echo "微信分享"; ?>" title="<?php echo "微信分享"; ?>">
						</div>
						<div class="div-share-font"><span style="">NYCuni.com</span><br><span style="">纽约有你</span><br><span style="color: rgba(2, 2, 2, 0.6);">公共平台</span></div>
					</div>
				</div>
				<div class="common-jia-button-share">
<?php 
	include $home . "template/common/jia_button.php";
?>
				</div>
			</div>
	</div>