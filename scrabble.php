<?php

require 'vendor/autoload.php';

function scrabble($string, $array) {
  $message = '';
  $numbers = [];

  return [
    'message' => $message,
    'numbers' => $numbers
  ];
}


use PHPUnit\Framework\TestCase;

class Test extends TestCase {

  public function testContainsTwoOfThree() {
    $string = 'one two three';
    $array = ['one', 'two'];
    $expected = [
      'message' => 'array contains 2 of these numbers. array containes numberes one, two',
      'numbers' => 'one, two'
    ];
    $actual = scrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }
}
