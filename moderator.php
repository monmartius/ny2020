
<?php 



function __header($url){

    $dirname = dirname($_SERVER['PHP_SELF']);
    // $dirname = str_replace(dirname($_SERVER['PHP_SELF']), "/", "\\" );
    
    if($dirname != ""){
    
        if ($dirname[strlen($dirname) - 1] == '\\') {
            
            $dirname = substr($dirname, 0, -1);
        }
    }
    
    if($dirname != ""){
        if ($dirname[strlen($dirname) - 1] == '/') {
            
            $dirname = substr($dirname, 0, -1);
        }
    }
    
    $url = "Location: http://" . $_SERVER['HTTP_HOST'] . $dirname . "/" . $url;

    return($url);
}


session_start();


if(!isset($_SESSION['access']) || $_SESSION['access'] != true){

	header(__header("login.php"));
}



if(isset($_REQUEST['logout'])){

    unset($_SESSION['logout']);
    unset($_SESSION['access']);
    unset($_SESSION['paswd']);
    header(__header("login.php"));
}

// deb($_REQUEST);

// die();

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

$db->prepare('SELECT count(*) FROM wish WHERE 1', 'wishAll');
$db->prepare('SELECT count(*) FROM wish WHERE checked = 1', 'wishPublished');
$db->prepare('SELECT count(*) FROM wish WHERE checked = 2', 'wishDeleted');
$db->prepare('SELECT count(*) FROM wish WHERE checked = 0', 'wishUnpublished');

$db->prepare('SELECT * FROM wish WHERE author_id = ?', 'wish');



$db->prepare('SELECT count(*) FROM ny_story WHERE 1', 'ny_storyAll');
$db->prepare('SELECT count(*) FROM ny_story WHERE checked = 1', 'ny_storyPublished');
$db->prepare('SELECT count(*) FROM ny_story WHERE checked = 2', 'ny_storyDeleted');
$db->prepare('SELECT count(*) FROM ny_story WHERE checked = 0', 'ny_storyUnpublished');

$db->prepare('SELECT * FROM ny_story WHERE author_id = ?', 'ny_story');
    


$db->prepare('UPDATE ny_story SET checked = ? WHERE id = ?', 'ny_storyUpdate');
$db->prepare('UPDATE wish SET checked = ? WHERE id = ?', 'wishUpdate');


$db->prepare('UPDATE ny_story SET content = ? WHERE id = ?', 'ny_storyUpdateContent');
$db->prepare('UPDATE wish SET content = ? WHERE id = ?', 'wishUpdateContent');





$db->prepare('SELECT count(*) FROM wish WHERE 1', 'wishAll');
$db->prepare('SELECT count(*) FROM wish WHERE checked = 1', 'wishPublished');
$db->prepare('SELECT count(*) FROM wish WHERE checked = 2', 'wishDeleted');
$db->prepare('SELECT count(*) FROM wish WHERE checked = 0', 'wishUnpublished');

$db->prepare('SELECT * FROM wish WHERE author_id = ?', 'wish');



$db->prepare('SELECT count(*) FROM ny_story WHERE 1', 'ny_storyAll');
$db->prepare('SELECT count(*) FROM ny_story WHERE checked = 1', 'ny_storyPublished');
$db->prepare('SELECT count(*) FROM ny_story WHERE checked = 2', 'ny_storyDeleted');
$db->prepare('SELECT count(*) FROM ny_story WHERE checked = 0', 'ny_storyUnpublished');

$db->prepare('SELECT * FROM ny_story WHERE author_id = ?', 'ny_story');
    


$db->prepare('SELECT count(*) FROM wish WHERE author_id = ?', 'wishUser');

