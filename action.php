<?php


$a = "~(htt(?:p|ps):\/\/.*)~" ;
echo $_GET["url"];

$data = file_get_contents($_GET["url"]);
$data = trim($data);
$data = preg_replace("/\n/"," ",$data);
echo $data;

$lookup = "~<div id=\"instituteContainer(.*)Download Brochure~";

echo "\n";
echo preg_match_all($lookup,$data,$matches);

var_dump($matches);




?>
 
