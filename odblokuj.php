<?php

$id_uzytkownik = $_GET["u"];
$d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$d) {echo "Błąd";}
mysqli_query($d, "UPDATE uzytkownicy SET blokada=0 WHERE id_uzytkownik='$id_uzytkownik'");
header("location: panel-admin.php");