$db->prepare('SELECT count(*) FROM wish 
                WHERE checked = 1 AND author_id = ?', 'wishUserPublished');

$db->prepare('SELECT count(*) FROM wish 
                WHERE checked = 2 AND author_id = ?', 'wishUserDeleted');

$db->prepare('SELECT count(*) FROM wish 
                WHERE checked = 0 AND author_id = ?', 'wishUserUnpublished');





$db->prepare('SELECT count(*) FROM ny_story 
                WHERE 1 AND author_id = ?', 'ny_storyUser');

$db->prepare('SELECT count(*) FROM ny_story 
                WHERE checked = 1 AND author_id = ?', 'ny_storyUserPublished');

$db->prepare('SELECT count(*) FROM ny_story 
                WHERE checked = 2 AND author_id = ?', 'ny_storyUserDeleted');

$db->prepare('SELECT count(*) FROM ny_story 
                WHERE checked = 0 AND author_id = ?', 'ny_storyUserUnpublished');










function statistic(){

	global $db;

	$ny_storyAll = $db->query('ny_storyAll')->fetch()[0];
	$ny_storyPublished = $db->query('ny_storyPublished')->fetch()[0];
	$ny_storyDeleted = $db->query('ny_storyDeleted')->fetch()[0];
	$ny_storyUnpublished = $db->query('ny_storyUnpublished')->fetch()[0];

	$wishAll =$db->query('wishAll')->fetch()[0];
	$wishPublished =$db->query('wishPublished')->fetch()[0];
	$wishDeleted =$db->query('wishDeleted')->fetch()[0];
	$wishUnpublished =$db->query('wishUnpublished')->fetch()[0];

	return 	$ny_storyAll . "," . 
			$ny_storyPublished  . "," . 
			$ny_storyDeleted . "," .
			$ny_storyUnpublished . "," .
			$wishAll  . "," .
			$wishPublished . "," .
			$wishDeleted . "," .
			$wishUnpublished;

}



if(isset($_REQUEST['delete'])){

    if(!isset($_SESSION['access']) || $_SESSION['access']!=true){

        die('Session is over.');
    }

    $from = $_REQUEST['from'];
    $id = $_REQUEST['id'];

    $db->query($from . 'Update', [MESSAGE_DELETED, $id]);

    
    // echo 'delete ' . $id . ' from ' . $from;

    die(statistic());
    
}


if(isset($_REQUEST['publish'])){



    if(!isset($_SESSION['access']) || $_SESSION['access']!=true){

        die('Session is over.');
    }


    
    $publish = $_REQUEST['publish'];

    $from = $_REQUEST['from'];
    $id = $_REQUEST['id'];

    if($publish == MESSAGE_PUBLISHED){

        $db->query($from . 'Update', [MESSAGE_PUBLISHED, $id]);
        
    }
    else{
        
        $db->query($from . 'Update', [MESSAGE_UNPUBLISHED, $id]);

    }
    
    // echo 'publish ' . $id . ' from ' . $from . 'status: ' . $publish ? 'MESSAGE_PUBLISHED' : 'MESSAGE_UNPUBLISHED';

    die(statistic());
}



if(isset($_REQUEST['update'])){


    if(!isset($_SESSION['access']) || $_SESSION['access']!=true){

        die('Session is over.');
    }
    
    $from = $_REQUEST['from'];
    $id = $_REQUEST['id'];
    $content = $_REQUEST['content'];
    
    
    $result = $db->query($from . 'UpdateContent', [$content, $id]);
    // echo 'update ' . $id . ' from ' . $from . 'content' . $content;
    
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
	<div class="container-fluid panel-info">
		<div class="row">
			<div class="container">
				<div class="row statistis">
			
					<div class="col-2"><span class="user-row-title">Историй </span></div>
					<div class="col-2"><span class="user-row-title">Всего: </span>

						<span class="ny_story-all">

						<?php 
							echo $db->query('ny_storyAll')->fetch()[0];
						?>
						
						</span>

					</div>
					<div class="col-2"><span class="user-row-title">Опубл.: </span>

						<span class="ny_story-published">
						
						<?php 
							echo $db->query('ny_storyPublished')->fetch()[0];
						?>
						
						</span>

					</div>
					<div class="col-2"><span class="user-row-title">Неопубл.: </span>
						
						<span class="ny_story-unpublished">

						<?php 
							echo ($db->query('ny_storyUnpublished')->fetch()[0]);
						?>
						
						</span>

					</div>
					<div class="col-2"><span class="user-row-title">Удаленных: </span>
						
						<span class="ny_story-deleted">

						<?php 
							echo ($db->query('ny_storyDeleted')->fetch()[0]);
						?>

						</span>

					</div>

				</div>
				<div class="row">
			
					<div class="col-2"><span class="user-row-title">Желаний </span>



					</div>
					<div class="col-2"><span class="user-row-title">Всего: </span>

						<span class="wish-all">

						<?php 
							echo $db->query('wishAll')->fetch()[0];
						?>

						</span>


					</div>
					<div class="col-2"><span class="user-row-title">Опубл.: </span>

						<span class="wish-published">
						
						<?php 
							echo $db->query('wishPublished')->fetch()[0];
						?>
						
						</span>

					</div>
					<div class="col-2"><span class="user-row-title">Неопубл.: </span>


						<span class="wish-unpublished">
						
						<?php 
							echo $db->query('wishUnpublished')->fetch()[0];
						?>
						
						</span>


					</div>
					<div class="col-2"><span class="user-row-title">Удаленных: </span>


						<span class="wish-deleted">
						
						<?php 
							echo $db->query('wishDeleted')->fetch()[0];
						?>
						
						</span>



					</div>

                    <div class="col-2">
                        <a href="?logout" class="btn btn-warning btn-exit">Выход</a>
                    </div>


				</div>

				
			</div>
		</div>

	</div>

	<div class="container">

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


                        $ny_storyUser = $db->query('ny_storyUser', $user['id'])->fetch()[0];
                        $ny_storyUserUnpublished = $db->query('ny_storyUserUnpublished', $user['id'])->fetch()[0];
                        $ny_storyUserPublished = $db->query('ny_storyUserPublished', $user['id'])->fetch()[0];
                        $ny_storyUserDeleted = $db->query('ny_storyUserDeleted', $user['id'])->fetch()[0];

                        $wishUser = $db->query('wishUser', $user['id'])->fetch()[0];
                        $wishUserUnpublished = $db->query('wishUserUnpublished', $user['id'])->fetch()[0];
                        $wishUserPublished = $db->query('wishUserPublished', $user['id'])->fetch()[0];
                        $wishUserDeleted = $db->query('wishUserDeleted', $user['id'])->fetch()[0];


                        // echo 
                        //     ' $ny_storyUser =' . $ny_storyUser . BR .
                        //     ' $ny_storyUserUnpublished ' . $ny_storyUserUnpublished . BR .
                        //     ' $ny_storyUserPublished ' . $ny_storyUserPublished . BR .
                        //     ' $ny_storyUserDeleted ' . $ny_storyUserDeleted . BR .

                        //     ' $wishUser ' . $wishUser . BR .
                        //     ' $wishUserUnpublished ' . $wishUserUnpublished . BR .
                        //     ' $wishUserPublished ' . $wishUserPublished . BR .
                        //     ' $wishUserDeleted ' . $wishUserDeleted . BR .
                        //     '--------------------------------'  . BR 
                        // ;


                   ?>



                <?php if(
                            ( $wishRow || $ny_storyRow ) 
                            && 
                            ( 
                                ( ( $ny_storyUserUnpublished > 0 ) || ( $ny_storyUserPublished > 0 ) )
                                || 
                                ( ( $wishUserUnpublished > 0 ) || ( $wishUserPublished > 0 )  ) 
                            ) 
                        ) 
                        :?>

                
<!-- ==================================================== -->


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

                    







                    <?php if( $ny_storyArr &&  ( ( $ny_storyUserUnpublished > 0 ) || ( $ny_storyUserPublished > 0 ) ) ) :?>

                    <div class="col-12">

                        <!-- <h5 class = "user-h">История:</h5> -->
                        <h5 class = "user-h">Историй: <?= $ny_storyUserUnpublished + $ny_storyUserPublished ?> </h5>
                        
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
                        
<!-- ==================================================== -->





                        <?php endif; ?>




                        <?php endforeach; ?>



                    </div><!-- col-12 -->

                    <?php endif; ?>

















                    <?php if( $wishArr && ( ( $wishUserUnpublished > 0 ) || ( $wishUserPublished > 0 )  ) ) :?>

                    <div class="col-12">
                        
                        <h5 class = "user-h">Желаний: <?= $wishUserPublished + $wishUserUnpublished ?> </h5>

                    
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