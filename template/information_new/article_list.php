            <div class="news">
                <div class="news-logo">
                     <img src=<?php echo $home."theme/images/news_logo.png"?> > 
                </div>
                <div class="news-content">
                    <p style="margin-top:20px" id="heiti">
                        <a href="<?php echo $home.$article['url']; ?>" style="text-decoration: none; color: #000" > <?php echo $article['title']; ?>：</a>
                    </p>
                    <p id="heiti" style="color: rgb(137, 137, 137); text-align: justify; text-indent: 2em; height:60px; "> <?php echo $article['content']; ?>... </p> 
                    <p id="heiti">发表人：<?php echo $article['name']; ?></p>
                </div>
                <div class="news-reply">
                    <div class="people-icon">
                       <img src="<?php if( $comment[0]['avatar'] == '' ) echo $home."theme/images/default/default_people"; else echo $home.$comment[0]['avatar']; ?>_small.jpg"> 
                    </div>
                    <div class="reply-info">
                        <p id="heiti" style="float:left;"> Re：  </p>
                        <p id="heiti" style="color: rgb(137, 137, 137); text-align: justify; float:left; "> <?php echo $comment[0]['text'] ?>  …</p>
                        </br>
                        <p id="heiti" style="color: rgb(137, 137, 137);">by：<?php echo $comment[0]['name'] ?></p>
                    </div>
                </div>
            </div>
            
