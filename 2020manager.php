<?php 


define('BR', "<br>");

function deb($obj){
    echo BR . '<pre>' . print_r($obj, true) . '</pre>' . BR;
}

function el($str){

    echo $str . BR;
}

function prs(){
    echo "<pre>";
}
function pre(){
    echo "</pre>";
}


function connect()
{
    $pdo = new \PDO("sqlite:ny.db");
    return $pdo;
}


class DB{

    public $db;
    public $query;
    public $stmnt;
    public $result;
    public $stmntResult;
    public $fetchAllResult;
    public $fetchResult;
    private $stmnts = [];

    function __construct($db){
        
        $this->db = $db;
    }

    function prepare($query, $alias = null){

        $this->stmnt = $this->db->prepare($query);
        
        
        if(!$this->stmnt){
            
            die("Fail prepare " . "'" . $query . "'");        
            
        }

        if($alias){

            $this->stmnts[$alias] = $this->stmnt;
        }

        return $this;
    }


    function query($alias = null, $data = null){

        if($alias){

            $this->stmnt = $this->stmnts[$alias];
        }

        if(!$data){

            $this->stmntResult = $this->stmnt->execute();
        }
        else{

            if(is_array($data)){

                $this->stmntResult = $this->stmnt->execute($data);
            }
            else{
                $this->stmntResult = $this->stmnt->execute([$data]);   
            }
        }

        if(!$this->stmntResult){
            die("Fail execute query" . "'" . $query . "'");    
        }
        

        return $this;
    }


    function fetchAll($param = NULL){

        $this->fetchAllResult = $this->stmnt->fetchAll($param);

        return $this->fetchAllResult;
    }

    function fetch($param = NULL){

        $this->fetchResult = $this->stmnt->fetch($param);

        return $this->fetchResult;
    }

    function alias($alias){

        if($alias){

            $this->stmnts[$alias] = $this->stmnt;
        }
        else{

            die('No alias in ' . __FILE__ . __LINE__);
        }

    }
}


define('MESSAGE_UNPUBLISHED', 0);
define('MESSAGE_PUBLISHED', 1);
define('MESSAGE_DELETED', 2);


$db = new DB(new PDO("sqlite:ny.db"));

$db ->prepare('SELECT * FROM user', 'allFromUsers')
    ->query()
    ->fetchAll(); 

$db ->prepare('SELECT * FROM user ORDER BY id DESC', 'allFromUsersDesc')
    ->query()
    ->fetchAll(); 

$db->prepare('SELECT * FROM wish WHERE author_id = ?', 'wish');
$db->prepare('SELECT * FROM ny_story WHERE author_id = ?', 'ny_story');
    


$db->prepare('UPDATE ny_story SET checked = ? WHERE id = ?', 'ny_storyUpdate');
$db->prepare('UPDATE wish SET checked = ? WHERE id = ?', 'wishUpdate');


$db->prepare('UPDATE ny_story SET content = ? WHERE id = ?', 'ny_storyUpdateContent');
$db->prepare('UPDATE wish SET content = ? WHERE id = ?', 'wishUpdateContent');







if(isset($_REQUEST['delete'])){

    $from = $_REQUEST['from'];
    $id = $_REQUEST['id'];

    $db->query($from . 'Update', [MESSAGE_DELETED, $id]);

    
    echo 'delete ' . $id . ' from ' . $from;

    die($db->stmntResult);
    
}


if(isset($_REQUEST['publish'])){
    
    $publish = $_REQUEST['publish'];

    $from = $_REQUEST['from'];
    $id = $_REQUEST['id'];

    if($publish == MESSAGE_PUBLISHED){

        $db->query($from . 'Update', [MESSAGE_PUBLISHED, $id]);
        
    }
    else{
        
        $db->query($from . 'Update', [MESSAGE_UNPUBLISHED, $id]);

    }
    
    echo 'publish ' . $id . ' from ' . $from . 'status: ' . $publish ? 'MESSAGE_PUBLISHED' : 'MESSAGE_UNPUBLISHED';

    die($db->stmntResult);
}



if(isset($_REQUEST['update'])){
    
    $from = $_REQUEST['from'];
    $id = $_REQUEST['id'];
    $content = $_REQUEST['content'];
    
    
    $result = $db->query($from . 'UpdateContent', [$content, $id]);
    echo 'update ' . $id . ' from ' . $from . 'content' . $content;
    
    die($db->stmntResult);
}















?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Модерация</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo|Merriweather:900i|Montserrat|Neucha&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <style type="text/css">

    </style>
</head>


<body>
	<div class="container">
		<div class="row">
			
			<h2>Модерация</h2>
			
		</div>

		<div class="row">

<?php 

$users = $db->query('allFromUsersDesc')->fetchAll();
$db->prepare('SELECT checked FROM ny_story WHERE id = ?', 'ny_storyStatus');
$db->prepare('SELECT checked FROM wish WHERE id = ?', 'wishStatus');

