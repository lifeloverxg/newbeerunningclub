<?php
	if(!defined('IN_NBRC'))
	{
		exit('<h1>403:Forbidden @util:render.php</h1>');
	}
	
	class spec_popup
	{
		public static function spec_popup_common($id, $title, $content, $decision, $left = "再想想", $right = "已决定")
		{
?>
			<div class="div-popup-normal" id="<?php echo $id; ?>">
				<section class="popup-normal" style="text-align: center;">
					<div class="modal-content">
		        		<div class="modal-header">
							<button type="button" onclick="hidePopup('#<?php echo $id; ?>')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title"><span style="color: red"><?php echo $title; ?></span></h4>
						</div>
						<div class="modal-body">
							<p><?php echo $content; ?></p>
							<p><span id="chkmsg"></span></p>
						</div>
						<div class="modal-footer">
							<a href="javascript: " onclick="hidePopup('#<?php echo $id; ?>')" class="btn btn-default btn-wide"><?php echo $left; ?></a>
							<a href="javascript: " onclick="<?php echo $decision; ?>" class="btn btn-wide btn-primary"><?php echo $right; ?></a>
						</div>
		        	</div>
        		</section>
    		</div>
<?php
		}

		public static function spec_popup_common_v2($id, $home, $email, $title, $content, $decision, $left = "再想想", $right = "已决定")
		{
?>
			<div class="div-popup-normal" id="<?php echo $id; ?>">
				<section class="popup-normal" style="text-align: center;">
					<form id="paypalfreeorderForm" name="paypalfreeorderForm" method="post" action="<?php echo $home . "cgi/formActions/uni_sale.php"; ?>" enctype="multipart/form-data" onSubmit="return helloworld(this)">	
						<div class="modal-content">
			        		<div class="modal-header">
								<button type="button" onclick="hidePopup('#<?php echo $id; ?>')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title"><span style="color: red"><?php echo $title; ?></span></h4>
							</div>
							<div class="modal-body">
								<p><?php echo $content; ?></p>
								<p><span id="chkmsg"></span></p>
							</div>
							<div class="modal-footer">
								<a href="javascript: " onclick="hidePopup('#<?php echo $id; ?>')" class="btn btn-default btn-wide"><?php echo $left; ?></a>
								<a href="javascript: " onclick="<?php echo $decision; ?>" class="btn btn-wide btn-primary"><?php echo $right; ?></a>
							</div>
			        	</div>
			        	<input type="hidden" name="user_email" value="<?php echo $email; ?>">
			        	<input type="submit" style="display:none;" name="paypal_free_order_submit" id="paypal-free-order-submit" value="生成订单" />
			        </form>
        		</section>
    		</div>
<?php
		}

		public static function popup_render_error($id, $title, $notification, $left = "OK")
		{
			$html = '
			<div class="div-popup-normal" id="'.$id.'">
				<section class="popup-normal" style="text-align: center;">
					<div class="modal-content">
		        		<div class="modal-header">
							<button type="button" onclick="hidePopup(\'#'.$id.'\')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title"><span style="color: red">'.$title.'</span></h4>
						</div>
						<div class="modal-body">
							<p><span id="chkmsg">'.$notification.'</span></p>
						</div>
						<div class="modal-footer">
							<a href="javascript: " onclick="hidePopup(\'#'.$id.'\')" class="btn btn-default btn-wide">'.$left.'</a>
						</div>
		        	</div>
        		</section>
    		</div>';

    		return $html;
		}

		public static function popup_render_share($id, $share_url, $content = "打开微信，点击底部的“发现”，使用 “扫一扫” 即可将网页分享到我的朋友圈")
		{
			$html = '		
			<div class="div-popup-small" id="'.$id.'">
				<section class="popup-small" style="text-align: center;">
					<button type="button" onclick="hidePopup(\'#'.$id.'\')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
					<h4>分享到朋友圈</h4>
					<img src="'.$share_url.'" style="width: 80%;">
					<p>'.$content.'</p>
				</section>
			</div>
			<script>
			$(".div-popup-small").click(function(event) {
			    if (!$(event.target).isChildAndSelfOf(".popup-small"))
			       hidePopup(\'.div-popup-small\');
			});
			</script>';

			return $html;
		}

		public static function popup_render_large_photo($id, $title, $image_url, $content='', $decision='', $left = "取消", $right = "下一张")
		{
			$html = '
			<div class="div-popup-normal" id="'.$id.'">
				<section class="popup-normal" style="text-align: center;">
					<div class="modal-content">
		        		<div class="modal-header">
							<button type="button" onclick="hidePopup(\'#'.$id.'\')" class="close fui-cross" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title"><span style="color: red">'.$title.'</span></h4>
						</div>
						<div class="modal-body">';
			if ( $image_url != '' )
			{
				$html .= '<img src="'.$image_url.'" style="width: 80%;">';
			}
			else
			{
				$html .= '<p>暂无大图</p>';
			}

			$html .= '
							<p><span id="chkmsg"></span></p>
						</div>
						<div class="modal-footer">
							<a href="javascript: " onclick="hidePopup(\'#'.$id.'\')" class="btn btn-default btn-wide">'.$left.'</a>';
							
							// <a href="javascript: " onclick="'.$desion.'" class="btn btn-wide btn-primary">'.$right.'</a>
			$html .= '			</div>
		        	</div>
        		</section>
    		</div>';

    		return $html;
    	}
	}
?>
