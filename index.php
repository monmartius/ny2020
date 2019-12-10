<?php 


// Примеры запросов Sqlite с PDO
// http://adatum.ru/primery-zaprosov-sqlite-s-pdo.html
//http://phpfaq.ru/pdo

define('BR', "<br>");

function deb($obj){
    echo BR . '<pre>' . print_r($obj, true) . '</pre>' . BR;
}

function el($str){

    echo $str . BR;
}

function connect()
{
    $pdo = new \PDO("sqlite:ny.db");
    return $pdo;
}

$db = new \PDO("sqlite:ny.db");




$getUser = $db->prepare('SELECT * FROM user WHERE id = ?');
$addUser = $db->prepare('
    INSERT INTO user (name, email, step, trees, gifts)
    VALUES (?, ?, ?, ?, ?);
');

dbQuery($db, 
    '
    UPDATE ny_story
    SET likes = 
    (
        SELECT count(*) FROM user_like_ny_story WHERE ny_story_id = ny_story.id
    );
    '
);

dbQuery($db, 
    '
    UPDATE comment
    SET likes = 
    (
        SELECT count(*) FROM user_like_comment WHERE comment_id = comment.id
    );
    '
);

dbQuery($db, 
    '
    UPDATE wish
    SET likes = 
    (
        SELECT count(*) FROM user_like_wish WHERE wish_id = wish.id
    );
    '
);

function dbQuery($db, $query, $data = NULL){

    $stmnt = $db->prepare($query);


    try{
        if($data){

            if(is_array($data)){

                $stmnt->execute($data);
            }
            else{
                $stmnt->execute([$data]);
            }

        }
        else {

            $stmnt->execute();
        }
    }
    catch(Exception $e){

        deb($e);
    }

    return $stmnt;
}




// $addNyStory = $db->prepare('
//     INSERT INTO ny_story (name, email, step, trees, gifts)
//     VALUES (?, ?, ?, ?, ?);
// ');



session_start();

// $user_id = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0;






If(isset($_REQUEST['reload'])){

    setcookie("user_id", "", 1);

    unset($_SESSION['user_id']);
    $step = 0;


    die();


}









if( isset($_SESSION['user_id']) ){

    $user_id = $_SESSION['user_id'];

    // deb($_SESSION);
    
    $getUser->execute([$user_id]);

    $user = $getUser->fetch(PDO::FETCH_LAZY);



    if(!$user){

        $addUser->execute(['', '', 0, 0, 0]);

        $user_id = $db->lastInsertId();

        setcookie( 'user_id', $user_id, time()+60*60*24*30);
        
        $_SESSION['user_id'] = $user_id;

        $getUser->execute([$user_id]);

        $user = $getUser->fetch(PDO::FETCH_LAZY);

        // $ttt = '<div style="font-size: 60px">'. $user_id . '</div>';


    // $user1 = 1;

    // $stories = dbQuery($db, "SELECT * FROM ny_story WHERE checked = 1 and author_id = $user1");

    // // $story = $stories->fetch(PDO::FETCH_LAZY);
    // $story = $stories->fetchAll();
    }



}
else{

    
    $addUser->execute(['', '', 0, 0, 0]);

    $user_id = $db->lastInsertId();

    setcookie( 'user_id', $user_id, time()+60*60*24*30);
    
    $_SESSION['user_id'] = $user_id;

    $getUser->execute([$user_id]);

    $user = $getUser->fetch(PDO::FETCH_LAZY);
}

$step = $user['step'];


if( isset($_REQUEST['commentlike']) ){

    $comment_id = $_REQUEST['commentlike'];

    $likedByThisUser = dbQuery($db, 
        "SELECT * FROM user_like_comment 
        WHERE comment_id = $comment_id 
        and user_id = {$user['id']};"
    );

    $likedByThisUser = (bool)$likedByThisUser->fetch();

    if($likedByThisUser){

        $res = dbQuery($db, 
            "
            DELETE FROM user_like_comment 
            WHERE comment_id = $comment_id 
            and user_id = {$user['id']};
            "
        );
    }
    else{
        $res = dbQuery($db, 
            "
            INSERT INTO user_like_comment(user_id, comment_id)
            VALUES ({$user['id']}, $comment_id);
            "
        );
    }


    dbQuery($db, 
        '
        UPDATE comment
        SET likes = 
        (
            SELECT count(*) FROM user_like_comment WHERE comment_id = ?
        );
        ',
        $comment_id
    );


    $likes = dbQuery($db, 
        'SELECT likes FROM comment WHERE id = ?',
        $comment_id
    );

    $likes = $likes->fetch()[0];

    echo $likes;

    die();
}






if( isset($_REQUEST['ny_storylike']) ){

    $ny_story_id = $_REQUEST['ny_storylike'];

    $likedByThisUser = dbQuery($db, 
        "SELECT * FROM user_like_ny_story 
        WHERE ny_story_id = $ny_story_id 
        and user_id = {$user['id']};"
    );

    $likedByThisUser = (bool)$likedByThisUser->fetch();

    if($likedByThisUser){

        $res = dbQuery($db, 
            "
            DELETE FROM user_like_ny_story
            WHERE ny_story_id = $ny_story_id
            and user_id = {$user['id']};
            "
        );
    }
    else{
        $res = dbQuery($db, 
            "
            INSERT INTO user_like_ny_story (user_id, ny_story_id)
            VALUES ({$user['id']}, $ny_story_id);
            "
        );
    }


    dbQuery($db, 
        '
        UPDATE ny_story
        SET likes = 
        (
            SELECT count(*) FROM user_like_ny_story WHERE ny_story_id = ?
        );
        ',
        $ny_story_id
    );


    $likes = dbQuery($db, 
        'SELECT likes FROM ny_story WHERE id = ?',
        $ny_story_id
    );

    $likes = $likes->fetch()[0];

    echo $likes;

    die();
}







if( isset($_REQUEST['wishlike']) ){

    $wish_id = $_REQUEST['wishlike'];

    $likedByThisUser = dbQuery($db, 
        "SELECT * FROM user_like_wish
        WHERE wish_id = $wish_id 
        and user_id = {$user['id']};"
    );

    $likedByThisUser = (bool)$likedByThisUser->fetch();

    if($likedByThisUser){

        $res = dbQuery($db, 
            "
            DELETE FROM user_like_wish
            WHERE wish_id = $wish_id
            and user_id = {$user['id']};
            "
        );
    }
    else{
        $res = dbQuery($db, 
            "
            INSERT INTO user_like_wish (user_id, wish_id)
            VALUES ({$user['id']}, $wish_id);
            "
        );
    }


    dbQuery($db, 
        '
        UPDATE wish
        SET likes = 
        (
            SELECT count(*) FROM user_like_wish WHERE wish_id = ?
        );
        ',
        $wish_id
    );


    $likes = dbQuery($db, 
        'SELECT likes FROM wish WHERE id = ?',
        $wish_id
    );

    $likes = $likes->fetch()[0];

    echo $likes;

    die();
}








if( isset($_REQUEST['trees']) ){

    $trees = $_REQUEST['trees'];



    dbQuery($db, 'UPDATE user SET trees = ? WHERE id = ?;', [$trees, $user_id]);

    echo "user_id = $user_id trees = $trees";

    die();
}



// print_r($_REQUEST);
    // die();


if( isset($_REQUEST['comment']) ){


    $comment = $_REQUEST['comment'];

    if(!$user['name']){

        $username = $_REQUEST['username'];

        if($username){

            dbQuery($db, 
                'UPDATE user SET name= ? WHERE id = ?', 
                [$username, $user_id]);
        }
    }



    dbQuery($db, 
        'INSERT INTO comment (author_id, checked, content)
        VALUES (?, ?, ?)', 
        [$user_id, 0, $comment]);

        dbQuery($db, 
            'UPDATE user SET step = ? WHERE id = ?', 
            [1, $user_id]);

        // die();

}


if( isset($_REQUEST['ny_story']) ){

    $ny_story = $_REQUEST['ny_story'];

    if(!$user['name']){

        $username = $_REQUEST['username'];

        if($username){

            dbQuery($db, 
                'UPDATE user SET name= ? WHERE id = ?', 
                [$username, $user_id]);
        }
    }



    dbQuery($db, 
        'INSERT INTO ny_story (author_id, checked, content)
        VALUES (?, ?, ?)', 
        [$user_id, 0, $ny_story]);

        dbQuery($db, 
            'UPDATE user SET step = ? WHERE id = ?', 
            [3, $user_id]);

}



if( isset($_REQUEST['wish']) ){

    $wish = $_REQUEST['wish'];

    if(!$user['name']){

        $username = $_REQUEST['username'];

        if($username){

            dbQuery($db, 
                'UPDATE user SET name= ? WHERE id = ?', 
                [$username, $user_id]);
        }
    }



    dbQuery($db, 
        'INSERT INTO wish (author_id, checked, content)
        VALUES (?, ?, ?)', 
        [$user_id, 0, $wish]);

        dbQuery($db, 
            'UPDATE user SET step = ? WHERE id = ?', 
            [4, $user_id]);

}


If(isset($_REQUEST['gifts'])){

    $gifts = $_REQUEST['gifts'];

    dbQuery($db, 
        'UPDATE user SET gifts = ? WHERE id = ?', 
        [$gifts, $user_id]);

        dbQuery($db, 
            'UPDATE user SET step = ? WHERE id = ?', 
            [2, $user_id]);

}



If(isset($_REQUEST['email'])){

    $email = $_REQUEST['email'];

    dbQuery($db, 
        'UPDATE user SET email = ? WHERE id = ?', 
        [$email, $user_id]);


    If(isset($_REQUEST['username'])){

        $username = $_REQUEST['username'];

        dbQuery($db, 
            'UPDATE user SET name = ? WHERE id = ?', 
            [$username, $user_id]);
    }    

}








If(isset($_REQUEST['step'])){

// print_r($_REQUEST);

    $step = $_REQUEST['step'];
    // echo $step;

    dbQuery($db,         'UPDATE user SET step = ? WHERE id = ?', [$step, $user_id]);

    // $q = $db->prepare('UPDATE user SET step = ? WHERE id = ?');
    // $q->execute([$step, $user_id])

    dbQuery($db, 
        "UPDATE user SET step = $step WHERE id = $user_id");



    // deb(dbQuery($db, 
    //     "SELECT * FROM user WHERE id = 6")->fetch());

    
}
else{
    $step = dbQuery($db, 'SELECT step FROM user WHERE id = ?', [$user['id']]);
    $step = $step->fetch()[0];
}




?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тест готовности к Новому году</title>

    
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo|Merriweather:900i|Montserrat|Neucha&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<a id="top"></a>

<div class = "d-none" 
    data-user_id = "<?= $user['id'] ?>"
    data-username = "<?= $user['name'] ?>"
    data-step = "<?= $user['step'] ?>">
    <?php deb($ss) ?></div>
            <div class="ny-header">
                <div class="container">
                        <div class="row">
                            <div class="ny-header-picture col-6 col-sm-4 col-lg-3">
                                <a href="#" class = "reset"><img src="images/ny2020.png" alt="" class="ny-header-picture__img"></a>
                            </div>

                            <div class="ny-header__slogan col-sm-5">
                                Пришло время этим&nbsp;воспользоваться!
                            </div>


                            <div class="ny-header-logo col-4 col-sm-3 col-lg-2">
                                <a href="#" class = "reload"><img src="images/LOGOSTICK.png" alt="" class="ny-header-logo__img"></a>
                            </div>



                        </div>
                    </div>
           
            </div><!--ny-header-->


<div class="slide">


<?php 


    include "step" . $step . ".php"; 
    // include "step" . 3 . ".php"; 
?>
            


</div> <!--/slide-->
<a href="#top" class = "top d-none"><button class="b1">1</button></a>
<div class="snowContainer">
    
    <div id="snow"></div>
    
</div>

<div class="landscape">
    <img src="images/winter-landscape.png">
    <!-- <img src="images/Laeacco-Moon.png"> -->
</div>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="js/jquery.nicescroll.js"></script>
    <script src="main.js"></script>
</body>
</html>