<div class="div-popup" id="edit-group-info">
    <a href="javascript:" class="popup-close"><span class="glyphicon glyphicon-remove"></span></a>
    <section class="popup-main">
            <header>
                <h1>修改群组信息</h1>
            </header>
            <article class="modify-group-form">
			     <form class="modifyForm" name="modifyForm" method="post" action="" enctype="multipart/form-data" onSubmit="return chk_modify(this)">            

                    <p>群组名称: </p>
                    <input name="edit_title" type="text" class="modify_form_class" placeholder="群组名称" value="<?php echo $info_list['title'];?>"/>

                    <p>群组类型: </p>
                    <select name="edit_category" class="modify_form_class">
<?php foreach ($group_catalog_list as $catalog_id => $catalog_name) {
            if ($catalog_name == $info_list['群组类型']){
?>
                    <option id="option-group-catalog-list" value="<?php echo $catalog_id ?>" selected><?php echo $catalog_name; ?></option>
<?php       } else { ?>
                    <option id="option-group-catalog-list" value="<?php echo $catalog_id ?>" ><?php echo $catalog_name; ?></option>
<?php       }
    }
?>
                    </select>
              
                              
                <p>人数规模: </p>
                <input name="edit_size" type="text" class="modify_form_class" placeholder="群组规模" value="<?php echo (isset($info_list['人数规模'])?$info_list['人数规模']:''); ?>" maxlength="30"/>
              
                <p>群组标签: </p>
<!--                <input name="edit_tag"   type="text" class="modify_form_class" placeholder="群组标签" value="<?php echo (isset($info_list['群组标签'])?$info_list['群组标签']:''); ?>" maxlength="60"/>-->
                <div class="edit_tag">
                <input type="text" name="edit_tag" class="tag-value none_class" value="<?php echo (isset($info_list['群组标签'])?$info_list['群组标签']:''); ?>"/>
                    <div class="search-right-filter">
                        <ul class="ul-search-filter-list">
<?php foreach ($group_filter_list as $filter_id => $filter) { ?>
                            <li>
                                <span id="search-filter-list-<?php echo $filter_id; ?>" class="search-filter-list search-filter-list-<?php echo $filter['class']; ?> <?php if ($filter['title'] == '全部') {echo 'none_class';}?>" href="javascript:" onclick="<?php echo $filter['action']; ?>"><?php echo $filter['title']; ?></span>
                            </li>
<?php } ?>
                        </ul>
                    </div>
                </div>

                <p>群组公告: </p>
                <textarea name="group_announcement" class="group_description" placeholder="群组公告" value="<?php echo (isset($info_list['群组公告'])?$info_list['群组公告']:''); ?>"><?php echo (isset($info_list['群组公告'])?$info_list['群组公告']:''); ?>
                </textarea>              

                <p>群组描述: </p>
                <textarea name="group_description" class="group_description" placeholder="群组描述" value="<?php echo (isset($info_list['群组描述'])?$info_list['群组描述']:''); ?>"><?php echo (isset($info_list['群组描述'])?$info_list['群组描述']:''); ?>
                </textarea>
                
				<input type="reset" name="button" class="edit_button" value="取消修改" onclick="hidePopup('.div-popup')" style="cursor: pointer;" />
				<input type="submit" name="edit_submit" class="edit_button" value="保存修改" />
          </form>
		</article>
	</section>
</div>