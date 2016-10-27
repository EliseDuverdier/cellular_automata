<?php

/**
 * Class Lib
 */
class Lib {

    /** @var int Maximum number of rules */
    private static $maxRule;
    
    /**
     * Get parameters from $_GET
     */
    public static function getColor() {
        return $_GET['color'] ?? '#000000';
    }
    public static function getBgColor() {
        return $_GET['bgcolor'] ?? '#ffffff';
    }
    public static function getMiddleColor() {
        return $_GET['middlecolor'] ?? '#aacc00';
    }
    public static function getRandomStart() {
        return $_GET['randomstart'] ?? true;
    }
    public static function getPixelSize() {
        return $_GET['pixel'] ?? 1;
    }
    public static function getWidth() {
        return $_GET['width'] ?? 400;
    }
    public static function getHeight() {
        return $_GET['height'] ?? 400;
    }
    public static function getRandomRule() {
        return $_GET['random'] ?? null;
    }
    public static function getRuleNumber() {
        return $_GET['rule'] ?? null;
    }


    /**
     * Check if the rule number is in the bound
     * @param {int} the rule
     * @param {int} the number of states of the automata
     *
     * @throws {ErrorException}
     * @return void
     */
    public static function checkPossibleRules($rule, $states) {
        self::$maxRule = 2 ** $states ** 3;
        if (!is_null($rule) && $rule > self::$maxRule){
            throw new ErrorException('There is only '. self::$maxRule.' possible rules.', 1);
        }
    }


    /**
     * Returns a rule number, from the paramater or randomly
     * @param {int} the number of states
     * @return int
     */
    public static function whichRule($states) : int {
//        $preferedRule = ($states === 2 ? 110 : 1819);
        return self::getRuleNumber() === null || self::getRuleNumber() == 0 ?
            rand(0, (2 ** $states ** 3)) : intval(self::getRuleNumber());
    }


    /**
     * Returns the dimension of the final image, and the length of a pixel
     * @return array  column, generationsNb, pixelLength
     */
    public static function getSize() : array {
        $columns       = self::getWidth();
        $generationsNb = self::getHeight();

        if (intval(self::getPixelSize()) > 1){
            $pixelLength = intval(self::getPixelSize());
            $columns *= $pixelLength;
            $generationsNb *= $pixelLength;
        } else {
            $pixelLength = 1;
        }
        return array(
            'columns'       => $columns,
            'generationsNb' => $generationsNb,
            'pixelLength'   => $pixelLength,
        );
    }


    /**
     * Returns true if the first line is a single point, false if random points
     * @return bool
     */
    public static function startWithRandomLine() : bool {
        return self::getRandomStart() == true;
    }


    /**
     * The index, when in bin[/trin]ary, will represent the state of the three current cells,
     *  and the number (0/1[/2]), will represent the state of the resulting cell.
     *
     * @param {int} $ruleNumber
     * @param {int} $states      digital base
     * @return array  an "associative" array corresponding to the rule number.
     */
    public static function ruleToArray($ruleNumber, $states) : array {
        $toBaseN = sprintf("%08d", intval(base_convert( $ruleNumber, 10, $states )));
        return array_reverse(str_split(strval($toBaseN)));
    }



    /**
     * Decode Color from string, either rrr,vvv,bbb or #rrvvbb
     * and allocate this color to the Image resource
     *
     * @param {string}   $color    color in hexa or decimal format.
     * @param {resource} $theImage the image resource
     *
     * @throws Exception if the format could not be understood
     *
     * @return int (ImageColorAllocate)
     */
    public static function decodeColor($color, $theImage) : int {
        preg_match('/#([0-9a-fA-F]+)/i', $color, $match_hexa);
        preg_match('/\d+,\d+,\d+/i', $color, $match_rgb);
        if (count($match_hexa) > 0){ // #CCDD99
            $hexaNbs = str_split($match_hexa[1], 2);
            return ImageColorAllocate($theImage,
                intval(base_convert($hexaNbs[0], 16, 10)),
                intval(base_convert($hexaNbs[1], 16, 10)),
                intval(base_convert($hexaNbs[2], 16, 10))
            );
        } else if (count($match_rgb) > 0) {  // rgb(200,220,180)
            $colorNbs = explode(',', $color);
            return ImageColorAllocate($theImage,
                intval($colorNbs[0]),
                intval($colorNbs[1]),
                intval($colorNbs[2])
            );
        } else {
            throw new Exception('The color '.$color.' could not be decoded.');
        }
    }

}
