<div class="direction">
    <span>
        <a href="<?php echo $home; ?>">首页</a>
    </span>
    <span>
        <a href="<?php echo $home."event"; ?>">活动 </a> 
    </span>
    <span>
<?php if (isset($eid)) { 
	echo $info_list['title'];
} ?>
    </span>
    <hr style="border:1px dotted rgb(210,210,210); margin-top: 2px; margin-bottom: 10px;" />
</div> 