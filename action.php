<?php
require("functions.php");
$data = fetch_data($_GET["url"]);
//echo $data;
$next_page="@<li class=\" linkpagination\"><a data-page=\"\d\" href =(.*)<\/a><\/li>@";

preg_match_all($next_page,$data,$next,PREG_PATTERN_ORDER);

 $regex = "@(?s)<h2.*?Add to Compare@";
    preg_match_all($regex,$data,$matches,PREG_PATTERN_ORDER);

    
    $college_name= "@<h2.*\">(.*)<\/a>@";
    $place = "@<p>\|(.*)<\/p>@";
    $facilities = "@<h3>(.*)<\/h3>@";
    $reviews = "@<span><b>(\d+)<\/b><a target=\"_blank\"@";
    
    $college=[];
    
    $crude_data = $matches[0];
    $i=0;
    
    foreach ( $crude_data as $var)
    {
        preg_match($college_name,$var,$r_name);
        preg_match($place,$var,$r_place);
        preg_match_all($facilities,$var,$r_fac);
        preg_match($reviews,$var,$r_rev);
        
        
       $college[$i] = array($r_name[0],$r_place[1],$r_fac[0],$r_rev[1]);
        
        $i = $i+1;
    }
//print_r($next[1]);
/*
foreach ($next[1] as $var)
{
    $data = fetch_data($var);
    //echo $data;
   
    $regex = "@(?s)<h2.*?Add to Compare@";
    preg_match_all($regex,$data,$matches,PREG_PATTERN_ORDER);
    
    //echo $matches[0];
    
    $crude_data = $matches[0];
    
    foreach ( $crude_data as $var)
    {
        preg_match($college_name,$var,$r_name);
        preg_match($place,$var,$r_place);
        preg_match_all($facilities,$var,$r_fac);
        
       $college[$i] = array($r_name[0],$r_place[1],$r_fac[0]);
        
        $i = $i+1;
    }
   
}*/
// print_r($next[1]);
print_r($college);

?>