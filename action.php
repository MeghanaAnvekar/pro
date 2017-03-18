<?php
    require("functions.php");
    $data = fetch_data($_GET["url"]);
    
    $next_page="@<li class=\" linkpagination\"><a data-page=\"\d\" href = (.*)<\/a><\/li>@";
    
    preg_match_all($next_page,$data,$next,PREG_PATTERN_ORDER);
    
    $pages=[];
    $j =0;
   foreach ($next[1] as $a)
    {
        $a = strchr($a,"http");
        $pages[$j] = $a;
        $j = $j+1;
    }


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
        
        
        $r_rev[1]=(int)$r_rev[1];
        
       $college[$i] = ["name" => $r_name[1],"place" => $r_place[1],"facilities" => $r_fac[1],"reviews" => $r_rev[1]];
        
        $i = $i+1;
    }

foreach ($pages as $url)
{
    $data = fetch_data($url);
    preg_match_all($regex,$data,$matches,PREG_PATTERN_ORDER);
    $crude_data = $matches[0];
    
    foreach ( $crude_data as $var)
    {
        preg_match($college_name,$var,$r_name);
        preg_match($place,$var,$r_place);
        preg_match_all($facilities,$var,$r_fac);
        preg_match($reviews,$var,$r_rev);
        
        $r_rev[1]=(int)$r_rev[1];
       
        $college[$i] = ["name" => $r_name[1],"place" => $r_place[1],"facilities" => $r_fac[1],"reviews" => $r_rev[1]];
       
        $i = $i+1;
    }
   
}



// print_r($next[1]);
/*foreach($college as $a)
{
    print_r($a);
    ?>
    <br>
    <hr>
    <br>
    <?php
}
*/
?>
<html>
    <head>
        <style>
        body{
            background: url("https://media.giphy.com/media/26tPgy93ssTeTTSqA/giphy.gif");
            background-size:100% ;
            background-repeat:no-repeat;
        }
        h1
        {
            font-family:Verdana;
            color:#4286f4;
            font-size:80px;
            text-align:center;
        }
        </style>
    </head>
    
    <body>
        <h1>Loading...</h1>
       </body>
    
</html>
<?php
update_db($college);


?>