<?php
  session_start();
  $d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
  if(!$d) {echo "Błąd";}
  $ID = $_GET['id_uzytkownik'];
  mysqli_query($d, "DELETE FROM uzytkownicy WHERE uzytkownicy.id_uzytkownik='$ID'");
  header ("location: panel-admin.php");
?>
