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
    
    unset($_SESSION['fileName']);
    unset($_SESSION["selectedPicture"]);
    unset($_SESSION["comments"]);
    unset($_SESSION["albumId"]);
    
    
    $accessibilities = getAccessibilities();
    $albums = getMyOwnAlbums($user->getUserId());
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $singleAlbumId = $_POST["singleAlbumId"]; 
        $albumIds = $_POST["albumIds"]; 
        $accessibilityCodes = $_POST["accessibility"];  
      
        //redirect the page to MyPictures.php with the selecte album
        if(isset($_POST["redirectBtn"])){  
            $_SESSION["albumId"] = $singleAlbumId;  
            header("Location: MyPictures.php");
            exit();     
        }        
        //delete the album with the corresponding Id and update all albums
        if(isset($_POST["deleteBtn"])){    
            deleteAlbum($singleAlbumId);
            $albums = getMyOwnAlbums($user->getUserId());            
        }
        //save accessibility change to the albums
        if(isset($_POST["saveBtn"])){ 
            for ($i = 0; $i < count($albums); $i++) {
                updateAlbum($accessibilityCodes[$i], $albumIds[$i]); 
            }                      
            $albums = getMyOwnAlbums($user->getUserId());                           
       }
    }      
    
    include("./common/header.php"); 
?>
<div class="container">
<br>
<h1 class="center">My Albums</h1>
<br>
<p>Welcome <strong><?php echo $user->getName(); ?></strong>! (not you? change user <a href="Logout.php">here</a>)</p>
<div class="text-right"><a href="AddAlbum.php">Create a New Album</a></div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Number of Pictures</th>
                <th>Accessibility</th>
                <th></th>
                <th></th>
            </tr>
        </thead>    
        <tbody>
          <?php
                for ($i = 0; $i < count($albums); $i++) {
                    echo '<tr>';
                    echo '<td><a href="javascript:void(0);" onclick="redirectAlbum('.$albums[$i]->getAlbumId().')">'.$albums[$i]->getTitle().'</a></td>';
                    echo '<td>'.getPictureNumByAlbumId($albums[$i]->getAlbumId()).'</td>';
                    echo '<td><select class="form-control" name="accessibility[]" onchange="updateAlbum('.$i.','.$albums[$i]->getAlbumId().')">'; //pass index and albumId as two parameters to the function
                    foreach($accessibilities as $a){
                        echo '<option value="'.$a->getCode().'"'.($albums[$i]->getAccessibilityCode() == $a->getCode() ? 'selected': '').'>'.$a->getDescription().'</option>'; //display the preferred accessibility option stored in the database as selected
                    }                        
                    echo '</select></td>';                
                    echo '<td><input type="hidden" name="albumIds[]" class="selectedAlbumId"></td>';
                    echo '<td><a href="javascript:void(0);" onclick="confirmDelete('.$albums[$i]->getAlbumId().')">Delete</a></td>'; //pass index and albumId as two parameters to the function
                    echo '</tr>';                      
                }   
          ?>                      
        </tbody>
    </table>
    <input type="hidden" name="singleAlbumId" id="singleAlbumId">
    <button type="submit" name="redirectBtn" id="redirectBtn" hidden>Redirect Album</button>
    <button type="submit" name="deleteBtn" id="deleteBtn" hidden>Delete</button>
    <button type="submit" name="saveBtn" class="btn btn-primary">Save Changes</button> 
</form>
<br>
</div>
<?php include('./common/footer.php'); ?>

<script type="text/javascript">
    const selectedAlbumIds = document.querySelectorAll(".selectedAlbumId");
    const singleAlbumId = document.getElementById("singleAlbumId"); 
    const deleteBtn = document.getElementById("deleteBtn"); 
    const redirectBtn = document.getElementById("redirectBtn"); 
    function updateAlbum(index, albumId) {
        for (let i = 0; i < selectedAlbumIds.length; i++) {
            if (i === index){
                selectedAlbumIds[i].value = albumId;
            }     
        }
    }  
    function redirectAlbum(albumId) {
        singleAlbumId.value = albumId;
        redirectBtn.click();
        return false;
    }   
    function confirmDelete( albumId) {
        if (confirm("This album will be deleted!") === true) {
            singleAlbumId.value = albumId;
            deleteBtn.click();
        }
        return false;
    }    
</script>