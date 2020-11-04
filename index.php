<?php
session_start();
$d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$d) {echo "Błąd";}


?>
<!doctype html>

<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STRONA PIŁKARSKA</title>
  <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#2d89ef">
  <meta name="theme-color" content="#000000">
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
<?php if (isset($_SESSION["login"])) { ?>
<h2 class="text-center">
  Witaj <i class="fas fa-user-tie"></i> <?= $_SESSION["imie"]; ?>
  <br>
  <?= $_SESSION["monety"]; ?> <img src="img/coins.png" height="40px" width="40px" alt="monety">
</h2>
<?php } ?>
<div class="napis">
  <h1><i class="far fa-futbol"></i> STRONA PIŁKARSKA <i class="far fa-futbol"></i></h1>
</div>
<?php if (!isset($_SESSION["login"])) { ?>
<div class="rejlog">
  <a href="rejestracja.php" class="przycisk"><i class="fas fa-registered"></i> REJESTRACJA</a>
  <a href="logowanie.php" class="przycisk"><i class="fas fa-sign-in-alt"></i> LOGOWANIE</a>
</div>
<?php } else { ?>
  <div class="rejlog">
    <a href="wylogowanie.php" class="przycisk"><i class="fas fa-sign-out-alt"></i> WYLOGUJ</a>
    <a href="gra-karty" class="przycisk"><i class="fab fa-500px"></i></i> GRA 5 VS 5</a>
  </div>
<?php } ?>
<?php if ($_SESSION["login"] == "admin") { ?>
  <div class="rejlog">
    <a href="panel-admin.php" class="przycisk"><i class="fas fa-user-edit"></i> PANEL ADMINA</a>
  </div>
<?php } ?><br>


<div class="text-center mt-5">
  <span class="h2 text-white">Ostatnie wyniki w grach</span>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <table class="table table-dark">
        <thead>
          <tr>
            <th>QUIZ</th>
            <th>Gracz</th>
            <th>punkty</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $q = mysqli_query($d, "SELECT * FROM wyniki_quiz ORDER BY data DESC LIMIT 8");
          while ($a = mysqli_fetch_array($q)) {
            $data = $a["data"];
            $punkty = $a["punkty"];
            $id_uzytkownik = $a["id_uzytkownik"];
            $q2 = mysqli_query($d, "SELECT * FROM uzytkownicy WHERE id_uzytkownik='$id_uzytkownik'");
            $a2 = mysqli_fetch_array($q2);
            $uzytkownik = $a2["imie"];
          ?>
          <tr>
            <td><?= $data ?></td>
            <td><?= $uzytkownik ?></td>
            <td><?= $punkty ?>/20</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="col-lg-6">
      <table class="table table-dark">
        <thead>
          <tr>
            <th>GRA W  PARY</th>
            <th>Gracz</th>
            <th>ilość rund (mniej=lepiej)</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $q = mysqli_query($d, "SELECT * FROM wyniki_pary ORDER BY data DESC LIMIT 8");
          while ($a = mysqli_fetch_array($q)) {
            $data = $a["data"];
            $punkty = $a["wynik"];
            $id_uzytkownik = $a["id_uzytkownik"];
            $q2 = mysqli_query($d, "SELECT * FROM uzytkownicy WHERE id_uzytkownik='$id_uzytkownik'");
            $a2 = mysqli_fetch_array($q2);
            $uzytkownik = $a2["imie"];
          ?>
          <tr>
            <td><?= $data ?></td>
            <td><?= $uzytkownik ?></td>
            <td><?= $punkty ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="col-lg-6">
      <div class="text-center mt-5">
        <span class="h2 text-white">Udostępnione składy</span>
      </div>
      <table class="table table-dark">
        <thead>
          <tr>
            <th>Gracz</th>
            <th>Skład</th>
            <th>Pokaż</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $q = mysqli_query($d, "SELECT * FROM sklady WHERE udostepniony='1'");
          while ($a = mysqli_fetch_array($q)) {
            $nazwa = $a["nazwa_skladu"];
            $id_sklad = $a["id_sklad"];
            $id_uzytkownik = $a["id_uzytkownik"];
            $q2 = mysqli_query($d, "SELECT * FROM uzytkownicy WHERE id_uzytkownik='$id_uzytkownik'");
            $a2 = mysqli_fetch_array($q2);
            $uzytkownik = $a2["imie"];
          ?>
          <tr>
            <td><?= $uzytkownik ?></td>
            <td><?= $nazwa ?></td>
            <td>
              <a href="sklady/zaladuj.php?id=<?= $id_sklad; ?>" class="btn btn-outline-light">Pokaż</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
$('.left-menu').sliiide({place: 'left', toggle: '#nav-icon'});
</script>
<div class="stopka">
    <h4>&copy; Administratorzy: Mateusz Matusik & Maciej Gołdyn</h4>
</div><br><br>
</body>
</html>
