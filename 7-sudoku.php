<?php

function init_sudoku(array $array_str_sudoku): array
{
    // Chargement du fichier s.txt dans un tableau 2D
    $line = 0;
    foreach ($array_str_sudoku as $str_sudoku_line) {
        if (is_numeric($str_sudoku_line[0]) || $str_sudoku_line[0] === "_") {
            $col = 0;
            for ($i = 0; $i < strlen($str_sudoku_line); $i++) {
                if (is_numeric($str_sudoku_line[$i]) || $str_sudoku_line[$i] === "_") {
                    $sudoku[$line][$col] = (int) $str_sudoku_line[$i];
                    $col++;
                }
            }
            $line++;
        }
    }
    return $sudoku;
}

function init_map_groupes(): array
{
    // mapping des groupes, le sudoku est un tableau 2D de dimension 9*9
    $col_depart = 0;
    $line_depart = 0;
    $num_groupe = 0;

    while ($line_depart !== 9) {
        while ($col_depart !== 9) {
            for ($y = $line_depart; $y < $line_depart + 3; $y++) {
                for ($x = $col_depart; $x < $col_depart + 3; $x++) {
                    $map[$y][$x] = $num_groupe;
                }
            }
            $col_depart = $col_depart + 3;
            $num_groupe++;
        }
        $col_depart = 0;
        $line_depart = $line_depart + 3;
    }

    return $map;
}

function resoudre_line(array $sudoku, array $coord, $debug = false): array
{
    // Coordonnées en entrées correspondent à la case à remplacer
    for ($i = 0; $i < 9; $i++) {
        $groupe[] = $sudoku[$coord[0]][$i];
    }

    // Trouver le chiffre manquant dans le $groupe
    $diff = array_diff(range(1, 9), $groupe);
    if (count($diff) === 1) {
        if ($debug) echo "Debug: resolution par ligne n°{$coord[0]} (coord: {$coord[0]},{$coord[1]}).\n";
        $sudoku[$coord[0]][$coord[1]] = array_shift($diff);
    } else {
        if ($debug) echo "Debug: pas de resolution par ligne n°{$coord[0]} (coord: {$coord[0]},{$coord[1]}).\n";
    }

    return $sudoku;
}

function resoudre_col(array $sudoku, array $coord, $debug = false): array
{
    // Coordonnées en entrées correspondent à la case à remplacer
    for ($i = 0; $i < 9; $i++) {
        $groupe[] = $sudoku[$i][$coord[1]];
    }

    // Trouver le chiffre manquant dans le $groupe
    $diff = array_diff(range(1, 9), $groupe);
    if (count($diff) === 1) {
        if ($debug) echo "Debug: resolution par colonne n°{$coord[1]} (coord: {$coord[0]},{$coord[1]}).\n";
        $sudoku[$coord[0]][$coord[1]] = array_shift($diff);
    } else {
        if ($debug) echo "Debug: pas de resolution par colonne n°{$coord[1]} (coord: {$coord[0]},{$coord[1]}).\n";
    }

    return $sudoku;
}

function resoudre_groupe(array $sudoku, array $map_groupes, array $coord, $debug = false): array
{
    $num_groupe = $map_groupes[$coord[0]][$coord[1]];

    for ($y = 0; $y < 9; $y++) {
        for ($x = 0; $x < 9; $x++) {
            if ($map_groupes[$y][$x] === $num_groupe) {
                $groupe[] = $sudoku[$y][$x];
            }
        }
    }

    // Trouver le chiffre manquant dans le $groupe
    $diff = array_diff(range(1, 9), $groupe);
    if (count($diff) === 1) {
        if ($debug) echo "Debug: resolution par groupe (groupe $num_groupe (coord: {$coord[0]},{$coord[1]})).\n";
        $sudoku[$coord[0]][$coord[1]] = array_shift($diff);
    } else {
        if ($debug) echo "Debug: pas de resolution par groupe (groupe $num_groupe (coord: {$coord[0]},{$coord[1]})).\n";
    }

    return $sudoku;
}

function affiche_grille(array $sudoku): void
{
    // Affiche le sudoku dans le terminal à partir du tableau 2D
    for ($y = 0; $y < 9; $y++) {
        for ($x = 0; $x < 9; $x++) {

            if ($sudoku[$y][$x] === 0) echo '_';
            else echo $sudoku[$y][$x];

            if ($x == 2 || $x == 5)
                echo '|';
        }
        echo "\n";
        if ($y == 2 || $y == 5) {
            for ($i = 0; $i < 11; $i++)
                echo "-";
            echo "\n";
        }
    }
}

function in_array_recursive($needle, $haystack, $strict = false): bool
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_recursive($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}


// Verifs et lecture du fichier
if ($argc === 2)
    if (is_string($argv[1])) {
        $fichier_sudoku = $argv[1];
        $fichier_sudoku = file_get_contents($fichier_sudoku);

        $fichier_sudoku = preg_split("/\r\n|\r|\n/", $fichier_sudoku);
    } else {
        echo "Argument (only one): /PATH/TO/FILE.\n";
        exit(1);
    } else exit(1);

// Configuration
$sudoku = init_sudoku($fichier_sudoku);
$map_groupes = init_map_groupes();
$iteration_max = 100;

echo "Nous allons résoudre le Sudoku suivant :\n\n";
affiche_grille($sudoku);
echo "\n";

$debug_mode = readline("Voulez vous un affichage en mode debug (y/N) ");

if (strtolower($debug_mode) === 'y')
    $debug_mode = true;
else
    $debug_mode = false;


// Tant qu'il y a des '0' dans le sudoku on continue ou que le sudoku ne peut pas être résolu en moins de $iteration_max
$iteration = 0;
while (in_array_recursive(0, $sudoku, true)) {
    for ($y = 0; $y < 9; $y++) {
        for ($x = 0; $x < 9; $x++) {
            if ($sudoku[$y][$x] === 0)
                $sudoku = resoudre_line($sudoku, [$y, $x], $debug_mode);
            if ($sudoku[$y][$x] === 0)
                $sudoku = resoudre_col($sudoku, [$y, $x], $debug_mode);
            if ($sudoku[$y][$x] === 0)
                $sudoku = resoudre_groupe($sudoku, $map_groupes, [$y, $x], $debug_mode);
        }
    }

    if( ($iteration++) === $iteration_max){
        echo "\nATTENTION: ce Sudoku ne peut pas être résolu en moins de $iteration_max itérations :/\n";
        break;  
    } 
}

echo "\nSolution du sudoku : \n\n";
affiche_grille($sudoku);
