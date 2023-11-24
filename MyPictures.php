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
<h1 class="center">My Pictures</h1>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <button type="submit" name="submitBtn" class="btn btn-primary">Add Comment</button> 
</form>
<br>
</div>
<?php include('./common/footer.php'); ?>