<?php

/**
 *
 *  Cellular Automata
 *
 */
require('init.php');

try {

    $cellularAutomata = new CA_2states();

} catch (Exception $e) {

    echo $e->getMessage();

}
