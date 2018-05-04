<?php

require 'vendor/autoload.php';

function scrabble($string, $array) {
  $string = preg_split('/[\s]+/', trim($string));
  $numbers = array_intersect($string, $array);
  $count_numbers = count($numbers);
  $imploded_numbers = implode(', ', $numbers);

  switch($count_numbers) {
    case 0:
      $message = 'none of the elements for the array has been found in the string';
      break;
    case 1:
      $number = array_pop($numbers);
      $message = "one element from the array has been found in the string. element is $number";
      break;
    case count($array):
      $message = 'all elements from the array have been found in the string';
      break;
    default: // more then 1 and less than all
      $message = "$count_numbers elements from the array have been found in the string. elements are $imploded_numbers";
  }

  return [
    'message' => $message,
    'numbers' => $imploded_numbers
  ];
}

function notScrabble($string, $array) {
  // loop over array
  foreach($array as $element) {
    preg_match("/\b$element\b/", $string, $matches);

var_dump($matches);
  }
}


use PHPUnit\Framework\TestCase;

class Test extends TestCase {

  public function testSimpleSentence() {
    $string = 'Fox likes dogs and cats';
    $array = ['Fox likes dogs'];
    $expected = [
      'message' => 'one element from the array has been found in the string. element is Fox likes dogs',
      'elements' => 'Fox likes dogs'
    ];
    $actual = notScrabble($string, $array);
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

  public function testContainsTwoOfThree() {
    $string = 'one two three';
    $array = ['one', 'two'];
    $expected = [
      'message' => 'all elements from the array have been found in the string',
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
