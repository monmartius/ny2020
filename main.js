user_id = $('[data-user_id]').data('user_id');
username = $('[data-username]').data('username');
step = $('[data-step]').data('step');
$('#feedback-message').val("");
$('#question-gifts-input').val("");
$('#question-username-input').val("");

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};


indexPage = 'slides.php';
indexPage = location.href;


// $("body").html("");
// b = document.getElementsByTagName('body')[0];


// setTimeout(function(){ $('.b1').trigger('click'); }, 100);
setTimeout(function(){ 

// if(isMobile.any()){
if(1){

	console.log('mobile!');

	$('.b1').trigger('click');
	$('.b1').trigger('click');	
}



}, 100);





function animateCSS(element, animationName, callback) {
    const node = document.querySelector(element);
    node.classList.add('animated', animationName);

    function handleAnimationEnd() {
        node.classList.remove('animated', animationName);
        node.removeEventListener('animationend', handleAnimationEnd);

        if (typeof callback === 'function') callback();
    }

    node.addEventListener('animationend', handleAnimationEnd);
}






// $animate = $('.question__title, .trees-btn-wrap, .question-btn, .question-gifts-input-wrap')
// .add('.question__title, .trees-btn-wrap, .question-btn, .question-gifts-input-wrap')
// .add('.question__title, .trees-btn-wrap, .question-btn, .question-gifts-input-wrap')
// .add('.question__title, .trees-btn-wrap, .question-btn, .question-gifts-input-wrap')
// .add( '.question-btn-gifts-fear, .js-feedback-message-box, .msg-block')
// .add('.general-results-box, .btn-give-me-surprise')
// .add('.congratulations, .congratulations-input-email, .congratulations-input-name')
// .add('.results-h2');



// $animate.addClass('animated fadeInDown');
// $('body').css('visibility', 'visible')

















$(window).scrollTop(0);



console.log(indexPage);


function reload(){
	location.reload();
}

(function($){
    $.fn.limit  = function(options) {
        var defaults = {
        limit: 1000,
        id_result: 'feedback-message-counter',
        alertClass: false
        }

        var options = $.extend(defaults,  options);

        return this.each(function() {
            var characters = options.limit;
            if(options.id_result != false)
            {
                $("#"+options.id_result).append("Вы можете ввести <strong>"+  characters+"</strong> знаков");
            }
            $(this).keyup(function(){
                if($(this).val().length > characters){
                    $(this).val($(this).val().substr(0, characters));
                }
                if(options.id_result != false)
                {
                    var remaining =  characters - $(this).val().length;
                    $("#"+options.id_result).html("Вы можете ввести еще <strong>"+  remaining+"</strong> знаков");
                    if(remaining <= 10)
                    {
                        $("#"+options.id_result).addClass(options.alertClass);
                    }
                    else
                    {
                        $("#"+options.id_result).removeClass(options.alertClass);
                    }
                }
            });
        });
    };
})(jQuery);


$('#feedback-message').limit();



$('a.js-Likes').on('click', function(e){

	e.preventDefault();

	var id = $(this).data('id');

	$this = $(this);

	href = $(this).attr('href');



	if(step == 0){
		data = {
			commentlike: id
		}
	}

	if(step == 2){

		data = {
			ny_storylike: id
		}
	}
	
	if(step == 3){

		data = {
			wishlike: id
		}
	}
	if(step == 4){

		if(href.indexOf('comment') !== -1){

			data = {
				commentlike: id
			}
		}

		if(href.indexOf('story') !== -1){

			data = {
				ny_storylike: id
			}
		}

		if(href.indexOf('wish') !== -1){

			data = {
				wishlike: id
			}
		}
	}

	$.ajax({
		url: indexPage,
		type: 'GET',
		data: data,
		success: function (res) {

			// selector = 'a.js-Likes[data-id="' + id + '"]';
			selector = $this;

			
			$(selector).parent('.msg-block__item').toggleClass('likedByThisUser');
			$('.msg-block__like-counter', selector).html(res);

		},
		error: function (res) {
			console.log(res.responseText);
		}
	});
});




$('a[data-trees]').on('click', function(e){

	e.preventDefault();

	var trees = $(this).data('trees');

	$this = $(this);

	// alert(id);

	$.ajax({
		url: indexPage,
		type: 'GET',
		data: {
			trees: trees
		},
		success: function (res) {

			$('a[data-trees]').removeClass('checked');

			$this.addClass('checked');
		},
		error: function (res) {
			console.log(res.responseText);
		}
	});
});






$('.question-btn-gifts-fear').on('click', function(e){

	e.preventDefault();

	gifts = parseInt($('#question-gifts-input').val());

	if(!Number.isInteger(gifts)){

		gifts = -1;
	}

	$.ajax({
		url: indexPage,
		type: 'POST',
		data: {
			step: 2,
			gifts: gifts
		},
		success: function (res) {

// window.location.href=window.location.href
					reload();
		},
		error: function (res) {
			console.log(res.responseText);
		}
	});

});

$('#question-gifts-input').on('keyup change', function(e){

	console.log($('#question-gifts-input').val());

	value = $('#question-gifts-input').val();

	res = "";

	for(i=0; i < value.length; i++){

		char = value[i];

		if(char < '0' || char > '9' ) char = "";

		res = res + "" + char;
	}

	$('#question-gifts-input').val(res)
	
});




