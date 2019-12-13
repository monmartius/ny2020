
    <div class="container container1">

        <div class="row">
            
            <div class="container">
                
                <div class="row">
                     










                   <div class="col-12 col-lg-12 your-results">

                        <div class="congratulations-v-gutter d-lg-none"></div>
                        
                        <h2 class="results-h2">Ваши результаты</h2>


                        <?php 

                            $trees = dbQuery($db, 'SELECT trees FROM user WHERE id = ?', $user_id)->fetch()['0'];

                            $gifts = dbQuery($db, 'SELECT gifts FROM user WHERE id = ?', $user_id)->fetch()['0'];
                            $ny_story = dbQuery($db, 'SELECT content FROM ny_story WHERE author_id = ?', $user_id)->fetch()['0'];
                            $wish = dbQuery($db, 'SELECT content FROM wish WHERE author_id = ?', $user_id)->fetch()['0'];


                            $scores = ($trees ? 1 : 0) + ($gifts ? 1 : 0) + ($ny_story ? 1 : 0) + ($wish ? 1 : 0);

                            // die();

                        ?>





                        <div class="row general-results-box">
                            
                            <div class="col-8 general-results-clause">Количество ёлок, которые вы собираетесь нарядить:</div>

                            <div class="query-result general-results-clause-digits col-12 col-sm-4 ">

                         
                                <?php 

                                $trees = dbQuery($db, 'SELECT trees FROM user WHERE id = ?', $user_id);

                                $trees = (string) $trees->fetch()['0'];

                                // die($trees);

                                

                                $trees = str_replace(".", ",", $trees);

                                // $trees = round("0.123123123123", 1);

                                echo $trees ;


                                ?>

                                <!-- <span style = "margin-left: 8px; font-size: 60%; position: relative; top: 4px;">ёлок</span>
 -->
                                
                            </div>
                        
                        </div>

                        <div class="row general-results-box">



                            <?php 

                            $gifts = dbQuery($db, 'SELECT gifts FROM user WHERE id = ?', $user_id)-> fetch()[0];

                            ?>
                            
                            <?php if((int) $gifts == "-1" ) : ?> 

                                <div class="col-12 general-results-clause mb-3">Количество подарков, которые вы собираетесь подарить:</div>
                                    
                                <div class="query-result general-results-clause-digits col-12" style="font-size: 85%">
                                    
                                    <?= 'Даже страшно об этом подумать!' ?>

                                </div>
                            
                            <?php else :?>

                                <div class="col-12 col-sm-8 general-results-clause mb-3">Количество подарков, которые вы собираетесь подарить:</div>

                                <div class="query-result general-results-clause-digits col-12 col-sm-4 ">

          
                                <?php 

                                    $gifts = dbQuery($db, 'SELECT gifts FROM user WHERE id = ? ORDER BY id DESC', $user_id);

                                    $gifts = (string) $gifts->fetch()['0'];

                                    // die($trees);


                                    echo $gifts ;

                                    ?><!-- <span style = "margin-left: 8px; font-size: 60%; position: relative; top: 4px;">ёлок</span>
     -->
                                    
                                </div>

                            <?php endif; ?>

                        </div><!-- row -->


                        <?php 

                        $ny_story = dbQuery($db, 'SELECT content FROM ny_story WHERE author_id = ? ORDER BY id DESC', $user_id)->fetch()[0];

                        if($ny_story) :?>


                        <div class="row general-results-box">
                            
                            <div class="col-12 general-results-clause mb-3">Ваше воспоминание о самой необычной встрече Нового года:</div>


                            <div class="col-12 general-results-clause results-ready results-ready-text">

                         
                            <?= $ny_story ?>

                                
                            </div>





                        </div><!-- row -->

                        <?php endif; ?>









                        <?php 

                        $wish = dbQuery($db, 'SELECT content FROM wish WHERE author_id = ? ORDER BY id DESC', $user_id)->fetch()[0];

                        if($wish) :?>


                        <div class="row general-results-box">
                            
                            <div class="col-12 general-results-clause mb-3">Ваше главное желание в 2020 году:</div>


                            <div class="col-12 general-results-clause results-ready results-ready-text">

                         
                            <?= $wish ?>

                                
                            </div>





                        </div><!-- row -->

                        <?php endif; ?>











                        <div class="row general-results-box">



                            <div class="col-12 general-results-clause results-ready results-ready-resume">
                                
