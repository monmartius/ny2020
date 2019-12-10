
    <div class="container container1">

        <div class="row">

            <div class="container1-grid-1 col-12 col-md-7 col-lg-7">
                
                <div class="question question-trees">

                    <div class="question__title">
                        Какая встреча Нового года была у вас самая необычная?
                    </div>

                    <form class="question-form container-fluid question-form-ny_story">

                     
                        <div class="js-feedback-message-box row">
                            <textarea 
                                id = "feedback-message"
                                name="textarea" 
                                class = "col-12 question-textarea" 
                                name = "feedback" 
                                placeholder="Ваша история"></textarea>
                            <div id="feedback-message-counter"></div>
                        </div>
                        <div class="js-feedback-message-box row">

<?php if($user['name'] == "" ) :?>
                            <div class="question-submit-input-wrap">
                            <input 
                                type="text" 
                                class="js-feedback-message-box question-input question-ny-story-input" 
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

                    <div class="msg-block__title">Истории <div class = "d-none d-lg-block"></div>других участников</div>

                    <div class="msg-block__msg-box">

<?php 
    $ny_stories = dbQuery($db, "SELECT * FROM ny_story WHERE  1 ORDER BY likes DESC");
    $ny_stories = $ny_stories->fetchAll();
?>
    <?php foreach ($ny_stories as $ny_story) : ?>
    
<?php 

    // $likeCounter = dbQuery($db, 
    //     "SELECT count(*) FROM user_like_comment WHERE comment_id = {$comment['id']};"
    // );

    // $likeCounter = $likeCounter->fetch()['count(*)'];
    // el('$likeCounter ' . $likeCounter);
    // el($comment['content']);

if($ny_story['content']){


    $likeCounter = dbQuery($db, 
        'SELECT likes FROM ny_story WHERE id = ?',
        $ny_story['id']
    );

    $likeCounter = $likeCounter->fetch()[0];




    $likedByThisUser = dbQuery($db, 
        "SELECT count(*) FROM user_like_ny_story 
        WHERE ny_story_id = {$ny_story['id']} 
        and user_id = {$user_id};"
    );

    $likedByThisUser = (bool) $likedByThisUser->fetch()['count(*)'];
    // el($likedByThisUser->fetch()['count(*)']);

    $author = dbQuery($db, 
        "SELECT name FROM user WHERE id = {$ny_story['author_id']};"
    );

    $author = $author->fetch()[0];

    // el('$author ' .  $author);    
    


    // die();

    ?>

                        <div class="msg-block__item
                        <?php echo $likedByThisUser ? " likedByThisUser" : ""?>">
                            <a href="?ny_storylike=<?= $ny_story['id'] ?>" 
                                data-id = "<?= $ny_story['id'] ?>" 
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
                                    <?= $ny_story['content'] ?>
                                </div>
                                <div class="msg-block__author">
                                    <?= $author ?>
                                </div>
                            </div>
                        </div>





<?php
} 
endforeach; ?>

                    </div><!--     /msg-block__msg-box-->



                </div> <!-- /msg-block-->

            </div>



















