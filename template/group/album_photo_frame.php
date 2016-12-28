<?php
	// HTML header
include $home . "template/common/header.php";

// Album List Content
include $home . "cgi/group_show_more_album.php";
// Photos in chosen album
include $home . "template/common/album_photo.php";
include $home . "template/common/photo_view_full.php";

// HTML footer
include $home . "template/common/footer.php";