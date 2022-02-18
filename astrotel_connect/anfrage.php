<?php

header('Access-Control-Allow-Origin: *');

$anf_id = $_GET['anf_id'];
//$arr_id = substr($arr_id,2);
//echo $ang_id."<br><br>";

$xmlFile = '../sitemap.xml';
$xml = simplexml_load_file($xmlFile); 

foreach ( $xml->url as $user )  
{  
   //echo 'Id: ' . $user -> loc . '<br>';
   
   $str = $user -> loc;
   $str_len = strlen($str);
   $pos = strpos($user -> loc, $anf_id);
   $sub = substr($str, $pos, $str_len);
   //echo 'Link: ' . $sub . $ang_id . '<br>';
   if($sub == $anf_id)
   {
	   echo "<iframe id=\"i_quelle\" src=\"". $str ."\"></iframe>";
   }
}
		
		
?>

