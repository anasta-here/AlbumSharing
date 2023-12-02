<?php 
    session_start();
    
    if(isset($_SESSION["user"])){
        $user = $_SESSION["user"];
    }
   
    include("./common/header.php"); 
?>
<div class="container">
<br>
<h1>Welcome to Algonquin Album Sharing Website</h1>
<br>
<?php 
    if (!$user){
        print "<p>If you have never used this before, you have to <a href='NewUser.php'>sign up</a> first.</p>";
        print "<p>If you have already signed up, you can <a href='Login.php'>log in</a> now.</p>";
    } else {
        print "You're already logged in.";
    }
?>
</div>
<?php include('./common/footer.php'); ?>