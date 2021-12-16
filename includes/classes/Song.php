<?php

class Song {
    
    private $con; //connection
    private $id; //song id
    private $mysqliData; // All relevant song data
    
    private $title;
    private $albumId;
    private $albumTitle;
    private $songArtists;
    private $tag;
    private $duration;
    private $artworkPath;
    private $albumOrder;

    
    public function __construct($con, $id) {
        
        $this->id = $id;   //song id 
        $this->con = $con;
        $this->songArtists = array();
        $this->title = array();
        $this->duration = array();
        
        $this->mysqliData = mysqli_query($this->con, "SELECT * FROM SONG s, CREDIT c, ARTIST a WHERE s.songID = c.songCredit AND a.artistID = c.artistCredit AND s.songID='$this->id'");
        
        
        while($row = mysqli_fetch_array($this->mysqliData)){
            array_push($this->songArtists, $row["stageName"]);
            array_push($this->title, $row["title"]);
            array_push($this->duration, $row["duration"]);
        }
        
        $query = mysqli_query($this->con, "SELECT albumID, title FROM  ALBUM a, ALBUM_INCLUSION ai WHERE albumID=album AND songAlbum=$this->id");
        
        $album = mysqli_fetch_array($query);
        
        $this->albumTitle = $album["title"];
        $this->albumId = $album["albumID"];
        
    }
    
    public function getTitle() {
        
        $songTitle = $this->title;

        return $songTitle[0]; 
    }
    
    public function getArtist() {
        
       return $this->songArtists;
    }
    
    public function getAlbum() {
       return $this->albumId; 
    }
    
    public function getAlbumTitle() {
        
        return $this->albumTitle; 
    }
    
    public function getTag() {
        $query = mysqli_query($this->con, "SELECT tagName, description as tagDescribe FROM SONG s, TAG t, TAG_POSSESSION tp WHERE s.songID = tp.songTag AND tp.tagPoss = t.tagID AND s.songID='$this->id'");
        
        $songTag = array();
        while($row=mysqli_fetch_array($query)){
            $songTag = $row;
        }

       return $songTag; 
    }
    
    public function getArtworkPath() {
        
        $artworkQuery = mysqli_query($this->con, "SELECT artwork FROM ALBUM a, ALBUM_INCLUSION ai WHERE ai.album = a.albumID AND ai.songAlbum = $this->id");
        
        $artworkPath = mysqli_fetch_array($artworkQuery);
        
        $this->artworkPath = $artworkPath["artwork"];
        
       return $this->artworkPath; 
    }
    
    public function getDuration() {
        
        $songDuration = $this->duration;

        return $songDuration[0]; 
    }
 
    
    
}

?>