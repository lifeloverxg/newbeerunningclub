 <div class="right-half">
        <div class="share-frame">
            <div class="share-header">
                <p class="right-title">Share Through Wechat</p>
            </div>
            <div class="share-wechat">
                <img src="<?php echo $home."theme/images/Nycuni_wechat.jpg"; ?>">
                <div class="NYCuni-com">
                    <p id="uni">NYCuni.com</p>
                    <p id="uni" style="font-size:22px; letter-spacing:3px;">纽约有你</p>                
                    <p id="uni" style="color: rgb(89,87,87);font-weight:normal">公共平台</p>
                </div>
            </div>
        </div>
        <div class="share-media">
                <div class="jiathis-border">
                    <a href="http://service.weibo.com/share/share.php?appkey=907989633&title=<?php if (isset($eid)) {echo '来自nycuni.com的活动: '.$info_list['title'].'    活动描述: '.$info_list['活动描述'];} else if (isset($gid)) {echo '来自nycuni.com的群组: '.$info_list['title'].'    群组描述: '.$info_list['群组描述'];} else {echo '来自nycuni.com的好友分享: '.$info_list['title'].'    个性签名: '.$info_list['个人签名'].'   属性: '.$info_list['属性'];}?>&url=<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>&pic=<?php echo $_SERVER['HTTP_HOST'].'/'.$large_logo['image'];?>&searchPic=true&style=simple" target="_blank">
                        <img src="<?php echo $home . "theme/icon/sina.png"?>" alt="分享到新浪" title="分享到新浪"/>
                    </a>
                </div>             
                <div class="jiathis-border">
                    <a href="javascript:" onclick="show_wechatShare()" title="分享到微信">
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
        <div class="school-admin">
            <div class="share-header">
                <p class="right-title">Administrators</p>
            </div>
            <div class="school-admin-list">
                <?php foreach ($admin_list_small as $admin) { ?>
                <div class="school-admin-member">
                            <a href="<?php echo $home.$admin['url']; ?>">
                                <img src="<?php echo $home.$admin['image']; ?>" alt="<?php echo $admin['alt']; ?>" title="<?php echo $admin['title']; ?>">                          
                                <p id="heiti" style="height:38px;line-height:19px;"><?php echo $admin['title']; ?></p>
                            </a>
                </div>
               <?php } ?>
            </div>
        </div>
        <div class="school-member">
            <div class="share-header">
                <p class="right-title" style="display:inline-block">Participants</p> 
                <a href="<?php echo $home . "group/member_list.php?gid=".$gid; ?>"><p class="right-title" style="color: #ccc; font-size: 14px;display:inline-block">/ See all</p></a>
            </div>
            <div class="school-member-list">
<?php $i=0; foreach ($member_list_small as $member) { $i++; if($i>6) break;?>
                    <div class="school-admin-member">
                        <a href="<?php echo $home.$member['url']; ?>">
                            <img src="<?php echo $home.$member['image']; ?>" alt="<?php echo $member['alt']; ?>" title="<?php echo $member['title']; ?>">
                            <p id="heiti" style="height:38px;line-height:19px;"><?php echo $member['title']; ?></p>
                        </a>
                    </div>
<?php } ?>
            </div>
        </div>
   
    </div>