<?php 

            switch ($scores) {
                case '0':
                    echo "Вы совсем не&nbsp;готовы к&nbsp;встрече Нового года, стоит поторопиться и&nbsp;нарядить хотя бы одну&nbsp;ёлку!";
                    break;
                
                case '1':
                    echo "Вы совсем не&nbsp;готовы к встрече Нового года, стоит поторопиться и&nbsp;нарядить хотя&nbsp;бы одну&nbsp;ёлку!";
                    break;
                
                case '2':
                    echo "Вы почти готовы к&nbsp;встрече Нового года, подумайте, где нарядить еще одну&nbsp;ёлку!";
                    break;
                
                case '3':
                    echo "Вы почти готовы к&nbsp;встрече Нового года, подумайте, где нарядить еще одну&nbsp;ёлку!";
                    break;


                case '4':
                    echo "Вы готовы к встрече Нового года, но всегда можно улучшить личный результат и нарядить ещё одну&nbsp;ёлку!";
                    break;

                    
                }

?>

                            </div>



                            
                        </div>
                        
                    </div><!-- col-12 col-lg-6 your-results -->










                    <div class="col-12 give-me-surprise mt-5">
                        <a href="#" class="btn btn-give-me-surprise">
                        Получить сюрприз! 
                        <i class="fa fa-long-arrow-right btn-give-me-surprise__arrow"></i>
                        </a>
                    </div>    






                    <div class="col-12 col-lg-12 other-results mt-5">

                        <div class="congratulations-v-gutter d-lg-none"></div>
                        
                        <h2 class="results-h2">Результаты опроса других участников</h2>

                        <div class="row general-results-box">
                            
                            <div class="col-sm-8 general-results-clause">Участники опроса планируют нарядить в&nbsp;среднем</div>

                            <div class="query-result general-results-clause-digits col-12 col-sm-4">

                                <?php 

                                $trees = dbQuery($db, 'SELECT avg(trees) FROM user');

                                $trees = $trees->fetch()['avg(trees)'];

                                $trees = (string )round($trees, 1);

                                $trees = str_replace(".", ",", $trees);

                                echo $trees;

                                ?><span style = "margin-left: 8px; font-size: 60%; position: relative; top: 4px;">ёлок</span>
                                
                            </div>

                        </div><!-- row -->


                        
                        <div class="row general-results-box">

                            <div class="col-12 col-sm-8 general-results-clause">И в среднем готовят для своих близких</div>

                            <div class="query-result general-results-clause-digits col-12 col-sm-4">

                                <?php 

                                $gifts = dbQuery($db, 'SELECT avg(gifts) FROM user');

                                $gifts = $gifts->fetch()['avg(gifts)'];

                                $gifts= (string) round($gifts, 1);

                                $gifts = str_replace(".", ",", $gifts);

                                echo $gifts;



                                 ?> <span style = "margin-left: 8px; font-size: 60%; position: relative; top: 4px;">подарков</span>
                                

                            </div>

                            
                        </div>
                        



                    </div><!-- col-12 col-lg-6 other-results -->











   
                </div>
 
                
            </div><!-- container -->

        </div><!-- row -->
            



            <div class="row msg-results">
                
                <div class="col-12 col-md-6">









                    <div class="msg-block">

                        <div class="msg-block__title">Истории других участников</div>

                        <div class="msg-block__msg-box">

                            <?php 
                                $ny_stories = dbQuery($db, "SELECT * FROM ny_story WHERE checked = 1 ORDER BY likes DESC");
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


                            <?php endforeach; ?>

                        </div><!--     /msg-block__msg-box-->

                    </div> <!-- /msg-block-->



















                </div><!-- /col-12 col-md-6 -->

                <div class="col-12 col-md-6">



















                <div class="msg-block">

                    <div class="msg-block__title">Желания других участников</div>

                    <div class="msg-block__msg-box">

<?php 
    $wishes = dbQuery($db, "SELECT * FROM wish WHERE checked = 1 ORDER BY likes DESC");
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












                </div><!-- /col-12 col-md-6 -->

            </div><!-- <div class="row msg-results"> -->


            



    </div>









