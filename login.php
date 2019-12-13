<?php
  if(!empty($_POST['paswd'])){
     $pass = "123654";
    if($_POST['paswd']==$pass){
      session_start();
      $_SESSION['access']=true;
      header("Location: moderator.php") ;
    }
    else {
       header("Location: login.php") ;
    }
  }
  else
  {
    ?>
    <form method="POST">
      <input type="text" name="paswd">
      <input type="submit">
    </form>
    <?php
  }
?>



