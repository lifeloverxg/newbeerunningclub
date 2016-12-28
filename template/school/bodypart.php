<?php include $home."template/information_new/post_article.php" ?>
<div class ="content">
<div class ="main">
    <div class = "direction">
        <span>
            <a href="<?php echo $home ?>">首页 </a> <img src="<?php echo $home."theme/images/chevron-right.png" ?>"> 
        </span>
        <span>
            <a href="<?php echo $home.'information' ?>">综合 </a> <img src="<?php echo $home."theme/images/chevron-right.png"?>"> 
        </span>
        <span>
    	    <a href="<?php echo $home.'information/new' ?>">新生 </a> <img src="<?php echo $home."theme/images/chevron-right.png"?>"> 
        </span>
        <span>
             <?php echo $info_list['title'];?>
        </span>
        <hr style="border:1px dotted rgb(210,210,210); margin-top: 10px;" />
    </div> 
    <div style="width:100%;height:55px;">   
    <h2 style="margin:-10px 0 10px 5px;float:left;" >
        <?php echo $info_list['title'];?> 新生社群
    </h2>
    <?php if (isset($_SESSION['auth']) && ($viewer_role >= Role::Member)) { ?> 
    <div class="release-article">
        <button type="button" onclick= "show_article_panel()"> 发表文章</button>
    </div>
    <?php }
    ?>
    </div>


<div class="school-frame" style="width:100%">

<?php include $home."template/school/left_frame.php" ?> 

<?php include $home."template/school/right_frame.php" ?>

</div>


