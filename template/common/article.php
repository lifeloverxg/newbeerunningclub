<section class="section-feed-list-large">
  <header class="tag-tabs">
    <ul class="ul-tag-list">
<?php foreach ($article['tag_list'] as $tag) { ?>
      <li>
        <a class="tag-tabs-list" href="javascript:" onclick="<?php echo $tag['action']; ?>"><?php echo $tag['title']; ?></a>
      </li>
<?php } ?>
    </ul>
  </header>

  <div class="feed-list-content">
    <article>
  <!-- Article Content -->
      <ul class="ul-feed-list-large">
  <?php if (!empty($article['content'])) { ?>
        <li class="li-feed-list-large">
  <!-- left area: poster -->
          <div class="feed-left-area">
            <a href="<?php echo $home.$article['owner']['url']; ?>">
              <img class="logo-medium" src="<?php echo $home.$article['owner']['image_large']; ?>" alt="<?php echo $article['owner']['alt']; ?>" title="<?php echo $article['owner']['title']; ?>">
            </a>
          </div>
  <!-- right area-->
          <div class="feed-right-area">
  <!-- board area -->
            <div class="div-feed-list-feed">
  <!-- board content -->
              <a href="<?php echo $home.$article['owner']['url']; ?>">
                <span class="list-title-member"><?php echo $article['owner']['title']?></span>
              </a>
              <p><?php echo $article['title']; ?></p>
              <p><?php echo $article['content']; ?></p>
  <!-- board timestamp -->
              <span class="time-feed"><?php echo $article['ctime']; ?></span>
            </div>
            <div class="div-feed-list-comment-list">
              <div class="div-feed-list-more-comment" id="div-feed-list-more-comment-<?php echo $article['id']; ?>">
              </div>
  <!-- comment list -->
              <ul class="ul-feed-list-comment-list" id="ul-feed-list-comment-list-<?php echo $article['id']; ?>">
  <?php 		foreach ($article['comments']['comment'] as $comment) { ?>
                <li>
                  <a href="<?php echo $home.$comment['owner']['url']; ?>">
                    <img class="logo-small" src="<?php echo $home.$comment['owner']['image']; ?>" alt="<?php echo $comment['owner']['alt']; ?>" title="<?php echo $comment['owner']['title']; ?>">
                  </a>
                  <div class="comment-right-area">
  <!-- replyer name -->
                    <a class="replyer-title" href="<?php echo $home.$comment['owner']['url']; ?>"><?php echo $comment['owner']['title']; ?></a>
                    <p><?php echo $comment['content']; ?></p>
                    <span class="comment-time-feed"><?php echo $comment['timestamp']; ?></span>
                  </div>
                </li>
  <?php 		} ?>
              </ul>
            </div>
  <?php 		if($auth['uid'] > 0) { ?>
  <!-- reply area -->
  <!--如果是游客则不显示回复窗口-->
            <div class="ul-feed-list-reply">
              <a href="<?php echo $home.$auth['url']; ?>">
                <img class="self-logo-small" src="<?php echo $home.$auth['image']; ?>" alt="<?php echo $auth['alt']; ?>" title="<?php echo $auth['title']; ?>">
              </a>
              <div>
                <textarea class="comment-textarea" id="comment-textarea-<?php echo $article['id']; ?>" placeholder="发表评论" title="发表评论" value="发表评论"></textarea>
                <button class="button-reply" onclick="<?php echo $article['func']['reply']; ?>">评论</button>
              </div>
            </div>
  <!-- 结束回复板块 -->
  <?php 		} ?>
          </div>
        </li>
  	</ul>
  <?php } ?>
  <!-- Comments -->
    </article>
    <footer class="more-list-large">
    </footer>
  </div>
</section>
