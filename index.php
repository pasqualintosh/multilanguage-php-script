<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<p>
<?php
/*
 * Converts CSV to JSON
 */
error_reporting(E_ERROR | E_PARSE);
header('Content-type: application/json');
$REPLACE_ARRAY= ["ç", "+", " ", ",", ":", "!", ".", "/", "'", "(", ")", "[", "]", "’", "<", ">", "%", "#", "-", "=", "  ", "*", "?", "!", " "];

/**
 * Function to convert CSV into associative array
 */
function csvToArray($file, $delimiter) { 
  if (($handle = fopen($file, 'r')) !== FALSE) { 
    $i = 0; 
    while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) { 
      for ($j = 0; $j < count($lineArray); $j++) { 
        $arr[$i][$j] = $lineArray[$j]; 
      } 
      $i++; 
    } 
    fclose($handle); 
  } 
  return $arr; 
} 

$ln_to_in = [
  'en' => 4,
  'it' => 5,
  'es' => 6,
  'ct' => 7,
  'pt' => 8
];

/**
 * Start
 */

$data = csvToArray("./tournament.csv", ',');


foreach ($ln_to_in as $lan => $ind) {
  echo $lan . ':{<br>';
    $labels = [];
    
    for ($i=1; $i < sizeof($data); $i++) { 
      if($data[$i][3] < 10) {
        $label = "id_" . $data[$i][1] . "_0" . $data[$i][3];
      }
      else {
        $label = "id_" . $data[$i][1] . "_" . $data[$i][3];
      }
      $value = $data[$i][$ind];
      $value = str_replace('"', "'", $value);
      if($value == "") {
        $value = $data[$i][5]; // 5 diventera' 4 perche' in futuro il lang di default sara eng
        $value = str_replace('"', "'", $value);
      }
      array_push($labels, $label);
      echo $label . ":" . '"' . $value . '",<br>';
    
    }
    
    echo '},';
    $json .= '},';
}

?>

 </p> 
</body>
</html>

