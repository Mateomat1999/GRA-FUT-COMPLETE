<?php
session_start();
$d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$d) {echo "Błąd";}
?>
 <!DOCTYPE html>
 <html lang="pl">
 <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width">
   <title> LOGOWANIE </title>
   <link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body>
     <form class="form" method="POST">
       <a href="index.php" style="text-decoration: none">
         <button type="button" name="button" class="przycisk"> Powrót </button>
       </a><br>
       <div class="formularz">
         <?php
           if(isset($_POST["login"])) {
             $login = $_POST["login"];
             $haslo = $_POST["haslo"];
             $wiadomosc_bledy = "Logowanie nie powiodło się!<br><p>";
             $blad = false;
             $q = mysqli_query($d, "SELECT * FROM uzytkownicy WHERE login='$login'");
             if (mysqli_num_rows($q)>0) {
               $tablica_uzytkownik = mysqli_fetch_array($q);
               if (password_verify($haslo, $tablica_uzytkownik["haslo"])) {
                 if ($tablica_uzytkownik["blokada"]==0) {
                   if ($tablica_uzytkownik["czy_aktywowany"]) {
                     $_SESSION["id_uzytkownik"] = $tablica_uzytkownik["id_uzytkownik"];
                     $_SESSION["monety"] = $tablica_uzytkownik["monety"];
                     $_SESSION["login"] = $tablica_uzytkownik["login"];
                     $_SESSION["email"] = $tablica_uzytkownik["email"];
                     $_SESSION["imie"] = $tablica_uzytkownik["imie"];
                     $_SESSION["ulubiony_klub"] = $tablica_uzytkownik["ulubiony_klub"];
                     $_SESSION["nazwisko"] = $tablica_uzytkownik["nazwisko"];
                     $_SESSION["data_urodzenia"] = $tablica_uzytkownik["data_urodzenia"];
                     $_SESSION["data_zalozenia"] = $tablica_uzytkownik["data_zalozenia"];
                     if ($tablica_uzytkownik["img"] == "") {
                       $_SESSION["img"] = "user-default.png";
                     } else {
                       $_SESSION["img"] = $_SESSION["id_uzytkownik"].".".$tablica_uzytkownik["img"];
                     }

                     if ($tablica_uzytkownik["czy_admin"]==1) {
                       header("location: panel_administracyjny.php");
                     } else {
                       header("location: index.php");
                     }
                   } else {
                     $blad = true;
                     $wiadomosc_bledy .= "Użytkownik niekatywny, sprawdź swój e-mail";
                   }
                 } else {
                   $blad = true;
                   $wiadomosc_bledy .= "Użytkownik zablokowany";
                 }
               } else {
                 $blad = true;
                 $wiadomosc_bledy .= "Błędny  lub hasło";
               }
             } else {
               $blad = true;
               $wiadomosc_bledy .= "Błędny login lub ";
             }

             $wiadomosc_bledy .= "</p>";
         }
          ?>
          <?= ($blad) ? $wiadomosc_bledy : ""; ?>
         <h1>LOGOWANIE</h1>
          <h2> Login </h2>
          <input type="text" name="login" placeholder="Wpisz login..."><br>
          <h2> Haslo </h2>
          <input type="password" name="haslo" placeholder="Wpisz haslo..."><br><br>
          <input type="submit" value="zaloguj" class="przycisk"><br>
       </div>
     </form>
 </body>
 </html>
