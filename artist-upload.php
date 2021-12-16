<?php 
include("includes/includedFiles.php");


$userArtist = $_GET["userLoggedIn"];
$artist = new Artist($con, $userArtist);

?>
<h1 class="pageHeadingBig">Upload Song</h1>

<style rel="stylesheet">  
    #mainViewContent {
        height: calc(100% - 90px);
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
    
    input#myFile, input#myArtwork {
        background-color: #c69c6d;
        color: #FFF;
        padding: 10px;
    }
    
    input[type="submit"] {
        background-color: #2E3192;
        color: #FFF;
        border:none;
        padding: 10px;
    }
    input[type="text"] {
        background-color: transparent;
        color: #FFF;
        border:none;
        border-bottom: 2px solid #FFF;
        padding: 10px;
    }
    label {
        display: block;
        padding-bottom: 10px;
    }
    .fields {
        margin-bottom: 25px;
    }
    #result {
        color:#c69c6d;
        font-weight: bold;
    }
</style>

<div class="gridViewContainer">
    <form method="post" action="artist-upload.php" enctype="multipart/form-data">
        <p class='fields'>
            <label>Enter title </label>
            <input type="text" id="songTitle" name="songTitle" required>
        </p>
        
        <input type="hidden" id="userArtist" name="userArtist" value="<?php echo $userArtist?>">
        <div id="uploads">
        <p class='fields'>
            <label>Upload Artwork </label>
            <input type="file" id="myArtwork" name="artwork" placeholder="Upload artwork">
        </p>
        <p class='fields'>
            <label>Upload mp3 or wav file</label>
            <input type="file" id="myFile" name="filename" placeholder="Upload mp3 file">
            <input type="submit" value="SUBMIT">
        </p>
        </div>
        
    </form>
    <div id="result"></div>
    <script>
        $(document).ready(function(){
                
                searchResult=[];
                let submission;
                
                $("form").submit(function (event) {
                    
               var data = new FormData();
                jQuery.each(jQuery('#myFile')[0].files, function(i, file) {
                    data.append('music', file);
    
                });
                jQuery.each(jQuery('#myArtwork')[0].files, function(i, file) {
                    data.append("artwork", file);
   
                });
                data.append("userArtist", $("#userArtist").val());
                    data.append("title", $("#songTitle").val());
      
                jQuery.ajax({
                url: 'includes/handlers/song-upload-handler.php',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    
                    submission = data;
                    if(data){
                        $("#result").text("Success");
                        $("#songTitle").val("");
                        $("#myArtwork").val("");
                        $("#myFile").val("");
                    }
                    setTimeout(function(){
                        $("#result").text("");                       
                    },4000);
      
                }

                
                    
              });
            event.preventDefault();

            });
        });
    
    </script>
</div>

