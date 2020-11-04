<?php
$target_dir = "img/karty/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) {
    echo "Plik jest obrazem - " . $check["mime"] . ".";
} else {
    echo "Plik nie jest obrazem.";
    $uploadOk = 0;
}

if (file_exists($target_file)) {
    echo "Przepraszamy, plik już istnieje.";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 99999999) {
    echo "Niestety, Twój plik jest zbyt duży.";
    $uploadOk = 0;
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Niestety, dozwolone są tylko pliki JPG, JPEG, PNG";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Niestety, Twój plik nie został przesłany.";

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $c = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
        if(!$c) {echo "Bd";}
        $imie = $_POST["imie"];
        $nazwisko = $_POST["nazwisko"];
        $ocena = $_POST["ocena"];
        $pozycja = $_POST["pozycja"];
        $narodowosc = $_POST["narodowosc"];
        $data_urodzenia = $_POST["data_urodzenia"];
        $jakosc_karty = $_POST["jakosc_karty"];
        $wartosc = $_POST["wartosc"];
        $klub = $_POST["klub"];
        $pac_tem = $_POST["pac_tem"];
        $str_sho = $_POST["str_sho"];
        $pas_pod = $_POST["pas_pod"];
        $dri_dry = $_POST["dri_dry"];
        $def_obr = $_POST["def_obr"];
        $phy_fiz = $_POST["phy_fiz"];
        $noga = $_POST["noga"];
        $zyciorys = filter_var($_POST["zyciorys"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nazwa = basename( $_FILES["fileToUpload"]["name"]);
        mysqli_query($c, "INSERT INTO `zawodnicy` (`id_zawodnik`, `imie`, `nazwisko`, `overall`, `data_urodzenia`, `klub`, `narodowosc`, `pozycja`, `lepsza_noga`, `wartosc_zawodnika_monety`, `punkty_tempa`, `punkty_strzalu`, `punkty_podan`, `punkty_dryblingu`, `punkty_obrony`, `punkty_fizycznosci`, `zyciorys`, `jakosc`, `zdjecie`) VALUES (NULL, '$imie', '$nazwisko', '$ocena', '$data_urodzenia', '$klub', '$narodowosc', '$pozycja', '$noga', '$wartosc', '$pac_tem', '$str_sho', '$pas_pod', '$dri_dry', '$def_obr', '$phy_fiz', '$zyciorys', '$jakosc_karty', '$nazwa')");
        echo "Ten plik ". basename( $_FILES["fileToUpload"]["name"]). " został wysłany";
    } else {
        echo "Niestety wystąpił błąd podczas przesyłania Twojego pliku.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Dodawanie</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <a href="panel-admin.php">Wróć do panelu</a>
    <ul class="list-group">
      <li class="list-group-item list-group-item-secondary"><?= $imie ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $nazwisko ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $ocena ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $pozycja ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $narodowosc ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $data_urodzenia ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $jakosc_karty ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $wartosc ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $klub ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $pac_tem ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $str_sho ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $pas_pod ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $dri_dry ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $def_obr ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $phy_fiz ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $noga ?></li>
      <li class="list-group-item list-group-item-secondary"><?= $zyciorys ?></li>
    </ul>
  </div>
</body>
</html>
