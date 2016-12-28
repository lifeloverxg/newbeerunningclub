<?php
// HTML header
include $home . "template/mobile/shared/partial/m_shared_header.php";
?>

<section class="section-confirmation-page">
	恭喜您，已经加入活动, 点击<a href='<?php echo $back; ?>'>返回</a>到活动页面</p>

	<div style="width:195px; text-align:center; margin: 0px auto;" ><iframe  src="https://www.eventbrite.com/countdown-widget?eid=12034135423" frameborder="0" height="586" width="195" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="true"></iframe></div>
<!--
	<div style="width:1000px; text-align:center;" ><iframe  src="https://www.eventbrite.com/calendar-widget?eid=10925296857" frameborder="0" height="400" width="195" marginheight="-100" marginwidth="0" scrolling="no" allowtransparency="true"></iframe><div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:195px; text-align:center;" ></div></div>
-->	
<!--
<div style="width:100%; text-align:left;" >
  <iframe src="http://www.eventbrite.com/tickets-external?eid=10925296857&ref=etckt&v=2" frameborder="0" height="256" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>
</div>
-->
</section>

<?php
// HTML footer
include $home . "template/mobile/shared/partial/m_shared_footer.php";
?>