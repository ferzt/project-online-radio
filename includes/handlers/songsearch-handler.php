<?php 
include("../config.php");
include("../classes/Request.php");

if(isset($_POST["songSearched"])){
    //Seacrh by song name, album, artist name, playlist
    $searchText = $_POST["songSearched"];
    $searchScope = $_POST["searchScope"];

    $searchReq = new Request($con, $searchText);
    $result;
    if($searchScope == "song"){
        $result = $searchReq->getSearchAsSong();        
    }
    
    if($searchScope == "playlist"){
        $result = $searchReq->getSearchAsPlaylist();        
    }
    
    if($searchScope == "artist"){
        $result = $searchReq->getSearchAsArtist();        
    }
    
    if($searchScope == "album"){
        $result = $searchReq->getSearchAsAlbum();        
    }    

    echo json_encode($result);
}


?>