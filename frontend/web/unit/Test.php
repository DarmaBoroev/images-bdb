<?php

namespace test;

include_once 'calculator.php';


class CalculatorTest {
    
    public function __construct() {
        self::testAddCorrect();
        self::testDivideCorrect();
        self::testDivideZero();
    }
    
    public static function testAddCorrect(){
        echo 'Running ' . __METHOD__ . '<br>';
        
        $result = Calculator::add(10, 5);
        if($result === 15){
            echo 'Passed';
        }else{
            echo 'Failed: expected {integer} 15. Result: {' . gettype($result) . "} $result";
        }
        echo '<hr>';
    }
    
    public static function testDivideCorrect(){
        echo 'Running ' . __METHOD__ . '<br>';
        
        $result = Calculator::divide(10, 5);
        if($result === 2){
            echo 'Passed';
        }else{
            echo 'Failed: expected {integer} 2. Result: {' . gettype($result) . "} $result";
        }
        echo '<hr>';
    }
    
    public static function testDivideZero(){
        echo 'Running ' . __METHOD__ . '<br>';
        
        $result = Calculator::divide(10, 0);
        if($result === null){
            echo 'Passed';
        }else{
            echo 'Failed: expected {integer} null. Result: {' . gettype($result) . "} $result";
        }
        echo '<hr>';
    }
}
new CalculatorTest();
