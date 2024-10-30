var ngg_kobunny_teams=[];
var ngg_kobunny_matches;
var ngg_kobunny_last4teams=[];
var ngg_kobunny_last2teams=[];
var ngg_kobunny_nummatches=0;
var ngg_kobunny_round=1;
var ngg_kobunny_tournamentwinner;
var ngg_kobunny_matchwinner;
var ngg_kobunny_icounter=1;

const ngg_kobunny_winner_pts=5;
const ngg_kobunny_last2teams_pts=3;
const ngg_kobunny_last4teams_pts=2;
const ngg_kobunny_last8teams_pts=1;


function ngg_kobunny_initialise() {
   		ngg_kobunny_teams=[];
   		ngg_kobunny_matches=[];
   		ngg_kobunny_last4teams=[];
   		ngg_kobunny_last2teams=[];
   		ngg_kobunny_nummatches=0;
   		ngg_kobunny_round=1;
   		ngg_kobunny_tournamentwinner="";
   		ngg_kobunny_matchwinner="";
   		ngg_kobunny_icounter=1;  	
}
   
function ngg_kobunny_myNewPlayFunction() {
		if (document.getElementById("ngg_kobunny_Team1").value==""){
			return;
		}

		document.getElementById("ngg_kobunny_canvastodiv").style.display = "none";
     	ngg_kobunny_playMatches();		  	
}
   
function ngg_kobunny_playMatches() {
   		ngg_kobunny_initialise();
   		ngg_kobunny_getTeams();
   		ngg_kobunny_matches=ngg_kobunny_teams;
   		ngg_kobunny_nummatches=4;
   		document.getElementById("ngg_kobunny_HomeTeam").innerHTML = ngg_kobunny_matches[ngg_kobunny_icounter-1];
   		document.getElementById("ngg_kobunny_AwayTeam").innerHTML = ngg_kobunny_matches[ngg_kobunny_icounter];
   		document.getElementById("ngg_kobunny_match").style.display = "block";
}
   
function ngg_kobunny_playLast4() {
   		ngg_kobunny_matches=ngg_kobunny_last4teams;
   		ngg_kobunny_nummatches=2;
}
   
function ngg_kobunny_playLast2() {
   		ngg_kobunny_matches=ngg_kobunny_last2teams;
   		ngg_kobunny_nummatches=1;			
}
   
function ngg_kobunny_awayWin() {
		ngg_kobunny_matchwinner=document.getElementById("ngg_kobunny_AwayTeam").innerHTML;
		ngg_kobunny_matchOver();
}
   
function ngg_kobunny_homeWin() {
		ngg_kobunny_matchwinner=document.getElementById("ngg_kobunny_HomeTeam").innerHTML;
		ngg_kobunny_matchOver();
}
   
function ngg_kobunny_matchOver() {
   		switch (ngg_kobunny_round) {
   			case 1:
   				ngg_kobunny_last4teams.push(ngg_kobunny_matchwinner);
   				break;
   			case 2:
   				ngg_kobunny_last2teams.push(ngg_kobunny_matchwinner);
   				break;
   			case 3:
   				ngg_kobunny_tournamentwinner=ngg_kobunny_matchwinner;
				document.getElementById("ngg_kobunny_match").style.display = "none";
				ngg_kobunny_send_results();
				document.getElementById("ngg_kobunny_pickteams").style.display = "none";
				ngg_kobunny_populateCanvas();
				break;
   		}
   		ngg_kobunny_nextMatch();
}
   
function ngg_kobunny_nextMatch() {
		ngg_kobunny_icounter=ngg_kobunny_icounter+2;
		if (ngg_kobunny_icounter>2*ngg_kobunny_nummatches) {
			ngg_kobunny_nextRound();
		}
		document.getElementById("ngg_kobunny_HomeTeam").innerHTML = ngg_kobunny_matches[ngg_kobunny_icounter-1];
		document.getElementById("ngg_kobunny_AwayTeam").innerHTML = ngg_kobunny_matches[ngg_kobunny_icounter];
}
   
