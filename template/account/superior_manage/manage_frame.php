<?php
// HTML header
include $home . "template/common/header.php"; ?>

<?php
//HTML body
include $home . "template/account/superior_manage/event_manage_sale.php";

spec_popup::spec_popup_common("show-del-error", "取消活动"." - ".$info_list['title'], "Alex童鞋, 你确定要取消该活动吗", "event_delete_oper(".$auth['uid'].", ".$eid.", 'delete')");
?>

<?php
// HTML footer
include $home . "template/common/footer.php"; ?>