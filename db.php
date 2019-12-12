<?php session_start();
$num = (isset($_SESSION['num'])) ? $_SESSION['num'] : 0;
$num++;
$_SESSION['num'] = $num;
echo "<h1>Вы тут уже $num-й раз!</h1>";

//проверим существует ли БД
//если БД нет то создадим её и таблицу в ней msages
//if(!file_exists("mytest.db")){
//    $db=new SQLiteDatabase("mytest.db");
//    $sql="CREATE TABLE msages(
//            id INTEGER PRIMARY KEY,
//            fname TEXT,
//            email TEXT,
//            msage TEXT,
//            datetime INTEGER,
//
//        )";
//    $db->query($sql);
//}else{
////если бд есть то просто подключ. к ней
//    $db=new SQLiteDatabase("mytest.db");
//}
function connect()
{
    $pdo = new \PDO("sqlite:ny.db");
    return $pdo;
}





$db = connect();

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('BR', "<br>");


try {

    $dropTable = $db->exec("DROP TABLE IF EXISTS user;");
    echo "Таблица user успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS ny_story;");
    echo "Таблица ny_story успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS user_like_ny_story;");
    echo "Таблица user_like_ny_story успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS wish;");
    echo "Таблица wish успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS user_like_wish;");
    echo "Таблица user_like_wish успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS comment;");
    echo "Таблица comment успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS user_like_comment;");
    echo "Таблица user_like_comment успешно удалена!" . BR;


}
catch(PDOException $e) {
    echo "Ошибка при удалении таблицы в базе данных: " . $e->getMessage();
}

// echo "<script>alert($dropTable);</script>";

