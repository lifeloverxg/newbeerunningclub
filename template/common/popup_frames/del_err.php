			<div class="div-popup-normal" id="show-del-error">
				<section class="popup-normal" style="text-align: center;">
					<div class="modal-content">
		        		<div class="modal-header">
							<button type="button" onclick="hidePopup('#show-del-error')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title"><span style="color: red">取消活动</span> - (<?php echo $info_list['title']; ?>)</h4>
						</div>
						<div class="modal-body">
							<p>Alex童鞋, 你确定要取消该活动吗</p>
						</div>
						<div class="modal-footer">
							<a href="javascript: " onclick="hidePopup('#show-del-error')" class="btn btn-wide btn-primary">再想想</a>
							<a href="javascript: " onclick="<?php echo "event_delete_oper(".$auth['uid'].", ".$eid.", 'delete')"; ?>" class="btn btn-default btn-wide">已决定</a>
						</div>
		        	</div>
        		</section>
    		</div>