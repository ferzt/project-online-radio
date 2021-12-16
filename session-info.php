<?php 

include("includes/includedFiles.php");

$user = new User($con,$_GET["userLoggedIn"]);
$userID = $user->getUserId();
?>
<h1 class="pageHeadingBig">Studio Sessions</h1>

<style rel="stylesheet">  
    #mainViewContent {
        height: calc(100% - 90px);
        background-image: linear-gradient(to bottom  left, #2E3192, #1a1a1a, #1a1a1a, black, black);
    }
    
    .heading-info {
        box-sizing: border-box;
        border-bottom: 2px double #FFF;
        padding: 5px;
    }
    
    .heading-info p{
        color: #c69c6d;
        font-weight: bold;
    }
    
    .gridViewContainer {
        padding-bottom: 100px;
    }
    
    .apt-date, .studio-engineer, .track-title {
        width:20%;
    }
    
    .session-info {
        width: 40%;
    }
    
    #heading-appointments, #all-appointments {
        border-left: 5px solid #c69c6d;
        padding-left: 10px;
    }
    a#download {
        text-decoration: underline;
    }
    a#download:hover {
        color: #c69c6d;
    }
    
</style>

<div class="gridViewContainer">
    <div id="heading-appointments">
        <div class="heading-info queueItemInfo">
            <p class='apt-date' id="date-section">Date</p>
            <p class="studio-engineer" id="eng-section">Engineer</p>
            <p class="track-title" >Title</p>
            <p class="session-info" id="info-section">Song Info</p>
        </div>
    </div>
    <?php 
    $queryId = mysqli_query($con, "SELECT * FROM SESSION_INFO WHERE userArtistID='$userID'");
    while($row = mysqli_fetch_array($queryId)){
        echo '<div id="all-appointments">
        <div class="apt-info queueItemInfo">
            <p class="apt-date">' . $row["date"] . '</p>
            <p class="studio-engineer">' . $row["engineer"] . '</p>
            <p class="track-title">' . $row["track"] . '</p>
            <p class="session-info"><a id="download" href="' . $row["sessionFile"] . '">Download File</a></p>
        </div>
    </div>';
    }
    ?>
    
</div>

