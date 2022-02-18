<?php

header('Access-Control-Allow-Origin: *');

$kon_id = $_GET['kon_id'];
$kon_id = substr($kon_id,2);

$xmlFile = '../sitemap.xml';
$xml = simplexml_load_file($xmlFile); 

foreach ( $xml->url as $user )  
{ 
   $str = $user -> loc;
   $str_len = strlen($str);
   $pos = strpos($user -> loc, $kon_id);
   $sub = substr($str, $pos, $str_len);
   if($sub == $kon_id)
   {
	   echo "<iframe id=\"i_quelle\" src=\"". $str ."\"></iframe>";
   }
}
		
		
?>

