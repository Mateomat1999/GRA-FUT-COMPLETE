<?php
function format_mail($kod) {
    return "
    <!DOCTYPE html>
    <html>
        <body>
            <p>Aktywacja na stronie mama.sql.net.pl</p>
            <p>Twój link: http://mama.sql.net.pl/GRA%20FUT%20PI%C5%81KARZE/aktywowanie.php?kod=$kod</p>
        </body>
    </html>";
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=gb18030">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>REJESTRACJA</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <form class="form" method="POST">
    <a href="index.php" style="text-decoration: none">
      <button type="button" name="button" class="przycisk"> Powrót </button>
    </a><br>
    <br>
      <div class="formularz">
        <?php
          if(isset($_POST["login"])) {
            $imie = filter_var($_POST["imie"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $nazwisko = filter_var($_POST["nazwisko"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($_POST["email"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $login = filter_var($_POST["login"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = $_POST["data_urodzenia"];
            $haslo = $_POST["haslo"];
            $blad = false;
            $wiadomosc_bledy = "Rejestracja nie powiodła się!<br><p>";

            if (empty($imie)) {
              $blad = true;
              $wiadomosc_bledy .= "Puste pole [imie] <br>";
            }
            if (empty($nazwisko)) {
              $blad = true;
              $wiadomosc_bledy .= "Puste pole [nazwisko] <br>";
            }
            if (empty($login)) {
              $blad = true;
              $wiadomosc_bledy .= "Puste pole [login] <br>";
            }
            if (strlen($haslo) < 8) {
              $blad = true;
              $wiadomosc_bledy .= "Hasło przynajmniej 8 znaków<br>";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $blad = true;
              $wiadomosc_bledy .= "Niepoprawny email $email<br>";
            }
            $wiadomosc_bledy .= "</p>";

            if (!$blad) {
              $c = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
              if(!$c) {echo "Bd";}
              $haslo2 = password_hash($haslo, PASSWORD_DEFAULT);
              mysqli_query($c, "INSERT INTO `uzytkownicy` (`id_uzytkownik`, `ulubiony_klub`, `imie`, `nazwisko`, `email`, `login`, `haslo`, `data_urodzenia`, `data_zalozenia`, `img`, `monety`, `czy_admin`, `blokada`, `czy_aktywowany`) VALUES (NULL, '', '$imie', '$nazwisko', '$email', '$login', '$haslo2', '$data', CURRENT_TIMESTAMP, '', '0', '0', '0', '0')");
              echo "Pomyslnie dodano użytkownika!!!";
              $q = mysqli_query($c, "SELECT * FROM uzytkownicy WHERE email='$email'");
              $a = mysqli_fetch_array($q);
              $id_uzytkownika = $a["id_uzytkownik"];
              $headers = array();
              $headers[] = "MIME-Version: 1.0";
              $headers[] = "Content-type: text/html; charset=utf-8";
              $headers[] = "From: STRONA_PILKARSKA";
              $headers[] = "Reply-To: {$email}>";
              $headers[] = "Subject: Weryfikacja";
              $headers[] = "X-Mailer: PHP/".phpversion();
              $kod = bin2hex(random_bytes(8));
              mail($email, "Weryfikacja", format_mail($kod), implode("\r\n", $headers));
              mysqli_query($c, "INSERT INTO aktywacja (id_aktywnosc, id_uzytkownika, kod, uzyty) VALUES (NULL, '$id_uzytkownika', '$kod', '0')");
            }
          }
          ?>
        <?= ($blad) ? $wiadomosc_bledy : ""; ?>
        <h1> REJESTRACJA </h1>
        <h2> Imie </h2>
        <input type="text" name="imie" placeholder = "Wpisz imie..."><br>
        <h2> Nazwisko </h2>
        <input type="text" name="nazwisko" placeholder = "Wpisz nazwisko..."><br>
        <h2> E-mail </h2>
        <input type="email" name="email" placeholder = "Wpisz email..."><br><br>
        <h2> Login </h2>
        <input type="text" name="login" placeholder = "Wpisz login..."><br>
        <h2> Haslo </h2>
        <input type="password" name="haslo" placeholder = "Wpisz haslo..."><br>
        <h2> Data urodzenia: </h2>
        <input type="date" name="data_urodzenia"><br><br>
        <input type="submit" class="przycisk"><br><br>
        <input type="reset" class="przycisk"><br><br>
      </div>
    </form><br>
</body>
</html>
