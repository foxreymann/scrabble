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

  public function testContainsAllThreeOfThree() {
    $string = 'one two three';
    $array = ['one', 'two', 'three'];
    $expected = [
      'message' => 'all elements from the array have been found in the string',
      'numbers' => 'one, two, three'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsTwoOfThree() {
    $string = 'one two three';
    $array = ['one', 'two'];
    $expected = [
      'message' => '2 elements from the array have been found in the string. elements are one, two',
      'numbers' => 'one, two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsTwoOfThreePlusOneWrong() {
    $string = 'one two three';
    $array = ['one', 'two', 'five'];
    $expected = [
      'message' => '2 elements from the array have been found in the string. elements are one, two',
      'numbers' => 'one, two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsAllNumbersAndOneMore() {
    $string = 'one two three';
    $array = ['one', 'two', 'four', 'three'];
    $expected = [
      'message' => '3 elements from the array have been found in the string. elements are one, two, three',
      'numbers' => 'one, two, three'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsOneNumber() {
    $string = 'one two three';
    $array = ['two'];
    $expected = [
      'message' => 'one element from the array has been found in the string. element is two',
      'numbers' => 'two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testContainsNoneWithWrongAnswers() {
    $string = 'one two three';
    $array = ['four', 'fox'];
    $expected = [
      'message' => 'none of the elements for the array has been found in the string',
      'numbers' => ''
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }
}
