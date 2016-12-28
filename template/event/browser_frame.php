<?php
// HTML header
include $home . "template/common/header.php";

// <-- HTML body
?>
<section class="section-margin-top">
<?php
include $home . "template/common/navigation/navi_event_browser.php";

include $home . "template/event/top.php";

include $home . "template/event/event_list.php";

include $home . "template/event/browser_right.php";

include $home . "template/event/create.php";
?>
</section>
<?php
// -->

// HTML footer
include $home . "template/common/footer.php";