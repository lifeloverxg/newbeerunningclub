		<section class="section-home">
			<div class="div-recommend">
				<ul class="ul-recommend">
<?php foreach ($index_event_list as $key =>$event) { ?>
					<li id="li-recommend-<?php echo $key; ?>">
						<a href="<?php echo $event['url']; ?>">
							<img src="<?php echo $home . $event['image']; ?>" alt="<?php echo $event['alt']; ?>" title="<?php echo $event['title']; ?>">
						</a>
					</li>
<?php } ?>
				</ul>
			</div>
			<nav>
				<ul class="main-menu">
					<li id="menu-event">
						<a href="<?php echo $home.$links['event']; ?>">活动</a>
						<!-- <p>
							和小伙伴们一起 分享乐趣<br>结识新的朋友 开始纽约的冒险
						</p> -->
					</li>
					<li id="menu-group">
						<a href="<?php echo $home.$links['group']; ?>">群组</a>
						<!-- <p>
							一个好汉三个帮<br>加入开创自己的地盘
						</p> -->
					</li>
					<li id="menu-people">
						<a href="<?php echo $home.$links['people']; ?>">个人</a>
					</li>
					<li id="menu-faq">
						<a href="<?php echo $home.$links['faq']; ?>">综合</a>
						<!-- <p>
							你想知道的<br>你不知道的<br>你能让大家知道的
						</p> -->
					</li>
				</ul>
			</nav>
		</section>
