<?php

/**
 * 2nd order cellular automata with two states
 */

class CA_2order extends CellularAutomata {

    /**
     * CA_2states constructor.
     */
    public function __construct() {
        static::$states = 2;
        static::$order = 2;
        parent::__construct();
    }
}
