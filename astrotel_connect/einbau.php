<?php
include('../admin/data_list.php');
$connect	= @mysql_connect($mysql_host, $mysql_user, $mysql_password);
$db			= @mysql_select_db($mysql_dbname);

include("funktionen.php");
?>

<!doctype html>
<html lang="de">

<head>
	<link rel="stylesheet" type="text/css" href="../admin/style.css" />
	<style>
		body {
			font-size: 16px;
			color: #fff;
			text-align: center;
		}

		div.einbau {
			width: 80%;
			margin: auto;
			text-align: left;
			margin-top: 30px;
		}
	</style>
</head>

<body>
	<div class="einbau">
		<strong>Headbereich</strong>
		<br>
		<br>
		<pre><code>&lt;head&gt;</code></pre>
		<br>
		<pre><code>&lt;!-- PFLICHT --&gt;</code></pre>
		<pre><code>&lt;link rel="stylesheet" type="text/css" href="<?php echo $url; ?>astrotel_connect/style.connect.css" /&gt;</code></pre>
		<br>
		<br>
		<pre><code>&lt;!-- OPTIONAL: Wenn die Icons von Font Awesome in der Version 4.7.0 nicht vorhanden sind --&gt;</code></pre>
		<pre><code>&lt;link rel="stylesheet" type="text/css" href="https://www.libraries.net-booking.de/awesome/css/font-awesome.css" /&gt;</code></pre>
		<br>
		<br>
		<pre><code>&lt;!-- OPTIONAL: Wenn jQuery nicht vorhanden, oder kleiner als Version 1.5.1 ist --&gt;</code></pre>
		<pre><code>&lt;script src="https://www.libraries.net-booking.de/jquery/jquery-3.3.1.min.js"&gt;&lt;/script&gt;</code></pre>
		<br>
		<br>
		<pre><code>&lt;!-- OPTIONAL: Wenn die Fonts: Lato 900 und Roboto Condensed 400 nicht vorhanden sind --&gt;</code></pre>
		<pre><code>&lt;link rel="stylesheet" type="text/css" href="https://www.libraries.net-booking.de/font.css" /&gt;</code></pre>
		<br>
		<br>
		<pre><code>&lt;!-- OPTIONAL: Bei Verwendung der Kalenderauswahl auf der Homepage --&gt;</code></pre>
		<pre><code>&lt;link rel="stylesheet" href="https://www.libraries.net-booking.de/jquery/jquery-ui.css"&gt;
&lt;script src="https://www.libraries.net-booking.de/jquery/jquery-ui.js"&gt;&lt;/script&gt;
&lt;script&gt;
$( function() {  
	$('.datepicker').datepicker({
		minDate: -0, maxDate: "+1Y", dateFormat:'d.mm.yy',
		prevText: '&#x3c;zur&uuml;ck', prevStatus: '',
		prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
		nextText: 'Vor&#x3e;', nextStatus: '',
		nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
		currentText: 'heute', currentStatus: '',
		todayText: 'heute', todayStatus: '',
		clearText: '-', clearStatus: '',
		closeText: 'schlie&szlig;en', closeStatus: '',
		monthNames: ['Januar','Februar','M&auml;rz','April','Mai','Juni',
		'Juli','August','September','Oktober','November','Dezember'],
		monthNamesShort: ['Jan','Feb','M&auml;r','Apr','Mai','Jun',
		'Jul','Aug','Sep','Okt','Nov','Dez'],
		dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
		dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
		showMonthAfterYear: false
	});
});
&lt;/script&gt;
</code></pre>
		<br>
		<pre><code>&lt;/head&gt;</code></pre>
		<br>
		<br>
		<strong>Inhaltsbereich</strong>
		<br>
		<br>
		<pre><code>&lt;body&gt;</code></pre>
		...<br>
		...<br>
		...<br>
		<pre><code>&lt;!-- PFLICHT: Vor dem schlie�endem Body-Tag --&gt;</code></pre>
		<pre><code>&lt;script src="<?php echo $url; ?>astrotel_connect/libraries/js.astrotel.js"&gt;&lt;/script&gt;</code></pre>
		<pre><code>&lt;/body&gt;</code></pre>
		<br>
		<br>
		<strong>Links</strong>
		<br>
		<br>
		<?php
		$sql_menu = "SELECT * FROM " . $TabMenu . " ORDER BY template_id asc";
		$result_menu = mysql_query($sql_menu);
		//$row_menu = mysql_fetch_array($result_menu);

		while ($row_menu	= @mysql_fetch_array($result_menu)) {
			$typ = "";
			$mask_main = "";
			$html_name = $row_menu['html_name'];
			$html_name = eregi_replace('&', '&amp;', $html_name);

			if ($row_menu['template_id'] == 20 or $row_menu['template_id'] == 22 or $row_menu['template_id'] == 24 or $row_menu['template_id'] == 25 or $row_menu['template_id'] == 27) {

				if ($row_menu['template_id'] == 20) {
					$typ = "Reservierung: ";
					$mask_main = "main";
				} else if ($row_menu['template_id'] == 22) {
					$typ = "Angebot: ";
					$mask_main = "arr";
				} else if ($row_menu['template_id'] == 24 or $row_menu['template_id'] == 25) {
					$typ = "Produkte: ";
					$mask_main = "pro";
				} else if ($row_menu['template_id'] == 27) {
					$typ = "Tischreservierung: ";
					$mask_main = "tisch";
				}
				echo "<pre><code>&lt;!-- " . $typ . $row_menu['titel'] . " --&gt;</code></pre>
		<pre><code>	&lt;!-- Im neuen Fenster --&gt;</code></pre>
		<pre><code>	" . $url . $html_name . "</code></pre><br>
		<pre><code>	&lt;!-- Bei Einbau in die Homepage --&gt;</code></pre>
		<pre><code>	&lt;a href=\"#" . $row_menu['id'] . "\" class=\"mask_" . $mask_main . "\"&gt;</code></pre>";

				echo "<br><br>";
			}
		}
		?>
	</div>
</body>