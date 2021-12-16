<?php

class Playlist {
    
    private $con;
    private $mysqlData;
    private $name;
    private $id;
    private $playlistIds;
    private $user;
    
    public function __construct($con, $id, $mode) {
   
        $this->con = $con;
        $this->id = $id;    
//        $this->mysqlData = mysqli_query($this->con, "SELECT * FROM PLAYLIST_INCLUSION P, SONG S WHERE P.songInclusion = S.songID AND P.playlistInclusion = '$id' ORDER BY playOrder");
        
        $this->mysqlData = mysqli_query($this->con, "SELECT songInclusion FROM PLAYLIST_INCLUSION WHERE playlistInclusion = '$id' ORDER BY playOrder");
        
        $query = mysqli_query($this->con, "SELECT name, createdBy FROM PLAYLIST P WHERE playlistId = $id");
        $plInfo = mysqli_fetch_array($query);
        $this->name = $plInfo["name"];
        $this->user = $plInfo["createdBy"];
        
        $this->playlistIds = array();
        
    }
    
    
    public function getSongIds(){
        
        $playlistSongs = array();
        
        while($row = mysqli_fetch_array($this->mysqlData)){ 
            array_push($playlistSongs, $row["songInclusion"]);
        }
   
        return $playlistSongs;
    }
    
    
    public function getName(){
   
        return $this->name;
    }
    
    
    public function getUser(){
        
        $query = mysqli_query($this->con, "SELECT username FROM USERS WHERE userID = $this->user");
        
        $username = mysqli_fetch_array($query);
        
        return $username["username"];

    }
    
    
    public function getNumberOfSongs(){
        
        $numSongs = mysqli_num_rows($this->mysqlData);
        
        return $numSongs;
        
    }
 

    
}

?>