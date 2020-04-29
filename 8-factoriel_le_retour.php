<?php

function calc_fact_no_expo(int $num_fact): array
{
     /* Calcul procédural d'une factorielle dans un tableau
     Au lieu de calc direct sur un float on calc sur chaque case du tableau avec les retenues etc... */

    $fact_precedent = [1];

    for ($i = 1; $i <= $num_fact; $i++) {
        $retenue = 0;
        foreach ($fact_precedent as $key => $value) {
            $fact_resultat[$key] = ($value * $i + $retenue) % 1000;
            $retenue = (int) (($value * $i + $retenue) / 1000);

            if (!isset($fact_resultat[$key + 1]) && $retenue !== 0) {
                $fact_resultat[$key + 1] = $retenue;
            }
        }
        $fact_precedent = $fact_resultat;
    }
    
    return $fact_resultat;
}

function affiche_result(array $fact_resultat): void
{
    foreach (array_reverse($fact_resultat) as $key => $value) {
        if ($key !== 0)
            if($value < 10) $value = "00".$value;
            else if($value < 100) $value = "0".$value;

        if($key < count($fact_resultat) - 1){
            echo "$value,";
        } else {
            echo $value."\n";
        }
    }
}

// Verif des input du script
if ($argc === 2)
    if (is_numeric($argv[1])) {
        $num_fact = (int) $argv[1];
    } else {
        echo "Wrong arguments.\n";
        exit(1);
    }
else {
    echo "Wrong argument number.\n";
    exit(1);
}

affiche_result(calc_fact_no_expo($num_fact));