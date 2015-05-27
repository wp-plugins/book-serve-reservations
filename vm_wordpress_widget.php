<?php

   /*
   Plugin Name: VM Wordpress Widget
   Plugin URI: http://www.vinyl-matt.com
   Description: Vinyl Mattt Booking Form
   Version: 0.1
   Author: Bryan McEleney
   Author URI: http://www.vinyl-matt.com
   */

include "utils.php";


class VMBFWordpressWidget extends WP_Widget {
          function VMBFWordpressWidget() {
		$widget_ops = array(
			'classname' => 'VMBFWordpressWidget',
			'description' => 'Vinyl Matt Booking Form'
		);

		$this->WP_Widget(
		    'VMBFWordpressWidget',
		    'VM Wordpress Widget',
		    $widget_ops
		);
	}

	function widget($args, $instance) { // widget sidebar output

		extract($args, EXTR_SKIP);
		echo $before_widget; // pre-widget code from theme

		include "config.php";
		include "book_serve_booking_form/booking_form.php";	
		vmbf_booking_form(1, "remote", $booking_engine_url, $language_iso, $show_departure, $show_number_nights, $num_nights_min, $num_nights_max, $show_rate_code, $show_flexible_check);

		echo $after_widget; // post-widget code from theme

	}

}

add_action(
          'widgets_init',
          create_function('','return register_widget("VMBFWordpressWidget");')
);



add_action( 'wp_enqueue_scripts', 'vmbf_load_our_scripts', 15 );
function vmbf_load_our_scripts() {

	//booking form css and js
	wp_enqueue_style( 'vmbf_wordpress_plugin_booking_form_css', plugins_url('book_serve_booking_form/booking_form.css', __FILE__));
	wp_register_script( 'vmbf_wordpress_plugin_booking_form_js', plugins_url('book_serve_booking_form/booking_form.js', __FILE__), false, null );
	wp_enqueue_script('vmbf_wordpress_plugin_booking_form_js');


}


//add options page
add_action('admin_menu', 'vmbf_wordpress_plugin_add_options_page');
function vmbf_wordpress_plugin_add_options_page() {
	add_options_page('VM Wordpress Plugin', 'VM Wordpress Plugin', 'manage_options', 'plugin', 'vmbf_wordpress_plugin_options_page');
}



//options page function
function vmbf_wordpress_plugin_options_page() {
?>

<div>

	<h2>Vinyl Matt Booking Form Plugin</h2>

	<form action="options.php" method="post">
		<?php settings_fields('vmbf_plugin_options'); ?>
		<?php do_settings_sections('plugin'); ?>
 
		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>

</div>
 
<?php
}



//options list
add_action('admin_init', 'vmbf_wordpress_plugin_init');

function vmbf_wordpress_plugin_init() {

	register_setting( 'vmbf_plugin_options', 'vmbf_plugin_options', 'vmbf_plugin_options_validate' );

	add_settings_section('plugin_main', 'Main Settings', 'vmbf_plugin_section_text', 'plugin');

	add_settings_field('booking_engine_url', 'Booking Engine URL', 'vmbf_plugin_setting_string', 'plugin', 'plugin_main', array("booking_engine_url"));
	add_settings_field('language_iso', 'Language ISO', 'vmbf_plugin_setting_string', 'plugin', 'plugin_main', array("language_iso"));
	/* add_settings_field('show_departure', 'Show Departure', 'vmbf_plugin_setting_yes_no', 'plugin', 'plugin_main', array("show_departure")); */
	add_settings_field('show_number_nights', 'Show Number of Nights ( instead of departure )', 'vmbf_plugin_setting_yes_no', 'plugin', 'plugin_main', array("show_number_nights"));
	add_settings_field('num_nights_min', 'Minimum Number Nights', 'vmbf_plugin_setting_string', 'plugin', 'plugin_main', array("num_nights_min"));
	add_settings_field('num_nights_max', 'Maximum Number Nights', 'vmbf_plugin_setting_string', 'plugin', 'plugin_main', array("num_nights_max"));
	add_settings_field('show_rate_code', 'Show Rate Code', 'vmbf_plugin_setting_yes_no', 'plugin', 'plugin_main', array("show_rate_code"));
	add_settings_field('show_flexible_check', 'Show Flexible Check', 'vmbf_plugin_setting_yes_no', 'plugin', 'plugin_main', array("show_flexible_check"));
	add_settings_field('season_opens', 'Calendar intialised to when season opens', 'vmbf_plugin_setting_yes_no', 'plugin', 'plugin_main', array("season_opens"));
	add_settings_field('season_opens_date', 'Season Opens', 'vmbf_plugin_setting_date', 'plugin', 'plugin_main', array("season_opens_date"));


}

