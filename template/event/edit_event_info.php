<div class="div-popup" id="edit-event-info">
    <a href="javascript:" class="popup-close"><span class="glyphicon glyphocon-remove"></span></a>
    <section class="popup-main">
        <header>
            <h1>修改活动信息</h1>
        </header>
        <article class="edit-event-form">
			<form class="modifyForm" name="modifyForm" method="post" action="" enctype="multipart/form-data" onSubmit="return chk_modify(this)">
                
                <p>活动名称: </p>
                <input name="edit_title" type="text" class="modify_form_class" placeholder="活动名称" value="<?php echo $info_list['title'];?>" maxlength="120"/>

                <p>活动类型: </p>
                <select name="edit_category" class="modify_form_class" placeholder="活动类型">
<?php foreach ($event_catalog_list as $catalog_id => $catalog_name) {
            if ($catalog_name == $info_list['活动类型']){
?>
                <option id="option-event-catalog-list" value="<?php echo $catalog_id ?>" selected><?php echo $catalog_name; ?></option>
<?php       } else { ?>
                <option id="option-event-catalog-list" value="<?php echo $catalog_id ?>" ><?php echo $catalog_name; ?></option>
<?php       }
    }
?>
                </select>
                <p>活动时间: </p>
                <div class="event_time">
                    <input type="text" name="edit_start_time" id="datetimepicker-start" class="modify_form_class" value="<?php echo (isset($event_time['start_time'])?$event_time['start_time']:''); ?>"/>
                    <a href="javascript:" id="add-end-time">添加结束时间</a>
                    <input type="text" name="edit_end_time" id="datetimepicker-end" class="modify_form_class" value="<?php echo (isset($event_time['end_time'])?$event_time['end_time']:''); ?>"/>
                    <a href="javascript:" id="cancel-end-time">取消</a> 
                </div>
              
                <p>活动地点: </p>
            <!--<input name="edit_location" type="text" class="modify_form_class" placeholder="活动地点" value="<?php echo (isset($info_list['活动地点'])?$info_list['活动地点']:''); ?>" maxlength="100"/>-->
<?php foreach($address as $key => $value) { ?>
                <input name="edit_location_<?php echo $key; ?>" type="text" class="modify_form_class location_<?php echo $key; ?>" placeholder="<?php echo $key; ?>" value="<?php echo $value; ?>" maxlength="100"/>
<?php } ?>        

<!--<?php include $home . "template/common/map_form.php"; ?>-->
              
              
                <p>人数规模: </p>
                <input name="edit_size" type="text" class="modify_form_class" placeholder="活动规模" value="<?php echo (isset($info_list['规模'])?$info_list['规模']:''); ?>" maxlength="100"/>
              
              
                <div class="div-edit-event-tag">
                    <p style="height: 80px;">活动标签: </p>
    <!--                <input name="edit_tag"   type="text" class="modify_form_class" placeholder="活动标签" value="<?php echo (isset($info_list['活动标签'])?$info_list['活动标签']:''); ?>" maxlength="100"/> -->
                    <div class="edit_tag">
                    <input type="text" name="edit_tag" class="tag-value none_class" value="<?php echo (isset($info_list['活动标签'])?$info_list['活动标签']:''); ?>"/>
                        <div class="search-right-filter">
                            <ul class="ul-search-filter-list">
<?php foreach ($event_filter_list as $filter_id => $filter) { ?>
                                <li>
                                    <span id="search-filter-list-<?php echo $filter_id; ?>" class="search-filter-list search-filter-list-<?php echo $filter['class']; ?> <?php if ($filter['title'] == '全部') {echo 'none_class';}?>" href="javascript:" onclick="<?php echo $filter['action']; ?>"><?php echo $filter['title']; ?></span>
                                </li>
<?php } ?>
                            </ul>
                        </div>
                    </div>
                 </div>
              
              
                <p>活动收费: </p>
                <input name="edit_price" type="text" class="modify_form_class" placeholder="活动收费" value="<?php echo (isset($info_list['活动收费'])?$info_list['活动收费']:''); ?>" maxlength="100"/>
                
              
                <p>活动描述: </p>
                <textarea name="event_description" class="event_description" id="edit_event_description" placeholder="活动描述" title="活动描述..." value="<?php echo (isset($info_list['活动描述'])?$info_list['活动描述']:''); ?>"><?php echo (isset($info_list['活动描述'])?$info_list['活动描述']:''); ?></textarea>
                
				<input type="reset" name="button" class="edit_button" value="取消修改" onclick="hidePopup('.div-popup')" style="cursor: pointer;"/>
				<input type="submit" name="edit_submit" class="edit_button" value="保存修改" />
          </form>
		</article>
	</section>
</div>