$('.question-gifts-btn-next').on('click', function(e){

	e.preventDefault();

	gifts = parseInt($('#question-gifts-input').val());

	if(!Number.isInteger(gifts)){

		gifts = 0;
	}

		$.ajax({
			url: indexPage,
			type: 'POST',
			data: {
				step: 2,
				gifts: gifts
			},
			success: function (res) {

  // window.location.href=window.location.href
  					reload();
			},
			error: function (res) {
				console.log(res.responseText);
			}
	});

});



$('.question-input').on('click', function(e){

	$('.question-username-input-error').html("");
})


$('.question-btn-submit').on('click', function(e){

	e.preventDefault();

	if( !$('[data-username]').data('username') ){

		username = $('#question-username-input').val();

	}


	message = $('#feedback-message').val();


// console.log('username ' + username)
// console.log('message ' + message)
// console.log(step)

	// if(!message && username){
	// 	$('#feedback-message-counter').html('Вы не ввели сообщение');
	// }
	if(message && !username){

		$(".question-username-input-error").html('Введите ваше имя');
	}


	if( (username && message) ) {

		
		if(step == 2){
		
			data = {
				user_id: user_id,
				ny_story: message,
				username: username, 
				step: 3
			}
		}	

		if(step == 3){
			data = {
				wish: message,
				user_id: user_id,
				username: username,
				step: 4
			}
		}


		$.ajax({
			url: indexPage,
			type: 'POST',
			data: data,
			success: function (res) {

			console.log(res)				
				reload();
				// window.location.href=window.location.href
				
			},
			error: function (res) {
				console.log(res.responseText);
			}
		});		



	}


	if ((username && !message )) {

		data = {
			user_id: user_id,
			step: step + 1
		}



		$.ajax({
			url: indexPage,
			type: 'POST',
			data: data,
			success: function (res) {

			console.log(res)				
				reload();
				// window.location.href=window.location.href
				
			},
			error: function (res) {
				console.log(res.responseText);
			}
		});		



	}



	if ( (!username && !message) ){

		data = {
			user_id: user_id,
			step: step + 1
		}



		$.ajax({
			url: indexPage,
			type: 'POST',
			data: data,
			success: function (res) {

			console.log(res)				
				reload();
				// window.location.href=window.location.href
				
			},
			error: function (res) {
				console.log(res.responseText);
			}
		});		


	}
});


$('.question-trees-btn-next').on('click', function(e){

	e.preventDefault();
	
	$.ajax({
				url: indexPage,
				type: 'POST',
				data: {
					step: 1,
				},
				success: function (res) {

	  				reload();


				},
				error: function (res) {
					console.log(res.responseText);
				}
	});

});


$('.reset').on('click', function(e){

	e.preventDefault();

	$.ajax({
			url: indexPage,
			type: 'POST',
			data: {
				step: 0,
			},
			success: function (res) {

  				reload();

			},
			error: function (res) {
				console.log(res.responseText);
			}
	});

});






$('.reload').on('click', function(e){

	e.preventDefault();

				// alert();
	$.ajax({
			url: indexPage,
			type: 'POST',
			data: {
				step: 0,
				reload: reload
			},
			success: function (res) {

				
				console.log(res);

				// alert();

  				reload();

			},
			error: function (res) {
				console.log(res.responseText);
			}
	});

});









$('.question-ny-story-next').on('click', function(e){

	e.preventDefault();

	$.ajax({
			url: indexPage,
			type: 'POST',
			data: {
				step: 3,
			},
			success: function (res) {

  				reload();

			},
			error: function (res) {
				console.log(res.responseText);
			}
	});

});



$('.question-wish-next').on('click', function(e){

	e.preventDefault();

	$.ajax({
		url: indexPage,
		type: 'POST',
		data: {
			step: 4,
		},
		success: function (res) {
					reload();
		},
		error: function (res) {
			console.log(res.responseText);
		}
	});
});


$('.btn-give-me-surprise').on('click', function(e){

	e.preventDefault();

	$.ajax({
		url: indexPage,
		type: 'POST',
		data: {
			step: 5,
		},
		success: function (res) {
					reload();
		},
		error: function (res) {
			console.log(res.responseText);
		}
});

});





$('.btn-give-me-surprise').on('click', function(e){

	e.preventDefault();



	$.ajax({
		url: indexPage,
		type: 'POST',
		data: {
			step: 5,
		},
		success: function (res) {
					reload();
		},
		error: function (res) {
			console.log(res.responseText);
		}
	});

});




$('.btn-send-email').on('click', function(e){

	e.preventDefault();
	
	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	var email = $('.input-email').val();
	

	if(!username){

		var username = $('.input-username').val() ;

			msgInput = "";

			if($('.input-username').length){

			if(username == ""){

				msgInput = 'Введите ваше имя.';
			}
		}

	}


		// alert("username" + username)

	msgEmail = "";

	if(reg.test(email) == false) {

		msgEmail = "Введите допустимый email-адрес.";

	}

	if(msgInput + ' ' + msgEmail !== ' '){

		$('.errors').html(msgInput + ' ' + msgEmail);	
	}
	else{
	
		// alert("username" + username)

		$.ajax({
					url: indexPage,
					type: 'POST',
					data: {
						email: email,
						username: username,
						step: 6
					},
					success: function (res) {

		  				reload();

					},
					error: function (res) {
						console.log(res.responseText);
					}
		});

	}


});





$(document).ready(function() {

// https://pcvector.net/412-nicescroll-alternativa-polos-prokrutki.html
    
    var nice = $(".msg-block__msg-box").niceScroll(
    	{
    		cursoropacitymin: .3,
    		cursoropacitymax: 1,
    		cursorwidth: '15px',
    		autohidemode: false,
    		cursorcolor: '#ff0000',
    		zindex: 100


    	}
    );

});
