<div class="left-half">
    	<div class="school-intro">
            <div class="school-logo">
    		    <img src="<?php echo $home.'theme/images/nyu.png'?>" id="school-logo">
                </br>
                <?php if (isset($_SESSION['auth'])) { ?>   
                <?php if ($viewer_role >= Role::Admin) { ?>
                <button type="text" onclick="<?php echo 'window.location=\'manage_member.php?gid='.$gid.'\''; ?>">管理
                </button>
                <button type="text" onclick="<?php echo "create_event(" . $auth['uid'] . ")"; ?>">创建活动
                </button>
                <?php }
                ?>
                <?php if ($viewer_role < Role::Member ) { ?>
                <button type="text" onclick="<?php echo 'group_oper('. $auth['uid'] .','.$gid.',\'join\')'; ?>">加入
                </button>
                <?php }
                ?>
                <?php if ($viewer_role == Role::Member ) { ?>
                <button type="text" onclick="<?php echo "create_event(" . $auth['uid'] . ")"; ?>">创建活动
                </button>
                <button type="text" onclick="<?php echo 'group_oper('. $auth['uid'] .','.$gid.',\'leave\')'; ?>">退出
                </button>
                <?php }
                ?>
                <?php }
                ?>
            </div>
    		<p id="heiti" style="font-size:16px; margin:10px 0 0 15px;">
            NYU is a university in and of the city and in and of the world. 
            Based in the heart of Greenwich Village with facilities located 
            throughout Manhattan and Brooklyn, the traditional boundaries 
            of the classroom are limitless, providing students and faculty 
            with the unique opportunity to learn, teach, and grow iworld's most dynamic city. 
    		</p>
    	</div>

    	<div class="school-event">
            <a href="<?php echo $home."group/e_list.php?gid=".$gid; ?>">
        		<div class="event-title">               
                    <p id="title">Event</p>             
                </div>
            </a>
            <div class="school-event-list">
            <?php
            foreach ( $event_list as $key => $value)  { $event = School::get_event_info($value['eid'])?>
            <a href="<?php echo $home."event?eid=". $value['eid']?>">
                <div class="event-description">
                    
                    <img src="<?php echo $home.$event['logo']."_large.jpg"?>" class="event-logo">
                    
                    </br>
                    <div class="event-place">
                    <p style="color: #000;height:38px;"> <?php echo $event['title']?></p>
                    <p style="font-size:12px; color: rgb(89,87,87)"><?php echo $event['start_time']?></p>
                    </div>
                </div>
                </a> 
            <?php }
?>
            </div>
    	</div>

       <div class="school-article" style="overflow:scroll; overflow-x:hidden; height:300px;">
            <div class="event-title">
                <!-- <a href="<?php echo $home."group/a_list.php?gid=".$gid; ?>"> -->
                <p id="title">Article</p>
                <!-- </a> -->
            </div>
            <?php 
            foreach ( $article_list as $key => $article) { ?>
                <div class="school-article-list">
                    <a href="<?php echo $home.$article['url']; ?>">
                        <p id="heiti" style="font-size:16px;float:left;"><?php echo $article['title']; ?></p>
                    </a>
                        <p id="heiti" style="float:right;"> <?php echo $article['time']; ?> </p>
                </div>
            <?php }
?> 

        </div>

    	<div class="school-comment" >
    		<div class="comment-title">
                <p id="title" style="color: #4c94b5;">Comment</p>
            </div>
            <!-- <div class="comment-class">
                <span>All</span>
                <button>发表点评</button>
            </div> -->
            <?php
    include $home . "cgi/feed_list.php";
?>
    	</div>
    </div>