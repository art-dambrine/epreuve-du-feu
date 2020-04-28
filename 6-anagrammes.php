<?php

/* 
    Repérer les anagrammes
*/

function string_tri_bulle(string $mot): string
{
    // tri à bulle ordre alphabetique
    while (true) {
        $tri_ok = true;
        for ($i = 0; $i < strlen($mot) - 1; $i++) {
            if ($mot[$i] > $mot[$i + 1]) {
                $tmp = $mot[$i + 1];
                $mot[$i + 1] = $mot[$i];
                $mot[$i] = $tmp;
                $tri_ok = false;
            }
        }
        if ($tri_ok) break;
    }
    return $mot;
}


// Verifs et lecture du fichier
if ($argc > 2)
    if (is_string($argv[1]) && file_exists($argv[2])) {
        $mot = $argv[1];
        $fichier_mots = $argv[2];
        $fichier_mots = file_get_contents($fichier_mots);

        /* Split le contenu du fichier à chaque fin de ligne 
        (regex "/\r\n|\r|\n/") (fonctionne avec windows, mac, linux) */
        $liste_mots = preg_split("/\r\n|\r|\n/", $fichier_mots);
    } else {
        echo "Argument 1 : \"mot\" et argument 2 : /PATH/TO/FILE.\n";
        exit(1);
    } else exit(1);



$mot_trie = string_tri_bulle(strtolower($mot));

foreach ($liste_mots as $key => $mot_de_liste) {

    $liste_mots_trie[$key] = string_tri_bulle(strtolower($mot_de_liste));
}

$anagrammes = null;

foreach ($liste_mots_trie as $key => $mot_de_liste_trie) {
    if ($mot_de_liste_trie === $mot_trie)
        $anagrammes[] = $liste_mots[$key];
}

if ($anagrammes !== null) {
    echo "Les anagrammes trouvés sont les suivants : \n";
    foreach ($anagrammes as $anagramme) {
        echo " - $anagramme\n";
    }
} else {
    echo "Pas d'anagramme trouvé\n";
}
