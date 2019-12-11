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

    function prepare($query){

        $this->stmnt = $this->db->prepare($query);
        
        deb ($this->stmnt);

        if(!$this->stmnt){

            die("Fail prepare " . "'" . $query . "'");
        }

        return $this;
    }


    function query($query = NULL, $data = NULL){


        if($query){

            $this->stmnt = $this->stmnts[$query];
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
            die("Fail exute query" . "'" . $query . "'");    
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
        
        $this->stmnts[$alias] = $this->stmnt;
        
        return $this;
    }

}





$db = new DB(new PDO("sqlite:ny.db"));

$db ->prepare('SELECT * FROM user WHERE 1')
    ->alias('users')
    ->query()
    ->fetchAll(); 

$db ->prepare('SELECT content FROM comment WHERE ?')
    ->alias('comment'); 

$comment = $db->query('comment', $user['id'])->fetch();




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
        body pre{
            color: #fff;
        }

        .user-table{
            border: 1px solid #000;
            padding: 3px;
        }

        .user-table tr{
            border: 1px solid #000;
            padding: 3px;
        }
        .user-table td{
            border: 1px solid #000;
            padding: 3px;
        }

    </style>
</head>
<body>
	<div class="container">
		<div class="row">
			
			<h2>Модерация</h2>
			
		</div>

		<div class="row">

<table class="user-table">

<tr>
    <td>id</td><td>name</td><td>email</td><td>Комментарий</td> 
</tr>        
    


<?php foreach ($users as $user) : ?>
<?php 

    
?>

<tr>
    <td>
        <?= $user['id'] ?>
    </td>

    <td>
        <?= $user['name'] ?>
    </td>

    <td>
        <?= $user['email'] ?>
    </td>


    <td>
        <?php 
            $comment = $db->query('userComment',[$user['id']])->fetch()[0];
            if($comment){
                print_r($comment);
            }
            else{
                echo "пусто";
            }
        ?>
    </td>

</tr>    
    

<?php endforeach; ?>

</table>        
			
		</div>
	</div>
</body>
</html>