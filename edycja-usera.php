<?php
session_start();
$d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$d) {echo "Błąd";}

if (!isset($_SESSION['login'])) {
header("location: logowanie.php");
exit();
}
$id_uzytkownik=$_GET['id_uzytkownik'];

if (isset($_POST["imie"])) {
  $imie = $_POST["imie"];
  $nazwisko = $_POST["nazwisko"];
  $login = $_POST["login"];
  $ulubiony_klub = $_POST["klub"];
  $error = false;
  $error = (empty($imie)) ? true : $error;
  $error = (empty($nazwisko)) ? true : $error;
  $error = (empty($login)) ? true : $error;
  $error = (empty($ulubiony_klub)) ? true : $error;

  if (!$error) {
    mysqli_query($d, "UPDATE uzytkownicy SET imie='$imie', nazwisko='$nazwisko', login='$login',ulubiony_klub='$ulubiony_klub' WHERE id_uzytkownik='$id_uzytkownik'");
    $wiadomosc = "Edytowano dane";
  } else {
    $wiadomosc = "Nie zostawiaj pustych miejsc w wymaganych polach";
  }

}


$sprawdzanie=mysqli_query($d, "SELECT * FROM uzytkownicy WHERE id_uzytkownik='$id_uzytkownik'");
$odczyt = mysqli_fetch_array($sprawdzanie);
?>

<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>STRONA PIŁKARSKA</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="shortcut icon" type="image/png" href="pliki/img/favicon.png"/>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1 class="display-3 text-center">Edytuj dane użytkownika <?= $odczyt["imie"]; ?></h1>
    <div class="row mt-5">
      <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
        <a href="panel-admin.php" class="btn btn-outline-light btn-block">Wróć do konta</a>
        <form method="POST">
          <div class="form-group">
            <label for="imie">Imie</label>
            <input type="text" class="form-control" id="imie" name="imie" placeholder="Nowe imie" value="<?= $odczyt["imie"]; ?>">
           </div>
           <div class="form-group">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" placeholder="Nowe nazwisko" value="<?= $odczyt["nazwisko"]; ?>">
           </div>
           <div class="form-group">
             <label for="klub">Ulubiony klub</label>
             <input type="text" class="form-control" id="klub" name="klub" placeholder="Nowy ulubiony klub" value="<?= $odczyt["ulubiony_klub"]; ?>">
           </div>
           <div class="form-group">
             <label for="login">login</label>
             <input type="text" class="form-control" id="login" name="login" placeholder="Nowy login" value="<?= $odczyt["login"]; ?>">
           </div>
           <input type="submit" class="btn btn-outline-light btn-block" name="submit" value="Aktualizuj dane">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
