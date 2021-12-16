<?php

function sanitizeFormString($inputText) {
            $inputText = strip_tags($inputText);
            $inputText = str_replace(' ','',$inputText);
            $inputText = ucfirst(strtolower($inputText));
            return $inputText;
        }

function sanitizeFormUsername($inputText) {
            $inputText = strip_tags($inputText);
            $inputText = str_replace(' ','',$inputText);
            return $inputText;
        }

function sanitizeFormPassword($inputText) {
            $inputText = strip_tags($inputText);
            return $inputText;
        }
        

if(isset($_POST["registerButton"])){
    $username = sanitizeFormUsername($_POST["username"]);
    $firstName = sanitizeFormString($_POST["firstName"]);
    $lastName = sanitizeFormString($_POST["lastName"]);
    $email = sanitizeFormString($_POST["email"]);
    $email2 = sanitizeFormString($_POST["email2"]);
    $password = sanitizeFormPassword($_POST["password"]);
    $password2 = sanitizeFormPassword($_POST["password2"]);
    echo "before";
    $wasSuccessful = $account->register($username,$firstName,$lastName,$email,$email2,$password,$password2);

    if($wasSuccessful) {
        $_SESSION['userLoggedIn']= $username;
        $_SESSION['userType']= "registered";
        header("Location: home.php");
    }
}

?>