<?php
// Externen Zugriff zulassen
///////////////////////////////////////////////////
header('Access-Control-Allow-Origin: *');


// Buttons
///////////////////////////////////////////////////
// Icons: https://fontawesome.com/v4.7.0/icons/
///////////////////////////////////////////////////
$snav_elemente = array (
	"Hotline: +49 (0) 5883 638" => "fa-phone,<a href='tel:+495883638'>", 
	"Reservierungsanfrage" => "fa-bed,<a class='mask_main' href='#'>",
	"Angebote" => "fa-gift,<a href='https://www.landgasthof-rieger.astrotel-server.de/arrangements.html'>",
	"facebook" => "fa-facebook,<a href='https://www.facebook.com/Landgasthof-Rieger-463871810327498/' target='_blank'>",
	"Twitter" => "fa-twitter,<a href='https://twitter.com/search?src=typd&q=landgasthof%20rieger' target='_blank'>"
);


// Ausgabe
///////////////////////////////////////////////////
$snav_ausgabe = "<ul>";
$abstand_wert = 55;
$abstand = 0;
$i=1;
foreach ($snav_elemente as $titel => $element) {
	$element_array = explode (",", $element); $icon = $element_array [0]; $link = $element_array [1];
	if($link == "leer")
	{
		$snav_ausgabe = $snav_ausgabe. "<li id='snav_".$i."' style='".($abstand * $abstand_wert)."'><li><span class='icons ".$icon."'></span><span>".$titel."</span></li>";
	} else
	{
		$snav_ausgabe = $snav_ausgabe. "<li id='snav_".$i."' style='top:".($abstand * $abstand_wert)."px;'><span class='icons ".$icon."'></span><span class='stxt'>".$link.$titel."</a></span></li>";
	}
	$i++;
	$abstand++;
}
$snav_ausgabe = $snav_ausgabe. "</ul>";
echo $snav_ausgabe;

// JS erzeugen
///////////////////////////////////////////////////
unset($fp);
$fp = @fopen("libraries/snav.js", "w+");
@fwrite($fp, "document.write(\"<div id='astrotel_nav'>");
@fwrite($fp, "".$snav_ausgabe."");
@fwrite($fp, "</div>\");");
@fclose($fp);


$snavm_ausgabe = "<ul>";
$abstand = 0;
$i=1;
foreach ($snav_elemente as $titelm => $elementm) {
	$element_arraym = explode (",", $elementm); $iconm = $element_arraym [0]; $linkm = $element_arraym [1];
	if($linkm == "leer")
	{
		$snavm_ausgabe = $snavm_ausgabe. "<li id='snavm_".$i."'><li><span class='icons ".$iconm."'></span><span>".$titelm."</span></li>";
	} else
	{
		$snavm_ausgabe = $snavm_ausgabe. "<li id='snavm_".$i."'><span class='icons ".$iconm."'></span><span class='stxt'>".$linkm.$titelm."</a></span></li>";
	}
	$i++;
	$abstand++;
}
$snavm_ausgabe = $snavm_ausgabe. "</ul>";
echo $snavm_ausgabe;

// JS MOBILE erzeugen
///////////////////////////////////////////////////
unset($fp);
$fp = @fopen("libraries/snavm.js", "w+");
@fwrite($fp, "document.write(\"<div id='astrotel_nav_m'><div id='mclose'><span class='icons fa-close'></span></div>");
@fwrite($fp, "".$snavm_ausgabe."");
@fwrite($fp, "</div>\");");
@fclose($fp);

?>