<?php

add_action( 'wp_dashboard_setup', 'ngg_kobunny_dashboard_widget' );

// Add a menu for our option page
add_action('admin_menu', 'ngg_kobunny_add_page');

function ngg_kobunny_dashboard_widget() {
	if (current_user_can( 'administrator')) {
		wp_add_dashboard_widget( 'dashboard_custom_feed', 'KnockoutBunny Results', 'ngg_kobunny_widget_display' );
	}
}

function ngg_kobunny_widget_display() {
	$ngg_kobunny_options = get_option( 'ngg_kobunny_options' );
	if ($ngg_kobunny_options) {
		$teams=array($ngg_kobunny_options['team1'],
			$ngg_kobunny_options['team2'],
			$ngg_kobunny_options['team3'],
			$ngg_kobunny_options['team4'],
			$ngg_kobunny_options['team5'],
			$ngg_kobunny_options['team6'],
			$ngg_kobunny_options['team7'],
			$ngg_kobunny_options['team8']
		);
		$args = array( 
			'numberposts'	=> -1, 
			'post_status' => 'draft',
			'post_type'		=> 'knockoutbunny_result'
		);
		$getposts=get_posts($args);
		$countposts=count($getposts);
		$postscores=array();
		echo '<p>Number of Submissions: <span class="ngg_kobunny_submissions">' . $countposts . '</span></p>';
		if ($countposts > 0){
			echo '<h3>Current Rankings</h3>';
			$teamscores=array(0,0,0,0,0,0,0,0);
			if ( $getposts ) {
				foreach ( $getposts as $post ) :	
					$postid=$post->ID;
					$postscores=get_post_meta($postid, '_kobunnymetaKey', false);
					if (count($postscores) == 8) {
						for ($i=0; $i<8; $i++){ 
							$teamscores[$i]=$teamscores[$i]+$postscores[$i];
						}
					}
				endforeach; 
			}

			$teamfinalscores=array(
				$teams[0]=>$teamscores[0],
				$teams[1]=>$teamscores[1],
				$teams[2]=>$teamscores[2],
				$teams[3]=>$teamscores[3],
				$teams[4]=>$teamscores[4],
				$teams[5]=>$teamscores[5],
				$teams[6]=>$teamscores[6],
				$teams[7]=>$teamscores[7]
			);
			arsort($teamfinalscores);
			echo '<ol id="ngg_kobunny_rankings">';
			foreach ($teamfinalscores as $x => $x_value){ 
				echo '<li>' . $x . ':' . $x_value . '</li>';
			}
			echo '</ol>';
		}
	}
	else {
		echo '<p>No game created yet!</p>';
	}

}




function ngg_kobunny_add_page() {
	add_options_page( 'KnockoutBunny', 'KnockoutBunny', 'manage_options', 'ngg_kobunny', 'ngg_kobunny_option_page' );
}

// Draw the option page
function ngg_kobunny_option_page() {
	?>
	<div class="wrap">
		<h2>KnockoutBunny</h2>
		<form action="options.php" method="post">
			<?php settings_fields('ngg_kobunny_options'); ?>
			<?php do_settings_sections('ngg_kobunny'); ?>
			<input id="ngg_kobunny_save" name="Submit" type="submit" value="<?php	_e('Save', 'kobunny'); ?>" />
		</form>
	</div>
	<?php
	$args = array( 
			'numberposts'	=> -1, 
			'post_status' => 'draft',
			'post_type'		=> 'knockoutbunny_result'
		);
	$getposts=get_posts($args);
	$numdraftposts=count($getposts);
	
	$args = array( 
			'numberposts' => -1, 
			'post_status' => 'trash',
			'post_type'	=> 'knockoutbunny_result'
	);
	$getposts=get_posts($args);
	$numbinposts=count($getposts);
	
	if (($numdraftposts > 0) or ($numbinposts > 0))
		{
		echo '<h3 id="ngg_kobunny_cleardown_warning">' . __('You should delete ALL knockoutbunny_results posts when creating a new game', 'kobunny') . __(' - you have ', 'kobunny') . '<span id="ngg_kobunny_warn_numdraft">' . $numdraftposts . '</span>' . __(' draft posts', 'kobunny') . __(' and ', 'kobunny') . '<span id="ngg_kobunny_warn_numtrash">' . $numbinposts . '</span>' . __(' trashed posts', 'kobunny') . '</h3>';
		}
}

// Register and define the settings
add_action('admin_init', 'ngg_kobunny_admin_init');
function ngg_kobunny_admin_init(){
	register_setting(
		'ngg_kobunny_options',
		'ngg_kobunny_options',
		'ngg_kobunny_validate_options'
	);
	add_settings_section(
		'ngg_kobunny_main',				// name of section
		'Settings',						// h3 title
		'ngg_kobunny_section_text',		//function to echo explanation
		'ngg_kobunny'					// url
	);
	add_settings_field(
		'ngg_kobunny_bkgrndcolor',			// html id tag for the section
		__( 'Choose BackGround Color', 'kobunny' ),			
		'ngg_kobunny_bkgrndcolor_input',	// echo form
		'ngg_kobunny',					// settings page
		'ngg_kobunny_main'				// section
	);
	add_settings_field(
		'ngg_kobunny_fgrndcolor',			// html id tag for the section
		__( 'Choose ForeGround Color', 'kobunny' ),			
		'ngg_kobunny_fgrndcolor_input',	// echo form
		'ngg_kobunny',					// settings page
		'ngg_kobunny_main'				// section
	);
	add_settings_field(
		'ngg_kobunny_tournie',			// html id tag for the section
		__( 'Enter Category', 'kobunny' ),					
		'ngg_kobunny_tournie_input',	// echo form
		'ngg_kobunny',					// settings page
		'ngg_kobunny_main'				// section
	);

	for ($i=1; $i<9; $i++){ 
  		add_settings_field(
			'ngg_kobunny_team' . $i,			// html id tag for the section
			sprintf(__( 'Enter Entry %1$s here', 'kobunny' ),$i),				
			'ngg_kobunny_team' . $i . '_input',		// echo form
			'ngg_kobunny',					// settings page
			'ngg_kobunny_main'				// section
		);
	}
}

