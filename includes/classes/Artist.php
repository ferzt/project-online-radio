<?php

class Artist {
    
    private $con;
    private $id;
    private $username;
    private $artistId;
    private $artistName;
    private $realName;
    
    public function __construct($con, $username) {
        $this->username = $username;    
        $this->con = $con;
        
        $query = mysqli_query($this->con,"SELECT userID FROM USERS WHERE username='$this->username'");
        $userId = mysqli_fetch_array($query);
        $userId = $userId ["userID"];
        $this->id = $userId;
        
        $query = mysqli_query($this->con,"SELECT artistID FROM USER_ARTIST WHERE userID='$this->id'");
        $artistId = mysqli_fetch_array($query);
        $artistId = $artistId["artistID"];
        $this->artistId = $artistId;
        
        $query = mysqli_query($this->con,"SELECT stageName, realName FROM ARTIST WHERE artistID='$this->artistId'");
        $allName = mysqli_fetch_array($query);
        $artistName = $allName["stageName"];
        $this->artistName = $artistName;
        
        $realName = $allName["realName"];
        $this->realName = $realName;
        

    }
    
    public function getArtistName() {

        return $this->artistName;
    }
    
    public function getArtistId() {

        return $this->artistId;
    }
    
    public function getNumAppearances() {
        
        $query = mysqli_query($this->con,"SELECT artistCredit FROM CREDIT WHERE artistCredit='$this->artistId'");
        $numApp = mysqli_num_rows($query);
        
        return $numApp;
        
    }
    
    public function mostRecentReleaseID() {
        
        $query = mysqli_query($this->con,"SELECT songID FROM SONG s, CREDIT c WHERE songID = songCredit AND artistCredit='$this->artistId' ORDER BY releaseSong desc LIMIT 1");
        $songID = mysqli_fetch_array($query);
        $songID = $songID["songID"];
        return $songID;    
    }
    
    public function mostPlayedReleaseID() {
        $query = mysqli_query($this->con,"SELECT songID FROM SONG s, CREDIT c WHERE songID = songCredit AND artistCredit='$this->artistId' ORDER BY totalListens desc LIMIT 1");
        $songID = mysqli_fetch_array($query);
        $songID = $songID["songID"];
        return $songID;
    }
    
    
}

?>