<?php
session_start();
if (!isset($_SESSION['id_uzytkownik'])) {
  header("location: logowanie.php");
  exit();
}
$c = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$c) {echo "Bd";}

$id_uzytkownik = $_SESSION["id_uzytkownik"];

if (isset($_GET["id"])) {
  $id_zawodnik = $_GET["id"];
  $q = mysqli_query($c, "SELECT * FROM zawodnicy WHERE id_zawodnik='$id_zawodnik'");
  $a = mysqli_fetch_array($q);

  if ($_SESSION["monety"] < $a["wartosc_zawodnika_monety"]) {
    $w = "Nie stać cię na tego zawodnika";
  } else {
    $_SESSION["monety"] -= $a["wartosc_zawodnika_monety"];
    $monety = $_SESSION["monety"];
    mysqli_query($c, "INSERT INTO `kupieni` (`id_kupieni`, `id_uzytkownik`, `id_zawodnik`) VALUES (NULL, '$id_uzytkownik', '$id_zawodnik')");
    mysqli_query($c, "UPDATE uzytkownicy SET monety='$monety' WHERE id_uzytkownik='$id_uzytkownik'");
  }
}


$zawodnicy = mysqli_query($c, "SELECT * FROM zawodnicy");
?>
<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GRA PIŁKARSKA</title>
  <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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
              <a href="WYNIKI\index.php" class="h3" role="button" aria-pressed="true"><i class="fas fa-poll-h"></i> WYNIKI MŚ</a>
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
<script>

$('.left-menu').sliiide({place: 'left', toggle: '#nav-icon'});
</script>

  <div class="container">
    <?= $w ?>
    <div class="row">
      <?php while ($a = mysqli_fetch_array($zawodnicy)) {
        $id_zawodnik = $a["id_zawodnik"];
        $q = mysqli_query($c, "SELECT * FROM kupieni WHERE id_zawodnik='$id_zawodnik' AND id_uzytkownik='$id_uzytkownik'");
        ?>
      <div class="col-lg-2 col-md-3 col-sm-4 col-6 p-0">
        <div class="bg-light-80 m-2 p-2 rounded border">
          <a href="info-zawodnik.php?id_zawodnik=<?= $a["id_zawodnik"]; ?>">
            <img src="img/karty/<?= $a["zdjecie"]; ?>" class="img-fluid miniatura" alt="">
          </a>
          <div class="text-center">
            <img src="img/coins.png" class="img-fluid" width="30" alt="monety">
            <span><?= $a["wartosc_zawodnika_monety"]; ?></span>
          </div>
          <?php if (mysqli_num_rows($q)>0) { ?>
            <span class="btn btn-sm btn-success btn-block mt-2">Posiadany</span>
          <?php } else { ?>
            <a href="?id=<?= $a["id_zawodnik"]; ?>" class="btn btn-sm btn-outline-light btn-block mt-2">Kup</a>
          <?php } ?>
        </div>

      </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>
