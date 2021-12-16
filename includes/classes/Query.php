<?php

class Query{
    
    public static  $checkLoginDetails = "SELECT * FROM USERS WHERE username = '"; //$un' AND password = '$pw'";
    public static  $checkLoginDetails2 = "' AND password = '"; //$un' AND password = '$pw'";
    public static  $homepagerecents = "SELECT s.title as song_title, a.title as album_title, a.artwork as album_art, s.songID as id
    FROM SONG as s, ALBUM as a, ALBUM_INCLUSION as ai
    WHERE s.songID = ai.songAlbum
    AND a.albumID = ai.album
    ORDER BY RAND()
    LIMIT 5";
    
   

}

?>