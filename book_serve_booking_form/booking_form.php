<?php 

include "calendar/calendar.php";

# action is "remote" or "local". "remote" to go to remote bke "local" to load iframe
function vmbf_booking_form($property_id, $action, $bke_url, $lang, $show_departure, $show_number_nights, $num_nights_min, $num_nights_max, $show_rate_code, $show_flexible_check) {

	vmbf_get_arrival_departure($arrival_date, $departure_date, $rate_code, $dates_flexible);

	//$date_of_expiry = time() + 60 * 60 * 24 * 365 * 14;
	//setcookie("prop_arrival_date", $arrival_date, $date_of_expiry, "/" );

	$date_of_expiry = time() + 60 * 60 * 24 * 365 * 14;
	//setcookie("prop_departure_date", $departure_date, $date_of_expiry, "/" );


	#error text for the form validation
	echo "<div id=\"vmbf_please_select_arrival\" style=\"display:none;\" >";
		echo vmbf_we_localise_english("Please select and arrival date");
	echo "</div>";

	echo "<div id=\"vmbf_invalid_arrival_date\" style=\"display:none;\" >";
		echo vmbf_we_localise_english("Invalid Arrival Date");
	echo "</div>";

	echo "<div id=\"vmbf_please_select_departure\" style=\"display:none;\" >";
		echo vmbf_we_localise_english("Please select a departure date");
	echo "</div>";

	echo "<div id=\"vmbf_invalid_departure_date\" style=\"display:none;\" >";
		echo vmbf_we_localise_english("Invalid Departure Date");
	echo "</div>";

?>

	<div class="vmbf_booking_form vmbf_slide_booking_form" >

		<div class="vmbf_booking_form_terms_ie_bug" >
		<div id="vmbf_booking_form_terms_conditions" class="vmbf_booking_form_terms_conditions_surround" onclick="javascript:vmbf_hide_terms_conditions();" >

		<div class="vmbf_booking_form_terms_conditions_inside" > 

			<div class="vmbf_booking_form_terms_conditions_close" >
				<a href="javascript:vmbf_hide_terms_conditions()" >
					<img src="<?php echo vmbf_plugin_base_url(); ?>close.png" alt="close" />
				</a>
			</div>

			<div class="vmbf_booking_form_terms_conditions_caption" >
				<?php echo vmbf_we_localise_english("Terms and Conditions"); ?>
			</div>

			<div class="vmbf_booking_form_terms_conditions_content" >
				<?php 
					# Edit terms and conditions here
					$content = file_get_contents(plugin_dir_path( __FILE__ ) . "../book_serve_terms_conditions.html");

					echo vmbf_we_localise_english($content); 

				?>
			</div>


			<div style="clear:both;" ></div>

		</div>

		</div>
		</div>


		<div class="vmbf_booking_form_form" >

			<?php

				if ( $action == "local" )
					$url = "reservation?";
				else
					$url = $bke_url . "pages/index.php?";

			?>

			<form method="post" id="vmbf_property_booking_form" action="<?php echo $url; ?>property_id=<?php echo $property_id; ?>&amp;lang=<?php echo $lang; ?>">

			<div class="vmbf_first_group" >

				<input type="hidden" name="form_name" value="vmbf_booking_form" />

				<input type="hidden" name="bke_url" value="<?php echo $bke_url;?>" />

				<div id="vmbf_booking_form_arrival_row">

					<div id="vmbf_booking_form_arrival_label">
					<?php echo vmbf_we_localise_english("Arrival"); ?>:
					</div>

					<div id="vmbf_booking_form_arrival_input_div">
						<!-- in case javascript is off, use php to default to today -->
						<div style="float:left;" >
							<?php 

								vmbf_calendar("arrival_date", vmbf_we_localise_english("Select Arrival"), "vmbf_booking_form_arrival_input", "vmbf_change_arrival();", 1, "", $arrival_date); 

							?>
						</div>
					</div>

				</div>

				<?php if ($show_number_nights != "yes") { ?>
				<div id="vmbf_booking_form_departure_row">

					<div id="vmbf_booking_form_departure_label">
					<?php echo vmbf_we_localise_english("Departure"); ?>:
					</div>

					<div id="vmbf_booking_form_departure_input_div">
						<div style="float:left;" >
							<?php 

								if ($departure_date < $arrival_date)
									$departure_date = $arrival_date + ( 60 * 60 * 24 );

								vmbf_calendar("departure_date", vmbf_we_localise_english("Select Departure"), "vmbf_booking_form_departure_input", "", 1, "", $departure_date); 
							?>
						</div>

					</div>

				</div>
				<?php } ?>
			
			
				<?php if ($show_number_nights == "yes") { ?>
				<div id="vmbf_booking_form_number_nights_row">

					<div id="vmbf_booking_form_number_nights_label">

						<?php echo vmbf_we_localise_english("Nights"); ?>:

					</div>

					<div id="vmbf_booking_form_number_nights_input_div">

						<div style="float:left;" >
							<?php 
								vmbf_calendar_number_of_nights_combo("departure_date", $num_nights_min, $num_nights_max);
							?>
						</div>

					</div>

				</div>
				<?php } ?>
			
			</div>



			<div class="vmbf_second_group" >
				
				<?php if ($show_rate_code == "yes") { ?>
				<div id="vmbf_booking_form_rate_code_row">

					<div id="vmbf_booking_form_rate_code_label" >
						<?php echo vmbf_we_localise_english("Rate Code"); ?>:
					</div>

					<div id="vmbf_booking_form_rate_code_input_div" >
						<input type="text" id="vmbf_booking_form_rate_code_input" name="rate_code" value="" />
					</div>

				</div>
				<?php } ?>

				<?php if ($show_flexible_check == "yes") { ?>
				<div id="vmbf_booking_form_dates_flexible_row"  >

					<div id="vmbf_booking_form_dates_flexible_label" >
						<?php
							vmbf_bf_form_checkbox("vmbf_dates_flexible", "vmbf_booking_form_dates_flexible", vmbf_we_localise_english("Flexible Dates:"));
						?>				
					</div>

				</div>
				<?php } ?>

			</div>


			<div style="clear:left;height:80px;" >

				<div id="vmbf_booking_form_terms_and_conditions_row" >
					<?php
						echo vmbf_we_localise_english("Reservation service provided by") . " Book Serve";
					?>
					<a href ="javascript:vmbf_show_terms_conditions();" >
						<?php
							echo vmbf_we_localise_english("Click here for terms and conditions.");
						?>
					</a>
				</div>

				<div class="vmbf_book_button_position" >
					<?php 
						if (vmbf_we_get_language_iso() == "en")
							$book_now_text = vmbf_we_localise_english("Book Now");
						else 
							$book_now_text = vmbf_we_localise_english("Reserve");
		
						echo "<input type=\"button\" onclick=\"javascript:vmbf_validate_booking();\" value=\"" . $book_now_text . "\" />";

						//flexi_button($book_now_text, "javascript:validate_booking();"); 
					?>
				</div>

			</div>

			</form>

		</div>

	</div>



<?php
}



