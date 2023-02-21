<?php
session_start();

$gelenSecim = $_GET["dilSecimi"];

$_SESSION["siteDili"] = $gelenSecim;

header("Location: index.php");
exit();
?>