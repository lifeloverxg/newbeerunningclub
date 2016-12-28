<div class="div-popup" id="show-mail_oper">
    <a href="javascript:" class="popup-close"><span class="glyphicon glyphocon-remove"></span></a>
    <section class="popup-main">
        <header>
            <h1>成员邮件管理 - <?php echo $info_list['title']; ?></h1>
        </header>
        <article class="article-mail-oper">
			<!-- <form class="modifyForm" name="modifyForm" method="post" action="" enctype="multipart/form-data" onSubmit="return chk_modify(this)"> -->
                <div class="mail-receiver">
                    <p>收件人:</p>
                    <input name="mail_receiver" type="text" class="mail-oper" id="mail_oper_receiver" placeholder="收件人" value="To: All" disabled="disabled" maxlength="20"/>          
                </div>
                <div class="mail-subject">
                    <p>主题:</p>
                    <input name="mail_subject" type="text" class="mail-oper" id="mail_oper_subject" placeholder="subject..." value="重要文件<?php echo (isset($mail_subject)?$$mail_subject:''); ?>" maxlength="100"/>
                </div>
              
                <div class="mail-content">
                    <p>邮件:</p>
                    <textarea name="mail_content" class="textarea-mail-content" id="mail_oper_content" placeholder="content..." title="邮件内容..." value="邮件内容">感谢您的大力支持</textarea>
                </div>
                
                <input type="button" class="btn" id="sub_btn" value="发送邮件" onclick="send_event_groupmail('<?php echo $mail_list_string; ?>')">
         <!--  </form> -->
		</article>
                <p><span id="chkmsg">等待发送...</span></p>
	</section>
</div>
