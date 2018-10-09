'use strict';

$(function()
{	

	let largeur= window.innerWidth-118;
	largeur = largeur+'px';

	$('#rustine').css('width',largeur);

	window.onresize = function() {
        let nouvelleLargeur= window.innerWidth-118;

    /*adaptation au passage à un font-size=57% pour le html*/
        if (window.innerWidth<480){
        	nouvelleLargeur += 2;
        }
		nouvelleLargeur = nouvelleLargeur+'px';
        $('#rustine').css('width',nouvelleLargeur);     
    };

/*Au clic sur le bouton power*/

    $('#light').click(function(){
    	if (gamestate === 0){
    		document.body.className = "loading";

    		$('#light').css('background-position','-178px -178px');
    		activate('start');
    	
    		playSound(2);

	    	activateMuch();
	    	$('#effect').toggleClass('voile');
	    	$('#effect2').toggleClass('voile');
	    	$('#rustine').toggleClass('shadow');
	    	$('#rustine').html('Bienvenue !');
	  

	    	gamestate=1;
	    	document.body.className = "";
	    } else {
	    	document.body.className = "loading";
	    	playSound(3);
	    	$('#light').css('background-position','-178px -94px');
	    	$('#start').css('background-position','-10px -10px');
	    	

	    	inactivateMuch();
	    	inactivate('help');
	    	inactivate('giveup');
	    	inactivate('newgame');

	    	$('#start').on('click',startGame);
	    	$('#start').prop('disabled','true');

	    	for (let i=0;i<13;i++){
				sleepingLine(i);
			}

	    	$('#effect').toggleClass('voile');
	    	$('#effect2').toggleClass('voile');
	    	$('#rustine').toggleClass('shadow');
	    	$('#rustine').empty();
	    	$('.tentries').val('');
	    	$('.tentries').attr('disabled','true');

	    	$('.gameline').css('display','inline-block');

	    	$('#stats').empty();
	    	$('.result').empty();
	    	$('#winners').empty();
	
			if($('#infos').hasClass('help')) {
				$('.further').toggle('slow');
				$('#infos').removeClass('help');
			}

			if ($('#instructions').hasClass('help')){
				$('.how').toggle('slow');
				$('#instructions').removeClass('help');
			}


			difficulty=3;
			setDifficulty(difficulty);

	    	gamestate=0;
	    	document.body.className = "";
	    }
    });

/*Au clic sur le feu tricolore*/
	$('#lvlchange').on('click',function(){
		playSound(8);
		setDifficulty(difficulty);
	});

/*Au clic sur le bouton start*/
    $('#start').on('click',startGame);


/*Au clic sur l'icone règles'*/
	$('#instructions').on('click',function(){
		$('.how').toggle('slow');

		$('#instructions').toggleClass('on');
		if($('#instructions').hasClass('on')){
			playSound(7);
		}

	});

/*Au clic sur l'icone infos'*/
	$('#infos').on('click',function(){
		$('.further').toggle('slow');
	});
	
	
/*Au clic que l'icone statistiques*/
$('#statistics').on('click',function(){
		let content=$('#stats').html();

		if(content.length>20){
			$('#stats').html(' ');
		} else {

		$.ajax({
				type: "get",
				url: "php/stats.php",
				success:function(data){
				$('#stats').html(data);
				}
		});
	}
	});

/*Au clic sur le bouton 'HELP''*/

	$('#help').on('click',function(){
		$.ajax({
				type: "get",
				url: "php/help.php",
				success:function(data){
				
				$('#answer').html(data);
				inactivate('help');
				}
			});
	});


    

/*Au clic sur l'icone son - sous la nav à gauche*/
	$('#sound').click(function() {
	 	silence = !silence;
	 	let position = "";
	 	silence ? position="off" : position="on";
	 	$('#sound').html(`<img src="img/audio-${position}.png" alt="" />`);
 	});


	

/*Au clic sur l'icone bulles'*/
	$('#comments').on('click',function(){
		var content=$('#winners').html();
		
		if(content.length>20){
			
			$('#winners').html(' ');
		} else {
					
			$.ajax({
					type: "get",
					url: "php/comments.php",
					success:function(data){
					$('#winners').html(data);
					pagesCount = $('.hidden').length;

					$('.page1').toggleClass('hidden');
					currentPage = 1;

					$('#pageSelect').on('click',goToPage);

					$('.nextPage').on('click',goNextPage);
					$('.prevPage').on('click',goPrevPage);
					}
			});
		}
	});

/*Au clic sur le bouton 'Rejouer'*/
	$('#newgame').on('click',function(){
		playSound(4);
		$('#help').css('background-position','-10px -94px');
		$('.tentries').prop('disabled',false).val('');
		$('.result').html('');
		inactivate('newgame');
		inactivate('giveup');
		activate('help');
		for (let i=0;i<13;i++){
			sleepingLine(i);
		}
		
		activate('help');

		launch();
	});

/*Au clic sur le bouton 'Abandonner'*/
	$('#giveup').on('click',function(){
		$('#help').css('background-position','-94px -10px');
		playSound(5);
		$.ajax({
				type: "get",
				url: "php/abort.php",
				success:function(data){
					
				sleepingGame();
				$('#answer').html(data);
				threeInOne();
			}
		});
	});

/*À la validation d'une proposition*/
	$('.game').on('click',onClickExecute);
	
/*Au survol de l'image PHP*/
	$('#eleph  img').on('mouseenter',function() {
	 	playSound(0);
	});

/*Au survol de l'image MySQL*/
	$('#dolph  img').on('mouseenter',function() {
	 	playSound(1);
	 });

/* Gestion des ancres prenant en compte la nav fixe*/
	(function($, window) {
        let setAnchor = function() {
		let $anchor = $(':target');
        let fixedElementHeight = 100;
            
        if(window.innerWidth<480){
            fixedElementHeight=308;
        }

        if ($anchor.length > 0) {
			$('html, body')
                .stop()
                .animate({
                    scrollTop: $anchor.offset().top - fixedElementHeight
                }, 300);
            }
        };

        $(window).on('hashchange load', function() {
            setAnchor();
        });

    })(jQuery, window);

    var miniatures = document.getElementsByClassName('miniatures');

    for (let i=1; i<=miniatures.length; i++) {
    	$(`#img${i}`).on('click',zoom);
    }

});





 



