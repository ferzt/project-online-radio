<html>
    <head>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/pop-up.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
        <script src="assets/js/script.js"></script>
        <title>Legal Alien Radio: Welcome <?php echo "Anonymous"; ?></title>
    </head>
    
    <body>
        
        <div id="mainContainer">
            
            <div id="topContainer">
               <?php include("includes/navBarContainer.php")?>  
                <div id="mainViewContainer">
                    <div id="myNav" class="overlay">

                      <!-- Button to close the overlay navigation -->
                      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

                      <!-- Overlay content -->
                      <div class="overlay-content">
                          <p>SORRY, RADIO IS CURRENTLY OFFLINE</p>
                        <div><button class="pausePlayAlbumSong"><a href="register.php">LOGIN/REGISTER</a></button></div>
                      </div>

                    </div>
                    <div id=mainViewContent>
                        <div class="entityInfo">
                            <div class="topSection">
                                <h1>You are now listening to</h1> 
                                <div class="registerUser"><button class="pausePlayAlbumSong"><a href="register.php">LOGIN/REGISTER</a></button></div>
                            </div>
                            
                            <div class="leftSection">
                                <img src="https://via.placeholder.com/300" width="220">
                                </div>

                                <div class="rightSection">

                                </div>
                            
                            <div class="bottomSection">
                                
                                <h2><?php echo "Song Title"?></h2>
                                <p class="artistName">By <?php echo "Artist name"; ?></p>
                                <p class="albumTitle"><?php echo "Album song is featured on"; ?> </p>
                            </div>
                        </div>

                    </div>
                
                </div>
            </div>
            <?php include("includes/nowPlayingBarAnon.php")?>         
        </div>
        
        
    </body>

</html>