function ngg_kobunny_nextRound() {
   		ngg_kobunny_icounter=1;
   		ngg_kobunny_round=ngg_kobunny_round+1;
   		switch (ngg_kobunny_round) {
   			case 2:
   				ngg_kobunny_playLast4();
   				break;
   			case 3:
   				ngg_kobunny_playLast2();
   				break;
   		}
}
   
function ngg_kobunny_getTeams() {
		var Team1 = document.getElementById("ngg_kobunny_Team1").value;
		var Team2 = document.getElementById("ngg_kobunny_Team8").value;
		var Team3 = document.getElementById("ngg_kobunny_Team6").value;
		var Team4 = document.getElementById("ngg_kobunny_Team4").value;
		var Team5 = document.getElementById("ngg_kobunny_Team5").value;
		var Team6 = document.getElementById("ngg_kobunny_Team3").value;
		var Team7 = document.getElementById("ngg_kobunny_Team7").value;
		var Team8 = document.getElementById("ngg_kobunny_Team2").value;
		ngg_kobunny_teams = [Team1, Team2, Team3, Team4, Team5,Team6,Team7,Team8];
}

function ngg_kobunny_calculateresults() {
	var results_text_array=[];
	var i;	
	var teams=[
		ngg_kobunny_settings.team1, 
		ngg_kobunny_settings.team2,
		ngg_kobunny_settings.team3,
		ngg_kobunny_settings.team4,
		ngg_kobunny_settings.team5,
		ngg_kobunny_settings.team6,
		ngg_kobunny_settings.team7,
		ngg_kobunny_settings.team8		
	];

	for (i = 0; i < teams.length; i++) {
		results_text_array.push(ngg_kobunny_getpoints(teams[i]));
	}
	return results_text_array;
}

function ngg_kobunny_getpoints(team) {
	var pts="0";
	if (team == ngg_kobunny_tournamentwinner){
		pts=ngg_kobunny_winner_pts;
	}
	else
	if (ngg_kobunny_last2teams.indexOf(team) != -1) {
		pts=ngg_kobunny_last2teams_pts;
	}
	else
	if (ngg_kobunny_last4teams.indexOf(team) != -1) {
		pts=ngg_kobunny_last4teams_pts;
	}
	else
	pts=ngg_kobunny_last8teams_pts; 
	return pts;
}


function ngg_kobunny_send_results() {
// NOTE: when using REST Api the custom type must be in CamelCase
//	var post = new wp.api.models.Kobunny( { id: 370 } );
//	post.fetch();

	if (ngg_kobunny_settings.cansendresults == 'Y') {
		var results_array=ngg_kobunny_calculateresults();
		var post = new wp.api.models.Kobunny( { title: "knockoutbunnyresult"  } );
		post.set( 'meta', { '_kobunnymetaKey' : results_array } );
		post.save();

	} 
}



function ngg_kobunny_shuffleArray(array) {
   		for (var i = array.length - 1; i > 0; i--) {
   			var j = Math.floor(Math.random() * (i + 1));
   			var temp = array[i];
   			array[i] = array[j];
   			array[j] = temp;
   		}
}
   


