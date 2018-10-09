'use strict';

/*Initialisation d'une nouvelle partie*/
function launch(){
	essai=1;
	
	$('.tentries').css('background-color',colors[difficulty]);
 
	$('.tries').css('opacity','1');

	activeLine(essai);
	activate('help');

	$.ajax({
		type: "post",
		url: "php/initd.php",
		data: {'difficulty': difficulty},
		success:function(data){
			inactivate('lvlchange');
		
		}
	});
}

/*à la validation d'une proposition*/
function onClickExecute(){
	
	let type = $(this).attr("id");
	if (attempts[type] != essai){
		$(`#${type}try`).html(`<span class="error bg-black">Vous êtes au n°${essai} !</span>`);
		return;
	}

	let saisie = $(`input.${type}`).val();
	if (saisie.match(/[a-zA-zÉéÀàÈèÙùÂâÊêÎîÔôÛûËëÏïÜüŸÿçÇ]{5}/) === null) {
		$(`#${type}try`).html('Veuillez saisir un mot de 5 lettres.');
		return;
	} else {
		document.body.className = "loading";
	}
	$.ajax({
		type: "post",
		url: "php/gamed.php",
		data: {'saisie': saisie,'try' : type},
		success:function(data){
			$(`#${type}try`).html(data);
			if(data.includes('Bravo')){
				playSound(6);

				threeInOne();

				$(`.${type}`).attr("disabled","disabled");
				
				sleepingGame();
				sleepingLine(essai);	

				submitScore();

				$('#answer').html('<p class="bg-white"><textarea id="commentaire" placeholder="Votre commentaire"></textarea><button id="write">Ajouter mon commentaire</button><span></p>');
				$('#write').on('click',addComm);
			}
			if (data.includes('solution')) {
				threeInOne();
				$('#help').css('background-position','-94px -10px');
			}
			if(data.includes('summary') &&(!data.includes('Bravo'))){
				sleepingLine(essai);
				$(`#${type}try`).addClass('bg-white');
				$(`.${Object.keys(attempts)[essai-1]}`).attr('disabled','disabled');

				activeLine(essai+1);
				if (essai==1){
						activate('newgame');
						activate('giveup');
				}
				essai++;
			}
			document.body.className = "";
		}
	});
}

function zoom() {
	
	let picture = document.getElementById('wholepic');

	let selected = document.getElementById("special");
	let captionText = document.getElementById("caption");

	let menu = document.getElementById("flexnav");

    picture.style.display = "block";

    menu.style.display = "none";

    let splitted = (this.src).split('');
    
    for(let i=0;i<splitted.length;i++){
    	if (splitted[i] == '8'){
    		if (splitted[i+1]=='.'){
    			splitted[i] = '9';
    		}
    	}
    }

    let newsrc ="";

    for(let i=0;i<splitted.length;i++){
    	newsrc += splitted[i];
    }

    selected.src=newsrc;

    captionText.innerHTML = this.alt;

	let span = document.getElementsByClassName("close")[0];

	span.onclick = function() { 
   	 	picture.style.display = "none";
    	menu.style.display= "flex";
	};
}

function openscore(){
	window.open('highscores.phtml','highscores','height=600, width=600, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); 
}







