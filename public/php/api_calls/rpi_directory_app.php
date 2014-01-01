<?
$DIRECTORY_API_URL = "http://rpidirectory.appspot.com/api";

function getYogFromClass($class) {
  $currentDate = new DateTime;
  $yog = (int)$currentDate->format("Y");
  if ((int)$currentDate->format("m") > 5) {
    $yog += 1;
  }
  switch($class) {
  case "first-year student":
    $yog += 3;
    break;
  case "sophomore":
    $yog += 2;
    break;
  case "junior":
    $yog += 1;
    break;
  case "senior":
    break;
  }
  return $yog;
}

function getUserFromDirectory($rcsid) {
  global $db; // PDO defined in "db/init.php"
  global $DIRECTORY_API_URL;

  // Request from the RPI Directory app
  // See https://github.com/jewishdan18/RPI-Directory/wiki/API-Documentation
  $directoryResponse = json_decode(
    file_get_contents("$DIRECTORY_API_URL?q=$rcsid"));

  foreach ($directoryResponse->data as $user) {
    // Only accept an exact match
    if ($user->rcsid != $rcsid) continue;

    return $user;
  }
  return false;
}
?>
