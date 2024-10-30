<?php
/*
Plugin Name: KnockoutBunny
Plugin URI:https://www.knockoutbunny.com
Description: Enable site visitors to have fun whilst picking their favourite from 8 items of your choosing
Version: 1.2.0
Requires at least: 5.6
Requires PHP: 7.3.9
Author: ValGord Systems Ltd
Author URI: https://www.knockoutbunny.com/wordpress/about-us/
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: kobunny
Domain Path: /languages
*/




/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this program. If not, see {URI to Plugin License}.
*/


add_action( 'plugins_loaded', 'ngg_kobunny_load_textdomain' );

add_action( 'init', 'ngg_kobunny_init' );


  
if ( is_admin() ) {
	require_once ( dirname(__FILE__).'/includes/ngg_kobunny_admin.php');
}





function ngg_kobunny_init() {
	ngg_kobunny_register_posttype();
	ngg_kobunny_register_shortcode();
}



function ngg_kobunny_register_posttype() {
	$ngg_kobunny_args = array(
	  'show_ui' => true,
	  'delete_with_user' => true,
      'show_in_rest' => true,
	  'rest_base' => 'kobunny',
	  'supports' => array(
		'custom-fields',
		'author',
		'title'
	  ),
	  'labels' => array(
		'name' => 'knockoutbunny_results',
		'singular_name' => 'knockoutbunny_result'
	  )
    );

	register_post_type( 'knockoutbunny_result', $ngg_kobunny_args );

	register_post_meta( 'knockoutbunny_result', '_kobunnymetaKey', 
		['show_in_rest' => true, 
		'type' => 'integer', 
		'single' => false, 
		'auth_callback' => function() {return current_user_can( 'edit_posts' );}
		]
	);
}

function ngg_kobunny_set_perms(){


}

function ngg_kobunny_register_shortcode() {
	add_shortcode ('knockoutbunny', 'ngg_kobunny_create_shortcode');
}


function ngg_kobunny_create_shortcode() {
	wp_enqueue_script( 'ngg_kobunny_kobunny_playpage', plugins_url('/js/ngg_kobunny_kobunny_playpage.js', __FILE__), array( 'wp-api' ));
	wp_enqueue_style( 'ngg_kobunny_kobunny_stylesheet', plugins_url('/css/ngg_kobunny_kobunny_stylesheet.css', __FILE__));

	$ngg_kobunny_options = get_option( 'ngg_kobunny_options' );
	$ngg_kobunny_bkgrndcolor = $ngg_kobunny_options['bkgrndcolor'];
	$ngg_kobunny_fgrndcolor = $ngg_kobunny_options['fgrndcolor'];
	$ngg_kobunny_tournie = $ngg_kobunny_options['tournie'];
	$ngg_kobunny_team1 = $ngg_kobunny_options['team1'];
	$ngg_kobunny_team2 = $ngg_kobunny_options['team2'];
	$ngg_kobunny_team3 = $ngg_kobunny_options['team3'];
	$ngg_kobunny_team4 = $ngg_kobunny_options['team4'];
	$ngg_kobunny_team5 = $ngg_kobunny_options['team5'];
	$ngg_kobunny_team6 = $ngg_kobunny_options['team6'];
	$ngg_kobunny_team7 = $ngg_kobunny_options['team7'];
	$ngg_kobunny_team8 = $ngg_kobunny_options['team8'];
	$ngg_kobunny_myfavetext = __('My Favourite ', 'kobunny');

//  check user permissions
	$ngg_kobunny_cansendresults = 'N';
	if (current_user_can( 'edit_posts')) {
		$ngg_kobunny_cansendresults = 'Y';
	}
	
	$ngg_kobunny_params = array(
	'tournie' => $ngg_kobunny_tournie,
	'team1' => $ngg_kobunny_team1,
	'team2' => $ngg_kobunny_team2,
	'team3' => $ngg_kobunny_team3,
	'team4' => $ngg_kobunny_team4,
	'team5' => $ngg_kobunny_team5,
	'team6' => $ngg_kobunny_team6,
	'team7' => $ngg_kobunny_team7,
	'team8' => $ngg_kobunny_team8,
	'fgrndcolor' => $ngg_kobunny_fgrndcolor,
	'myfavetext' => $ngg_kobunny_myfavetext,
	'cansendresults' => $ngg_kobunny_cansendresults
	);

	wp_localize_script('ngg_kobunny_kobunny_playpage', 'ngg_kobunny_settings',  $ngg_kobunny_params);
	
	ob_start();
	if (!isset($ngg_kobunny_tournie))
	{
		require_once ( dirname(__FILE__).'/includes/ngg_kobunny_notready.php');
	}
	else 
	{
		require_once ( dirname(__FILE__).'/includes/ngg_kobunny_playiframe.php');
	}
	return ob_get_clean();
}

/**
 * Load plugin textdomain.
 */
function ngg_kobunny_load_textdomain() {
  load_plugin_textdomain ('kobunny', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}



?>