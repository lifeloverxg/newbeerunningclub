	<section>
		<div class="spec-uni_film-up">
			<div class="spec-uni-film-up-left">
				<object width="450" height="325">
					<param name="movie" value="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&
					color2=0x6b8ab6&border=1&fs=1"></param>
					<param name="allowFullScreen" value="true"></param>
					<embed src="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&color2=0x6b8ab6&border=1&fs=1"
					type="application/x-shockwave-flash"
					width="450" height="325" 
					allowfullscreen="true"></embed>
				</object>
			</div>
			<div class="spec-uni-film-up-right">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1">剪辑1</a></li>
					<li class=""><a href="#tab2">剪辑2</a></li>
					<li class=""><a href="#tab3">剪辑3</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<object width="225" height="175">
							<param name="movie" value="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&
							color2=0x6b8ab6&border=1&fs=1"></param>
							<param name="allowFullScreen" value="true"></param>
							<embed src="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&color2=0x6b8ab6&border=1&fs=1"
							type="application/x-shockwave-flash"
							width="225" height="175" 
							allowfullscreen="true"></embed>
						</object>
					</div>

					<!-- /tabs -->
					<div class="tab-pane" id="tab2">
						<object width="225" height="175">
							<param name="movie" value="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&
							color2=0x6b8ab6&border=1&fs=1"></param>
							<param name="allowFullScreen" value="true"></param>
							<embed src="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&color2=0x6b8ab6&border=1&fs=1"
							type="application/x-shockwave-flash"
							width="225" height="175" 
							allowfullscreen="true"></embed>
						</object>
					</div>

					<!-- /tabs -->
					<div class="tab-pane" id="tab3">
						<object width="225" height="175">
							<param name="movie" value="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&
							color2=0x6b8ab6&border=1&fs=1"></param>
							<param name="allowFullScreen" value="true"></param>
							<embed src="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&color2=0x6b8ab6&border=1&fs=1"
							type="application/x-shockwave-flash"
							width="225" height="175" 
							allowfullscreen="true"></embed>
						</object>
					</div>
				</div>
			</div>
		</div>
		
		<div class="spec-uni_film-down">
			<div class="spec-uni_film-down-top">
				<div class="spec-image-region">
					<div id="myCarousel" class="carousel slide" data-interval="false">
			          	<!-- Indicators -->
			            <ol class="carousel-indicators">
			              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			              <li data-target="#myCarousel" data-slide-to="1"></li>
			              <li data-target="#myCarousel" data-slide-to="2"></li>
			            </ol>
			            <!-- Wrapper for slides -->
			            <div class="carousel-inner">
			              <div class="item active">
			                <img src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/"; ?>images/carousel/image-01.jpg" alt="">
			                <div class="carousel-caption">
			                  <h3>Thumbnail label</h3>
			                  <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec.</p>
			                </div>
			              </div>
			              <div class="item">
			                <img src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/"; ?>images/carousel/image-02.jpg" alt="">
			                <div class="carousel-caption">
			                  <h3>Thumbnail label</h3>
			                  <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec.</p>
			                </div>
			              </div>
			              <div class="item">
			                <img src="<?php echo $home . "theme/Flat-UI-Pro-1.2.5/"; ?>images/carousel/image-03.jpg" alt="">
			                <div class="carousel-caption">
			                  <h3>Thumbnail label</h3>
			                  <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec.</p>
			                </div>
			              </div>
			            </div>
			            <!-- Controls -->
			            <a class="left carousel-control fui-arrow-left" href="#myCarousel" data-slide="prev"></a>
			            <a class="right carousel-control fui-arrow-right" href="#myCarousel" data-slide="next"></a>
			        </div>
				</div>

				<div class="spec-mv-region">
					<object width="320" height="215">
						<param name="movie" value="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&
						color2=0x6b8ab6&border=1&fs=1"></param>
						<param name="allowFullScreen" value="true"></param>
						<embed src="https://www.youtube.com/v/u1zgFlCw8Aw?rel=1&color1=0x2b405b&color2=0x6b8ab6&border=1&fs=1"
						type="application/x-shockwave-flash"
						width="320" height="215" 
						allowfullscreen="true"></embed>
					</object>
				</div>
			</div>

			<div class="spec-uni_film-down-down">
				<div class="spec-board-region">
					<p>留言框</p>
					<div class="div-spec-add-feed">
						<p>您的名字: </p><input type="text" style="width: 30%; margin-bottom: 10px;" class="form-control input-sm" name="user" id="user" required="" placeholder="您的名字" value="<?php if ($username != "") {echo $username;} ?>">
						<!-- <input type="text" class="form-control input-sm" name="event" id="event" placeholder="您想要怎样的活动, 比如电影, 登山, 篮球, 看书, 跑步">
						<input type="text" class="form-control input-sm" name="group" id="group" placeholder="您想要怎样的群组, 比如电影, 登山, 篮球, 看书, 跑步"> -->
						<!-- <input type="text" name="feed" id="feed" placeHolder="您想对我们说什么"> -->
						<div>
							<!-- <textarea class="comment-textarea" placeholder="您的留言..." title="您的留言..." value="您的留言..." style="resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; height: 99px; width: 446px; line-height: 24px; text-decoration: none; letter-spacing: 0px;" tabindex="-1"></textarea>
							<textarea class="comment-textarea" placeholder="您的留言..." title="您的留言..." value="您的留言..." style="resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; height: 99px; width: 446px; line-height: 24px; text-decoration: none; letter-spacing: 0px;" tabindex="-1"></textarea>
							<textarea class="comment-textarea" placeholder="您的留言..." title="您的留言..." value="您的留言..." style="resize: none; overflow-y: hidden; position: absolute; top: 0px; left: -9999px; height: 99px; width: 446px; line-height: 24px; text-decoration: none; letter-spacing: 0px;" tabindex="-1"></textarea> -->
							<p>您的留言: </p><textarea class="comment-textarea form-control" style="width: 70%; margin-bottom: 10px;" id="comment-textarea" placeholder="您的留言..." title="您的留言..." value="您的留言..." style="resize: none; overflow-y: hidden;"></textarea>
						</div>
						<p><span id="chkmsg"></span></p>
						<!-- <input type="text" name="username" id="username" required placeHolder="原用户名"> -->
						<!-- <input type="button" class="btn" id="sub_btn" value="发表" onclick="spec_add_feed()"> -->
						<button class="btn btn-lg btn-block btn-info" style="width: 25%; height: 30px; float: right; padding: 0px;" id="sub_btn" onclick="spec_add_feed()">发表</button>
					</div>
				</div>

				<div class="spec-about-region">
					<div class="demo-col">
						<a href="#fakelink" class="btn btn-default btn-sm btn-social-googleplus">
							<span class="fui-googleplus"></span>
							Connect with Google
						</a>
						<a href="#fakelink" class="btn btn-default btn-sm btn-social-facebook">
							<span class="fui-facebook"></span>
							Connect with Facebook
						</a>
						<a href="#fakelink" class="btn btn-default btn-sm btn-social-twitter">
							<span class="fui-twitter"></span>
							Connect with Twitter
						</a>
					</div>
				</div>
		</div>
	</div>
	</section>