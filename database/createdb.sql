CREATE TABLE ARTIST
(artistID int NOT NULL AUTO_INCREMENT,
stageName VARCHAR(50),
realName VARCHAR(50),
PRIMARY KEY (ArtistID));

CREATE TABLE SONG
(songID int NOT NULL AUTO_INCREMENT,
title VARCHAR(100),
duration VARCHAR(4),
mp3File VARCHAR(100),
releaseSong DATE,
totalListens int,
totalRating float,
PRIMARY KEY (SongID));

CREATE TABLE CREDIT
(Role VARCHAR(100),
songCredit int,
artistCredit int,
FOREIGN KEY (songCredit) REFERENCES SONG (songID),
FOREIGN KEY (artistCredit) REFERENCES ARTIST (artistID));

CREATE TABLE USERS
(userID int NOT NULL AUTO_INCREMENT,
username VARCHAR(50),
firstName VARCHAR(50),
lastName VARCHAR(50),
email VARCHAR(50),
password VARCHAR(50),
date date,
profile VARCHAR(50),
PRIMARY KEY (userID));

CREATE TABLE USER_ADMIN
(userID int NOT NULL,
title VARCHAR(50),
PRIMARY KEY (userID),
FOREIGN KEY (userID) REFERENCES USERS (userID));

CREATE TABLE USER_ARTIST
(userID int NOT NULL,
socialProfiles VARCHAR(50),
bio VARCHAR(50),
artistID INT,
PRIMARY KEY (userID),
FOREIGN KEY (userID) REFERENCES USERS (userID),
FOREIGN KEY (artistID) REFERENCES ARTIST (artistID));

CREATE TABLE SESSION_INFO
(sessID int NOT NULL AUTO_INCREMENT,
userArtistID INT,
engineer VARCHAR(50),
track VARCHAR(50),
date date,
sessionFile VARCHAR(100),
PRIMARY KEY (sessID),
FOREIGN KEY (userArtistID) REFERENCES USER_ARTIST (userID));

CREATE TABLE HEARING
(Rating float,
lastListen date,
numberListens int,
userHear int,
songHear int,
favorite Boolean,
FOREIGN KEY (userHear) REFERENCES USERS (userID),
FOREIGN KEY (songHear) REFERENCES SONG (songID));

CREATE TABLE ALBUM
(albumID int NOT NULL UNIQUE AUTO_INCREMENT,
title VARCHAR(50),
artwork VARCHAR(50),
releaseAlb DATE,
PRIMARY KEY (albumID));

CREATE TABLE ALBUM_INCLUSION
(albumOrder int,
album int,
songAlbum int,
FOREIGN KEY (album) REFERENCES ALBUM (albumID),
FOREIGN KEY (songAlbum) REFERENCES SONG (songID));

CREATE TABLE PLAYLIST
(playlistID int NOT NULL AUTO_INCREMENT,
name VARCHAR(25),
public boolean,
createdBy INT,
PRIMARY KEY (playlistID),
FOREIGN KEY (createdBy) REFERENCES USERS (userID));

CREATE TABLE PLAYLIST_INCLUSION
(playOrder int,
playlistInclusion int,
songInclusion int,
FOREIGN KEY (playlistInclusion) REFERENCES PLAYLIST (playlistID),
FOREIGN KEY (songInclusion) REFERENCES SONG (songID));

CREATE TABLE TAG
(tagID INT NOT NULL AUTO_INCREMENT,
tagName VARCHAR(50),
description VARCHAR(50),
PRIMARY KEY (tagID));

CREATE TABLE TAG_POSSESSION
(tagPoss INT,
songTag int,
FOREIGN KEY (tagPoss) REFERENCES TAG (tagID),
FOREIGN KEY (songTag) REFERENCES SONG (songID));

CREATE TABLE ON_AIR
(songRef INT,
reqUserId int,
priority int,
timer VARCHAR(50),
approvedBy INT,
FOREIGN KEY (songRef) REFERENCES SONG (songID),
FOREIGN KEY (approvedBy) REFERENCES USER_ADMIN (userID),
FOREIGN KEY (reqUserId) REFERENCES USERS (userID));


