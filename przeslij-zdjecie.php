<?php
session_start();
$d = @mysqli_connect("localhost","mama_projekt","zaq1@WSX","mama_projekt_pilkarze");
if(!$d) {echo "Błąd";}

$id_user = $_SESSION["id_uzytkownik"];

$postName = "image";
$uploadDirectory = "img/users/";
$allowedType = ["image/png", "image/jpeg"];
$allowedExtension = ["png", "jpg", "jpeg"];
$newName = $id_user;

try {
  $fileName = $_FILES[$postName]["name"];
  $fileSize = $_FILES[$postName]["size"];
  $fileError = $_FILES[$postName]["error"];
  $fileTmpName = $_FILES[$postName]["tmp_name"];
  $fileType = $_FILES[$postName]["type"];
  $fileExtension = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
  $targetfile = $uploadDirectory."/".$newName.".".$fileExtension;

  if (!isset($_FILES[$postName])) {
    throw new Exception("Błąd wysłania pliku");
  }

  switch ($fileError) {
    case UPLOAD_ERR_OK:
      break;

    case UPLOAD_ERR_NO_FILE:
      throw new Exception("Nie przesłano pliku");
      break;

    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      throw new Exception("Za duży rozmiar maksymalny to 10 MB");
      break;

    default:
      throw new Exception("Wystąpił błąd podczas przesyłania");
      break;
  }

  if ($fileSize > 10000000) {
    throw new Exception("Za duży rozmiar maksymalny to 10 MB");
  }

  if (!in_array($fileType, $allowedType)) {
    throw new Exception("Dozwolone rozszerzenia plików to png, jpg, jpeg2");
  }

  if (!in_array($fileExtension, $allowedExtension)) {
    throw new Exception("Dozwolone rozszerzenia plików to png, jpg, jpeg");
  }

  if (!is_uploaded_file($fileTmpName)) {
    throw new Exception("Możliwy atak podczas przesyłania zdjęcia");
  }

  if(!move_uploaded_file($fileTmpName, $targetfile)) {
    throw new Exception("Wystąpił błąd podczas przesyłania");
  }



  $_SESSION["wiadomosc_zdjecie"] = "Pomyślnie zmieniono zdjęcie";
  mysqli_query($d, "UPDATE uzytkownicy SET img='$fileExtension' WHERE id_uzytkownik'$id_user'");
  $_SESSION["img"] = $id_user.".".$fileExtension;
} catch (Exception $e) {
  $_SESSION["wiadomosc_zdjecie"] = $e->getMessage();
}
header("location: user-edytuje.php");
