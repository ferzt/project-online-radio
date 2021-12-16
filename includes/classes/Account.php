<?php

class Account {
    
    private $errorArray;
    private $con;
    
    public function __construct($con) {
        $this->errorArray = array();    
        $this->con = $con;
    }
    
    public function checkLoginDetails($un,$pw) {
        $pw=md5($pw);
        $query = mysqli_query($this->con,Query::$checkLoginDetails . $un . Query::$checkLoginDetails2 . $pw . "'");
        
        if(mysqli_num_rows($query)==1) {
            return true;
        } else {
            array_push($this->errorArray,Constants::$loginFailed);
            return false;
        }
    }
    
    public function checkAdminArtistLoginDetails($un, $pw, $ut) {
        $pw=md5($pw);
        if($ut == "admin") {
            $query = mysqli_query($this->con,Query::$checkLoginDetails . $un . Query::$checkLoginDetails2 . $pw . "'");
            if(mysqli_num_rows($query) == 0) {
                echo "here";
                return false;
            } 
            $row = mysqli_fetch_array($query);
            $uid = $row["userID"];
            if(mysqli_num_rows($query)==1){
                $query = mysqli_query($this->con,"SELECT * FROM USER_ADMIN WHERE userID = '$uid'");
            }
        } else {
            $query = mysqli_query($this->con,Query::$checkLoginDetails . $un . Query::$checkLoginDetails2 . $pw . "'");
            if(mysqli_num_rows($query) == 0) {
                
                return false;
            } 
            $row = mysqli_fetch_array($query);
            $uid = $row["userID"];
            if(mysqli_num_rows($query)==1){
                $query = mysqli_query($this->con,"SELECT * FROM USER_ARTIST WHERE userID = '$uid'");
            }
        }
        
        if(mysqli_num_rows($query)==1) {
            return true;
        } else {
            array_push($this->errorArray,Constants::$loginFailed);
            return false;
        }
    }

    public function register($un,$fn,$ln,$em,$em2,$pw,$pw2) {
        // $this used efor both functions and variables
        $this->validateUsername($un);
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateEmails($em,$em2);
        $this->validatePasswords($pw,$pw2);
        
        if(empty($this->errorArray)) {
            
            return $this->insertUserDetails($un,$fn,$ln,$em,$pw);
        }else {
            return false;
        }
        
    }
    
    private function insertUserDetails($un,$fn,$ln,$em,$pw) {
        $encryptedPw=md5($pw);
        $profilePic="assets/images/profilepics/profilepic.png";
        $date = date("Y-m-d");
        
        $result = mysqli_query($this->con,"INSERT INTO USERS (username, firstName, lastName, email, password, date, profile) VALUES ('$un','$fn','$ln','$em','$encryptedPw','$date','$profilePic')");
        return $result;
    }
    
    public function getError($error) {
        // in-_array checks inside an array
        if(!in_array($error,$this->errorArray)) {
            $error="";
        }
        return "<span class='errorMessage'>$error</span>";
        
    }

    private function validateUsername($un) {        
        if(strlen($un) < 5 || strlen($un) > 25) {
            array_push($this->errorArray, Constants::$usernameCharacters);
        }  
        
        $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM USERS WHERE username = '$un'");
        if(mysqli_num_rows($checkUsernameQuery)!=0){
            array_push($this->errorArray,Constants::$usernameTaken);
        }
        return;
    }

    private function validateFirstName($fn) {        
        if(strlen($fn) < 2 || strlen($fn) > 25) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }      
        return;
        
    }

    private function validateLastName($ln) {
        if(strlen($ln) < 2 || strlen($ln) > 25) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        } 
        return;
        
    }

    private function validateEmails($em,$em2) {
        if($em != $em2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        } 
        if(!filter_var($em,FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }       
        
        
        $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM USERS WHERE email = '$em'");
        if(mysqli_num_rows($checkEmailQuery)!=0){
            array_push($this->errorArray,Constants::$emailTaken);
            return;
        }
        
    }

    private function validatePasswords($pw,$pw2) {
        if($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
        } 
        
        if(preg_match('/[^a-zA-z0-9]/',$pw)) {
            array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
        }
        
        if(strlen($pw) < 5 || strlen($pw) > 30 ) {
            array_push($this->errorArray, Constants::$passwordCharacters);
        }
        return;
        
    }
    
}

?>