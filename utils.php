<?php

function vmbf_now_unix() {

	return mktime (4,0,0,date("m"),date("d"),date("Y"));

}

//just a stub
function vmbf_we_get_language_iso() {

	return "en";

}


//just a stub
function vmbf_we_localise_english($text, $iso="") {

	return $text;

}

//just a stub
function vmbf_read_XML_config($key) {

	return "";

}



function vmbf_flexi_button($text, $href, $wait_icon="", $id="", $style="") {

	echo "<div style=\"cursor:pointer;\" >";

		echo "<div style=\"float:left;font-size:0px;\" >";
			echo "<img src=\"" . vmbf_plugin_base_url() . "images/button_left.png\" alt=\"\" />";			
		echo "</div>";

		echo "<div class=\"flexi_button\" onclick=\"" . $href . "\" style=\"" . $style . "\" >";
			echo $wait_icon;
			echo "<a style=\"color:black;\" >" . $text . "</a>";
		echo "</div>";

		echo "<div style=\"float:left;font-size:0px;\" >";
			echo "<img src=\"" . vmbf_plugin_base_url() . "images/button_right.png\" alt=\"\" />";			
		echo "</div>";

	echo "</div>";

}




function vmbf_plugin_base_url() {

	return plugins_url('book_serve_booking_form/', __FILE__);

}


function vmbf_option($name) {

	$options = get_option('vmbf_plugin_options');
	return $options[$name];

}




?>
