<?php 

class Collection {
    
    private $con;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;
    
    public function __construct($con, $id, $ownerId, $type) {
        //owner id is songid for album and user id for playlists
        if($type == "album") {
            $this->id = $id;    //album id
            $this->con = $con;

            $albumQuery = mysqli_query($this->con, "SELECT * FROM ALBUM WHERE albumID='$this->id'");
            //echo mysqli_field_count($con); //number of columns got from most recent query using connection variable
            $album = mysqli_fetch_array($albumQuery);
            /*mysqli_fetch_array only returns a single row at a time from a result set - $albumQuery*/
            //use while loop to obatain all rows and create multi dimensional array for further processing
            $this->title = $album['title'];
            //echo  "<script> console.log('" . $album["title"]  . "'); </script>"; // enclose console.log string in single quotes;
            $this->artworkPath = $album['artwork'];
            
            $artistIdQuery = mysqli_query($this->con, "SELECT artistCredit FROM CREDIT WHERE songCredit='$ownerId'");
            $artist = mysqli_fetch_array($artistIdQuery);
            $artist = $artist["artistCredit"];
            
            $artistQuery = mysqli_query($this->con, "SELECT stageName FROM ARTIST WHERE artistID='$artist'");
            $artistName = mysqli_fetch_array($artistQuery);
            
            $this->artistId = $artistName['stageName'];
            
            $tagIdQuery = mysqli_query($this->con, "SELECT tagPoss FROM TAG_POSSESSION WHERE songTag='$ownerId'");
            $tagId= mysqli_fetch_array($tagIdQuery);
            $tagId = $tagId["tagPoss"];
            
            $tagQuery = mysqli_query($this->con, "SELECT tagName FROM TAG WHERE tagID='$tagId'");
            $tagName = mysqli_fetch_array($tagQuery);
            
            $this->genre = $tagName['tagName'];
        }
        
        if($type == "playlist") {
            $this->id = $id;    
            $this->con = $con;

            $albumQuery = mysqli_query($this->con, "SELECT * FROM ALBUM WHERE id='$this->id'");
            //echo mysqli_field_count($con); //number of columns got from most recent query using connection variable
            $album = mysqli_fetch_array($albumQuery);
            /*mysqli_fetch_array only returns a single row at a time from a result set - $albumQuery*/
            //use while loop to obatain all rows and create multi dimensional array for further processing
            $this->title = $album['title'];
            //echo  "<script> console.log('" . $album["title"]  . "'); </script>"; // enclose console.log string in single quotes;
            $this->artworkPath = $album['artwork'];
            $this->artistId = $album['artist'];
            $this->genre = $album['genre'];
        }
        
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getArtist() {
        return $this->artistId;        
    }
    
    public function getArtworkPath() {
        return $this->artworkPath;        
    }
    
    public function getGenre() {
        return $this->genre;  
    }
    
    public function getNumberOfSongs() {
        $query = mysqli_query($this->con, "SELECT songAlbum FROM ALBUM_INCLUSION WHERE album='$this->id'"); 
        return mysqli_num_rows($query);
    }
    
    public function getSongIds() {
        $query = mysqli_query($this->con, "SELECT songAlbum as id FROM  ALBUM_INCLUSION WHERE album='$this->id' ORDER BY albumOrder");
        
        $songIdArray = array();
        while($row = mysqli_fetch_array($query)){
            array_push($songIdArray, $row["id"]);
        }

        return $songIdArray;
    }
    
    public function getSongIdsPlaylist() {
        
    }
    
}


?>