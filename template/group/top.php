			<header class="top top-group">
				<div class="top-search-wrap">
					<div class="top-search-wrap-tabs">
						<div class="page-title">
							群组
						</div>
						<div class="search-tabs">
							<ul class="nav nav-tabs">
	<?php foreach ($search_tabs as $tab_id => $tabs) { ?>
		                    <li <?php if ($tab_id == 0) { echo "class='active'"; }?>>
		                        <a href="#tab<?php echo ($tab_id+1); ?>">
		                            <p><?php echo $tabs; ?></p>
		                        </a>
		                    </li>
		                    <div class="search-tab-border-right">
		                    </div>
	<?php } ?>                  
		                	</ul>
		                </div>
		            </div>
				</div>
				

				<div class="top-create-btn shake shake-slow">
					<div class="span-create-btn">
						自己有想法?<!-- <img src="<?php echo $home . "theme/images/event_create_span.png"; ?>"/> -->
					</div>
					<ul class="ul-button-list-large">
<?php foreach ($button_list_large as $button) { ?>
						<li>
							<button onclick="<?php echo $button['action']; ?>" class="create-btn"><?php echo $button['title']; ?></button>
						</li>
<?php } ?>
					</ul>
				</div>
			</header>

			<!-- <div class="shake">Hello world</div>
			<div class="shake shake-hard">Hello world</div>
			<div class="shake shake-slow">Hello world</div>
			<div class="shake shake-little">Hello world</div>
			<div class="shake shake-horizontal">Hello world</div>
			<div class="shake shake.vertical">Hello world</div>
			<div class="shake shake-rotate">Hello world</div>
			<div class="shake shake-opacity">Hello world</div>
			<div class="shake shake-crazy">Hello world</div> -->