function vmbf_get_arrival_departure(&$arrival_date, &$departure_date, &$rate_code, &$dates_flexible) {

	if ($_POST["arrival_date"] != "")
		$arrival_date = vmbf_date_to_unix($_POST["arrival_date"]);
	else if ($_GET["arrival_date"] != "")
		$arrival_date = vmbf_date_to_unix($_GET["arrival_date"]);
	else if ($_COOKIE["prop_arrival_date"] != "")
		$arrival_date = $_COOKIE["prop_arrival_date"];
	else
		$arrival_date = vmbf_calendar_today();

	if (vmbf_option( 'season_opens' ) == "true") {
	
		$exploded = explode("_", vmbf_option( 'season_opens_date' ));
		$day = $exploded[0];
		$month = $exploded[1];
		$year = $exploded[2];

		$opening = mktime(0, 0, 0, $month, $day, $year);
		if ($opening > $arrival_date)
			$arrival_date = $opening;

	}

	if ($_POST["departure_date"] != "")
		$departure_date = vmbf_date_to_unix($_POST["departure_date"]);
	else if ($_GET["departure_date"] != "")
		$departure_date = vmbf_date_to_unix($_GET["departure_date"]);
	else if ($_COOKIE["prop_departure_date"] != "")
		$departure_date = $_COOKIE["prop_departure_date"];
	else		
		$departure_date = vmbf_calendar_today() + ( 60 * 60 * 24);

	if ($_POST["dates_flexible"] != "")
		$_SESSION["dates_flexible"] = $_POST["dates_flexible"];

	$rate_code = $_REQUEST["rate_code"];
	$dates_flexible = $_REQUEST["dates_flexible"];

}


function vmbf_bf_form_checkbox($name, $id, $caption) {

	if ($_REQUEST[$name] != "")
		$value = $_REQUEST[$name];
	else
		$value = "false";

	echo "<input type=\"hidden\" name=\"" . $name . "\" id=\"" . $id . "\" value=\"" . $value . "\" />";

	$onclick = "vmbf_flip_checkbox('" . $id . "');";

	echo "<div onclick=\"" . $onclick . "\" style=\"float:left;cursor:pointer;margin-right:10px;width:155px;\"  >";
			
		echo "<div style=\"float:left;margin-top:2px;width:84px;\" >";		
			echo $caption;
		echo "</div>";

		if ($value == "true") {
			$display_on = "block";
			$display_off = "none";
		}
		else {
			$display_off = "block";
			$display_on = "none";
		}

		echo "<div style=\"float:left;width:15px;height:15px;margin-top:2px;margin-left:5px;\" >";

			if (vmbf_read_XML_config("site_theme") == "functional") {
				$selected_dot_image = "selected_dot_functional.png";
				$unselected_dot_image = "unselected_dot_functional.png";
			}
			else {
				$selected_dot_image = "selected_dot_image_led.png";
				$unselected_dot_image = "unselected_dot_image_led.png";			
			}
		
			echo "<img id=\"vmbf_check_on_" . $id . "\" src=\"" . vmbf_plugin_base_url() . $selected_dot_image . "\" alt=\"\" style=\"display:" . $display_on . ";\" />";
			echo "<img id=\"vmbf_check_off_" . $id . "\" src=\"" . vmbf_plugin_base_url() . $unselected_dot_image . "\" alt=\"\" style=\"display:" . $display_off . ";\" />";
		echo "</div>";

	echo "</div>";
}



?>

<!-- end booking_form -->
