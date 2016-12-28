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
        综合 
    </span>
    <hr style="border:1px dotted rgb(210,210,210); margin-top: 10px;" />
</div> 

<?php include $home."template/information_new/search_and_release.php" ?>

        <div class="special">
            <div class="topicimage-l1" style="background-color: rgb(211, 35, 56); border: 1px solid rgb(211, 35, 56);">
                <a href="<?php echo $home.'information/new'?>">
                    <p id="yahei"> SPECIAL EVENT : 新生入学</p>
                </a>
            </div>
        </div>

<!-- Topic Image -->
    	<div class="topicimage">
            <div class="topicimage-l1">
            </div>
            <div class="topicimage-l2">
                <div class="puzzle1" style="background-color: rgb(253, 210, 62)">
                </div>
                <div class="puzzle1" style="background-color: rgb(125, 70, 152)">
                    <p> 吃 </p>
                </div>
                <div class="puzzle1" style="background-color: rgb(142, 196, 62)">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(255, 141, 0)">
                </div>
                <div class="puzzle1" style="background-color: rgb(77, 67, 152); padding-bottom:4px; margin-bottom:0;">
                    <p> 梦 </p>
                </div>
                <div class="puzzle1" style="background-color: rgb(125, 70, 152)">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(255, 141, 0)">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(76, 148, 181)">
                    <p>玩</p>
                </div>
                <div class="puzzle1" style="background-color: rgb(142, 196, 62)">
                </div>
                <div class="puzzle1" style="background-color: rgb(77, 67, 152); padding-top:4px; margin-top:0;">
                    <p>想</p>
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(125, 70, 152)">
                    <p>喝</p>
                </div>
                <div class="puzzle1" style="background-color: rgb(77, 67, 152);">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(76, 148, 181)">
                </div>
                <div class="puzzle1" style="background-color: rgb(253, 210, 62)">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(125, 70, 152)">
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(253, 210, 62)">
                </div>
                <div class="puzzle1" style="background-color: rgb(181, 76, 99)">
                    <p>乐</p>
                </div>
                <div class="puzzle1" style="background-color: #fff">
                </div>
                <div class="puzzle1" style="background-color: rgb(255, 141, 0)">
                </div>
            </div>
        </div>

<!-- 人在纽约 -->
        <div class="innyc">

            <a href="<?php echo $home."information/list.php?category=0&page=1" ?>">
                <div class="topicimage-l1">
                    <p id="yahei"> 人在纽约 </p>
                </div>
            </a>

<?php               
                $article_l = FORUM::get_article_info(0, 5);
                foreach ( $article_l as $key => $article ) { 
                $comment = FORUM::get_comment_info($article['bid'],1);         
            ?>

           <?php include $home."template/information_new/article_list.php" ?>
            
<?php }
?>

        </div>
<!-- 茶余饭后 -->
        <div class="innyc">

            <a href="<?php echo $home."information/list.php?category=1&page=1" ?>">
                <div class="topicimage-l1">
                    <p id="yahei"> 茶余饭后 </p>
                </div>
            </a>


<?php               
                $article_l = FORUM::get_article_info(1, 4);
                foreach ( $article_l as $key => $article ) { 
                $comment = FORUM::get_comment_info($article['bid'],1);         
            ?>


            <?php include $home."template/information_new/article_list.php" ?>

<?php }
?>

        </div>