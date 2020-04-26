<?php

function fichier_parallelepipede_to_array(string $parallelepipede): array
{
    $ligne = 0;
    for ($i = 0; $i < strlen($parallelepipede); $i++) {
        if (is_numeric($parallelepipede[$i])) {
            $forme_array[$ligne][] = (int)$parallelepipede[$i];
        } else if ($parallelepipede[$i] === "\n") {
            $ligne++;
        }
    }
    return $forme_array;
}

// Verif des paramètres d'entrée

if ($argc > 2)
    if (file_exists($argv[1]) && file_exists($argv[2])) {
        $fichier_carre = $argv[1];
        $fichier_rectangle = $argv[2];
        $fichier_carre = file_get_contents($fichier_carre);
        $fichier_rectangle = file_get_contents($fichier_rectangle);
    } else {
        echo "Les deux arguments d'entrée doivent être des noms de fichiers valides.\n";
        exit(1);
    } else exit(1);



$carre = fichier_parallelepipede_to_array($fichier_carre);
$rectangle = fichier_parallelepipede_to_array($fichier_rectangle);
