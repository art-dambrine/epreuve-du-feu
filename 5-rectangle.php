<?php

function fichier_parallelepipede_to_array(string $parallelepipede): array
{
    $ligne = 0;
    for ($i = 0; $i < strlen($parallelepipede); $i++) {
        if (is_numeric($parallelepipede[$i])) {
            $forme_array[$ligne][] = (int) $parallelepipede[$i];
        } else if ($parallelepipede[$i] === "\n") {
            $ligne++;
        }
    }
    return $forme_array;
}


function compare_ligne(array $ligne_carre, array $ligne_rectangle): int
{
    /* 
     fonction qui vérifie si la ligne du carre est comprise dans la ligne du rectangle
        si la ligne est comprise, va retourner la position $offset_col de la ligne carre dans la ligne rectangle
        sinon retourner -1
    */

    $offset_col = 0;
    $comparaison_valide = 0;
    $largeur_carre = count($ligne_carre);

    while ($offset_col < count($ligne_rectangle)) {

        if ($ligne_carre[$comparaison_valide] === $ligne_rectangle[$offset_col + $comparaison_valide]) {
            $comparaison_valide++;
            // echo "Debug: comparaison_valide = $comparaison_valide, offset = $offset_col\n";

            if ($comparaison_valide === $largeur_carre)
                return $offset_col;
        } else {
            $comparaison_valide = 0;
            $offset_col++;
        }
    }

    return -1;
}


function compare_carre(array $carre, array $rectangle): ?array
{
    /* 
        Si le carre est inclut dans le rectangle on retourne sa position
        sinon on retourne null
    */

    $offset_col = null;
    $offset_col_precedent = null;
    $offset_line = 0;
    $comparaison_valide = 0;
    $longeur_carre = count($carre);

    while ($offset_line < count($rectangle)) {

        $offset_col = (compare_ligne($carre[$comparaison_valide], $rectangle[$offset_line + $comparaison_valide]));

        if ($offset_col !== -1) {

            if ($comparaison_valide === 0) {
                // echo "Debug: Ligne $offset_line + $comparaison_valide est ok\n";
                $comparaison_valide++;
            }

            if ($comparaison_valide > 0 && $offset_col === $offset_col_precedent) {
                // echo "Debug : Ligne $offset_line + $comparaison_valide est ok ";
                // echo "&& \$offset_col === \$offset_col_precedent\n";
                $comparaison_valide++;
            }


            if ($comparaison_valide === $longeur_carre) return ["offset_line" => $offset_line, "offset_col" => $offset_col];
        } else {
            $comparaison_valide = 0;
            $offset_line++;
        }

        $offset_col_precedent = $offset_col;
    }

    return null;
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


$resultat = compare_carre($carre, $rectangle);

if ($resultat === null) {
    echo "Le carre n'est pas inclut dans le rectangle :( \n";
} else {
    echo "Le carre est inclut dans le rectangle à la ligne ". ($resultat['offset_line']+1) ." et colonne " . ($resultat['offset_col']+1) . "\n";
}
