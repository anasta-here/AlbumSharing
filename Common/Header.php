<!DOCTYPE html>
<?php     
    if(isset($_SESSION["user"])){
        $user = $_SESSION["user"];
    }
?>
<html lang="en" style="position: relative; min-height: 100%;">
<head>
	<title>Bee Yourself</title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.6/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="Common/css/Css.css">
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap');
        </style>

</head>

<body style="padding-top: 50px; margin-bottom: 60px;">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="padding: 10px" href="http://www.algonquincollege.com">
              <img src="Common/img/BeeYourself_Logo.png" 
                   alt="Bee Yourself Logo" style="max-width:100%; max-height:100%;"/>
          </a>    
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="Index.php">Home</a></li>
            <li><a href="MyFriends.php">My Friends</a></li>
            <li><a href="MyAlbums.php">My Albums</a></li>
            <li><a href="MyPictures.php">My Pictures</a></li>
            <li><a href="UploadPictures.php">Upload Pictures</a></li>
            <?php global $user; print ($user) ? '<li><a href="Logout.php">Log Out</a></li>' : '<li><a href="Login.php">Log In</a></li>';?>            
          </ul>
        </div>
      </div>  
    </nav>
