'use strict';

var attempts = {'first' : 1, 'second' : 2,'third' : 3, 'fourth' : 4,'fifth' : 5, 'sixth' : 6,'seventh' : 7, 'eighth' : 8,'ninth' : 9, 'tenth' : 10, 'eleventh':11, 'twelfth' : 12};
var colors ={'1':'#7b5','2':'#fd5','3':'#e34'};

var silence = true;
var difficulty = 1;

var essai = 0;
var nthgame = 0;

var gamestate= 0;

var currentPage =0;
var pagesCount =0;

function playSound(id){
	if (silence === false){
		let sound = document.getElementsByTagName("audio")[id];
		sound.play();
	}
}


function sleepingGame(){
	for (let i=essai-1; i<13; i++){
		$(`.${Object.keys(attempts)[i]}`).attr('disabled','disabled');
		$(`.${Object.keys(attempts)[i]}`).css("background-color","rgb(235,235,228)");
		$(`#${Object.keys(attempts)[i]}`).css("background-color","rgb(55,55,55)");
		$(`#${Object.keys(attempts)[i]}`).prop('disabled','true');
		$("#giveup").prop('disabled','true');
	}
}

function sleepingLine(line){
	$(`.${Object.keys(attempts)[line-1]}`).attr('disabled','disabled');
	$(`.${Object.keys(attempts)[line-1]}`).css("background-color","rgb(235,235,228)");
	$(`#${Object.keys(attempts)[line-1]}`).css("background-color","rgb(55,55,55)");
	$(`#${Object.keys(attempts)[line-1]}`).prop('disabled','true');
	$(`.${line}`).removeAttr('id');
}

function activeLine(line){
	
	$(`#${Object.keys(attempts)[line-1]}`).css('background-color','white');
	$(`.${Object.keys(attempts)[line-1]}`).css("background-color","black");
	$(`.${line}`).attr('id',"current");
	$(`#${Object.keys(attempts)[line-1]}`).removeAttr('disabled');
	$(`.${Object.keys(attempts)[line-1]}`).removeAttr('disabled');
}

function activate(buttonid){

	$(`#${buttonid}`).removeAttr('disabled');
	$(`#${buttonid}`).addClass('activebutton');
	$(`#${buttonid}`).removeClass('inactivebutton');
	
}

function inactivate(buttonid){

	$(`#${buttonid}`).prop('disabled','true');
	$(`#${buttonid}`).removeClass('activebutton');
	$(`#${buttonid}`).addClass('inactivebutton');

}

function activateMuch(){
	activate('lvlchange');
	activate('start');
	activate('instructions');
	activate('topscores');
	activate('infos');
	activate('statistics');
	activate('comments');
}

function inactivateMuch(){
	inactivate('lvlchange');
	inactivate('start');
	inactivate('instructions');
	inactivate('topscores');
	inactivate('infos');
	inactivate('statistics');
	inactivate('comments');
}


function threeInOne(){
	inactivate('giveup');
	inactivate('help');
	activate('lvlchange');
}

function setDifficulty($difficulty){
	switch($difficulty){
		case 1:
			$('#lvl').removeClass('green');
			$('#lvl').addClass('yellow');
			$('#lvl').html('Niveau II');
			difficulty = 2;
		break;
		case 2:
			$('#lvl').removeClass('yellow');
			$('#lvl').addClass('red');
			$('#lvl').html('Niveau III');
			difficulty = 3;
		break;
		case 3:
			$('#lvl').removeClass('red');
			$('#lvl').addClass('green');
			$('#lvl').html('Niveau I');
			difficulty = 1;
		break;
	}
}