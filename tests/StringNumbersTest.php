<?php

use ItvisionSy\StringNumbers\StringNumbers;

class StringNumbersTest extends PHPUnit_Framework_TestCase {

    public function __construct($name = null, array $data = array(), $dataName = '') {
        require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        parent::__construct($name, $data, $dataName);
    }

    public function testSimpleWordsToNumbersString() {
        $string = "Five";
        $this->assertEquals("5", StringNumbers::wordsToNumbers($string));
        $string = "Zero";
        $this->assertEquals("0", StringNumbers::wordsToNumbers($string));
        $string = "Ten";
        $this->assertEquals("10", StringNumbers::wordsToNumbers($string));
        $string = "Twelve";
        $this->assertEquals("12", StringNumbers::wordsToNumbers($string));
        $string = "Twenty";
        $this->assertEquals("20", StringNumbers::wordsToNumbers($string));
        $string = "Twenty Two";
        $this->assertEquals("22", StringNumbers::wordsToNumbers($string));
        $string = "A hundred";
        $this->assertEquals("100", StringNumbers::wordsToNumbers($string));
        $string = "One hundred";
        $this->assertEquals("100", StringNumbers::wordsToNumbers($string));
        $string = "Three hundred fifty";
        $this->assertEquals("350", StringNumbers::wordsToNumbers($string));
        $string = "Three hundred fifty two";
        $this->assertEquals("352", StringNumbers::wordsToNumbers($string));
        $string = "A thousand Three hundred fifty two";
        $this->assertEquals("1352", StringNumbers::wordsToNumbers($string));
        $string = "Twelve thousand Three hundred fifty two";
        $this->assertEquals("12352", StringNumbers::wordsToNumbers($string));
        $string = "Twenty nine thousand Three hundred fifty two";
        $this->assertEquals("29352", StringNumbers::wordsToNumbers($string));
        $string = "A hundred thousand Three hundred fifty two";
        $this->assertEquals("100352", StringNumbers::wordsToNumbers($string));
    }

    public function testComplexWordsToNumbersString() {
        $string = "Thirty three men have bought more than two hundred devices in less than three days cost more than 5 million 600 thousands 5 hundreds fifty five";
        $this->assertEquals("33 men have bought more than 200 devices in less than 3 days cost more than 5600555", StringNumbers::wordsToNumbers($string));
    }

    public function testSimpleNumbersToWordsString() {
        $string = "0";
        $this->assertEquals("zero", StringNumbers::numbersToWords($string));
        $string = "8";
        $this->assertEquals("eight", StringNumbers::numbersToWords($string));
        $string = "10";
        $this->assertEquals("ten", StringNumbers::numbersToWords($string));
        $string = "11";
        $this->assertEquals("eleven", StringNumbers::numbersToWords($string));
        $string = "20";
        $this->assertEquals("twenty", StringNumbers::numbersToWords($string));
        $string = "25";
        $this->assertEquals("twenty five", StringNumbers::numbersToWords($string));
        $string = "250";
        $this->assertEquals("two hundred fifty", StringNumbers::numbersToWords($string));
        $string = "255";
        $this->assertEquals("two hundred fifty five", StringNumbers::numbersToWords($string));
        $string = "1000";
        $this->assertEquals("one thousand", StringNumbers::numbersToWords($string));
        $string = "299299299299299";
        $this->assertEquals("two hundred ninety nine trillion two hundred ninety nine billion two hundred ninety nine million two hundred ninety nine thousand two hundred ninety nine", StringNumbers::numbersToWords($string));
    }
    
    public function testComplexNumbersToWordsString(){
        $string = "33 men have bought more than 200 devices in less than 3 days cost more than 5600555";
        $this->assertEquals("thirty three men have bought more than two hundred devices in less than three days cost more than five million six hundred thousand five hundred fifty five", StringNumbers::numbersToWords($string));
    }

}
