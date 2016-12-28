<?php
// HTML header
include $home . "template/common/header.php";
?>
<?php include $home . "template/people/edit_profile.php"; ?>

<?php
// HTML left panel
include $home . "template/people/top_frame.php";
include $home . "template/people/left_frame.php";
include $home . "template/people/right_frame.php";
?>

<?php
// popup frames 
include $home . "template/common/popup_frames/edit_display_photo.php";
include $home . "template/common/popup_frames/large_qr.php";
include $home . "template/common/popup_frames/wechat_share.php";
?>
<?php
// HTML footer
include $home . "template/common/footer.php";
?>