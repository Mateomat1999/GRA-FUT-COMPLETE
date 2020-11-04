<?php
$c = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$c) {echo "Bd";}

$q = mysqli_query($c, "SELECT * FROM uzytkownicy");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Panel administracyjny</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1 class="display-3 text-center">Panel administracyjny</h1>
  <div class="container">
      <div class="rejlog">
          <a href="index.php" class="przycisk"><i class="fas fa-registered"></i> Powrót</a>
      </div>
    <h2  class="display-4">Użytkownicy</h2>
    <table class="table table-dark">
      <thead>
        <tr>
          <th>E-mail</th>
          <th>Login</th>
          <th>Imię</th>
          <th>Nazwisko</th>
          <th>usuń</th>
          <th>edytuj</th>
          <th>zab / odb</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($uzytkownik = mysqli_fetch_array($q)) { ?>
        <tr>
          <td><?= $uzytkownik["email"] ?></td>
          <td><?= $uzytkownik["login"] ?></td>
          <td><?= $uzytkownik["imie"] ?></td>
          <td><?= $uzytkownik["nazwisko"] ?></td>
          <td>
            <a href="usuwanie-usera.php?id_uzytkownik=<?= $uzytkownik["id_uzytkownik"]; ?>" class="btn btn-outline-light btn-block">Usuń</a>
          </td>
          <td>
            <a href="edycja-usera.php?id_uzytkownik=<?= $uzytkownik["id_uzytkownik"]; ?>" class="btn btn-outline-light btn-block">Edytuj</a>
          </td>
          <td>
            <?php if ($uzytkownik["blokada"]) { ?>
            <a href="odblokuj.php?u=<?= $uzytkownik["id_uzytkownik"]; ?>" class="btn btn-outline-light btn-block">Odblokuj</a>
            <?php } else { ?>
            <a href="blokuj.php?u=<?= $uzytkownik["id_uzytkownik"]; ?>" class="btn btn-outline-light btn-block">Zablokuj</a>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

    <h2 class="display-4">Dodaj pytanie (quiz)</h2>
    <form class="bg-ciemny p-3" method="POST">
      <?php
      if (isset($_POST["pytanie"])) {
        $error = false;
        $error = (empty($_POST["pytanie"])) ? true : $error;
        $error = (empty($_POST["odpa"])) ? true : $error;
        $error = (empty($_POST["odpb"])) ? true : $error;
        $error = (empty($_POST["odpc"])) ? true : $error;
        $error = (empty($_POST["odpd"])) ? true : $error;
        $error = (empty($_POST["poprawna"])) ? true : $error;

        if (!$error) {
          $pytanie = $_POST["pytanie"];
          $odpa = $_POST["odpa"];
          $odpb = $_POST["odpb"];
          $odpc = $_POST["odpc"];
          $odpd = $_POST["odpd"];
          $poprawna = $_POST["poprawna"];
          mysqli_query($c, "INSERT INTO `quiz` (`id_quiz`, `pytanie`, `odpa`, `odpb`, `odpc`, `odpd`, `poprawna`) VALUES (NULL, '$pytanie', '$odpa', '$odpb', '$odpc', '$odpd', '$poprawna')");
          echo "Dodano pytanie do quizu";
        } else {
          echo "Uzupełnij wszystkie pola!";
        }
      }
      ?>
      <div class="form-group">
        <label for="pytanie">Pytanie</label>
        <input type="text" class="form-control" id="pytanie" name="pytanie" placeholder="Pytanie">
      </div>
      <div class="form-group">
        <label for="pytanie">Odpowiedź A</label>
        <input type="text" class="form-control" id="odpa" name="odpa" placeholder="Odpowiedź A">
      </div>
      <div class="form-group">
        <label for="pytanie">Odpowiedź B</label>
        <input type="text" class="form-control" id="odpb" name="odpb" placeholder="Odpowiedź B">
      </div>
      <div class="form-group">
        <label for="pytanie">Odpowiedź C</label>
        <input type="text" class="form-control" id="odpc" name="odpc" placeholder="Odpowiedź C">
      </div>
      <div class="form-group">
        <label for="pytanie">Odpowiedź D</label>
        <input type="text" class="form-control" id="odpd" name="odpd" placeholder="Odpowiedź D">
      </div>
      <div class="form-group">
        <label for="prawidlowa">Prawidłowa</label>
        <input type="text" class="form-control" id="prawidlowa" name="poprawna" aria-describedby="prawidlowaHelp" placeholder="Prawidłowa">
        <small id="prawidlowaHelp" class="form-text text-muted">Podaj liczbę, schemat: A-0 | B-1 | C-2 | D-3</small>
      </div>
      <input type="submit" class="btn btn-outline-light" value="Dodaj">
    </form>

    <h2 class="display-4">Dodawanie zawodnika</h2>
    <form enctype="multipart/form-data" class="bg-ciemny p-3" action="dodaj-zawodnika.php" method="POST">
      <div class="form-row">

        <div class="form-group col-md-4">
          <label for="imie">Imie</label>
          <input type="text" class="form-control" id="imie" name="imie" placeholder="Imie">
        </div>

        <div class="form-group col-md-4">
          <label for="nazwisko">Nazwisko</label>
          <input type="text" class="form-control" id="nazwisko" name="nazwisko" placeholder="Nazwisko">
        </div>

        <div class="form-group col-md-4">
          <label for="ocena">Ocena / Overall</label>
          <input type="text" class="form-control" id="ocena" name="ocena" placeholder="Ocena / Overall">
        </div>

        <div class="form-group col-md-2">
          <label for="pozycja">Pozycja</label>
          <select class="form-control" id="pozycja" name="pozycja">
            <option value="N">N</option>
            <option value="CF">CF</option>
        		<option value="ŚN">ŚN</option>
            <option value="PS">PS</option>
        		<option value="PP">PP</option>
            <option value="LS">LS</option>
        		<option value="LP">LP</option>
            <option value="ŚPO">ŚPO</option>
        		<option value="ŚP/CM">ŚP/CM</option>
            <option value="ŚPD">ŚPD</option>
            <option value="PO">PO</option>
        		<option value="ŚO/CB">ŚO/CB</option>
            <option value="LO">LO</option>
            <option value="BR">BR</option>
          </select>
        </div>

        <div class="form-group col-md-4">
          <label for="narodowosc">Narodowość piłkarza</label>
          <input type="text" class="form-control" id="narodowosc" name="narodowosc" placeholder="Narodowość piłkarza">
        </div>

        <div class="form-group col-md-3">
          <label for="data_urodzenia">Data urodzenia</label>
          <input type="date" class="form-control" id="data_urodzenia" name="data_urodzenia">
        </div>

        <div class="form-group col-md-3">
          <label for="jakosc_karty">Jakość karty</label>
          <select class="form-control" id="jakosc_karty" name="jakosc_karty">
            <option value="LEGENA/IKONA">LEGENA/IKONA</option>
            <option value="TOTY (Team of the year)">TOTY (Team of the year)</option>
            <option value="TOTW (Team of the week)">TOTW (Team of the week)</option>
            <option value="UEFA CHAMPIONS LEAGUE">UEFA CHAMPIONS LEAGUE</option>
            <option value="WARCI UWAGI">WARCI UWAGI</option>
            <option value="RZADKA ZŁOTA">RZADKA ZŁOTA</option>
        		<option value="ZŁOTA">ZŁOTA</option>
            <option value="SREBRNA">SREBRNA</option>
        		<option value="BRĄZOWA">BRĄZOWA</option>
          </select>
        </div>

        <div class="form-group col-md-3">
          <label for="wartosc">Wartość zawodnika</label>
          <input type="text" class="form-control" id="wartosc" name="wartosc" placeholder="Wartość zawodnika">
        </div>

        <div class="form-group col-md-9">
          <label for="klub">Klub</label>
          <input type="text" class="form-control" id="klub" name="klub" placeholder="Nazwa klubu">
        </div>

        <div class="form-group col-md-2">
          <label for="ocena">PAC/TEM</label>
          <input type="number" class="form-control" id="ocena" name="pac_tem" min="1" max="99" placeholder="PAC/TEM">
        </div>

        <div class="form-group col-md-2">
          <label for="ocena">STR/SHO</label>
          <input type="number" class="form-control" id="ocena" name="str_sho" min="1" max="99" placeholder="STR/SHO">
        </div>

        <div class="form-group col-md-2">
          <label for="ocena">PAS/POD</label>
          <input type="number" class="form-control" id="ocena" name="pas_pod" min="1" max="99" placeholder="PAS/POD">
        </div>

        <div class="form-group col-md-2">
          <label for="ocena">DRI/DRY</label>
          <input type="number" class="form-control" id="ocena" name="dri_dry" min="1" max="99" placeholder="DRI/DRY">
        </div>

        <div class="form-group col-md-2">
          <label for="ocena">DEF/OBR</label>
          <input type="number" class="form-control" id="ocena" name="def_obr" min="1" max="99" placeholder="DEF/OBR">
        </div>

        <div class="form-group col-md-2">
          <label for="ocena">PHY/FIZ</label>
          <input type="number" class="form-control" id="ocena" name="phy_fiz" min="1" max="99" placeholder="PHY/FIZ">
        </div>

      </div>

      <div class="form-group">
        <label for="zyciorys">Życiorys</label>
        <textarea class="form-control" id="zyciorys" name="zyciorys" rows="8" cols="80"></textarea>
      </div>

      <fieldset class="form-group">
        <div class="row">
          <legend class="col-form-label col-sm-2 pt-0">Lepsza noga</legend>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="noga" id="nogaPrawa" value="1" checked>
              <label class="form-check-label" for="nogaPrawa">
                Prawa
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="noga" id="nogaLewa" value="0">
              <label class="form-check-label" for="nogaLewa">
                Lewa
              </label>
            </div>
          </div>
        </div>
      </fieldset>

      <div class="form-group">
        <label for="fileToUpload">Dodaj zdjęcie zawodnika</label>
        <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload">
      </div>
      <input type="submit" class="btn btn-outline-light" value="Dodaj zawodnika">

    </form>
</body>
</html>
