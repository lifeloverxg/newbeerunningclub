<div class="direction">
    <span>
        <a href="<?php echo $home; ?>">首页 </a>
    </span>
    <span>
        <a href="<?php echo $home."event"; ?>">活动 </a>
    </span>
    <span>
<?php if ( isset($eid) && (isset($info_list)) ) { ?> 
        <a href="<?php echo $home."event/detail.php?eid=".$eid; ?>"><?php echo $info_list['title']; ?></a>
<?php } ?>
    </span>
    <span>
        <a href="<?php echo $home."event/album_photo.php?eid=".$eid; ?>">照片集</a>
    </span>
    <span>上传照片</span>
    
    <hr style="border:1px dotted rgb(210,210,210); margin-top: 2px; margin-bottom: 10px;" />
</div> 