function vmbf_plugin_section_text() {
}


function vmbf_plugin_setting_string($args) {

	$options = get_option('vmbf_plugin_options');

	echo "<input id='" . $args[0] . "' name='vmbf_plugin_options[" . $args[0] . "]' size='40' type='text' value='{$options[$args[0]]}' />";

}

function vmbf_plugin_setting_yes_no($args) {

	$options = get_option('vmbf_plugin_options');

	if ($options[$args[0]] == "true") {
		$checked_true = "checked='checked'";
	}
	else if ($options[$args[0]] == "false")
		$checked_false = "checked='checked'";

	echo "<input id='" . $args[0] . "_true' " . $checked_true . " name='vmbf_plugin_options[" . $args[0] . "]'  type='radio' value='true' /><label for = '" . $args[0] . "_true'>Yes</label><br /><br />";
	echo "<input id='" . $args[0] . "_false'  " . $checked_false . " name='vmbf_plugin_options[" . $args[0] . "]'  type='radio' value='false' /><label for = '" . $args[0] . "_false'>No</label>";

}

function vmbf_plugin_setting_date($args) {
	
	$options = get_option('vmbf_plugin_options');

	$id = $args[0];

	$value = $options[$args[0]];
	$exploded = explode("_", $value);
	$day = $exploded[0];
	$month = $exploded[1];
	$year = $exploded[2];

	echo "<input id='" . $id . "' name='vmbf_plugin_options[" . $args[0] . "]' size='40' type='hidden' value='{$options[$args[0]]}' />";

	echo "<select id='date_day' onchange='javascript:change_date_plugin_settings();' >";
		for($i=1;$i<32;$i++) {
			if ($i == $day)
				$selected = "selected='selected'";
			else
				$selected = "";
			echo "<option " . $selected . " value='" . $i . "' >" . $i . "</option>";
		}
	echo "</select>";
	
	echo "<select id='date_month' onchange='javascript:change_date_plugin_settings();' >";
		for($i=1;$i<13;$i++) {
			$monthNum  = 3;
			$dateObj   = DateTime::createFromFormat('!m', $i);
			$monthName = $dateObj->format('F');
			if ($i == $month)
				$selected = "selected='selected'";
			else
				$selected = "";

			echo "<option " . $selected . " value='" . $i . "' >" . $monthName . "</option>";
		}
	echo "</select>";
	
	echo "<select id='date_year' onchange='javascript:change_date_plugin_settings();' >";
		for($i=2015;$i<2025;$i++) {
			if ($i == $year)
				$selected = "selected='selected'";
			else
				$selected = "";
			echo "<option " . $selected . " value='" . $i . "' >" . $i . "</option>";
		}
	echo "</select>";
	?>
	<script language="javascript" >
		function change_date_plugin_settings() {
			
			e = document.getElementById('date_day');
			day = e.options[e.selectedIndex].value;
			e = document.getElementById('date_month');
			month = e.options[e.selectedIndex].value;
			e = document.getElementById('date_year');
			year = e.options[e.selectedIndex].value;

			date_string = day + "_" + month + "_" + year;

			document.getElementById('<?php echo $id; ?>').value = date_string;

		}
	</script>
	<?php
	

}


function vmbf_plugin_options_validate($input) {

	foreach ($input as $an_input => $value)
		$options[$an_input] = $value;


	return $options;


}



?>
