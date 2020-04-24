<?php 
// Factoriel en récursif
// Rappel calcul factoriel exemple: 4! = 1*2*3*4

function calcul_factoriel(int &$nombrefact, int &$resultat)
{
    $resultat = $nombrefact * $resultat;
    $nombrefact = $nombrefact - 1;

    if($nombrefact == 0 ){
        return $resultat;
    }
        
    calcul_factoriel($nombrefact,$resultat);
}

$nombrefact = (int)$argv[1];
$resultat = 1;

calcul_factoriel($nombrefact,$resultat);

echo "Le factoriel de {$argv[1]}! est $resultat.\n";