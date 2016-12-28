<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places,weather&language=en-us"></script>
  <script src='../../../js/zus/map/map.js'></script>
</head>
<?php 
$event = $_GET['event'];
$location = $_GET['location'];
?>
<body onload="codeAddress('<?php echo $location; ?>', '<?php echo $event; ?>')">
  <div id="map_canvas" style="width:500px; height:500px"></div>
</body>
