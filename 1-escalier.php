<?php
/* 
    En PHP $argv correspond au tabeau d'arguments
    passés au script.

    $argv[0] correspond au nom du script
    $argv[1] correpond au premier argument

    NOTE: comportement similaire à BASH
*/


$nbSteps = (int) $argv[1];

for ($i = 0; $i < $nbSteps; $i++) {
    echo str_repeat(" ",($nbSteps-$i-1)) . str_repeat("#", $i+1) . "\n";
}
