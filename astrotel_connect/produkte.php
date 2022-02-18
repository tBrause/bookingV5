<?php

header('Access-Control-Allow-Origin: *');

$pro_id = $_GET['pro_id'];
$pro_id = substr($pro_id,2);
//echo $arr_id."<br><br>";

$xmlFile = '../sitemap.xml';
$xml = simplexml_load_file($xmlFile); 

foreach ( $xml->url as $user )  
{  
   //echo 'Id: ' . $user -> loc . '<br>';
   
   $str = $user -> loc;
   $str_len = strlen($str);
   $pos = strpos($user -> loc, $pro_id);
   $sub = substr($str, $pos, $str_len);
   //echo 'Link: ' . $sub . $arr_id . '<br>';
   if($sub == $pro_id)
   {
	   //echo 'Link: ' . $str . '<br>';
	   echo "<iframe id=\"i_quelle\" src=\"". $str ."\"></iframe>";
   }
}
		
		
?>

