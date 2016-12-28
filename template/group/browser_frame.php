<?php
// HTML header
include $home . "template/common/header.php";
?>

<section class="section-margin-top">
<?php
// HTML body
include $home . "template/common/navigation/navi_group_browser.php";
include $home . "template/group/top.php";
include $home . "template/group/group_list.php";
include $home . "template/group/browser_right.php";
include $home . "template/group/create_group.php";
?>
</section>

<?php
// HTML footer
include $home . "template/common/footer.php";