?>

            <div class="col-12">
                
                <?php foreach ($users as $user) : ?>


                    <?php 


                        $ny_storyRow = $db->query( 'ny_story', [$user['id']] )->fetch();
                        $ny_storyArr = $db->query( 'ny_story', [$user['id']] )->fetchAll();


                        $wishRow = $db->query( 'wish', [$user['id']] )->fetch();
                        $wishArr = $db->query( 'wish', [$user['id']] )->fetchAll();

                   ?>

                <?php if($wishRow || $ny_storyRow) :?>

                <div class="row user-row">
                
                    <div class="col-3">
                        <div class="row">
                            <div class="col-12">
                                <span class = "user-row-title">id: </span><?= $user['id'] ?>
                            </div>
                            <div class="col-12">
                                <span class = "user-row-title"> Имя: </span><?= $user['name'] ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-3"><span class = "user-row-title">email: </span><?= $user['email'] ?></div>
                    <div class="col-3"><span class = "user-row-title">Елки: </span><?= $user['trees'] ?></div>

                    <?php if ($user['gifts'] == -1) : ?>
                    
                        <div class="col-12">

                            <span class = "user-row-title">Подарки: </span>
                            "Даже страшно об этом подумать!";

                        </div>

                    <?php else :?>

                        <div class="col-3">
                        
                            <span class = "user-row-title">Подарки: </span>                            
                            <?= $user['gifts']; ?>
                        
                        </div>

                    <?php endif; ?>

                    







                    <?php if( $ny_storyArr ) :?>

                    <div class="col-12">

                        <!-- <h5 class = "user-h">История:</h5> -->
                        <h5 class = "user-h">Историй: <?= count($ny_storyArr) ?> </h5>
                        
                        <?php foreach ($ny_storyArr as $ny_story) :?>

                            

                            
                        <?php 

                            $ny_storyStatus = (int) $db->query( 'ny_storyStatus', [$ny_story['id']] )->fetch()[0];

                        ?>


                        <?php if($ny_storyStatus !== MESSAGE_DELETED) :?>


                        <div class = "row user-message-content">

                            <div data-ny_story-id = "<?= $ny_story['id'] ?>" class = "content mod-content col-12">


                                <?php 
                                    
                                    echo $ny_story['content'];
                                
                                ?>


                            </div><!-- content -->

                            <div class="mod-wrap col-12">
                            
                            <?php
                            if($ny_storyStatus == MESSAGE_UNPUBLISHED){
                                    
                                $btnPublishClass = "btn-warning";
                                $btnPublishMessage = "НЕОПУБЛИКОВАНО / Опубликовать";
                                    
                            }
                            else{
                                
                                $btnPublishClass = "btn-success";
                                $btnPublishMessage = "ОПУБЛИКОВАНО / Распубликовать";

                            }; 

                            ?>
        
                                <a data-from = "ny_story" data-status = "<?= $ny_storyStatus ?>" data-id = "<?= $ny_story['id'] ?>" href="#" class = "btn mod-btn <?=  $btnPublishClass ?> mod-publish"><?= $btnPublishMessage ?></a> 
                                <a data-from = "ny_story" data-id = "<?= $ny_story['id'] ?>" href="#" class = "btn btn-info mod-btn mod-update">Редактировать</a> 
                                <a data-from = "ny_story" data-id = "<?= $ny_story['id'] ?>" href="#" class = "btn btn-danger mod-btn mod-delete">Удалить</a> 
                            </div>

                        </div><!-- row -->
                        
                        <?php endif; ?>

                        <?php endforeach; ?>

                    </div><!-- col-12 -->

                    <?php endif; ?>

















                    <?php if($wishArr) :?>

                    <div class="col-12">
                        
                        <h5 class = "user-h">Желаний: <?= count($wishArr) ?> </h5>

                    
                            <?php 
                            // echo($wishRow['content']) 
                            ?>
                    
                            <?php foreach ($wishArr as $wish) :?>


                                
                                
                            <?php 

                            $wishStatus = (int) $db->query( 'wishStatus', [$wish['id']] )->fetch()[0];

                            ?>




                            <?php if($wishStatus !== MESSAGE_DELETED) :?>


                            <div class = "row user-message-content">

                                <div data-wish-id = "<?= $wish['id'] ?>"  class = "content mod-content col-12">

                                        <?php 
                                                echo $wish['content'];
                                        ?>
                                    

                                </div><!-- content -->

                                <div class="mod-wrap col-12">

                                <?php 
                                
                                if($wishStatus == MESSAGE_UNPUBLISHED){
                                    
                                    $btnPublishClass = "btn-warning";
                                    $btnPublishMessage = "НЕОПУБЛИКОВАНО / Опубликовать";
                                }
                                else{
                                    
                                    $btnPublishClass = "btn-success";
                                    $btnPublishMessage = "ОПУБЛИКОВАНО / Распубликовать";

                                }

                                ?>
                                    <a data-from = "wish" data-status = "<?= $wishStatus?>" data-id = "<?= $wish['id'] ?>" href="#" class = "btn mod-btn <?=  $btnPublishClass ?> mod-publish"><?= $btnPublishMessage ?></a> 
                                    <a data-from = "wish" data-id = "<?= $wish['id'] ?>" href="#" class = "btn btn-info mod-btn mod-update">Редактировать</a> 
                                    <a data-from = "wish" data-id = "<?= $wish['id'] ?>" href="#" class = "btn btn-danger mod-btn mod-delete">Удалить</a> 
                                </div>

                            </div><!-- row -->

                            <?php endif; ?>


                            <?php endforeach; ?>
                            
                        </div><!-- col-12 -->

                    <?php endif; ?>
                    
                
                
                </div><!-- row user-row -->

                <?php endif; ?>

            <?php endforeach; ?>





            </div><!-- class="col-12 -->    
		</div>        <!-- row -->
	</div>    <!-- container -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="admin.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>