<?php

header('Access-Control-Allow-Origin: *');

$arr_id = $_GET['arr_id'];
//echo $arr_id."<br>";

$xmlFile = '../sitemap.xml';
$xml = simplexml_load_file($xmlFile); 

foreach ( $xml->url as $user )  
{  
   //echo 'Id: ' . $user -> loc . '<br>';
   
   $str = $user -> loc;
   $str_len = strlen($str);
   $pos = strpos($user -> loc, $arr_id);
   $sub = substr($str, $pos, $str_len);
   
   if($sub == $arr_id)
   {
	   //echo 'Link: ' . $str . '<br>';
	   echo "<iframe id=\"i_quelle\" src=\"". $str ."\"></iframe>";
   }
}
		
		
?>

