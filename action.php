<?php
$a = "~(htt(?:p|ps):\/\/.*)~" ;

$timeout = 10;
$ch = curl_init($_GET["url"]);
       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); 
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
       curl_setopt($ch, CURLOPT_FAILONERROR, 1);
       
       
$data = curl_exec($ch);

//echo $data;

curl_close($ch);

$regex = "@(?s)<h2.*?Add to Compare@";

//$data = "hello people iam happy . you are amazing. great work";

preg_match_all($regex,$data,$matches,PREG_PATTERN_ORDER);

//print_r($matches[0]);

$college_name= "@<h2.*\">(.*)<\/a>@";
$place = "@<p>\|(.*)<\/p>@";
$facilities = "@<h3>(.*)<\/h3>@";

$college=[];

$crude_data = $matches[0];
$i=0;

foreach ( $crude_data as $var)
{
    preg_match($college_name,$var,$r);
    $college[i]["name"] = $r[0];
    
    preg_match($place,$var,$r);
    $college[i]['place'] =$r[1];
    
    preg_match_all($facilities,$var,$r);
    
    $college[i]['facilities']=$r[0];
    $i  = $i+1;
    
}
   

print_r($college);



         
?>