<?php
session_start();

if (!isset($_SESSION['login'])) {
header("location: logowanie.php");
exit();
}

if (isset($_POST["submit"])) {
  $imie = $_POST["imie"];
  $nazwisko = $_POST["nazwisko"];
  $login = $_POST["login"];
  $email = $_POST["email"];
  $ulubiony_klub = $_POST["klub"];
  $id_uzytkownik =  $_SESSION["id_uzytkownik"];
  $error = false;
  $error = (empty($imie)) ? true : $error;
  $error = (empty($nazwisko)) ? true : $error;
  $error = (empty($login)) ? true : $error;
  $error = (empty($email)) ? true : $error;
  $error = (empty($ulubiony_klub)) ? true : $error;

  if (!$error) {
    $_SESSION["imie"] = $imie;
    $_SESSION["nazwisko"] = $nazwisko;
    $_SESSION["login"] = $login;
    $_SESSION["email"] = $email;
    $_SESSION["ulubiony_klub"] = $ulubiony_klub;
    $d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
    if(!$d) {echo "Błąd";}
    mysqli_query($d, "UPDATE uzytkownicy SET imie='$imie', nazwisko='$nazwisko', login='$login', email='$email', ulubiony_klub='$ulubiony_klub' WHERE id_uzytkownik='$id_uzytkownik'");
    $wiadomosc = "Edytowano dane";
  } else {
    $wiadomosc = "<span style=\"color: red;\">Nie zostawiaj pustych miejsc</span>";
  }

}
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
    <h1 class="display-3 text-center">Edytuj swoje dane</h1>
    <div class="row mt-5">
      <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
        <a href="konto_uzytkownika.php" class="btn btn-outline-light btn-block">Wróć do konta</a>
        <form method="POST">
          <span><?= $wiadomosc; ?></span>
          <div class="form-group">
            <label for="imie">Imie</label>
            <input type="text" class="form-control" id="imie" name="imie" placeholder="Nowe imie" value="<?= $_SESSION["imie"]; ?>">
           </div>
           <div class="form-group">
            <label for="nazwisko">Nazwisko</label>
            <input type="text" class="form-control" id="nazwisko" name="nazwisko" placeholder="Nowe nazwisko" value="<?= $_SESSION["nazwisko"]; ?>">
           </div>
           <div class="form-group">
             <label for="email">Email</label>
             <input type="text" class="form-control" id="email" name="email" placeholder="Nowy e-mail " value="<?= $_SESSION["email"]; ?>">
           </div>
           <div class="form-group">
             <label for="klub">Ulubiony klub</label>
             <input type="text" class="form-control" id="klub" name="klub" placeholder="Nowy ulubiony klub" value="<?= $_SESSION["ulubiony_klub"]; ?>">
           </div>
           <div class="form-group">
             <label for="login">login</label>
             <input type="text" class="form-control" id="login" name="login" placeholder="Nowy login" value="<?= $_SESSION["login"]; ?>">
           </div>
           <input type="submit" class="btn btn-outline-light btn-block" name="submit" value="Aktualizuj dane">
        </form>
        <form class="border p-2 mt-3" action="przeslij-zdjecie.php" method="post" enctype="multipart/form-data">
          <?php if (isset($_SESSION["wiadomosc_zdjecie"])) {
            echo $_SESSION["wiadomosc_zdjecie"];
            unset($_SESSION["wiadomosc_zdjecie"]);
          } ?>
          <div class="form-group">
            <img src="img/users/<?= $_SESSION["img"]; ?>" class="img-fluid d-block mx-auto" alt="zdjęcie profilowe">
            <label for="image">Wybierz zdjęcie</label>
            <input type="file" class="form-control-file" name="image" id="image">
          </div>
          <input type="submit" class="btn btn-success btn-block" value="Dodaj zdjęcie">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