// Draw the section header
function ngg_kobunny_section_text() {
	echo '<p><img src="' . plugins_url('../images/ngg_kobunny_guide.png', __FILE__) . '" alt="KnockOutBunny.com"></p>';

	echo '<h3>' . __('Use shortcode [knockoutbunny] in any Page/Post to publish your game', 'kobunny') . '</h3>';
}

// Display and fill the form field
function ngg_kobunny_bkgrndcolor_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	if (!($options['bkgrndcolor'])) {
		$text_string = '#5C5C5C';
	} else {
		$text_string = $options['bkgrndcolor'];
	}
	// echo the field
	echo "<input id='ngg_kobunny_bkgrndcolor' name='ngg_kobunny_options[bkgrndcolor]' type='color' value='$text_string' />";
}

function ngg_kobunny_fgrndcolor_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	if (!($options['fgrndcolor'])) {
		$text_string = '#C9FFE5';
	} else {
		$text_string = $options['fgrndcolor'];
	}
	// echo the field
	echo "<input id='ngg_kobunny_fgrndcolor' name='ngg_kobunny_options[fgrndcolor]' type='color' value='$text_string' />";
}

// Display and fill the form field
function ngg_kobunny_tournie_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['tournie'];
	// echo the field
	echo "<input id='ngg_kobunny_tournie' name='ngg_kobunny_options[tournie]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

// Display and fill the form field
function ngg_kobunny_team1_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team1'];
	// echo the field
	echo "<input id='ngg_kobunny_team1' name='ngg_kobunny_options[team1]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team2_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team2'];
	// echo the field
	echo "<input id='ngg_kobunny_team2' name='ngg_kobunny_options[team2]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team3_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team3'];
	// echo the field
	echo "<input id='ngg_kobunny_team3' name='ngg_kobunny_options[team3]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team4_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team4'];
	// echo the field
	echo "<input id='ngg_kobunny_team4' name='ngg_kobunny_options[team4]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team5_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team5'];
	// echo the field
	echo "<input id='ngg_kobunny_team5' name='ngg_kobunny_options[team5]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team6_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team6'];
	// echo the field
	echo "<input id='ngg_kobunny_team6' name='ngg_kobunny_options[team6]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team7_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team7'];
	// echo the field
	echo "<input id='ngg_kobunny_team7' name='ngg_kobunny_options[team7]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

function ngg_kobunny_team8_input() {
	// get option 'text_string' value from the database
	$options = get_option( 'ngg_kobunny_options' );

	$text_string = $options['team8'];
	// echo the field
	echo "<input id='ngg_kobunny_team8' name='ngg_kobunny_options[team8]' type='text' value='$text_string' required maxlength='20' /> " . __( 'max length 20 alphanumeric incl space', 'kobunny' );
}

// Validate user input (we want text only)
function ngg_kobunny_validate_options( $input ) {

	// check for duplicates

	//		if(array_unique($input) != $input) {
	//				$nggduplicates=array_diff_key($input,array_unique($input));
	//
	//				foreach($nggduplicates as $x=>$x_value) {
	//					$num=str_replace('team','',$x);
	//					add_settings_error(
	//						'ngg_kobunny_' . $x,
	//						'ngg_kobunny_texterror',
	//						sprintf(__('Duplicate value in Entry %1$s', 'kobunny'), $num),
	//						'error'
	//					);
	//				}
	//		}

	$valid['bkgrndcolor'] = $input['bkgrndcolor'] ;

	$valid['fgrndcolor'] = $input['fgrndcolor'] ;
	
	$valid['tournie'] = preg_replace( '/[^a-zA-Z 0-9]/', '', $input['tournie'] );
	
	if(( $valid['tournie'] != $input['tournie'] ) or (strlen($input['tournie']) > 20)) {
		add_settings_error(
			'ngg_kobunny_tournie',
			'ngg_kobunny_texterror',
			__('Incorrect value for tournie entered!', 'kobunny'),
			'error'
		);		
	}

	for ($i=1; $i<9; $i++){ 
		$valid['team' . $i] = preg_replace( '/[^a-zA-Z 0-9]/', '', $input['team' . $i] );
	
		if(( $valid['team' . $i] != $input['team' . $i] ) or (strlen($input['team' . $i]) > 20)) {
			$valid['team' . $i] = '******';
			add_settings_error(
				'ngg_kobunny_team' . $i,
				'ngg_kobunny_texterror',
				sprintf(__( 'Incorrect value entered for team %1$s!', 'kobunny' ),$i),	
				'error'
			);		
		}
	}
	return $valid;
}
?>