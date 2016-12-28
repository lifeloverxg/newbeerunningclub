<div class="post-article">
	<div class="post-article-frame">
		<div class="post-article-inner">

			<h3 style="margin:0"> 发表文章 </h3>
			<hr style="border:1px solid #0e0e0e; margin-top: 10px;" />

			<form method="post" action="" enctype="multipart/form-data" onSubmit="return sync()">
			    <textarea id="editor_article" name="article_content" style="width:99%; height: 300px">
                </textarea>

                <p style="margin-top: 15px;">标题 </p> 
                <input  name="article_title" type="text"  style="margin-top: 15px;" >  </input>
                  <br /> 

                <p>  分类 </p> 
                <select name="article_category">
                    <?php foreach ($article_catalog_list as $catalog_id => $catalog_name) { ?>
                    <option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
                    <?php } ?>
                </select>
                <br />

                <p >标签 </p> 
                <input name="article_tag" type="text" >  </input>
                <br /> 

                <p>  权限 </p> 
                <select name="article_privacy">
            	    <?php foreach ($article_privacy_list as $catalog_id => $catalog_name) { ?>
				    <option value="<?php echo $catalog_id; ?>"><?php echo $catalog_name; ?></option>
                    <?php } ?>
                </select>
                  <br />
                <div class="article-bottom-button" style="display: block; width: 100%; margin: 0px auto; text-align: center; margin-bottom: 50px;"> 
                    <input style="" id="article_submit" name="article_submit" type="submit" value="提交">  </input>
                    <button style="" onclick= "hide_article_panel()" type="reset"> 取消 </button>
                </div>
            </form>

	    </div>
	</div>
</div>
<style type="text/css">
.post-article
{
    display: none;
    margin: 0px auto;
	position: fixed;
    bottom: 0px;
    right: none;
    width: 100%;
    height: 100%;
    z-index: 150;
    background: rgba(0, 0, 0, 0.5);
    overflow: scroll;
}
.post-article-frame
{
	top:0;
    bottom: 100px;
	width: 60%;
	/*height: 700px;*/
	margin: 20px auto;
	background-color: #ffffcc;
}
.post-article-inner
{
	display: block;
	width: 92%;
	/*height: 92%;*/
	margin-right: auto;
	margin-left: auto;
	padding-top: 30px;
	overflow: hidden;

}
.post-article-inner>form>p
{
	float: left;
	font-family: 'Microsoft Yahei', '微软雅黑', Arial, sans-serif;
    font-size: 16px;
    color: #000;
    padding: 0;
    margin: 0;
    margin-bottom: 10px;
    overflow: hidden;
}
.post-article-inner>form>input
{
    margin-left: 20px;
    width: 182px;
    margin-bottom: 15px;
    height: 17px;
    padding: 1px 0 1px 0;
    border: 1px solid #aba9a9;
}
.post-article-inner>form>select
{
    margin-left: 20px;
    width: 184px;
    margin-bottom: 15px;
    height: 21px;
    border: 1px solid #aba9a9;
}
.post-article-inner>form button
{
	width: 105px;
	height: 30px;
	background-color: #fbf8f8;
	border-radius: 6px;
	border: 1px solid #aba9a9;
	font-family: 'Microsoft Yahei', '微软雅黑', Arial, sans-serif;
    font-size: 16px;
}
#article_submit
{
    width: 105px;
    height: 30px;
    background-color: #fbf8f8;
    border-radius: 6px;
    border: 1px solid #aba9a9;
    font-family: 'Microsoft Yahei', '微软雅黑', Arial, sans-serif;
    font-size: 16px;

}
</style>
<script charset="utf-8" src="<?php echo $home. "editor/kindeditor.js"; ?>"></script>
<script charset="utf-8" src="<?php echo $home. "editor/lang/zh_CN.js"; ?>"></script>
<script>
        KindEditor.ready(function(K) {
                window.editor = K.create('#editor_article');
        });
</script>