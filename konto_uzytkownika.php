  <?php
session_start();
$d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$d) {echo "Błąd";}
if (!isset($_SESSION['login'])) {
  header("location: logowanie.php");
  exit();
}
$id_uzytkownik = $_SESSION["id_uzytkownik"];

if (isset($_SESSION["wiadomosc_konto_u"])) {
  $wiadomosc = $_SESSION["wiadomosc_konto_u"];
  unset($_SESSION["wiadomosc_konto_u"]);
}

if (isset($_GET["sprzedaj"])) {
  $id = $_GET["sprzedaj"];
  $monety = $_GET["m"]+$_SESSION["monety"];
  $_SESSION["monety"] = $monety;
  mysqli_query($d, "DELETE FROM kupieni WHERE id_zawodnik = '$id' AND id_uzytkownik = '$id_uzytkownik'");
  mysqli_query($d, "UPDATE uzytkownicy SET monety = '$monety' WHERE id_uzytkownik = '$id_uzytkownik'");
  $_SESSION["wiadomosc_konto_u"] = "Sprzedano zawodnika za ".$_GET["m"]." monet.";
  header("location: konto_uzytkownika.php");
  exit();
}


$zawodnicy = mysqli_query($d, "SELECT * FROM zawodnicy");
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STRONA PIŁKARSKA</title>
  <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="shortcut icon" type="image/png" href="pliki/img/favicon.png"/>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="nav-icon">
      <span><i class="fa fa-bars"></i></span>
  </div>
  <div class="left-menu">
      <ul>
          <li>
            <a href="index.php" class="h3" role="button" aria-pressed="true"><i class="fas fa-home"></i> STRONA GŁÓWNA</a>
          </li>
          <li>
              <a href="sklady" class="h3" role="button" aria-pressed="true"><i class="fas fa-hammer"></i> ZŁÓŻ SKŁAD</a>
          </li>
          <li>
              <a href="wszyscy-zawodnicy.php" class="h3" role="button" aria-pressed="true"><i class="fas fa-globe"></i> WSZYSCY ZAWODNICY</a>
          </li>
          <li>
              <a href="quiz" class="h3" role="button" aria-pressed="true"><i class="fas fa-clipboard-list"></i> QUIZ</a>
          </li>
          <li>
              <a href="WYNIKI/index.php" class="h3" role="button" aria-pressed="true"><i class="fas fa-poll-h"></i> WYNIKI MŚ</a>
          </li>
          <li>
              <a href="gra-pary/gra.php" class="h3" role="button" aria-pressed="true"><i class="fas fa-crosshairs"></i> GRA W PARY</a>
          </li>
          <?php if (isset($_SESSION["login"])) { ?>
          <li>
              <a href="konto_uzytkownika.php" class="h3" role="button" aria-pressed="true"><i class="fas fa-user-cog"></i> KONTO</a>
          </li>
          <?php } ?>
      </ul>
  </div>
<script src="jquery.min.js"></script>
<script src="sliiide.min.js"></script>
<div class="napis">
  <h1>TWOJE KONTO</h1>
</div>
<?php if (isset($_SESSION["login"])) { ?>
<h2 class="text-center">
  Użytkownik: <?= $_SESSION["imie"]; ?>
  <br>
  <?= $_SESSION["monety"]; ?> <img src="img/coins.png" height="40px" width="40px" alt="monety">
</h2>
<?php } ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <img src="img/users/<?= $_SESSION["img"]; ?>" alt="" class="img-fluid d-block my-3 mx-auto">
      </div>
      <div class="col-md-6 offset-md-3">
        <table class="table table-dark">
          <tbody>
            <tr>
              <th>Imię</th>
              <td><?= $_SESSION["imie"]; ?></td>
            </tr>
            <tr>
              <th>Nazwisko</th>
              <td><?= $_SESSION["nazwisko"]; ?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?= $_SESSION["email"]; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-md-4 offset-md-4">
      <a href="user-edytuje.php" class="btn btn-outline-light btn-block">Edytuj dane</a>
    </div>
    <div>
      <?php if($wiadomosc) { ?>
        <p class="bg-dark text-center p-3 my-3"><?= $wiadomosc; ?></p>
      <?php } ?>
    </div>
    <br>
    <h1 style="text-align: center">POSIADANI ZAWODNICY:</h1><br>
    <div class="row">
      <?php while ($a = mysqli_fetch_array($zawodnicy)) {
        $id_zawodnik = $a["id_zawodnik"];
        $q = mysqli_query($d, "SELECT * FROM kupieni WHERE id_zawodnik='$id_zawodnik' AND id_uzytkownik='$id_uzytkownik'");
        if (mysqli_num_rows($q)>0) {
        ?>
      <div class="col-lg-2 col-md-3 col-sm-4 col-6 p-0">
        <div class="bg-light-80 m-2 p-2 rounded border">
          <img src="img/karty/<?= $a["zdjecie"]; ?>" class="img-fluid miniatura" alt="">
          <div class="text-center">
            <img src="img/coins.png" class="img-fluid" width="30" alt="monety">
            <span><?= $a["wartosc_zawodnika_monety"]; ?></span>
          </div>
          <a href="?sprzedaj=<?= $a["id_zawodnik"]; ?>&m=<?= $a["wartosc_zawodnika_monety"]/2 ; ?>" class="btn btn-sm btn-outline-light btn-block mt-2"><img src="img/coins.png" class="img-fluid" width="30" alt="monety"><?= $a["wartosc_zawodnika_monety"]/2 ; ?>  Sprzedaj</a>
        </div>
      </div>
    <?php }} ?>
    </div>
  </div><br><br>
<script>
$('.left-menu').sliiide({place: 'left', toggle: '#nav-icon'});
</script>
<div class="stopka">
    <h4>&copy; Administratorzy: Mateusz Matusik & Maciej Gołdyn</h4>
</div>
</body>
</html>
