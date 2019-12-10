user_id = $('[data-user_id]').data('user_id');
username = $('[data-username]').data('username');
step = $('[data-step]').data('step');
$('#feedback-message').val("");
$('#question-gifts-input').val("");
$('#question-username-input').val("");

indexPage = 'slides.php';
indexPage = location.href;

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

	$.ajax({
			url: indexPage,
			type: 'POST',
			data: {
				step: 3
			},
			success: function (res) {

				reload();
			},
			error: function (res) {
				console.log(res.responseText);
			}
		});	

}
);




$('.question-btn-submit').on('click', function(e){

	e.preventDefault();

	if( !username ){
		if(
			!$('#question-username-input')[0].value && 
			!$('.question-username-input-error', $('.question-form')).length
		)
		{
			$('<div class = "question-username-input-error">Введите ваше имя</div>').insertAfter($('#question-username-input'));
		}
		else{

			if($('#question-username-input')[0].value){

				username = $('#question-username-input')[0].value;
			}
		}
	}


	message = $('#feedback-message').val();

	console.log('message')
	console.log(message)

	if(message.length > 0 && username){
	
			$this = $(this);

			console.log(step)

			if(step == 0){
				data = {
					comment: message,
					user_id: user_id,
					username: username
				}
			}

			if(step == 2){
				data = {
					ny_story: message,
					user_id: user_id,
					username: username
				}
			}	

			if(step == 3){
				data = {
					wish: message,
					user_id: user_id,
					username: username
				}
			}			

console.log(step);
console.log(data);

			$.ajax({
				url: indexPage,
				type: 'POST',
				data: data,
				success: function (res) {

					reload();
					// window.location.href=window.location.href

				},
				error: function (res) {
					console.log(res.responseText);
				}
			});		
	}
	else{

		if(!message){
			$('#feedback-message-counter').html('Вы не ввели сообщение')
		}
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


$('.question-ny-story-next').on('click', function(e){

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
	var username = $('.input-username').val() ;

	msgInput = "";

	if($('.input-username').length){

		if(username == ""){

			msgInput = 'Введите ваше имя.';
		}
	}

	msgEmail = "";

	if(reg.test(email) == false) {

		msgEmail = "Введите допустимый email-адрес.";

	}

	if(msgInput + ' ' + msgEmail !== ' '){

		$('.errors').html(msgInput + ' ' + msgEmail);	
	}
	else{
	

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

    var nice = $(".msg-block__msg-box").niceScroll();

});
