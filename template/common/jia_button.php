			<div class="jiathis_style_32x32">
			    <div class="jiathis-border">
			    	<!-- <a class="jiathis_button_tsina"></a> -->
			    	<a href="http://service.weibo.com/share/share.php?appkey=907989633&title=<?php if (isset($eid)) {echo '来自nycuni.com的活动: '.$info_list['title'].'    活动描述: '.$info_list['活动描述'];} else if (isset($gid)) {echo '来自nycuni.com的群组: '.$info_list['title'].'    群组描述: '.$info_list['群组描述'];} else {echo '来自nycuni.com的好友分享: '.$info_list['title'].'    个性签名: '.$info_list['个人签名'].'   属性: '.$info_list['属性'];}?>&url=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&pic=<?php echo $_SERVER['HTTP_HOST'].'/'.$large_logo['image'];?>&searchPic=true&style=simple" target="_blank">
			    		<img src="<?php echo $home . "theme/icon/sina.png"?>" alt="分享到新浪" title="分享到新浪"/>
			    	</a>
			    </div>
			   <!--  <div class="jiathis-border">
			    	<a class="jiathis_button_weixin"></a>
			    </div> -->
			    <div class="jiathis-border">
			    	<a href="javascript:" onclick="show_qr('wechat', '<?php if ( isset($large_logo) ) {echo $large_logo['qr_code'];}?>' , '<?php echo $home; ?>')" title="分享到微信">
						<img src="<?php echo $home . "theme/icon/weixin.png"?>" alt="分享到微信" title="分享到微信"/>
					</a>
			    </div>
			    <div class="jiathis-border">
			    	<a href="javascript:window.open('http://widget.renren.com/dialog/share?resourceUrl='+encodeURIComponent(document.location.href)+'&nbsp;'+encodeURIComponent(document.title));void(0)" title="分享到人人">
			    		<img src="<?php echo $home . "theme/icon/renren.jpg"?>" alt="分享到人人" title="分享到人人"/>
			    	</a>
			    </div>
				<div class="jiathis-border">
					<a href="javascript:window.open('http://twitter.com/home?status='+encodeURIComponent(document.location.href)+'&nbsp;'+encodeURIComponent(document.title));void(0)" title="分享到twitter">
						<img src="<?php echo $home . "theme/icon/twitter.jpg"?>" alt="分享到twitter" title="分享到twitter" />
					</a>
				</div> 
				<div class="jiathis-border">
					<a href="javascript:window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(document.location.href)+'&t='+encodeURIComponent(document.title));void(0)" title="分享到facebook">
						<img src="<?php echo $home . "theme/icon/facebook.png"?>" alt="分享到facebook" title="分享到facebook"/>
					</a>
				</div>
				<div class="jiathis-border">
					<a href="javascript: void(window.open('https://plus.google.com/share?url='.concat(encodeURIComponent(location.href)), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'));">
						<img title="分享到Google+！" src="<?php echo $home . "theme/icon/gplus.jpg"?>" alt="分享到Google+"/>
					</a>
				</div>
			</div>
				<!--<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1351871604472678" charset="utf-8"></script>-->