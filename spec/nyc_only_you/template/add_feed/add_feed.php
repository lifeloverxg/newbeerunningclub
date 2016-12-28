 <section class="spec_add_feed">
 	<div class="div-spec-add-feed">
		<input type="text" name="user" id="user" required placeHolder="您的名字" value="<?php if ($username != "") {echo $username;} 	?>">
		<input type="text" name="event" id="event" placeHolder="您想要怎样的活动, 比如电影, 登山, 篮球, 看书, 跑步">
		<input type="text" name="group" id="group" placeHolder="您想要怎样的群组, 比如电影, 登山, 篮球, 看书, 跑步">
		<!-- <input type="text" name="feed" id="feed" placeHolder="您想对我们说什么"> -->
		<div>
			<textarea class="comment-textarea" id="comment-textarea" placeholder="您想对我们说什么" title="您想对我们说什么" value="您想对我们说什么"></textarea>
		</div>
		<p><span id="chkmsg"></span></p>
		<!-- <input type="text" name="username" id="username" required placeHolder="原用户名"> -->
		<!-- <input type="button" class="btn" id="sub_btn" value="发表" onclick="spec_add_feed()"> -->
		<button class="button-reply btn" id="sub_btn" onclick="spec_add_feed()">发表</button>
	</div>

	<div class="spec-feed-list-large">
			<ul class="ul-spec-feed-list-large">
<?php foreach ($feed_list as $feed_id => $feed) { ?>
				<li class="li-spec-feed-list-large">
					<div class="spec-feed-user">
						<?php echo $feed['user']?>
					</div>
					<div class="spec-feed-right">
						<span class="spec-addressing">活动: </span>
							<?php echo $feed['event']?> |
						<span class="spec-addressing">群组: </span>
							<?php echo $feed['group']?> |
						<span class="spec-addressing">ta的话: </span>
							<?php echo $feed['feed']?>
					</div>
				</li>
<?php } ?>
			</ul>
		</div>
</section>