function ngg_kobunny_populateCanvas() {
		var c = document.getElementById("ngg_kobunny_myCanvas");
		var ctx = c.getContext("2d");

		var ngcat = ngg_kobunny_settings.myfavetext + ngg_kobunny_settings.tournie.replace(/_/g,' ');
		var pixelRatio = window.devicePixelRatio || 1;
		var dataURL;

        var ngheight=180;

		ctx.clearRect(0,0, c.width, c.height);
		ctx.fillStyle = ngg_kobunny_settings.fgrndcolor;
		ctx.fillRect(0, 0, c.width, c.height);


		ctx.fillStyle = 'black';
		ctx.beginPath();

		ctx.font = "17px sans-serif";
		ctx.moveTo(10, ngheight+10);
		ctx.lineTo(300, ngheight+10);
		ctx.stroke();

		ctx.lineTo(300, ngheight+70);
		ctx.stroke();

		ctx.moveTo(10, ngheight+70);
		ctx.lineTo(300, ngheight+70);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_teams[0], 20, ngheight+30);
		ctx.fillText(ngg_kobunny_teams[1], 20, ngheight+60);

		ctx.moveTo(10, ngheight+130);
		ctx.lineTo(300, ngheight+130);
		ctx.stroke();

		ctx.lineTo(300, ngheight+190);
		ctx.stroke();

		ctx.moveTo(10, ngheight+190);
		ctx.lineTo(300, ngheight+190);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_teams[2], 20, ngheight+150);
		ctx.fillText(ngg_kobunny_teams[3], 20, ngheight+180);

		ctx.moveTo(10, ngheight+250);
		ctx.lineTo(300, ngheight+250);
		ctx.stroke();

		ctx.lineTo(300, ngheight+310);
		ctx.stroke();

		ctx.moveTo(10, ngheight+310);
		ctx.lineTo(300, ngheight+310);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_teams[4], 20, ngheight+270);
		ctx.fillText(ngg_kobunny_teams[5], 20, ngheight+300);

		ctx.moveTo(10, ngheight+370);
		ctx.lineTo(300, ngheight+370);
		ctx.stroke();

		ctx.lineTo(300, ngheight+430);
		ctx.stroke();

		ctx.moveTo(10, ngheight+430);
		ctx.lineTo(300, ngheight+430);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_teams[6], 20, ngheight+390);
		ctx.fillText(ngg_kobunny_teams[7], 20, ngheight+420);

		ctx.font = "17px sans-serif";
		
		ctx.moveTo(300, ngheight+40);
		ctx.lineTo(600, ngheight+40);
		ctx.stroke();

		ctx.lineTo(600, ngheight+160);
		ctx.stroke();

		ctx.moveTo(300, ngheight+160);
		ctx.lineTo(600, ngheight+160);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_last4teams[0], 320, ngheight+60);
		ctx.fillText(ngg_kobunny_last4teams[1], 320, ngheight+150);

		ctx.moveTo(300, ngheight+280);
		ctx.lineTo(600, ngheight+280);
		ctx.stroke();
	
		ctx.lineTo(600, ngheight+400);
		ctx.stroke();

		ctx.moveTo(300, ngheight+400);
		ctx.lineTo(600, ngheight+400);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_last4teams[2], 320, ngheight+300);
		ctx.fillText(ngg_kobunny_last4teams[3], 320, ngheight+390);

		ctx.moveTo(600, ngheight+100);
		ctx.lineTo(900, ngheight+100);
		ctx.stroke();

		ctx.lineTo(900, ngheight+340);
		ctx.stroke();

		ctx.font = "17px sans-serif";

		ctx.moveTo(600, ngheight+340);
		ctx.lineTo(900, ngheight+340);
		ctx.stroke();

		ctx.fillText(ngg_kobunny_last2teams[0], 620, ngheight+120);
		ctx.fillText(ngg_kobunny_last2teams[1], 620, ngheight+330);

		ctx.moveTo(900, ngheight+220);
		ctx.lineTo(1200, ngheight+220);
		ctx.stroke();

		ctx.font = "20px sans-serif";
		ctx.fillText(ngg_kobunny_tournamentwinner, 920, ngheight+210);

		ctx.font = "30px sans-serif";
		ctx.fillStyle = 'brown';


		ctx.font = "50px sans-serif";
		ctx.fillStyle = 'black';
        var starttitle=20;
		ctx.fillText(ngcat, starttitle, ngheight-80);

		var dataURL = c.toDataURL("image/png");
		document.getElementById("ngg_kobunny_canvastoimg").src=dataURL


		document.getElementById("ngg_kobunny_canvastodiv").style.display = "block";
}

