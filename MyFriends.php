<?php 
    include_once 'EntityClassLib.php';
    include_once('Functions.php');
    session_start();
    //check whether the user is logged in
    if(isset($_SESSION["user"])){
        $user = $_SESSION["user"];
    } else {
        header("Location: Login.php");
        exit();           
    }
      

    
    include("./common/header.php");  
?>
<div class="container">
<br>
<h1 class="center">My Friends</h1>
<br>
<p>Welcome <strong><?php echo $user->getName(); ?></strong>! (not you? change user <a href="Logout.php">here</a>)</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <button type="submit" name="submitBtn" class="btn btn-primary">Defriend Selected</button> 
</form>
<br>
</div>
<?php include('./common/footer.php'); ?>