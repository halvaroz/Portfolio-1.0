'use strict';
$(document).ready(function(){

	document.body.className = "loading";

	var classicDesign = false;

		$.ajax({
		type: "get",
		url: "php/loadscores.php",
		success:function(data){

			$('#trez').html(data);
			document.body.className = "";
		}
	});

	$('#switch').on('click',function(){

		if (classicDesign === false){
			$('.switcher').attr('src','img/switch-on.png');
		} else {
			$('.switcher').attr('src','img/switch-off.png');
		}

		classicDesign = !classicDesign;
		$('table').toggleClass('container');
		$('#general').toggleClass('cool');
		$('h1').toggleClass('cool');
		$('td').toggleClass('cool');
		$('th').toggleClass('cool');
		$('tr').toggleClass('cool');
		$('span').toggleClass('cool');
	});

	$('#lvltop').on('click',function(){
		if ($('#easy').hasClass('buster')){
			change('easy','medium',2);
		} else if ($('#medium').hasClass('buster')){
			change('medium','hard',3);
		} else if ($('#hard').hasClass('buster')){
			change('hard','easy',1);
		}
	 });
});

function change(current,next,lvl){
	$(`#${current}`).toggleClass('buster');
	$(`#${current}`).toggleClass('ghost');
	$(`#${next}`).toggleClass('buster');
	$(`#${next}`).toggleClass('ghost');
	$('h1').html('Classement niveau '+ lvl);
}
