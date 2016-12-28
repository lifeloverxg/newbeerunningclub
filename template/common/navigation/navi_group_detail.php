<div class="direction">
    <span>
        <a href="<?php echo $home; ?>">首页</a>
    </span>
<?php if ( isset($info_list) && ($info_list['群组类型'] == "新生群组") ) { ?>
    <span>
        <a href="<?php echo $home.'information' ?>">综合</a> 
    </span>
    <span>
        <a href="<?php echo $home.'information/new' ?>">新生</a>
    </span>
    <span>
         <?php echo $info_list['title'];?>
    </span>
<?php } else { ?>
    <span>
        <a href="<?php echo $home."group"; ?>">群组</a>
    </span>
    <span>
<?php if (isset($gid)) { 
	echo $info_list['title'];
} ?>
    </span>
<?php } ?>
    <hr style="border:1px dotted rgb(210,210,210); margin-top: 2px; margin-bottom: 10px;" />
</div> 