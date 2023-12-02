function getPicturesByAlbumId(albumId) {
    document.getElementById('albumSelectionChange').click();
}

function highlightThumbnail(thumbnail) {
    var imageFileNameInput = document.getElementById('imageFileName');
    var fullPath = thumbnail.getAttribute('data-path');
    var filename = fullPath.replace(/^.*[\\\/]/, ''); // This extracts the filename from the path
    imageFileNameInput.value = filename;

    document.getElementById('thumbnailChange').click();   
}