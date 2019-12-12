

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


<?php 



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

$db = connect();

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('BR', "<br>");





try {

    $dropTable = $db->exec("DROP TABLE IF EXISTS wish_status;");
    echo "Таблица wish_status успешно удалена!" . BR;

    $dropTable = $db->exec("DROP TABLE IF EXISTS ny_story_status;");
    echo "Таблица ny_story_status успешно удалена!" . BR;


}
catch(PDOException $e) {
    echo "Ошибка при удалении таблицы в базе данных: " . $e->getMessage();
}






$db->exec("

    CREATE TABLE IF NOT EXISTS wish_status(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        wish_id INTEGER UNIQUE,
        status INTEGER DEFAULT 0,
        FOREIGN KEY (wish_id) REFERENCES wish(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT EXISTS ny_story_status(

        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ny_story_id INTEGER UNIQUE,
        status INTEGER DEFAULT 0,
        FOREIGN KEY (ny_story_id) REFERENCES ny_story(id) ON DELETE CASCADE
    );
");


$ny_stories = $db->query("SELECT * FROM ny_story")->fetchAll();

$ny_story_status_stmnt = $db->query("

INSERT INTO ny_story_status (ny_story_id) VALUES (?)

");

foreach ($ny_stories as $ny_story) {
    
    $ny_story_status_stmnt->execute([$ny_story['id']]);
}



$wishes = $db->query("SELECT * FROM wish")->fetchAll();

$wish_status_stmnt = $db->query("

INSERT INTO wish_status (wish_id) VALUES (?)

");

foreach ($wishes as $wish) {
    
    $wish_status_stmnt->execute([$wish['id']]);
}

?>


</body>
</html>