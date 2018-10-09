'use strict';

function startGame(){
	$('#start').css('background-position','-94px -178px');
	inactivate('start');
	$('.gameline').css('display','block');
	launch();
}

function submitScore(){
	let type = $(this).attr("id");

	$.ajax({
		type: "post",
		url: "php/podium.php",
		success:function(data){

			$(`#${type}try`).html(data);

			document.body.className = "";

			$('#addname').on('click',specifyName);
			if (essai == 1){
				activate('newgame');
			}
		}
	});
}

function specifyName(){
	let name= $('#playername').val();
	
	if (name.trim() === ""){
		$('#success span').html('Veuillez écrirer un nom.');
		return;
	}

	$.ajax({
		type: "post",
		url: "php/updatename.php",
		data: {'name': name},
		success:function(data){

			$('#wellmessage').html(data);

			if (data.includes('caractères')){
				$('#addname').on('click',specifyName);
			}
		
		}
	});
}



function addComm(){
	let comment= $('#commentaire').val();
	
	if (comment.trim() === ""){
		$('#success span').html('Veuillez écrirer un commentaire.');
		return;
	}

	$.ajax({
		type: "post",
		url: "php/addcomment.php",
		data: {'comment': comment},
		success:function(data){
			$('#answer').html(data);

			if (data.includes('caractères')){
				$('#write').on('click',addComm);
			}
		}
	});
}



/*Trois fonctions pour la pagination des commentaires*/
function goToPage(){
	let selected = $('#nthpage').val();

	$(`.page${currentPage}`).toggleClass('hidden');
	$(`.page${selected}`).toggleClass('hidden');
	currentPage = selected;
};

function goNextPage(){
	if (currentPage<pagesCount){
		$(`.page${currentPage}`).toggleClass('hidden');
		$(`.page${currentPage+1}`).toggleClass('hidden');
		currentPage++;
	}
}

function goPrevPage(){
	if (currentPage>1){
		$(`.page${currentPage}`).toggleClass('hidden');
		$(`.page${currentPage-1}`).toggleClass('hidden');
		currentPage--;
	}
}