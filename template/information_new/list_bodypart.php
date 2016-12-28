<?php include $home."template/information_new/post_article.php" ?>
<!-- 综合板块内容 -->
<div class="content">
<div class="main" style="width: 1000px">
<!-- nav -->
<div class="direction">
    <span>
        <a href="<?php echo $home ?>">首页 </a> <img src="<?php echo $home."theme/images/chevron-right.png"?>"> 
    </span>
    <span>
        <a href="<?php echo $home.'information' ?>">综合 </a> <img src="<?php echo $home."theme/images/chevron-right.png"?>"> 
    </span>
    <span>
        <?php echo $category_name[$category];?>
    </span>
    <hr style="border:1px dotted rgb(210,210,210); margin-top: 10px;" />
</div> 

<?php include $home."template/information_new/search_and_release.php" ?>


<div class="page-list">

<?php for ($i = 1; $i <= $pagenumber; $i++)
{ ?>
      <a href="<?php echo $home."information/list.php?category=".$category."&page=".$i; ?>"> 
       
       <?php echo $i; ?>  

      </a>

<?php }
?>

</div>
        <div class="innyc" >
                <div class="topicimage-l1">
                    <p id="yahei"> <?php echo $category_name[$category];?> </p>
                </div>          

<?php               
                $article_l = FORUM::get_article_list_page($category, $page, $pagesize);
                foreach ( $article_l as $key => $article ) { 
                $comment = FORUM::get_comment_info($article['bid'],1);         
            ?>


           <?php include $home."template/information_new/article_list.php" ?>
            
<?php }
?>

        </div>
