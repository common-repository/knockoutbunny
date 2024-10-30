<!DOCTYPE html>

<html>
<head>


</head>

<body>
	<div id="ngg_kobunny_playgamesection"  align="center" style="background-color:<?php	echo esc_js( $ngg_kobunny_bkgrndcolor ); ?>">
	  <div id="ngg_kobunny_pickteams">
		<form action="javascript:ngg_kobunny_myNewPlayFunction()">
			<br>
			<p id="ngg_kobunny_gametitle"><?php	_e('Choose your favourite', 'kobunny'); ?> <?php	echo esc_js( $ngg_kobunny_tournie ); ?>	</p>
			<br>
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team1); ?>" type="text" id="ngg_kobunny_Team1" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team2); ?>" type="text" id="ngg_kobunny_Team2" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team3); ?>" type="text" id="ngg_kobunny_Team3" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team4); ?>" type="text" id="ngg_kobunny_Team4" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team5); ?>" type="text" id="ngg_kobunny_Team5" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team6); ?>" type="text" id="ngg_kobunny_Team6" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team7); ?>" type="text" id="ngg_kobunny_Team7" readonly  maxlength=20 >
			<input class="ngg_kobunny_TeamInput" value="<?php	echo esc_js($ngg_kobunny_team8); ?>" type="text" id="ngg_kobunny_Team8" readonly  maxlength=20 >
			<br>
			<input id="ngg_kobunny_playbtnid" class="ngg_kobunny_metroBtn" type="submit" value="<?php _e('PLAY', 'kobunny'); ?>" >
		</form>

		<div hidden id="ngg_kobunny_match" style="background-color:<?php	echo esc_js( $ngg_kobunny_fgrndcolor ); ?>">
			<button class="ngg_kobunny_Match_Team" id="ngg_kobunny_HomeTeam" onclick="ngg_kobunny_homeWin()">Home</button>
			<span class="ngg_kobunny_fixture">or</span>
			<span class="ngg_kobunny_fixture"><button class="ngg_kobunny_Match_Team" id="ngg_kobunny_AwayTeam" onclick="ngg_kobunny_awayWin()">Away</button></span>
		</div>
	  </div>
	  <canvas id="ngg_kobunny_myCanvas" style="display:none" width="1210" height="800">
			Your browser does not support the HTML5 canvas tag.
	  </canvas>
	  <div id="ngg_kobunny_canvastodiv" hidden >
			<br>
			<img id="ngg_kobunny_canvastoimg" class="ngg_kobunny_tournieresults" />
			<p>
	  </div>
	  <br>
	</div>	

</body>
</html>