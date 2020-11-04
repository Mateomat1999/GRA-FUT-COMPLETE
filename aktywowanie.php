<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta http-equiv="refresh" content="2; URL=logowanie.php">
  <title>Aktywacja</title>
</head>
<body>
  <?php
    if(isset($_GET["kod"])) {
      $d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
      $kod = $_GET["kod"];
      $a = mysqli_query($d, "SELECT * FROM aktywacja WHERE kod='$kod' AND uzyty='0'");
      if(mysqli_num_rows($a) > 0) {
        $b = mysqli_fetch_array($a);
        $c = $b["id_aktywnosc"];
        mysqli_query($d, "UPDATE aktywacja SET uzyty = '1' WHERE id_aktywnosc = $c");
        $id = $b["id_uzytkownika"];
        mysqli_query($d, "UPDATE uzytkownicy SET czy_aktywowany = '1' WHERE id_uzytkownik = '$id'");

        echo "Twoje konto zostało aktywowane :D";
      }
    }
  ?>
</body>
</html>
