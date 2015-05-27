<?php

define(CALENDAR_NUM_MONTHS,12);



#loop through the months, display a calendar for each
function vmbf_calendar($input_name, $caption, $input_id, $onchange, $num_months=1, $start_date="", $selected_date="") {
	
	echo "<div style=\"float:left;width:140px;padding-top:1px;\" >";
		vmbf_calendar_combos($input_name, $input_id, $selected_date, $onchange);
	echo "</div>";
		
}



#print the combo boxes for day and month / year
function vmbf_calendar_combos($input_name, $input_id, $selected_date, $onchange) {

	#hidden input to send to the BKE
	echo "<input type=\"hidden\" name=\"" . $input_name . "\" id=\"" . $input_id  .  "\" value=\"" . vmbf_calendar_display_date($selected_date) . "\" />";	

	echo "<div style=\"float:left;\" >";
		vmbf_calendar_combo_day($input_id, $selected_date, $onchange);
	echo "</div>";

	echo "<div style=\"float:left;\" >";
		vmbf_calendar_combo_month($input_id, $selected_date, $onchange);
	echo "</div>";

}


function vmbf_calendar_combo_day($input_id, $selected_date, $onchange_param) {

	$onchange = "javascript:vmbf_date_change('" . $input_id . "');";

	echo "<select  id=\"vmbf_day_select_" . $input_id . "\" onchange=\"" . $onchange . $onchange_param . "\" >";

	for($i=1;$i<32;$i++) {

		if ($i < 10)
			$display_day = "0" . $i;
		else
			$display_day = $i;

		if (date("d", $selected_date) == $display_day) 
			$selected = "selected=\"selected\"";	
		else
			$selected = "";			

		echo "<option " . $selected . " value=\"" . $display_day . "\" >" . $display_day . "</option>";

	}

	echo "</select>";


}



function vmbf_calendar_combo_month($input_id, $selected_date, $onchange_param) {

	$onchange = "javascript:vmbf_date_change('" . $input_id . "');" . $onchange_param;

	echo "<select id=\"vmbf_month_select_" . $input_id . "\" onchange=\"" . $onchange . "\" >";

	$loop_month = date("n", vmbf_calendar_today());
	$loop_year = date("Y", vmbf_calendar_today());

	for($i=1;$i<13;$i++) {

		if (date("n", $selected_date) == $loop_month && date("Y", $selected_date) == $loop_year) 
			$selected = "selected=\"selected\"";	
		else
			$selected = "";			

		echo "<option " . $selected . " value=\"" . vmbf_calendar_pad_zero($loop_month) . "_" . $loop_year . "\" >" . vmbf_unicode_substr(vmbf_we_localise_english(vmbf_calendar_month_number_to_text($loop_month)),0,3) .  " " . $loop_year . "</option>";

		$loop_month = $loop_month + 1;
		if ($loop_month == 13) {	
			$loop_month = 1;
			$loop_year = $loop_year + 1;
		}
	}

	echo "</select>";

}









function vmbf_calendar_pad_zero($month) {

	if ($month >= 10)
		return $month;
	else 
		return "0" . $month;
}



function vmbf_calendar_month_number_to_text($number) {

	if ($number == 1)
		return "January";
	if ($number == 2)
		return "February";
	if ($number == 3)
		return "March";
	if ($number == 4)
		return "April";
	if ($number == 5)
		return "May";
	if ($number == 6)
		return "June";
	if ($number == 7)
		return "July";
	if ($number == 8)
		return "August";
	if ($number == 9)
		return "September";
	if ($number == 10)
		return "October";
	if ($number == 11)
		return "November";
	if ($number == 12)
		return "December";

}





function vmbf_unicode_substr($str, $start, $len) {

	return mb_substr($str,$start,$len,'UTF-8');

}








function vmbf_calendar_month_combo($input_id, $start_date, $this_month, $this_year, $num_months) {

	$start_month = vmbf_calendar_get_month($start_date);
	$start_year = vmbf_calendar_get_year($start_date);

	echo "<select class=\"vmbf_calendar_combo_" . $input_id . "\" onchange=\"javascript:vmbf_calendar_select_month('" . $input_id . "',this.options[this.selectedIndex].value);\" >";

		for($i=0;$i<CALENDAR_NUM_MONTHS;$i++) {
			$loop_month = (($start_month + $i - 1 ) % 12 )  +1;
			$loop_year = $start_year + floor((($start_month + $i - 1  ) / 12)); 
			
			$display_month = vmbf_get_month_name($loop_month);

			if ($this_year == $loop_year && $this_month == $loop_month)
				$selected = "selected=\"selected\"";
			else
				$selected = "";
			
			#number of steps forward for this selection
			$steps_forward = ((($loop_year * 12) + $loop_month) - (($this_year * 12 ) + $this_month));

			echo "<option " . $selected . " value=\"" . $steps_forward . "\">" . $display_month . " " . $loop_year . "</option>";
		}

	echo "</select>";

}


function vmbf_get_month_name($month_number) {

	$month_name = date("F", mktime(4, 0, 0, $month_number, 1, $year));
	return vmbf_we_localise_english($month_name);

}




//combo instead of departure date. js fills in a "virtual" departure date 
function vmbf_calendar_number_of_nights_combo($name, $min, $max) {

	echo "<input type=\"hidden\" id=\"vmbf_booking_form_number_nights_date\" name=\"" . $name . "\" value=\"\" />";

	echo "<select id=\"vmbf_booking_form_number_nights_select\" onchange=\"javascript:vmbf_change_number_nights();\" >";

		for($i=$min;$i<=$max;$i++) {
			echo "<option value=\"" . $i . "\" >";
				echo $i;
			echo "</option>";
		}

	echo "</select>";	

}


function vmbf_calendar_today() {

	return mktime(4, 0, 0, date("m")  , date("d"), date("Y"));

}
#the date format to appear in the input
function vmbf_calendar_display_date($date) {
	return date('d/m/Y', $date);
}

#tomorrow's unix date
function vmbf_calendar_tomorrow() {

	return mktime(4, 0, 0, date("m")  , date("d") + 1, date("Y"));

}



#get the month of a date
function vmbf_calendar_get_month($date) {

	return date("n", $date);

}

#get the year of a date
function vmbf_calendar_get_year($date) {

	return date("Y", $date);

}

#get the date of the monday before or on the first of the month
function vmbf_calendar_get_first_monday($month, $year) {

	$first_of_month = mktime(4, 0, 0, $month, 1, $year);
	
	$date = $first_of_month;
	while (date("D",$date) != "Mon")
		$date = $date - ( 24 * 60 * 60);

	return $date;

}

#get the date of the monday before or on the first of the month
function vmbf_calendar_get_last_monday($month, $year) {

	#add one extra hours to cover for summer time error 4 -> 5
	$first_of_next_month = mktime(5, 0, 0, $month + 1, 1, $year);
	$last_of_month = $first_of_next_month - ( 24 * 60 * 60 );

	$date = $last_of_month;
	while (date("D",$date) != "Mon")
		$date = $date - ( 24 * 60 * 60);

	return $date;

}
?>
