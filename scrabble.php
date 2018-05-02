<?php

require 'vendor/autoload.php';

function scrabble($string, $array) {
  $string = preg_split('/[\s]+/', trim($string));
  $numbers = array_intersect($string, $array);
  $count_numbers = count($numbers);
  $imploded_numbers = implode(', ', $numbers);

  switch($count_numbers) {
    // none
    case count($string):
      $message = 'array contains all of these numbers';
      break;
    default: // more then 1 and less than all
      $message = "array contains $count_numbers of these numbers. array contains numbers $imploded_numbers";
  }

  return [
    'message' => $message,
    'numbers' => implode(', ', $numbers)
  ];
}


use PHPUnit\Framework\TestCase;

class Test extends TestCase {

  public function testContainsTwoOfThree() {
    $string = 'one two three';
    $array = ['one', 'two'];
    $expected = [
      'message' => 'array contains 2 of these numbers. array contains numbers one, two',
      'numbers' => 'one, two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }
}
