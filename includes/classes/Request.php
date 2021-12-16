<?php

class Request {
    
    private $con;
    private $searchString;
    
    public function __construct($con, $string) {
        $this->searchString = $string;    
        $this->con = $con;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getArtist() {
        return new Artist($this->con, $this->artistId);        
    }
    
    public function getArtworkPath() {
        return $this->artworkPath;        
    }
    
    public function getGenre() {
        return $this->genre;  
    }
    
    public function getNumberOfSongs() {
        $query = mysqli_query($this->con, "SELECT title FROM song WHERE title='$this->searchString'"); 
        return mysqli_num_rows($query);
    }
    
    public function getSearchAsSong() {
        $query = mysqli_query($this->con, "SELECT * FROM SONG s, CREDIT c, ARTIST A WHERE s.songID = c.songCredit AND c.artistCredit = A.artistID AND role = 'main' AND title LIKE '%$this->searchString%'");
        
        $songIdArray = array();

        while($row = mysqli_fetch_array($query)){
            
            $songID = $row["songID"];
            
            $featuresQuery = mysqli_query($this->con, "SELECT stageName FROM SONG s, CREDIT c, ARTIST A WHERE s.songID = c.songCredit AND c.artistCredit = A.artistID AND role = 'feature' AND songID=$songID");
            
            $artworkQuery = mysqli_query($this->con, "SELECT artwork FROM ALBUM a, ALBUM_INCLUSION ai WHERE ai.album = a.albumID AND ai.songAlbum = $songID");
            
            $features = array();
            $artwork = mysqli_fetch_array($artworkQuery);
            
            while($col = mysqli_fetch_array($featuresQuery)){
                array_push($features, $col["stageName"]);
                
            }
                
            $row["features"] = $features;
            $row["artwork"] = $artwork["artwork"];
            array_push($songIdArray, $row);
        }

        return $songIdArray;
    }
    
    
}

?>