$createTable = $db->exec("


    CREATE TABLE IF NOT EXISTS user(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT,
        step INTEGER DEFAULT 0,
        trees INTEGER DEFAULT 0,
        gifts INTEGER DEFAULT 0
    );

    CREATE TABLE IF NOT EXISTS ny_story(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        author_id INTEGER,
        likes INTEGER DEFAULT 0,
        checked INTEGER DEFAULT 0,
        content TEXT
    );


    CREATE TABLE IF NOT EXISTS user_like_ny_story(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        ny_story_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (ny_story_id) REFERENCES ny_story(id) ON DELETE CASCADE
    );



    CREATE TABLE IF NOT EXISTS wish(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        author_id INTEGER,
        likes INTEGER DEFAULT 0,
        checked INTEGER DEFAULT 0,        
        content TEXT
    );

    CREATE TABLE IF NOT EXISTS user_like_wish(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        wish_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (wish_id) REFERENCES wish(id) ON DELETE CASCADE
    );




    CREATE TABLE IF NOT EXISTS comment(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        author_id INTEGER,
        likes INTEGER DEFAULT 0,
        checked INTEGER DEFAULT 0,
        content TEXT
    );


    CREATE TABLE IF NOT EXISTS user_like_comment(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        comment_id INTEGER,
        FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
        FOREIGN KEY (comment_id) REFERENCES comment(id) ON DELETE CASCADE
    );


");

// echo $createTable;

$users = [
    [
        'name' => 'Иван',
        'email' => 'ivan@test.com',
        'step'=> 0,
        'trees'=> 1,
        'gifts'=> 3
    ],

    [
        'name' => 'Петр',
        'email' => 'petr@test.com',
        'step'=> 0,
        'trees'=> 2,
        'gifts'=> 3
    ],    
    
    [
        'name' => 'Сидор',
        'email' => 'sidor@test.com',
        'step'=> 0,
        'trees'=> 3,
        'gifts'=> 2
    ],        
];

$nyStories = [
    [
        'author_id' => 1,

        'content' => 'История Ивана. История Ивана. История Ивана. История Ивана. История Ивана. ' 
    ],
    [
        'author_id' => 2,
        'content' => 'История Петра. История Петра. История Петра. История Петра. История Петра. История Петра. '
    ],
    [
        'author_id' => 3,
        'content' => 'История Сидора. История Сидора. История Сидора. История Сидора. История Сидора. История Сидора. История Сидора. '
    ]
];

$wishes = [

    [
        'author_id' => 1,
        'content' => 'Желание Ивана. Желание Ивана. Желание Ивана. Желание Ивана. Желание Ивана. Желание Ивана. Желание Ивана. Желание Ивана. '
    ],
    [

        'author_id' => 2,
        'content' => 'Желание Петра. Желание Петра. Желание Петра. Желание Петра. Желание Петра. Желание Петра. Желание Петра. Желание Петра. '
    ],
    [

        'author_id' => 3,
        'content' => 'Желание Сидора. Желание Сидора. Желание Сидора. Желание Сидора. Желание Сидора. Желание Сидора. Желание Сидора. Желание Сидора. '
    ]
];

$comments = [
    [
        'author_id' => 1,
        'content' => 'Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана.  '
    ],
    [
        'author_id' => 1,
        'content' => 'Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана. Комментарий Ивана.  '
    ],
    [
        'author_id' => 2,
        'content' => 'Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. '
    ],
    [
        'author_id' => 2,
        'content' => 'Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. Комментарий Петра. '
    ],
    [
        'author_id' => 3,
        'content' => 'Комментарий Сидора. Комментарий Сидора. Комментарий Сидора. Комментарий Сидора. Комментарий Сидора. Комментарий Сидора. Комментарий Сидора. '
    ]
];

// user ==========================

$userInsert = $db->prepare('
    INSERT INTO user (name, email, step, trees, gifts)
    VALUES (:name, :email, :step, :trees, :gifts)
');

foreach ($users as $user) {
    
    echo '<pre>' . print_r($user, true) . '</pre>';

    $userInsert->execute([

        ':name' => $user['name'],
        ':email' => $user['email'],
        ':step' => $user['step'],
        ':trees' => $user['trees'],
        ':gifts' => $user['gifts'],
    ]);
}


// ny_story ==========================

$nyStoryInsert = $db->prepare('
    INSERT INTO ny_story (author_id, checked, content)
    VALUES (:author_id, :checked, :content)
');


foreach ($nyStories as $nyStory) {
    
    echo '<pre>' . print_r($nyStory, true) . '</pre>';

    $nyStoryInsert->execute([
        ':checked' => 1,
        ':author_id' => $nyStory['author_id'],
        ':content' => $nyStory['content'],
    ]);

}




// wish ==========================

$wishInsert = $db->prepare('
    INSERT INTO wish (author_id, checked, content)
    VALUES (:author_id, :checked, :content)
');


foreach ($wishes as $wish) {
    
    echo '<pre>' . print_r($wish, true) . '</pre>';

    $wishInsert->execute([
        ':checked' => 1,
        ':author_id' => $wish['author_id'],
        ':content' => $wish['content'],
    ]);

}



// comment ==========================

$commentInsert = $db->prepare('
    INSERT INTO comment (author_id, checked, content)
    VALUES (:author_id, :checked, :content)
');


foreach ($comments as $comment) {
    
    echo '<pre>' . print_r($comment, true) . '</pre>';

    echo $commentInsert->execute([
        ':checked' => 1,
        ':author_id' => $comment['author_id'],
        ':content' => $comment['content'],
    ]);

}


$userLikeNyStoryInsert = $db->prepare('
    INSERT INTO user_like_ny_story (user_id, ny_story_id)
    VALUES (:user_id, :ny_story_id)
');

$userLikeCommentInsert = $db->prepare('
    INSERT INTO user_like_comment (user_id, comment_id)
    VALUES (:user_id, :comment_id)
');


$userLikeWishInsert = $db->prepare('
    INSERT INTO user_like_wish (user_id, wish_id)
    VALUES (:user_id, :wish_id)
');

$userLikeNyStoryInsert->execute(['1', '1']);
$userLikeNyStoryInsert->execute(['1', '2']);
$userLikeNyStoryInsert->execute(['2', '2']);
$userLikeNyStoryInsert->execute(['2', '3']);
$userLikeNyStoryInsert->execute(['3', '1']);
$userLikeNyStoryInsert->execute(['3', '2']);



$userLikeCommentInsert->execute(['1', '1']);
$userLikeCommentInsert->execute(['1', '1']);
$userLikeCommentInsert->execute(['2', '1']);
$userLikeCommentInsert->execute(['2', '3']);
$userLikeCommentInsert->execute(['3', '1']);
$userLikeCommentInsert->execute(['3', '2']);


$userLikeWishInsert->execute(['1', '2']);
$userLikeWishInsert->execute(['1', '3']);
$userLikeWishInsert->execute(['2', '3']);
$userLikeWishInsert->execute(['2', '1']);
$userLikeWishInsert->execute(['3', '3']);
$userLikeWishInsert->execute(['3', '1']);



// user_like_ny_story user_like_comment user_like_wish












        // id INTEGER PRIMARY KEY,
        // user_id INTEGER,
        // ny_story_id

// 
// user_like_ny_story
// wish
// user_like_wish
// comment
// user_like_comment



    // name TEXT,
    // email TEXT,
    // step INTEGER,
    // trees INTEGER,
    // gifts INTEGER


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Year Database</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo|Merriweather:900i|Montserrat|Neucha&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>



    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="/main.js"></script>
</body>
</html>