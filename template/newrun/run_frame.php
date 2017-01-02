<?php
// HTML header
include $home . "template/common/header.php";


// <-- HTML body
include $home . "template/common/navigation/create/navi_new_run_create.php";

include $home . "template/newrun/run_record.php";

$test = RunDAO::get_sorted_rank_list();


// HTML footer
include $home . "template/common/footer.php";