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

function scrape($data,$i)
{
    $regex = "@(?s)<h2.*?Add to Compare@";
    preg_match_all($regex,$data,$matches,PREG_PATTERN_ORDER);

    
    $college_name= "@<h2.*\">(.*)<\/a>@";
    $place = "@<p>\|(.*)<\/p>@";
    $facilities = "@<h3>(.*)<\/h3>@";
    
    $college=[];
    
    $crude_data = $matches[0];
    
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

function update_db($college)
{
$servername = "localhost";
$username = "m_anvekar";
$password = "v1kCjsvLYytrBTGV";
$database = "colleges";

$conn = connect_db($servername,$username,$password ,$database);

table_setup($conn);

foreach ($college as $data)
{
    $facilities = "";
    $x = $data["facilities"];
   // echo gettype($x);
    foreach($x as $facs)
    {
        $facilities  =$facilities. $facs . ",";
    }
    insert_data($conn,$data,$facilities);
    display($data);
    
}

//$data = retrieve($conn);

//display($data);

$a = 1;
return $a;

}
function connect_db($servername,$username,$password ,$database)
{
    $conn = mysqli_connect($servername, $username, $password,$database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    
    return $conn;

}
function table_setup($conn)
{
    if ($result = mysqli_query($conn,"SHOW TABLES LIKE '".details."'")) {
        if($result->num_rows == 1) {
            $check  = 1;
        }
    }
    else {
       $check = 0;
    }
    
    if($check == 1)
    {
    $sql = "DROP TABLE details";
    echo mysqli_error($conn);
    
    $retval = mysqli_query($conn,$sql);
    if(! $retval )
    {
      die('Could not delete table: ' . mysqli_error($conn));
    }
   
    }
    
    $sql = "CREATE TABLE details (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(80),place VARCHAR(80),facilities VARCHAR(200),reviews INT)";

    $retval = mysqli_query($conn,$sql);
    
    if(! $retval )
    {
      die('Could not create table: ' . mysqli_error($conn));
    }
    
    
}

function insert_data($conn,$row,$f)
{
    $name = mysql_real_escape_string( $row["name"]);
    $place = mysql_real_escape_string( $row["place"]);
    $facs = mysql_real_escape_string( $f);
    $reviews = $row["reviews"];
    $sql = "INSERT INTO details (name,place,facilities,reviews) VALUES('$name','$place','$facs','$reviews')";
    $retval = mysqli_query($conn,$sql);
}

function retrieve($conn)
{
    $id = 1;
    $sql = "SELECT * FROM details where id = $id";
    $continue = true;
    $data = [];
    while($continue === true)
    {
        $retval = mysqli_query($conn,$sql);
        if($retval != false)
        $data[$id] = $retval;
        else
        {$continue = false;
        echo mysqli_error($conn);
        }
    }
    
    return $data;
    
}

function display($college)
{
    echo sizeof($college);
    foreach($college as $a)
{
    print_r($a);
    ?>
    <br>
    <br>
    <hr>
    <br>
    <?php
}
}
?>