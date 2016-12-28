<div class="div-popup" id="edit-profile-info">
     <a href="javascript:" class="popup-close"><span class="glyphicon glyphicon-remove"></span></a>
    <section class="popup-main">
        <header>
            <h1>修改个人信息</h1>
        </header>
        <article class="modify-profile-form">
			<form class="modifyForm" name="modifyForm" method="post" action="" enctype="multipart/form-data" onSubmit="return chk_modify(this)" style="margin-top:3px; margin-bottom:3px;">            

                <p>名字: </p>
                <input name="edit_title" type="text" class="modify_form_class" placeholder="名字" value="<?php echo $info_list['title'];?>" maxlength="20"/>
                 
                <p>个人签名: </p>
                <textarea name="edit_signature" class="modify_form_class" id= "edit_signature" placeholder="个人签名..." title="个人签名..." value="<?php $val=isset($info_list['个人签名'])?$info_list['个人签名']:''; echo $val; ?>" maxlength="500"><?php $val=isset($info_list['个人签名'])?$info_list['个人签名']:''; echo $val; ?></textarea>

                <p>性别: </p>
                <select name="edit_gender" class="modify_form_class">
<?php foreach ($gender_list as $gender_id => $gender_name) {
	if ((!empty($info_list['性别']) && $gender_name == $info_list['性别']) || (empty($info_list['性别']) && $gender_id == Gender::Female)) {
?>
                    <option id="option-gender-list" value="<?php echo $gender_id ?>" selected><?php echo $gender_name; ?></option>
<?php       } else { ?>
                    <option id="option-gender-list" value="<?php echo $gender_id ?>" ><?php echo $gender_name; ?></option>
<?php       }
    }
?>
                </select>
                
                <div class="div-edit-people-tag">
                    <p style="height: 80px;">属性: </p>
                    <input type="text" name="edit_nature" class="tag-value none_class" value="<?php echo (isset($info_list['nature'])?$info_list['nature']:''); ?>"/>
                    <div class="search-right-filter">
                        <ul class="ul-search-filter-list">
<?php foreach ($people_filter_list as $filter_id => $filter) { ?>
                            <li>
                                <span id="search-filter-list-<?php echo $filter_id; ?>" class="search-filter-list search-filter-list-<?php echo $filter['class']; ?> <?php if ( ($filter['title'] == '全部') || ($filter['title'] == '未知') ) {echo 'none_class';}?>" href="javascript:" onclick="<?php echo $filter['action']; ?>"><?php echo $filter['title']; ?></span>
                            </li>
<?php } ?>
                        </ul>
                    </div>
                </div>

                <p>学校: </p>
                <input name="edit_education" type="text" placeholder="学校" class="modify_form_class" value="<?php echo (isset($info_list['学校'])?$info_list['学校']:''); ?>" maxlength="30"/>
              
              
              
                <p>家乡: </p>
                 <input name="edit_hometown" type="text" placeholder="家乡" class="modify_form_class" value="<?php echo (isset($info_list['家乡'])?$info_list['家乡']:''); ?>" maxlength="30"/>
                
              
              
              
                <p>爱好: </p>
                <input name="edit_hobby" type="text" placeholder="爱好" class="modify_form_class" value="<?php echo (isset($info_list['爱好'])?$info_list['爱好']:''); ?>" maxlength="30"/>
                
                
                <p>生日: </p>
                <div class="birth_time">
                    <input type="text" name="edit_birth" id="datetimepicker-start" placeholder="生日" class="modify_form_class" value="<?php echo (isset($info_list['生日'])?$info_list['生日']:''); ?>"/> 
                </div>              
              
              
                <p>婚姻状况: </p>
                <input name="edit_marriage" type="text" placeholder="婚姻状况" class="modify_form_class" value="<?php echo (isset($info_list['婚姻状况'])?$info_list['婚姻状况']:''); ?>" maxlength="30"/>
                
  
                <p>电话: </p>
                <input name="edit_phone" type="text" placeholder="电话" class="modify_form_class" value="<?php echo (isset($info_list['电话'])?$info_list['电话']:''); ?>" maxlength="30"/>

              
                <p>邮箱: </p>
                <input name="edit_email" type="email" placeholder="邮箱" class="modify_form_class" value="<?php echo (isset($info_list['邮箱'])?$info_list['邮箱']:''); ?>" maxlength="30"/>
                
              

                <p>地址: </p>
                <input name="edit_address" type="text" placeholder="地址" class="modify_form_class" value="<?php echo (isset($info_list['地址'])?$info_list['地址']:''); ?>" maxlength="30"/>
                
				<input type="reset" name="button" class="edit_button" value="取消修改" onclick="hidePopup('.div-popup')" style="cursor: pointer;" />
				<input type="submit" name="edit_submit" class="edit_button" value="保存修改" />
          </form>
		</article>
    </section>
</div>