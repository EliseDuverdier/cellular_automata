<?php

/**
 *   Cellular Automata: 2 states
 */

class CA_2states extends CellularAutomata {

    /**
     * CA_2states constructor
     */
    public function __construct() {
        static::$states = 2;
        static::$order = 1;
        parent::__construct();
    }
}
