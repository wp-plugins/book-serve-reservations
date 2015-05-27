<?php
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
// 											//
// 											//
//	Configuration. These can be edited.						//
// 											//
// 											//
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

/*
$booking_engine_url = "https://seanogs.book-serve.com/";
$language_iso = "en";
$show_departure = true;
$show_number_nights = false;
$num_nights_min = 1;
$num_nights_max = 7;
$show_rate_code = true;
$show_flexible_check = true;
*/


//We normally use a wordpress configuration page
$booking_engine_url = vmbf_option( 'booking_engine_url' );
$language_iso = vmbf_option( 'language_iso' );
$show_departure = vmbf_option( 'show_departure' ) === "true" ? true : false;
$show_number_nights = vmbf_option( 'show_number_nights' ) === "true" ? true : false;
$num_nights_min = vmbf_option( 'num_nights_min' );
$num_nights_max = vmbf_option( 'num_nights_max' );
$show_rate_code = vmbf_option( 'show_rate_code' ) === "true" ? true : false;
$show_flexible_check = vmbf_option( 'show_flexible_check' ) === "true" ? true : false;
$season_opens = vmbf_option( 'season_opens' ) === "true" ? true : false;
$season_opens_date = vmbf_option( 'season_opens_date' );

//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
?>



