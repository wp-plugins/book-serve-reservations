function vmbf_flip_checkbox(id) {

	if (document.getElementById('vmbf_check_on_' + id).style.display == "block") {
		document.getElementById('vmbf_check_on_' + id).style.display = "none";
		document.getElementById('vmbf_check_off_' + id).style.display = "block";
		document.getElementById(id).value = "false";
	}
	else {
		document.getElementById('vmbf_check_on_' + id).style.display = "block";
		document.getElementById('vmbf_check_off_' + id).style.display = "none";
		document.getElementById(id).value = "true";
	}


}



function vmbf_show_terms_conditions() {

	document.getElementById("vmbf_booking_form_terms_conditions").style.display = "block";

}


function vmbf_hide_terms_conditions() {

	document.getElementById("vmbf_booking_form_terms_conditions").style.display = "none";

}


function vmbf_isInteger(s) {
	return (s.toString().search(/^-?[0-9]+$/) == 0);
}

//convert from text date

function vmbf_make_date(date) {

	//replace any underscore with slash
	date = date.replace("_","/");

	var parsedDate = date.split ("/");
	if (parsedDate.length != 3) valid=false;
	var day, month, year;
	day =  parsedDate[0];
	month = parsedDate[1];
	year = parsedDate[2];

	if (vmbf_check_date(date))
		return new Date(year, month - 1, day, 0, 0, 0, 0);

}

function vmbf_format_date(date) {

	var day = date.getDate();
	if (day < 10)
		day = "0" + day; 
	var month = date.getMonth() + 1;
	if (month < 10)
		month = "0" + month; 
	var year = date.getFullYear();
	
	return  day + "/" + month + "/" + year;

}




function vmbf_check_date(date) {

	var parsedDate = date.split ("/");
	if (parsedDate.length != 3) valid=false;
	var day, month, year;
	day =  parsedDate[0];
	month = parsedDate[1];
	year = parsedDate[2];

	valid = true;	

	if (!vmbf_isInteger(day) || !vmbf_isInteger(month) || !vmbf_isInteger(year))
		valid=false;

	if (month < 1 ) valid=false;
	if (month > 12 ) valid=false;
	if (day < 1 ) valid=false;
	if (day > 31 ) valid=false;
	if (year < 1000 ) valid=false;
	if (year > 3000 ) valid=false;

	return valid;
}


function vmbf_validate_booking() {	

	
	/* if using the number of nights combo ensure the departure date is set */
	vmbf_change_number_nights();

	document.getElementById("vmbf_property_booking_form").submit();


}


//if the departure is invalid less than the new arrival, set to day after arrival
function vmbf_change_arrival() {


	var departure_input = document.getElementById("vmbf_booking_form_departure_input");
	if (departure_input != null) {

		var day = document.getElementById('vmbf_day_select_' + 'vmbf_booking_form_arrival_input').value;
		var month = document.getElementById('vmbf_month_select_' + 'vmbf_booking_form_arrival_input').value;
		var arrival_date_text = day + "/" + month.replace("_","/");

		var day = document.getElementById('vmbf_day_select_' + 'vmbf_booking_form_departure_input').value;
		var month = document.getElementById('vmbf_month_select_' + 'vmbf_booking_form_departure_input').value;
		var departure_date_text = day + "/" + month.replace("_","/");

		var arrival_date = vmbf_make_date(arrival_date_text);
		var departure_date = vmbf_make_date(departure_date_text);

		if (departure_date <= arrival_date) {

			departure_date = arrival_date;
			departure_date.setDate(arrival_date.getDate()+1);

			//document.getElementById("booking_form_departure_input").value = format_date(departure_date);
			vmbf_set_calendar_combos("vmbf_booking_form_departure_input", vmbf_format_date(departure_date));

			vmbf_date_change("vmbf_booking_form_departure_input");

			//vmbf_sync_dep_months_to_arr("vmbf_booking_form_arrival_input", "vmbf_booking_form_departure_input")

		}

	}
}

/* set the hidden departure date given number of nights */
function vmbf_change_number_nights() {

	//if we aren't using the select in this form
	if (document.getElementById('vmbf_booking_form_number_nights_select') == null)
		return;

	/* get arrival date */
	var day = document.getElementById('vmbf_day_select_' + 'vmbf_booking_form_arrival_input').value;
	var month = document.getElementById('vmbf_month_select_' + 'vmbf_booking_form_arrival_input').value;
	var arrival_date_text = day + "/" + month;

	var arrival_date = vmbf_make_date(arrival_date_text);

	/* get number of nights */
	var index = document.getElementById('vmbf_booking_form_number_nights_select').selectedIndex;
	var number_of_nights = document.getElementById('vmbf_booking_form_number_nights_select').options[index].value;

	var departure_date = arrival_date;
	departure_date.setDate(arrival_date.getDate() + parseInt(number_of_nights));

	document.getElementById('vmbf_booking_form_number_nights_date').value = vmbf_format_date(departure_date);

}

function vmbf_date_change(input_id) {
	
	//update the text input
	var day = document.getElementById('vmbf_day_select_' + input_id).value;
	var month = document.getElementById('vmbf_month_select_' + input_id).value;
	var fulldatestring = day + "/" + month;
	
	fulldatestring = fulldatestring.replace("_","/");
	
	document.getElementById(input_id).value = fulldatestring;

}





function vmbf_set_calendar_combos(input_id, display_date) {

	var parsedDate = display_date.split ("/");
	if (parsedDate.length != 3) valid=false;
	var day, month, year;
	day =  parsedDate[0];
	month = parsedDate[1];
	year = parsedDate[2];

	var i, combo_val;

	for(i=0;i<31;i++) {
		combo_val = document.getElementById('vmbf_day_select_' + input_id).options[i].value;
		if (combo_val == day)
			document.getElementById('vmbf_day_select_' + input_id).selectedIndex = i;
	}

	
	for(i=0;i<12;i++) {
		combo_val = document.getElementById('vmbf_month_select_' + input_id).options[i].value;
		if (combo_val == month + "_" + year)
			document.getElementById('vmbf_month_select_' + input_id).selectedIndex = i;
	}
	

}


function vmbf_set_days_of_week_arrival_and_departure() {

	vmbf_set_days_of_week("vmbf_booking_form_arrival_input");
	vmbf_set_days_of_week("vmbf_booking_form_departure_input");

}

