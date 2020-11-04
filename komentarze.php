<?php
session_start();
if(isset($_SESSION['zalogowany'])) {
  $c = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
  if(!$c) {echo "Błąd";}
  $id_uzytkownik = $_SESSION["id_uzytkownik"];
  $id_sklad = $_POST["id_sklad"];
  $tresc = $_POST["tresc"];
  mysqli_query($c, "INSERT INTO `komentarze` (`id_komentarz`, `id_uzytkownik`, `id_sklad`, `tresc`, `data_komentarza`) VALUES (NULL, '$id_uzytkownik', '$id_sklad', '$tresc', CURRENT_TIMESTAMP);");

  header("location: sklady/sklad.php");
}
?>
