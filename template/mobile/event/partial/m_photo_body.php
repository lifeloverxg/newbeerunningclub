<div class="ordered-photo">
	<ul class="ul-ordered-photo">
<?php foreach ($photo_list as $photo) { ?>
		<li>
			<img src="<?php echo $home . $photo['image']; ?>" title="<?php echo $photo['title']; ?>" alt="<?php echo $photo['alt']; ?>"><br>
			<p style="color: #999; font-size: 0.8rem;"><?php echo $photo['ctime']; ?></p>
		</li>
<?php } ?>
	</ul>
	<footer class="more-photo">
<?php if (isset($next) && $next != "") { ?>
		<a href="javascript:" style="display: none;" id="load-more-photo" onclick="<?php echo $next; ?>">查看更多</a>
<?php } ?>
	</footer>
</div>