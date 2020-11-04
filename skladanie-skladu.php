<!doctype html>

<html lang="pl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GRA PIŁKARSKA</title>
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
            <a href="index.php" class="h3" role="button" aria-pressed="true">STRONA GŁÓWNA</a>
          </li>
          <li>
              <a href="sklady.php" class="h3" role="button" aria-pressed="true">ZŁÓŻ SKŁAD</a>
          </li>
          <li>
              <a href="wszyscy-zawodnicy.php" class="h3" role="button" aria-pressed="true">WSZYSCY ZAWODNICY</a>
          </li>
          <li>
              <a href="quiz" class="h3" role="button" aria-pressed="true">QUIZ</a>
          </li>
          <li>
              <a href="WYNIKI\index.php" class="h3" role="button" aria-pressed="true">WYNIKI MŚ</a>
          </li>
          <li>
              <a href="gra-pary/gra.php" class="h3" role="button" aria-pressed="true">GRA W PARY</a>
          </li>
          <li>
              <a href="konto_uzytkownika.php" class="h3" role="button" aria-pressed="true">KONTO</a>
          </li>
      </ul>
  </div>
<script src="jquery.min.js"></script>
<script src="sliiide.min.js"></script>
<script>

$('.left-menu').sliiide({place: 'left', toggle: '#nav-icon'});
</script>

<div class="stopka">
    <h4>&copy; Administratorzy: Mateusz Matusik & Maciej Gołdyn</h4>
</div>
</body>
</html>
