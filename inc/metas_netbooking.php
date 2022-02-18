<?php
unset($metas);

$metas[] = "<!-- CSS + Fonts -->";
$metas[] = "<link href=\"" . $url . "style.css\" rel=\"stylesheet\" type=\"text/css\">";
$metas[] = "<link href=\"" . $url . "libs/awesome/css/font-awesome.css\" rel=\"stylesheet\" type=\"text/css\">";

$metas[] = "<!-- jQuery -->";
$metas[] = "<script src=\"" . $url . "libs/jquery/jquery-3.3.1.min.js\"></script>";

$metas[] = "<!-- jQuery UI -->";
$metas[] = "<link href=\"" . $url . "libs/jquery/jquery-ui.css\" rel=\"stylesheet\" type=\"text/css\">";
$metas[] = "<script src=\"" . $url . "libs/jquery/jquery-ui.js\"></script>";

$metas[] = "<!-- JS -->";
$metas[] = "<script defer src=\"" . $url . "js.default.js\"></script>";
