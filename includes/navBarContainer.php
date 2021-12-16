<style>
    .navItem:hover a {
       color: black; 
    }

</style>
<script>
    $(document).ready(function(){
        
        $(document).on("click", ".navItemLink:not(first)", function(e){
            $(this).parent().addClass("activeLink");
            $(this).parent().siblings().removeClass("activeLink");
        })
        
    });
</script>

<div id="navBarContainer">
    <nav class="navBar">
        <span  role="link" tabindex="0" class="logo">
            <img src="assets/images/icons/logo.png">LA Radio
        </span>

        <div class="group">

            <div class="navItem">
                <?php 
                $refreshHeader;
                if(isset($userLoggedIn)){
                     if($userType == "registered")  {
                         $refreshHeader = "home.php";
                    } else {
                         if($userType == "artist") {
                             $refreshHeader =  "artist.php";
                         } else {
                             $refreshHeader = "admin.php"; 
                         }
                         }
                } else {
                    $refreshHeader = 'index.php';
                    
                }
                
                ?>
                
                <span  role="link" tabindex="0" onclick="openPage('<?php echo $refreshHeader ?>')" id='userHeader' class="navItemLink">
                    <?php 
                    if(isset($userLoggedIn)){
                        echo "<a>" . $userLoggedIn . "</a>"; 
                    } else {
                        echo "Anonymous";
                    }
                    
                    ?>
     
                    <img src="assets/images/icons/account.png" class="icon" alt="user">
                </span>                        
            </div>

            <?php 
            if(isset($userLoggedIn)){
                if($userType == "registered"){
                    echo "<div class='navItem regularLink'>
                        <span  role='link' tabindex='0' onclick='openPage(\"song-request.php\")' class='navItemLink'><a>Request Song</a></span>                        
                    </div>
                    <div class='navItem regularLink'>
                        <span  role='link' tabindex='0' onclick='openPage(\"playlist-mode.php\")' class='navItemLink'><a >Playlist Mode</a></span>                        
                    </div>
                    <div class='navItem regularLink'>
                        <span  role='link' tabindex='0' class='navItemLink'><a href='logout.php'>Log Off</a></span>                        
                    </div>"
                        ;
                }
                if($userType == "artist"){
                    echo "<div class='navItem regularLink'>
                        <span  role='link' tabindex='0' onclick='openPage(\"artist-upload.php\")' class='navItemLink'><a>Upload Song</a></span>                        
                    </div>
                    <div class='navItem regularLink'>
                        <span  role='link' tabindex='0' onclick='openPage(\"session-info.php\")' class='navItemLink'><a>Studio Session</a></span>                        
                    </div>
                    <div class='navItem regularLink'>
                        <span  role='link' tabindex='0' class='navItemLink'><a href='logout.php'>Log Off</a></span>                        
                    </div>";
                }
                
                if($userType == "admin"){
                    echo "<div class='navItem regularLink'>
                    <span  role='link' tabindex='0' onclick='openPage(\"queue-air.php\")' class='navItemLink'><a>View Queue</a></span>                        
                    </div>
                    <div class='navItem regularLink'>
                        <span  role='link' tabindex='0' onclick='openPage(\"user-access.php\")' class='navItemLink'><a>User Access</a></span>                        
                    </div>
                    <div class='navItem regularLink'>
                        <span  role='link' tabindex='0' class='navItemLink'><a href='logout.php'>Log Off</a></span>                        
                    </div>";
                    
                }
                
            } else {
                echo "";
            }
            
            ?>
            
        </div>


    </nav>

</div>