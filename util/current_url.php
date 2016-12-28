<?php
    function get_current_page_url()
    {
		$current_page_url = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") 
		{
		    $current_page_url .= "s";
		}
		
		$current_page_url .= "://";
		
		if ($_SERVER["SERVER_PORT"] != "80") 
		{
			$current_page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} 
		else {
		    $current_page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		return $current_page_url;
    }
?>