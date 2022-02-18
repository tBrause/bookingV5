<?php
// Externen Zugriff zulassen ?????????
///////////////////////////////////////////////////
#header('Access-Control-Allow-Origin: *');

/**
 * 
 * 
 * BUTTONS FÜR DIE 
 * HEIGHLIGHT-NAVIGATION
 * 
 * 
 */


function getButtons($conn, $dir)
{

	echo '<h2>HEIGHLIGHT-NAVIGATION</h2>';

	$abstand_wert = 55;
	$abstand = 0;

	$snav_ausgabe = "<ul>";
	$snavm_ausgabe = "<ul>";

	$sql = "SELECT * FROM `bubbles` ORDER BY position";
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_array($result)) {

		$id = intval($row['id']);
		$type = intval($row['type']);
		$title = mysqli_escape_string($conn, $row['title']);
		$link = $row['link'];

		$snav_ausgabe = $snav_ausgabe . "<li id='snav_" . $id . "' style='top:" . ($abstand * $abstand_wert) . "px;'><span class='icons_extern " . $row['icon'] . "'></span>";
		$snavm_ausgabe = $snavm_ausgabe . "<li id='snavm_" . $id . "'><span class='icons_extern " . $row['icon'] . "'></span>";


		# Telefonnummer
		if ($type === 1) {
			$link_ausgabe = "<a href='tel:" . $link . "'>";
		}

		# Link im neuen Fenster
		else if ($type === 2) {
			$link_ausgabe = "<a href='" . $link . "' target='_blank'>";
		}

		# Link im gleichen Fenster
		else if ($type === 3) {
			$link_ausgabe = "<a href='" . $link . "' target='_self'>";
		}

		# E-Mail-Adresse
		else if ($type === 4) {
			$link_ausgabe = "<a href='mailto:" . $link . "' target='_blank'>";
		}

		# Net-Booking Reservierung
		else if ($type === 5) {
			$link_ausgabe = "<a href='#" . $link . "' class='mask_main' target='_self'>";
		}

		# WhatsApp Nummer
		else if ($type === 6) {
			$link_ausgabe = "<a href='https://wa.me/" . $link . "' target='_blank'>";
		}

		# 
		else {
			$link_ausgabe = "<a href='" . $link . "'>";
		}

		if ($link == "") {
			$snav_ausgabe = $snav_ausgabe . "<span class='stxt'>" . $title . "</span>";
			$snavm_ausgabe = $snavm_ausgabe . "<span class='stxt'>" . $title . "</span>";
		} else {
			$snav_ausgabe = $snav_ausgabe . "<span class='stxt'>" . $link_ausgabe . $title . "</a></span>";
			$snavm_ausgabe = $snavm_ausgabe . "<span class='stxt'>" . $link_ausgabe . $title . "</a></span>";
		}

		$snav_ausgabe = $snav_ausgabe . "</li>";
		$snavm_ausgabe = $snavm_ausgabe . "</li>";

		$abstand++;
	}

	$snav_ausgabe = $snav_ausgabe . "</ul>";
	$snavm_ausgabe = $snavm_ausgabe . "</ul>";


	##### JS DATEI FÜR DESKTOP
	$fp = @fopen("" . $dir . "astrotel_connect/libraries/snav.js", "w+");
	@fwrite($fp, "document.write(\"<div id='astrotel_nav'>");
	@fwrite($fp, "" . $snav_ausgabe . "");
	@fwrite($fp, "</div>\");");
	@fclose($fp);
	echo '<h4>Die Datei für die DESKTOP-Ansicht wurde erstellt</h4>';

	##### JS DATEI FÜR MOBILE
	$fp = @fopen("" . $dir . "astrotel_connect/libraries/snavm.js", "w+");
	@fwrite($fp, "document.write(\"<div id='astrotel_nav_m'><div id='mclose'><span class='icons_extern fa-close'></span></div>");
	@fwrite($fp, "" . $snavm_ausgabe . "");
	@fwrite($fp, "</div>\");");
	@fclose($fp);
	echo '<h4>Die Datei für die MOBILE-Ansicht wurde erstellt</h4>';
}

getButtons($conn, $dir);