INSERT INTO ALBUM 
VALUES
    (5,"F.A.M.E", "assets/images/artwork/fame.jpg",'2012-04-23'),
    (15,"Born To Do It", "assets/images/artwork/borntodoit.jpg",'2012-04-23'),
    (25,"Three Ringz", "assets/images/artwork/three_ringz.jpg",'2012-02-12'),
    (35,"Strange Clouds", "assets/images/artwork/strange_clouds.jpg",'2012-02-12'),
    (45,"SINGLE", "assets/images/artwork/im_on_one_single.png",'2012-04-23'),
    (55,"SINGLE", "assets/images/artwork/paradise_single.jpg",'2012-04-23'),
    (65,"Made In Lagos", "assets/images/artwork/made_in_lagos.jpg",'2012-02-12'),
    (75,"Black Girl Magic", "assets/images/artwork/black_girl_magic.jpg",'2012-02-12'),
    (85,"Palm Wine Music 2", "assets/images/artwork/palm_wine_music_2.jpg",'2012-02-12'),
    (95,"Outside", "assets/images/artwork/outside.jpg",'2012-02-12');
    

INSERT INTO ARTIST 
VALUES
    (5,"Bruno Mars", "Bruno Mars"),
    (15,"Chris Brown", "Christopher M. Brown"),
    (25,"Craig David", "Craig David"),
    (35,"Justin Bieber", "Justin Bieber"),
    (45,"T-Pain", "T-Pain"),
    (55,"Dj Khaled", "Khaled"),
    (65,"Wizkid", "Ayo Balogun"),
    (75,"Rinyu", "Rinyu"),
    (85,"Show Dem Camp", "SDC"),
    (95,"Burna Boy", "Burna"),
    (105,"B.o.B", "Bob");

INSERT INTO SONG 
VALUES
    (5,"All Back", "3:02", "assets/music/Chris Brown/FAME/All Back.mp3","2021-01-12",0,0),
    (15,"Booty Man", "2:52", "assets/music/Craig David/BornToDoIt/bootyman.mp3","2004-10-12",0,0),
    (25,"Next To You", "3:02", "assets/music/Chris Brown/FAME/Next To You.mp3","2015-10-12",0,0),
    (35,"Freeze", "3:02", "assets/music/T-Pain/Three Ringz/Freeze.mp3","2016-04-12",0,0),
    (45,"Paradise", "3:02", "assets/music/Chris Brown/FAME/Paradise.mp3","2016-04-12",0,0),
    (55,"I'm On One", "2:52", "assets/music/Dj Khaled/Singles/I'm On One.mp3","2016-04-12",0,0),
    (65,"Koni Bjae", "3:02", "assets/music/Burna Boy/Outside/Koni Bjae.mp3","2016-04-12",0,0),
    (75,"Walking Away", "3:02", "assets/music/Craig David/BornToDoIt/walkingaway.mp3","2016-04-12",0,0),
    (85,"Castles", "3:02", "assets/music/B.o.B/Strange Clouds/Castles.mp3","2016-04-12",0,0),
    (95,"Strange Clouds", "2:52", "assets/music/B.o.B/Strange Clouds/strange_clouds.mp3","2016-04-12",0,0),
    (105,"Ye", "3:02", "assets/music/Burna Boy/Outside/Ye.mp3","2010-04-12",0,0),
    (115,"Chopped 'N Skrewed", "3:02", "assets/music/T-Pain/Three Ringz/Chopped N Skrewed.mp3","2016-04-12",0,0),
    (125,"Can't Believe It", "3:02", "assets/music/T-Pain/Three Ringz/Can't Believe It.mp3","2016-04-12",0,0),
    (135,"Essence", "2:52", "assets/music/Wizkid/Made In Lagos/essence.mp3","2011-04-12",0,0),
    (145,"Blessed", "3:02", "assets/music/Wizkid/Made In Lagos/blessed.mp3","2016-04-12",0,0),
    (155,"Black Girl Magic", "3:02", "assets/music/Rinyu/Black Girl Magic/black_girl_magic.mp3","2017-04-12",0,0);

INSERT INTO ALBUM_INCLUSION
VALUES
    (1,5,5),
    (1,15,15),
    (2,5,25),
    (1,55,45),
    (1,45,55),
    (1,95,65),
    (2,15,75),
    (1,35,85),
    (2,35,95),
    (2,95,105),
    (2,25,115),
    (3,25,125),
    (1,65,135),
    (2,65,145),
    (1,75,155),
    (1,25,35);

