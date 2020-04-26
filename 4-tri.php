<?php
/* 
// Solution 1 : Utilisation des fonctions de PHP

// Solution 2 : recoder un tri à bulle 
    Si l'élément suivant est plus grand alors échanger les positions

// Solution 3 : recoder un tri selectif
    On cherche le plus grand et on le met en position, on cherch le deuxième plus grand et on le met en position etc ..
*/

function solution_1_tri_php(array $tableau): array
{
    sort($tableau);
    $tableau = array_reverse($tableau);
    return $tableau;
}

function solution_2_tri_bulle(array $tableau): array
{
    while (true) {

        $tableau_trie = true;
        for ($i = 0; $i < count($tableau) - 1; $i++) {

            if ($tableau[$i] < $tableau[$i + 1]) {
                $tmp = $tableau[$i + 1];
                $tableau[$i + 1] = $tableau[$i];
                $tableau[$i] = $tmp;
                $tableau_trie = false;
            }
        }

        if ($tableau_trie) break;
    }

    return $tableau;
}


function solution_3_tri_selectif(array $tableau): array
{
    $curseur_tri = 0;

    while ($curseur_tri !== (count($tableau))-1) {
        
        $max = 0;
        $posmax = null;

        // Recherche du max à partir de $curseur_tri
        for ($i = $curseur_tri; $i < count($tableau); $i++) {
            if ($tableau[$i] >= $max) {
                $max = $tableau[$i];
                $posmax = $i;
            }
        }

        // On place le max en position $curseur_tri
        $tmp = $tableau[$curseur_tri];
        $tableau[$curseur_tri] = $max;
        $tableau[$posmax] = $tmp;

        $curseur_tri ++;
    }

    return $tableau;
}



$tableau = null;

foreach ($argv as $key => $argument) {
    # code...
    if ($key > 0)
        $tableau[] = (int) $argument;
}

// var_dump($tableau);
echo "Plusieurs tri possibles:
    1- Utilisation des fonctions de sort() et array_reverse()
    2- Tri à bulle
    3- Tri sélectif\n";

$choix = (int) readline("Saisissez votre choix : ");

switch ($choix) {
    case 1:
        # code...
        $tableau = solution_1_tri_php($tableau);
        break;
    case 2:
        # code...
        $tableau = solution_2_tri_bulle($tableau);
        break;
    case 3:
        # code...
        $tableau = solution_3_tri_selectif($tableau);
        break;

    default:
        exit(1);
        break;
}

foreach ($tableau as $key => $value) {
    if ($key == 0)
        echo $value;
    else
        echo " " . $value;
}

echo "\n";
