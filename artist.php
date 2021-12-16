<?php 

include("includes/includedFiles.php");
$userArtist = $_GET["userLoggedIn"];
$artist = new Artist($con, $userArtist);
$mostRecentRelease = new Song($con, $artist->mostRecentReleaseID());
$mostPlayedRelease = new Song($con, $artist->mostPlayedReleaseID());
?>
<h1 class="pageHeadingBig">Summary</h1>

<style rel="stylesheet">  
    #mainViewContent {
        height: calc(100% - 90px);
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
    
    .gridViewContainer {
        width:75%;
        margin: 0 auto;
        padding-bottom: 100px;
    }
    span.target-info {
        font-weight: bold;
        color: #c69c6d;
    }
    p {
        color: #a0a0a0;
    }
/*
    hr, h2 {
        width: 75%;
    }
    #invisible-separator {
        background-color: transparent;
    }
    p {
        width: 75%;
        margin:0 auto;
    }
*/
</style>

<div class="gridViewContainer">
    <hr>
    <h2>Account</h2>
    <?php
    echo "<p>Artist Affiliation: <span class='target-info'>" . $artist->getArtistName() . "</span></p>";
    echo "<p>Number of Appearances: <span class='target-info'>" . $artist->getNumAppearances() . "</span></p>";
    ?>
    <hr id="invisible-separator">
    <h2>Highlights</h2>
    <?php
    echo "<p>Most recent release <span class='target-info'>" . $mostRecentRelease->getTitle() . "</span></p>";
    echo "<p>Most played release: <span class='target-info'>" . $mostPlayedRelease->getTitle() . "</span></p>";
    ?>
</div>
