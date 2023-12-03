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
<br>
<div class="row">
    <div class="col-xs-6">
        <span class="text-left text-warning"><strong>Friends:</strong></span>
    </div>
    <div class="col-xs-6">
        <span class="pull-right"><a href="AddFriend.php">Add Friends</a></span>
    </div>
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Shared Albums</th>
                <th>Defriend</th>
            </tr>
        </thead>    
        <tbody>
            <td></td>
            <td></td>
            <td></td>       
        </tbody>        
    </table>
    <button type="submit" name="defriendBtn" class="btn btn-primary">Defriend Selected</button> 
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-xs-6">
            <span class="text-left text-warning"><strong>Friend Requests:</strong></span>
        </div>
    </div>    
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Accept or Deny</th>
            </tr>
        </thead>    
        <tbody>
            <td></td>
            <td></td>      
        </tbody>        
    </table>     
    <button type="submit" name="acceptBtn" class="btn btn-primary">Accept Selected</button> 
    <button type="submit" name="denyBtn" class="btn btn-primary">Deny Selected</button> 
</form>
<br>
</div>
<?php include('./common/footer.php'); ?>