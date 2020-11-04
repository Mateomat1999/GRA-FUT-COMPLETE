<?php
session_start();
if (!isset($_SESSION['id_uzytkownik'])) {
  header("location: logowanie.php");
  exit();
}
$c = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$c) {echo "Bd";}
$id_zawodnik = $_GET["id_zawodnik"];
$id_uzytkownik = $_SESSION['id_uzytkownik'];
$q = mysqli_query($c, "SELECT * FROM zawodnicy WHERE id_zawodnik='$id_zawodnik'");
$a = mysqli_fetch_array($q);

function kolor($punkty) {
  if ($punkty >= 80) {
    return "bg-success";
  } elseif ($punkty >= 60) {
    return "bg-warning";
  } else {
    return "bg-danger";
  }
}

if (isset($_GET["like"])) {
  $wartosc = $_GET["like"];
  $q2 = mysqli_query($c, "SELECT * FROM oceny_pilkarzy WHERE id_uzytkownik = '$id_uzytkownik' AND id_zawodnik = '$id_zawodnik'");
  if (mysqli_num_rows($q2)>0) {
    echo "Nie możesz ocenić drugi raz!";
  } else {
    mysqli_query($c, "INSERT INTO `oceny_pilkarzy` (`id_ocena_pilkarza`, `id_uzytkownik`, `id_zawodnik`, `wartosc`, `data_oceny`) VALUES (NULL, '$id_uzytkownik', '$id_zawodnik', '$wartosc', CURRENT_TIMESTAMP)");
  }
}


$oceny_like = mysqli_query($c, "SELECT * FROM oceny_pilkarzy WHERE id_zawodnik ='$id_zawodnik' AND wartosc = 1");
$oceny_unlike = mysqli_query($c, "SELECT * FROM oceny_pilkarzy WHERE id_zawodnik ='$id_zawodnik' AND wartosc = 0");
$like = 0;
$unlike = 0;
while ($a2 = mysqli_fetch_array($oceny_like)) {
  $like++;
}
while ($a2 = mysqli_fetch_array($oceny_unlike)) {
  $unlike++;
}
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
  <style>
    .zyciorys {
        text-align: justify;
        text-justify: inter-word;
        font-size: 20px;

    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <a href="wszyscy-zawodnicy.php" class="btn btn-outline-light mt-3 btn-block">Powrót</a>
      </div>
      <div class="col-md-9">
        <h1 class="text-center mt-3"><?= $a["imie"]." ".$a["nazwisko"]; ?></h1>
      </div>
      <div class="col-md-3">
        <img src="img/karty/<?= $a["zdjecie"]; ?>" class="img-fluid d-block m-auto" alt="">
      </div>
      <div class="col-md-9">
        <ul class="list-group mt-4">
          <li class="list-group-item list-group-item-dark">Klub: <b><?= $a["klub"]; ?></b></li>
          <li class="list-group-item list-group-item-dark">Narodowość: <b><?= $a["narodowosc"]; ?></b></li>
          <li class="list-group-item list-group-item-dark">Pozycja: <b><?= $a["pozycja"]; ?></b></li>
          <li class="list-group-item list-group-item-dark">Lepsza noga: <b><?= ($a["lepsza_noga"]) ? "Prawa" : "Lewa"; ?></b></li>
          <li class="list-group-item list-group-item-dark">Jakość: <b><?= $a["jakosc"]; ?></b></li>
        </ul>
      </div>
      <div class="col-md-6 mt-3">
        <h3 class="text-center">Punkty tempa</h3>
        <div class="progress" style="height: 20px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated <?= kolor($a["punkty_tempa"]); ?>" role="progressbar" aria-valuenow="<?= $a["punkty_tempa"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a["punkty_tempa"]; ?>%"><?= $a["punkty_tempa"]; ?></div>
        </div>
      </div>
      <div class="col-md-6 mt-3">
        <h3 class="text-center">Punkty dryblingu</h3>
        <div class="progress" style="height: 20px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated <?= kolor($a["punkty_dryblingu"]); ?>" role="progressbar" aria-valuenow="<?= $a["punkty_dryblingu"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a["punkty_dryblingu"]; ?>%"><?= $a["punkty_dryblingu"]; ?></div>
        </div>
      </div>
      <div class="col-md-6 mt-3">
        <h3 class="text-center">Punkty strzału</h3>
        <div class="progress" style="height: 20px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated <?= kolor($a["punkty_strzalu"]); ?>" role="progressbar" aria-valuenow="<?= $a["punkty_strzalu"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a["punkty_strzalu"]; ?>%"><?= $a["punkty_strzalu"]; ?></div>
        </div>
      </div>
      <div class="col-md-6 mt-3">
        <h3 class="text-center">Punkty obrony</h3>
        <div class="progress" style="height: 20px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated <?= kolor($a["punkty_obrony"]); ?>" role="progressbar" aria-valuenow="<?= $a["punkty_obrony"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a["punkty_obrony"]; ?>%"><?= $a["punkty_obrony"]; ?></div>
        </div>
      </div>
      <div class="col-md-6 mt-3">
        <h3 class="text-center">Punkty podań</h3>
        <div class="progress" style="height: 20px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated <?= kolor($a["punkty_podan"]); ?>" role="progressbar" aria-valuenow="<?= $a["punkty_podan"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a["punkty_podan"]; ?>%"><?= $a["punkty_podan"]; ?></div>
        </div>
      </div>
      <div class="col-md-6 mt-3">
        <h3 class="text-center">Punkty fizyczności</h3>
        <div class="progress" style="height: 20px;">
          <div class="progress-bar progress-bar-striped progress-bar-animated <?= kolor($a["punkty_fizycznosci"]); ?>" role="progressbar" aria-valuenow="<?= $a["punkty_fizycznosci"]; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $a["punkty_fizycznosci"]; ?>%"><?= $a["punkty_fizycznosci"]; ?></div>
        </div>
      </div>

    </div><br>
    <div style="text-align: center">
      <a href="?like=1&id_zawodnik=<?= $id_zawodnik; ?>" class="btn btn-outline-light mt-2 btn-block" style="width: 150px; float: left;"><i class="far fa-thumbs-up" style="height: 100px; width: 100px;"></i><br><?= $like; ?></a>
      <a href="?like=0&id_zawodnik=<?= $id_zawodnik; ?>" class="btn btn-outline-light mt-2 btn-block" style="width: 150px; float: left;"><i class="far fa-thumbs-down" style="height: 100px; width: 100px;"></i><br><?= $unlike; ?></a>
    </div><br><br><br><br><br><br>

    <p class="zyciorys bg-dark rounded p-3 mt-4"><?= $a["zyciorys"]; ?></p>
  </div>
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
</body>
</html>
