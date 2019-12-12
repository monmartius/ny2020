$('.mod-edit').on('click', function(e){

	e.preventDefault();
    
    console.log($(this).closest('.user-message-content'));

    $userMessageContent = $(this).closest('.user-message-content');

    $textArea = $("<textarea class = 'user-message-content-textarea col-12'></textarea>")
        .html($('.content', $userMessageContent).html().trim());

    $content = $('.content', $userMessageContent).detach();
    $buttons = $('.mod-wrap', $userMessageContent).detach();
    
    $editButtons = $("<div class = 'mod-wrap col-12'></div>");

    $saveBtn = $('<a href = "#" class = "btn btn-success mod-btn">Сохранить</a>');
    $cancelBtn = $('<a href = "#" class = "btn btn-danger mod-btn">Отменить</a>');
    
    $saveBtn.on('click', function(e){
        e.preventDefault();
        
        $editButtons.detach();
        $textArea.detach();

        $content.html($textArea.val().trim());

        $userMessageContent.append($content);
        $userMessageContent.append($buttons);


    });
    
    $cancelBtn.on('click', function(e){
        e.preventDefault();
        
        $editButtons.detach();
        $textArea.detach();

        $userMessageContent.append($content);
        $userMessageContent.append($buttons);
    });

    $editButtons.append($saveBtn);
    $editButtons.append($cancelBtn);
    $userMessageContent.prepend($textArea);
    $userMessageContent.append($editButtons);
    

});

$('.mod-publish').on('click', function(e){

    e.preventDefault();

});


$('.mod-delete').on('click', function(e){

    e.preventDefault();

});


