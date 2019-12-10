
    <div class="container container1">

        <div class="row">

            <div class="container1-grid-1 col-12 col-md-7 col-lg-7">
                
                <div class="question question-trees">

                    <div class="question__title">
                       Загадайте своё главное желание на&nbsp;2020 год, <span class="question__title" style="font-size: 70%;">мы отправим его Деду Морозу в Великий Устюг</span>
                    </div>

                    <form class="question-form question-form-ny_story container-fluid">

                     
                        <div class="js-feedback-message-box row">
                            <textarea 
                                id = "feedback-message"
                                name="textarea" 
                                class = "col-12 question-textarea" 
                                name = "feedback" 
                                placeholder="Ваше желание"></textarea>
                            <div id="feedback-message-counter"></div>
                        </div>
                        <div class="js-feedback-message-box row">

<?php if($user['name'] == "" ) :?>
                            <div class="question-submit-input-wrap">
                                <input 
                                type="text" 
                                class="js-feedback-message-box question-input question-wish-input" 
                                id="question-username-input" 
                                placeholder="Ваше имя">
                                <div class = "question-username-input-error"></div>
                            </div>
<?php endif;  ?>    
                            <a 
                                class="js-feedback-message-box btn question-btn question-btn-submit" 
                                name = "feedback-submmit" 
                                id = "feedback-submmit"
                                type="submit">Далее...</a>

                        </div>
                    </form>
                        

                </div>
            </div>

<!-- msg-block -->
<!--            <div class="container1-grid-2 col-12 col-sm-12 col-md-5 col-lg-5 order-3 order-md-2">-->
            <div class="container1-grid-2 col-12 col-sm-12 col-md-5 col-lg-5 order-3 order-md-2">

                <div class="msg-block">

                    <div class="msg-block__title">Желания <div class = "d-none d-lg-block"></div>других участников</div>

                    <div class="msg-block__msg-box">

<?php 
    $wishes = dbQuery($db, "SELECT * FROM wish WHERE 1 ORDER BY likes DESC");
    $wishes = $wishes->fetchAll();
?>
    <?php foreach ($wishes as $wish) : ?>
    
<?php 

    // $likeCounter = dbQuery($db, 
    //     "SELECT count(*) FROM user_like_comment WHERE comment_id = {$comment['id']};"
    // );

    // $likeCounter = $likeCounter->fetch()['count(*)'];
    // el('$likeCounter ' . $likeCounter);
    // el($comment['content']);


    $likeCounter = dbQuery($db, 
        'SELECT likes FROM wish WHERE id = ?',
        $wish['id']
    );

    $likeCounter = $likeCounter->fetch()[0];




    $likedByThisUser = dbQuery($db, 
        "SELECT count(*) FROM user_like_wish 
        WHERE wish_id = {$wish['id']} 
        and user_id = {$user_id};"
    );

    $likedByThisUser = (bool) $likedByThisUser->fetch()['count(*)'];
    // el($likedByThisUser->fetch()['count(*)']);

    $author = dbQuery($db, 
        "SELECT name FROM user WHERE id = {$wish['author_id']};"
    );

    $author = $author->fetch()[0];

    // el('$author ' .  $author);    
    


    // die();

    ?>

                        <div class="msg-block__item
                        <?php echo $likedByThisUser ? " likedByThisUser" : ""?>">
                            <a href="?wishlike=<?= $wish['id'] ?>" 
                                data-id = "<?= $wish['id'] ?>" 
                                class="msg-block__like-wrap js-Likes">

                                <div class="msg-block__like-counter">

                                     <?= $likeCounter ?>

                                </div>

                                <div class="msg-block__like-heart">

                                    <i class="fa"></i>

                                </div>
                            </a>
                            <div class="msg-block__message-wrap">
                                <div class="msg-block__message">
                                    <?= $wish['content'] ?>
                                </div>
                                <div class="msg-block__author">
                                    <?= $author ?>
                                </div>
                            </div>
                        </div>


<?php endforeach; ?>

                    </div><!--     /msg-block__msg-box-->



                </div> <!-- /msg-block-->

            </div>

<!--            <div class="container1-grid-3 col-12 col-md-12 order-3">-->



















