<?php

require 'vendor/autoload.php';

function scrabble($string, $array) {
  $string = preg_split('/[\s]+/', trim($string));
  $numbers = array_intersect($string, $array);
  $count_numbers = count($numbers);
  $imploded_numbers = implode(', ', $numbers);

  switch($count_numbers) {
    case 0:
      $message = 'array contains none of these numbers';
      break;
    case 1:
      $number = array_pop($numbers);
      $message = "array contains the number $number";
      break;
    case count($array):
    case count($string):
      $message = 'array contains all of these numbers';
      break;
    default: // more then 1 and less than all
      $message = "array contains $count_numbers of these numbers. array contains numbers $imploded_numbers";
  }

  return [
    'message' => $message,
    'numbers' => $imploded_numbers
  ];
}


use PHPUnit\Framework\TestCase;

class Test extends TestCase {

  public function testContainsAllTwoOfThree() {
    $string = 'one two three';
    $array = ['one', 'two'];
    $expected = [
      'message' => 'array contains all of these numbers',
      'numbers' => 'one, two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsNotAllTwoOfThree() {
    $string = 'one two three';
    $array = ['one', 'two', 'five'];
    $expected = [
      'message' => 'array contains 2 of these numbers. array contains numbers one, two',
      'numbers' => 'one, two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsAllNumbersAndOneMore() {
    $string = 'one two three';
    $array = ['one', 'two', 'four', 'three'];
    $expected = [
      'message' => 'array contains all of these numbers',
      'numbers' => 'one, two, three'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsOneNumber() {
    $string = 'one two three';
    $array = ['two'];
    $expected = [
      'message' => 'array contains the number two',
      'numbers' => 'two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testEmtpyArray() {
    $string = 'one two three';
    $array = [];
    $expected = [
      'message' => 'array contains none of these numbers',
      'numbers' => ''
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsNoneWithWrongAnswers() {
    $string = 'one two three';
    $array = ['four', 'fox'];
    $expected = [
      'message' => 'array contains none of these numbers',
      'numbers' => ''
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }
}
