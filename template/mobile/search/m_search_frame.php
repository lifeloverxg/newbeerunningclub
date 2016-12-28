<?php
//HTML header
include $home . "template/mobile/shared/partial/m_shared_header.php";
?>
<?
// HTML welcome page
/*include $home . "template/common/search_friend.php";*/
// include $home . "cgi/search_list.php";
?>
	<section class="section-search-frame-wrap">
<?php
// include $home . "template/search/top_Nav.php"; 
// include $home . "template/search/left_frame/left_frame.php";
// include $home . "template/search/right_frame/right_frame.php";
include $home . "template/mobile/search/partial/top_Nav.php"; 
include $home . "template/mobile/search/partial/m_search_category.php";
include $home . "template/mobile/search/partial/m_search_result.php";
?>
	</section>

<?
// HTML footer
include $home . "template/mobile/shared/partial/m_shared_footer.php";

?>