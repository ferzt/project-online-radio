                    </div>
                
                </div>
            </div>
            <?php 
                if(isset($_SESSION["userLoggedIn"])) {
                    if($userType=="admin"){
                        include("includes/nowPlayingBarAdmin.php");                        
                    } else {
                        include("includes/nowPlayingBar.php");
                    }
                } else {
                     include("includes/nowPlayingBarAnon.php");
                }

               ?>         
        </div>
        
        
    </body>

</html>