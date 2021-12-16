<?php 

include("includes/includedFiles.php");
?>
<h1 class="pageHeadingBig">Welcome Back <span style="color:#c69c6d"><?php echo $_GET["userLoggedIn"];?></span></h1>

<style rel="stylesheet">  
    #mainViewContent {
        height:calc(100% - 90px);
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
    hr {
        width:75%;
        background-color: #1a1a1a;
    }
    p.info-text {
        width:75%;
        margin: 0 auto;
    }
</style>

<div class="gridViewContainer">
    <hr>
    <p class="info-text">No new updates</p>
</div>

