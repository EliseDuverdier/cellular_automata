<?php

/**
 *   Cellular Automata with 3 states
 */

class CA_3states extends CellularAutomata {

    /**
     * CA_3states constructor
     */
    public function __construct() {
        static::$states = 3;
        static::$order = 1;
        parent::__construct();
    }
}
