<?php

function fetch_data($url)
{
    $timeout = 10;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); 
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
       
    $data = curl_exec($ch);
    curl_close($ch);
    //echo $data;
    return $data;
}

function scrape($data)
{
    $regex = "@(?s)<h2.*?Add to Compare@";
    preg_match_all($regex,$data,$matches,PREG_PATTERN_ORDER);

    
    $college_name= "@<h2.*\">(.*)<\/a>@";
    $place = "@<p>\|(.*)<\/p>@";
    $facilities = "@<h3>(.*)<\/h3>@";
    
    $college=[];
    
    $crude_data = $matches[0];
    $i=0;
    
    foreach ( $crude_data as $var)
    {
        preg_match($college_name,$var,$r_name);
        preg_match($place,$var,$r_place);
        preg_match_all($facilities,$var,$r_fac);
        
       $college[$i] = array($r_name[0],$r_place[1],$r_fac[0]);
        
        $i = $i+1;
    }
    
    return $college;
}

function db_connect()
{
$servername = "localhost";
$username = "username";
$password = "password";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE myDB";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);
}
?>