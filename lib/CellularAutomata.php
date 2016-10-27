<?php

/**
 * Cellular Automata Class
 */
class CellularAutomata {

    /** @var int The rule number */
    protected static $rule;

    /** @var int The number of different states */
    protected static $states;

    /** @var int The number of generation to take into account to compute a new cell */
    protected static $order;

    /** @var resource The image */
    protected $theImage;

    /** @var array the "map" representation of the rule. */
    protected $ruleArray;

    /** @var array the resulting array of array */
    protected $matrix;

    /**
     * Constructor
     */
    public function __construct() {
        $this->ruleNumber   = Lib::whichRule(static::$states);
        Lib::checkPossibleRules($this->ruleNumber, static::$states);

        $this->ruleArray    = Lib::ruleToArray($this->ruleNumber, static::$states);

        $size = Lib::getSize();
        $this->columns       = $size['columns'];
        $this->generationsNb = $size['generationsNb'];
        $this->pixelLength   = $size['pixelLength'];

        // colors
        $this->theImage       = ImageCreateTrueColor($this->columns, $this->generationsNb);
        $this->theColor       = Lib::decodeColor(Lib::getColor(), $this->theImage);
        $this->theBgColor     = Lib::decodeColor(Lib::getBgColor(), $this->theImage);
        $this->theMiddleColor = Lib::decodeColor(Lib::getMiddleColor(), $this->theImage);

        // generate
        $this->generate();
        $this->draw();
        $this->display();
    }


    /**
     *  Fill the first line with states, randomly or not
     * @return array of 0s and 1s
     */
    public function getFirstLine() {
        $cells = array();
        for ($i = 0; $i < ($this->columns / $this->pixelLength) ; $i++) {
            if ( Lib::startWithRandomLine()) {
                array_push($cells, rand(0, static::$states - 1));
            } else {
                $middle = intval( ($this->columns / $this->pixelLength) / 2);
                array_push($cells, ($i === $middle ? 1 : 0));
            }
        }
        return $cells;
    }


    /**
     * Calculate the state of a new cell according to the parent cell and its neighbours
     *
     * @param $currentLine {array}: current state of the cells
     * @param $position {int}: index of the array, 0 < i < a.length
     * @return int 0|1  or  0|1|2
     */
    public function newCell($currentLine, $position) : int { // 1st order: 1 line
        $len = count($currentLine);
        if ($position === 0) { // first
            $n = $currentLine[$len-1]*100 + $currentLine[0]*10 + $currentLine[1];
        } else if ($position === $len-1) { // last
            $n = $currentLine[$position-1]*100 +  $currentLine[$position]*10 + $currentLine[0];
        } else {
            $n = $currentLine[$position-1]*100 + $currentLine[$position]*10 + $currentLine[$position+1];
        }
        return $this->ruleArray[bindec($n)]; // number: 0 or 1
    }

    /**
    *    Generate new array
    * @param   {array} at 't'
    * @return  array   at 't+1'
    */
    function nextGeneration($currentCells) : array {
        $newCells = array();
        for ($i = 0 ; $i < count($currentCells) ; $i++) { // for each cell
            $newcellvalue = $this->newCell($currentCells, $i);
            array_push($newCells, $newcellvalue);
        }
        return $newCells;
    }

    /* /**
     * Generate a new generation for the 2nd order
     * @param $currentLine {}
     * @param $position {}
     * @param $t2 {}
     * @return int 0|1
     *
     public function nextGeneration2ndOrder($currentLine, $position, $t2) { // 2st order: 1 line
         $len = count($currentLine);
         if($position == 0) { // first
             $n = $currentLine[$len-1]*1000 + $currentLine[0]*100 + $currentLine[1]*10 + $t2;
         } else if ($position == $len-1) { // last
             $n = $currentLine[$position-1]*1000 +  $currentLine[$position]*100 + $currentLine[0]*10 + $t2;
         } else {
             $n = $currentLine[$position-1]*1000 + $currentLine[$position]*100 + $currentLine[$position+1]*10 + $t2;
         }
         return $this->rulenumber[bindec($n)];
     } //*/


    /**
     *  Generates the matrix of states
     */
    public function generate() {
        $this->matrix = array($this->getFirstLine());
        for ($line = 0 ; $line < $this->generationsNb ; $line++) {
            array_push(
                $this->matrix,
                $this->nextGeneration($this->matrix[$line])
            );
        }
    }


    /**
     * Draws the image from the matrix
     * background, and points
     */
    public function draw() {
        ImageFill($this->theImage, 0, 0, $this->theBgColor);
        for ($line = 0 ; $line < count($this->matrix) ; $line++) {
            for ($cell = 0 ; $cell < count($this->matrix[$line]) ; $cell++) {
                if ($this->matrix[$line][$cell] !== 0) {
                   $x1 = $cell * $this->pixelLength;
                   $y1 = $line * $this->pixelLength;
                   $x2 = $x1 + $this->pixelLength-1;
                   $y2 = $y1 + $this->pixelLength-1;
                   if ($this->pixelLength > 1) {
                       ImageFilledRectangle(
                           $this->theImage,
                           $x1, $y1, $x2, $y2,
                           $this->matrix[$line][$cell] === 1 ? $this->theColor : $this->theMiddleColor
                       );
                   } else {
                       ImageSetPixel(
                           $this->theImage,
                           $cell, $line,
                           $this->matrix[$line][$cell] === 1 ?  $this->theColor : $this->theMiddleColor
                       );
                   }
                }
            }
        }
    }

    /**
     * Displays the image
     */
    public function display() {
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="Rule'.$this->ruleNumber.'.png"');
        ImagePNG($this->theImage);
    }
}
