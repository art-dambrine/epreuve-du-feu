<?php
// Le script doit parcourir lettre par lettre la chaîne
// Si l'indice est impair, on change la lettre en maj
// Si l'indice est pair, on change la lettre en minuscule

$phrase = null;

foreach ($argv as $key => $argument) {
    if ($key == 1)
        $phrase = $phrase . $argument;
    if ($key > 1)
        $phrase = $phrase . " " . $argument;
}


for ($i=0; $i < strlen($phrase); $i++) { 
    if ($i%2 == 0)
        $phrase[$i] = strtolower($phrase[$i]);
    else
        $phrase[$i] = strtoupper($phrase[$i]);
}

echo $phrase."\n";
