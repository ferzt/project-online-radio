<?php

if(isset($_POST["loginButton"])){
                
        $loginUsername = $_POST["loginUsername"];
        $loginPassword = $_POST["loginPassword"];
    
        $result = $account->checkLoginDetails($loginUsername,$loginPassword);
        echo "here";
    if($result) {
        $_SESSION['userLoggedIn']= $loginUsername;
        $_SESSION['userType']= "registered";
        header("Location: home.php");
    }
}

if(isset($_POST["loginPrivButton"])){
                
        $loginUsername = $_POST["loginUsername"];
        $loginPassword = $_POST["loginPassword"];
        $loginType = $_POST["loginType"];
    
        $result = $account->checkAdminArtistLoginDetails($loginUsername,$loginPassword, $loginType);
    
    if($result) {
        $_SESSION['userLoggedIn']= $loginUsername;
        $_SESSION['userType']= $_POST["loginType"];
        if($loginType == "admin") {
            header("Location: admin.php");
        } else {
             header("Location: artist.php");            
        }
    }
}

?>