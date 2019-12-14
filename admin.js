indexPage = location.href;

function cahngeStatistic(str){

    arr = str.split(",");

    ny_storyAll = arr[0];
    ny_storyPublished = arr[1];
    ny_storyDeleted = arr[2];
    console.log('ny_storyDeleted')
    console.log(ny_storyDeleted)
    ny_storyUnpublished = arr[3];
    wishAll = arr[4];
    wishPublished = arr[5];
    wishDeleted = arr[6];
    wishUnpublished = arr[7];

    $statistis = $('statistis');

    $('.ny_story-all').html(ny_storyAll);
    $('.ny_story-published').html(ny_storyPublished);
    $('.ny_story-deleted').html(ny_storyDeleted);
    $('.ny_story-unpublished').html(ny_storyUnpublished);
    $('.wish-all').html(wishAll);
    $('.wish-published').html(wishPublished);
    $('.wish-deleted').html(wishDeleted);
    $('.wish-unpublished').html(wishUnpublished);

}
    

$('.mod-update').on('click', function(e){

	e.preventDefault();
    
    console.log($(this).closest('.user-message-content'));

    var $this = $(this);

    var $userMessageContent = $(this).closest('.user-message-content');

    var $textArea = $("<textarea class = 'user-message-content-textarea col-12'></textarea>")
        .html($('.content', $userMessageContent).html().trim());

    var $content = $('.content', $userMessageContent).detach();
    var $buttons = $('.mod-wrap', $userMessageContent).detach();

    var $editButtons = $("<div class = 'mod-wrap col-12'></div>");

    var $saveBtn = $('<a href = "#" class = "btn btn-success mod-btn">Сохранить</a>');
    var $cancelBtn = $('<a href = "#" class = "btn btn-danger mod-btn">Отменить</a>');

    
    $editButtons.append($saveBtn);
    $editButtons.append($cancelBtn);



    $saveBtn.on('click', function(e){
        e.preventDefault();
        
        $editButtons.detach();
        $textArea.detach();

        $content.html($textArea.val().trim());

        data = {
            from : $this.data('from'),
            id : $this.data('id'),
            update : "",
            content : $content.html()

        };

        var $waitMessage = $('<div class = "wait-message">Данные сохраняются...</div>');
        
        $userMessageContent.append($waitMessage);

        $.ajax({
            url: indexPage,
            type: 'GET',
            data: data,

            success: function (res) {
   

                if(res == "Session is over."){

                    location.reload();
                }
                
                $waitMessage.detach();
                
                $userMessageContent.append($content);
                $userMessageContent.append($buttons);
                
                console.log(res);
    
            },
            error: function (res) {
                console.log(res.responseText);
            }
        });

       


    });
    
    $cancelBtn.on('click', function(e){
        e.preventDefault();
        
        $editButtons.detach();
        $textArea.detach();

        $userMessageContent.append($content);
        $userMessageContent.append($buttons);
    });



    $userMessageContent.prepend($textArea);
    $userMessageContent.append($editButtons);
    

});

$('.mod-publish').on('click', function(e){

    e.preventDefault();



    var $this = $(this);

    var publish = $this.data('status') == "1" ? 0 : 1;

    console.log('publish')
    console.log(publish)

    publishClass = publish ? 'btn-success' : 'btn-warning';
    publishMessage = publish ? 'ОПУБЛИКОВАНО / Распубликовать' : 'НЕОПУБЛИКОВАНО / Опубликовать';

    data = {
        from : $this.data('from'),
        id : $this.data('id'),
        publish : publish
    }


    $.ajax({

        url: indexPage,
        type: 'GET',
        data: data,

        success: function (res) {

            if(res == "Session is over."){

                location.reload();
            }
            
            $this.removeClass('btn-success');
            $this.removeClass('btn-warning');
            $this.data('status', publish);
            $this.html(publishMessage);
            $this.addClass(publishClass);
            
            console.log(res);
            cahngeStatistic(res);

        },
        error: function (res) {
            console.log(res.responseText);
        }
    });


});








$('.mod-delete').on('click', function(e){

    e.preventDefault();

    $this = $(this);

    data = {
        from : $(this).data('from'),
        id : $(this).data('id'),
        delete : ""
    }


    $.ajax({

        url: indexPage,
        type: 'GET',
        data: data,

        success: function (res) {



            if(res == "Session is over."){

                location.reload();
            }
            
            $message = $this.closest('.user-message-content');
            $message.html($('<div class = "wait-message">Данные удалены</div>'));
            // .detach();
            console.log(res);
            cahngeStatistic(res);

        },
        error: function (res) {
            console.log(res.responseText);
        }
    });



    console.log(data);

});



