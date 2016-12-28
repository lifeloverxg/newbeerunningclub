<?php
// HTML header
	include $home . "template/mobile/shared/partial/m_shared_header.php";
?>

<div class="eventbrite-event-title" style="padding-top: 2rem; margin-bottom: 4rem; display: block; position: absolute; z-index: 200; width: 100%; background: white;">
	<?php echo $info_list['title'] . " - 购票页面"; ?>
</div>

<?php if ( $eid == 28 ) { ?>
<div style="width:100%; text-align:left;" ><iframe  src="https://www.eventbrite.com/e/11039149393?ref=eweb" frameborder="0" height="1000" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe><div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" ></div></div>
<?php } else if ( $eid == 13 ){ ?>
<div style="width:100%; text-align:left;" ><iframe  src="https://www.eventbrite.com/e/yijunxiao-for-test-tickets-10925296857?ref=eweb" frameborder="0" height="1000" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe><div style="font-family:Helvetica, Arial; font-size:10px; padding:5px 0 5px; margin:2px; width:100%; text-align:left;" ><a style="color:#ddd; text-decoration:none;" target="_blank" href="http://www.eventbrite.com/r/eweb">Sell Tickets Online</a> <span style="color:#ddd;">through</span> <a style="color:#ddd; text-decoration:none;" target="_blank" href="http://www.eventbrite.com?ref=eweb">Eventbrite</a></div></div>
<?php } else if ( $eid == 52 ){ ?>
<div style="width:100%; text-align:left;" ><iframe  src="https://www.eventbrite.com/tickets-external?eid=11737187243&ref=etckt" frameborder="0" height="274" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true" style="margin-top: -2rem;"></iframe></div>
<?php } ?>


<?php
// HTML footer
include $home . "template/mobile/shared/partial/m_shared_footer.php";
?>