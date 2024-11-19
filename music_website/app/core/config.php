<?php

if ($_SERVER['SERVER_NAME'] == "localhost") {

    define("ROOT", "http://localhost:8080/music_website/public");
    
    // local
    define("DBHOST", "localhost");
    define("DBDRIVER", "mysql");
    define("DBUSER", "root");
    define("DBPASS", "");
    define("DBNAME", "music_website_db");
} else
{
    define("ROOT", "http://www.mywebsite.com");

    // for online server
    define("DBHOST", "localhost");
    define("DBDRIVER", "mysql");
    define("DBUSER", "root");
    define("DBPASS", "");
    define("DBNAME", "music_website_db");
}