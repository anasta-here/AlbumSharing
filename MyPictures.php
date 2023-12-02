<?php
include_once 'EntityClassLib.php';
include_once('Functions.php');
session_start();
//check whether the user is logged in
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
} else {
    header("Location: Login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    extract($_POST);
    if (isset($_POST["albumChangeBtn"])) {
        if ($albumId != -1) {
            $_SESSION["albumId"] = $albumId;
        } else {
            $_SESSION["albumId"] = '';
        }
        unset($_SESSION['fileName']);
        unset($_SESSION["selectedPicture"]);
        unset($_SESSION["comments"]);
    }
    if (isset($_POST['thumbnailChangeBtn'])) {
        $fileName = $_POST['selectedImageFileName'];
        $_SESSION['fileName'] = $fileName;

        $selectedPicture = getPictureByFileName('./originals/' . $fileName);
        $_SESSION["selectedPicture"] = $selectedPicture;

        $comments = getAllCommentsForSelectedPictureOnMyPicturePage($selectedPicture->getPictureId());
        $_SESSION['comments'] = $comments;
    }

    if (isset($_POST['commentBtn'])) {
        $selectedPicture = $_SESSION["selectedPicture"];
        addCommentOnMyPicturePage($user->getUserId(), $selectedPicture->getPictureId(), $_POST['commentText']);
        $comments = getAllCommentsForSelectedPictureOnMyPicturePage($selectedPicture->getPictureId());
        $_SESSION['comments'] = $comments;
    }
}


include("./common/header.php");
?>
<div class="container">
    <br>
    <h1 class="text-center">My Pictures</h1>
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="albumForm">
        <div class="row form-group">
            <div class="col-md-7">
                <select class="form-control" name="albumId" onchange="AlbumSelected()">
                    <?php
                    $albums = getAlbums($user->getUserId());
                    $selectedAlbumId = isset($_SESSION['albumId']) ? $_SESSION['albumId'] : -1;
                    echo '<option value="-1" ' . ($selectedAlbumId == -1 ? 'selected' : '') . '>Select any album...</option>';
                    for ($i = 0; $i < count($albums); $i++) {
                        echo '<option value="' . $albums[$i]->getAlbumId() . '" ' . ($albums[$i]->getAlbumId() == $selectedAlbumId ? 'selected' : '') . '>'
                        . $albums[$i]->getTitle() . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-7">
                <?php
                //global $fileName;

                if (isset($_SESSION['fileName']) && isset($_SESSION["selectedPicture"])) {
                    $selectedPircture = $_SESSION["selectedPicture"];
                    $selectedPirctureTitle = $selectedPircture->getTitle();
                    echo "<h4 class=\"text-center\">$selectedPirctureTitle</h4>";
                    echo '<img class="img-responsive" src="./images/' . $_SESSION['fileName'] . '">';
                }
                ?>
                <br>
                <div class="thumbnail-bar">
                    <div class="thumbnails-container">
                        <?php
                        if (isset($_SESSION["albumId"])) {
                            $pictures = getAllPicturessByAlbumId($_SESSION["albumId"]);
                            if (isset($_SESSION["selectedPicture"])){
                                $selectedPircture = $_SESSION["selectedPicture"];
                                $selectedPirctureFileName = $selectedPircture->getFileName();                           
                            }
                            foreach ($pictures as $index => $picture) {
                                $originalPath = $picture->getFileName();
                                $thumbnailsPath = preg_replace('/^\.\/originals\//', './thumbnails/', $originalPath);
                                // Check if the current picture is the selected one
                                $thumbnailClass = ($originalPath == $selectedPirctureFileName) ? 'thumbnail clicked' : 'thumbnail';                            
                                echo "<div class='$thumbnailClass' data-index='$index' data-path='$thumbnailsPath' onclick='highlightThumbnail(this)'>"
                                . "<img src='$thumbnailsPath'>"
                                . "</div>";
                            }
                        }
                        ?>            
                    </div>
                </div>
                <input type="text" name="selectedImageFileName" id="imageFileName" hidden/>
            </div>

            <div class="col-md-5">   
                <?php
                if (isset($_SESSION["selectedPicture"])) {
                    $selectedPicture = $_SESSION["selectedPicture"];
                    $selectedPirctureDescription = $selectedPicture->getDescription();
                    if(!empty($selectedPirctureDescription)){
                        echo '<label class="col-form-label">Description:</label>';
                        echo "<p>$selectedPirctureDescription</p>";
                    }
                    echo '<label class="col-form-label"> Comments:</label>';
                    if (isset($_SESSION['comments']) && is_array($_SESSION['comments'])) {
                        $comments = $_SESSION['comments'];

                        for ($i = count($comments) - 1; $i >= 0; $i--) {
                            echo '<p>';
                            echo '<span class="text-primary">' . $comments[$i]->getUserName() . '</span>' . ': ';
                            echo $comments[$i]->getCommentText();
                            echo '</p>';
                        }
                    }    
                    echo '<textarea name="commentText" class="form-control" placeholder="Leave a comment..."></textarea><br>';
                    echo '<button type="submit" name="commentBtn" class="btn btn-primary">Add comment</button>';
                }
                ?>
                <button type="submit" name="albumChangeBtn" id="albumSelectionChange" hidden></button>
                <button type="submit" name="thumbnailChangeBtn" id="thumbnailChange" hidden></button>     
            </div>
        </div>
    </form>
</div>

<?php include('./common/footer.php'); ?>