INSERT INTO CREDIT
VALUES
    ("main",5,15),
    ("main",15,25),
    ("main",25,15),
    ("main",35,45),
    ("feature",25,35),
    ("feature",35,15),
    ("main",45,15),
    ("main",55,55),
    ("main",65,95),
    ("main",75,25),
    ("main",85,105),
    ("main",95,105),
    ("main",105,95),
    ("main",115,45),
    ("main",125,45),
    ("main",135,65),
    ("main",145,65),
    ("main",155,75);

INSERT INTO USERS 
VALUES 
    (5,"alchemist", "Walter", "White", "mrwhite@gmail.com", "7c6a180b36896a0a8c02787eeafb0e4c", "2021-11-26", "assets/images/profilepics/profilepic.png"),
    (15,"bonjovi", "Raymond", "Red", "rayrede@gmail.com", "7c6a180b36896a0a8c02787eeafb0e4c", "2021-11-26", "assets/images/profilepics/profilepic.png"),
    (25,"mpower", "Michael", "Power", "mpower@gmail.com", "7c6a180b36896a0a8c02787eeafb0e4c", "2021-11-26", "assets/images/profilepics/profilepic.png");

INSERT INTO PLAYLIST 
VALUES
    (5,"Summer Jam Outdoors", true, 5),
    (15,"Clean and Cook", false, 5);

INSERT INTO PLAYLIST_INCLUSION
VALUES
    (1,5,35),
    (1,15,15);
    
    
INSERT INTO TAG
VALUES
    (1,"R&B", "Melodies and Vibes"),
    (2,"Ballad","Big Drums and Sound"),
    (3,"Garage R&B UK","Garage Step Dance"),
    (4,"Afrobeat","Originating from Central Africa"),
    (5,"POP","Music popular in Western Culture"),
    (6,"Hip-Hop","Music developed by inner-city African Americans");
    
INSERT INTO TAG_POSSESSION
VALUES
    (2,5),
    (1,25),
    (2,35),
    (3,15),
    (5,45),
    (6,55),
    (4,65),
    (3,75),
    (5,85),
    (6,95),
    (4,105),
    (1,115),
    (1,125),
    (4,135),
    (4,145),
    (4,155);
    
INSERT INTO USER_ARTIST
VALUES 
    (15, "Follow me on instagram LINK", "Music Lover, Flight Enthusiast", 75);
    
INSERT INTO USER_ADMIN
VALUES 
    (25, "DjBooth");
    
INSERT INTO SESSION_INFO (userArtistID, engineer, track, date, sessionFile)
VALUES 
    (15, "Mastamind", "Blow My Mind", "2021-12-02", "downloads/blowmymind.mp3"),
    (15, "Bantu", "Feeling", "2021-12-02", "downloads/feeling.mp3");
    
INSERT INTO HEARING
VALUES
    (3.2, "2021-12-02", 0, 5, 15, false),
    (4.8, "2021-12-01", 0, 5, 25, true),
    (4.2, "2021-11-22", 0, 5, 35, true),
    (5.0, "2021-11-12", 0, 5, 45, true),
    (3.2, "2021-11-15", 0, 5, 55, true),
    (4.9, "2021-11-27", 0, 5, 65, true),
    (3.2, "2021-11-07", 0, 5, 75, true),
    (4.7, "2021-10-12", 0, 5, 85, true),
    (3.2, "2021-10-22", 0, 5, 95, true),
    (4.1, "2021-10-02", 0, 5, 105, true),
    (3.2, "2021-10-17", 0, 5, 115, true),
    (4.5, "2021-09-02", 0, 5, 125, true),
    (4.0, "2021-09-15", 0, 5, 135, false);
    
INSERT INTO ON_AIR
VALUES
    (15,5,0,"55",25),
    (35,5,10,"0",null),
    (65,5,10,"55",25),
    (135,5,10,"0",null),
    (85,5,10,"55",25),
    (155,5,10,"0",null),
    (75,5,10,"55",25),
    (125,5,10,"0",null),
    (95,5,10,"55",25),
    (105,5,10,"0",null),
    (5,5,10,"55",25),
    (55,5,10,"0",null),
    (25,5,10,"0",null);
    
    