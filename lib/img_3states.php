<?php

/**
 *
 *  Cellular Automata
 *
 */
require('init.php');

try {

    $cellularAutomata = new CA_3states();

} catch (Exception $e) {

    echo $e->getMessage();

}
