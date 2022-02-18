<?php

header('Access-Control-Allow-Origin: *');

$tr_id = $_GET['tr_id'];
$tr_id = substr($tr_id,2);
//echo $arr_id."<br><br>";

$xmlFile = '../sitemap.xml';
$xml = simplexml_load_file($xmlFile); 

foreach ( $xml->url as $user )  
{  
   //echo 'Id: ' . $user -> loc . '<br>';
   
   $str = $user -> loc;
   $str_len = strlen($str);
   $pos = strpos($user -> loc, $tr_id);
   $sub = substr($str, $pos, $str_len);
   //echo 'Link: ' . $sub . $arr_id . '<br>';
   if($sub == $tr_id)
   {
	   //echo 'Link: ' . $str . '<br>';
	   echo "<iframe id=\"i_quelle\" src=\"". $str ."\"></iframe>";
   }
}
		
		
?>

