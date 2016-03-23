<?php

/**
 * Copyright (c) 2015, Muhannad Shelleh
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN 
 * THE SOFTWARE.
 */

namespace ItvisionSy\StringNumbers;

/**
 * A class that helps to convert string to numbers and vice versa
 *
 * @author Muhannad Shelleh <muhannad.shelleh@live.com>
 */
class StringNumbers {

    protected static $map = [
        'zero' => '0',
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9',
        'ten' => '10',
        'eleven' => '11',
        'twelve' => '12',
        'thirteen' => '13',
        'fourteen' => '14',
        'fifteen' => '15',
        'sixteen' => '16',
        'seventeen' => '17',
        'eighteen' => '18',
        'nineteen' => '19',
        'twenty' => '20',
        'thirty' => '30',
        'fourty' => '40', // common misspelling
        'forty' => '40',
        'fifty' => '50',
        'sixty' => '60',
        'seventy' => '70',
        'eighty' => '80',
        'ninety' => '90',
        'hundreds' => '100',
        'hundred' => '100',
        'thousands' => '1000',
        'thousand' => '1000',
        'millions' => '1000000',
        'million' => '1000000',
        'billions' => '1000000000',
        'billion' => '1000000000',
        'trillions' => '1000000000000',
        'trillion' => '1000000000000',
    ];
    protected static $betweenerMap = [
        'a' => '1',
        'and' => ''
    ];
    protected static $char = null;

    public static function numbersToWords($string) {
        $result = preg_replace_callback('/\d+/', function($matches) {
            return static::convertDigitsString($matches[0]);
        }, static::wordsToNumbers($string));
        return $result;
    }

    public static function wordsToNumbers($string) {

        //reverse the string
        $reversedString = strrev($string);

        //prepare the result holders
        $word = "";
        $chunk = "";
        $finishedChunks = [];

        //loop the chars
        foreach (str_split($reversedString) as $index => $char) {
            static::$char = $char;
            //check if the char should join the chunk or the final
            if (preg_match('/[0-9a-zA-Z]/', $char)) { //if an accepted word char
                static::addNewWordChar($word, $chunk, $finishedChunks);
            } else {
                static::addNewNotWordChar($word, $chunk, $finishedChunks);
            }
        }
        static::processCurrentWord($word, $chunk, $finishedChunks, true);

        return trim(join("", array_reverse($finishedChunks)));
    }

    protected static function addNewWordChar(&$word, &$chunk, array &$finishedChunks = []) {
        $word.=static::$char;
    }

    protected static function addNewNotWordChar(&$word, &$chunk, array &$finishedChunks = []) {
        if (static::processCurrentWord($word, $chunk, $finishedChunks)) {
            $finishedChunks[] = static::$char;
        }
    }

    protected static function processCurrentWord(&$word, &$chunk, array &$finishedChunks = [], $terminated = false) {
        $word = strrev($word);
        $lWord = strtolower($word);
        $changed = false;
        if (is_numeric(trim($word)) || array_key_exists(trim($lWord), static::$map) || $chunk && array_key_exists(trim($lWord), static::$betweenerMap)) {
            $chunk.=" " . trim($lWord);
            if ($terminated) {
                $chunk = trim($chunk);
                $changed = static::processChunk($chunk, $finishedChunks);
            }
        } else {
            $changed = static::processChunk($chunk, $finishedChunks);
            if (trim($word)) {
                $changed = !!($finishedChunks[] = $word);
            }
        }
        $word = "";
        return $changed;
    }

    protected static function processChunk(&$chunk, array &$finishedChunks = []) {
        $changed = false;
        if (strlen(trim($chunk)) > 0) {
            $parts = array_reverse(explode(" ", trim($chunk)));
            $parsed = trim(static::convertWordsString($parts));
            $finishedChunks[] = $parsed;
            $finishedChunks[] = " ";
            $changed = true;
        }
        $chunk = "";
        return $changed;
    }

    protected static function convertWordsString(array $parts) {
        $result = $sectionResult = $partialResult = 0;
        $multiplyer = $sectionMultiplyer = 1;
        foreach (array_reverse($parts) as $part) {
            $part = (int) (is_numeric($part) ? $part : (array_key_exists($part, static::$map) ? static::$map[$part] : (array_key_exists($part, static::$betweenerMap) ? static::$betweenerMap[$part] : '')))? : '';
            if ($part >= 1000) { //new section
                $sectionResult += $partialResult ? $partialResult * $multiplyer : ($multiplyer > 1 ? $multiplyer : 0);
                $sectionResult *= $sectionMultiplyer;
                $result += $sectionResult;
                $sectionResult = $partialResult = 0;
                $multiplyer = 1;
                $sectionMultiplyer = $part;
            } elseif ($part == 100) {
                $sectionResult+=$partialResult;
                $partialResult = 0;
                $multiplyer = 100;
            } elseif ($part) {
                $partialResult+=$part;
            }
        }
        $sectionResult += $partialResult ? $partialResult * $multiplyer : ($multiplyer > 1 ? $multiplyer : 0);
        return (string) ($result + ($sectionResult ? $sectionMultiplyer * $sectionResult : ($sectionMultiplyer > 1 ? $sectionMultiplyer : 0)));
    }

    protected static function convertDigitsString($digits) {
        $digits = (int) $digits;
        $multiplier = 1;
        $result = [];
        $flippedMap = array_flip(static::$map);
        if ($digits === 0) {
            return $flippedMap[(string) $digits];
        }
        while ($digits) {
            $section = $digits % 1000; //current section
            $t0 = $section % 10; //first digit
            $t1 = ($section % 100) - $t0; //second digit
            $t2 = $section - $t1 - $t0; //third digit
            $sectionResult = array_merge([], ($multiplier > 1 && array_key_exists($multiplier, $flippedMap) ? [$flippedMap[$multiplier]] : []), ($t1 == 10 ? [$flippedMap[$t1 + $t0]] : ($t0 && array_key_exists($t0, $flippedMap) ? [$flippedMap[$t0]] : [])), ($t1 && $t1 !== 10 && array_key_exists($t1, $flippedMap) ? [$flippedMap[$t1]] : []), ($t2 ? [$flippedMap['100'], $flippedMap[(string) ($t2 / 100)]] : []));
            $result[] = join(" ", array_reverse($sectionResult));
            $multiplier*=1000;
            $digits = floor($digits / 1000);
        }
        return trim(join(" ", array_reverse($result)));
    }

}
