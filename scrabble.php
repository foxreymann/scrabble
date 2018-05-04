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
	// remove new lines and long white spaces from a string
	$string = trim(preg_replace('/\s+/', ' ', $string));
  $string = " $string ";

  $found_elements = 0;
  $elements = [];

  foreach($array as &$element) {
	  $element = trim(preg_replace('/\s+/', ' ', $element));
    if (false !== mb_strpos($string, " $element ")) {
      ++$found_elements;
      $elements[] = $element;
    }
  }

  $elements = implode(', ', $elements);

  switch($found_elements) {
    case 0:
      $message = 'none of the elements from the array has been found in the string';
      break;
    case 1:
      $message = "one element from the array has been found in the string. element is $elements";
      break;
    case count($array):
      $message = 'all elements from the array have been found in the string';
      break;
    default: // more then 1 and less than all
      $message = "$found_elements elements from the array have been found in the string. elements are $elements";
  }

  return [
    'message' => $message,
    'elements' => $elements
  ];

}


use PHPUnit\Framework\TestCase;

class Test extends TestCase {

  public function testNotScrabbleSimpleSentence() {
    $string = 'Fox likes dogs and cats';
    $array = ['Fox likes dogs'];
    $expected = [
      'message' => 'one element from the array has been found in the string. element is Fox likes dogs',
      'elements' => 'Fox likes dogs'
    ];
    $actual = notScrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testNotScrabbleNone() {
    $string = 'Fox likes dogs and cats';
    $array = ['Fox likes cats'];
    $expected = [
      'message' => 'none of the elements from the array has been found in the string',
      'elements' => ''
    ];
    $actual = notScrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testNotScrabbleTwoElements() {
    $string = 'Fox likes dogs and cats';
    $array = ['Fox likes dogs', 'cats', 'wolfs'];
    $expected = [
      'message' => '2 elements from the array have been found in the string. elements are Fox likes dogs, cats',
      'elements' => 'Fox likes dogs, cats'
    ];
    $actual = notScrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

  public function testNotScrabbleAllElementsWithATab() {
    $string = 'Fox likes dogs and 	  cats';
    $array = ['Fox likes dogs', 'and', 'cats'];
    $expected = [
      'message' => 'all elements from the array have been found in the string',
      'elements' => 'Fox likes dogs, and, cats'
    ];
    $actual = notScrabble($string, $array);
    $this->assertEquals($actual, $expected);
  }

	public function testNotScrabbleWeirdCharacters() {
		$string = "cool if there are none substring may include
		characters like . ' / & , £ $ and accents on letters eg foreign
		letters... ąąźźćć in the next room abracadabra scroll";
		$array = ["cool", "if", "there are none", "substring may include characters like . ' / & , £ $ and accents on letters eg foreign letters...", "in the next room", "abracadabra scroll", "ąąźźćć"];
    $expected = [
      'message' => 'all elements from the array have been found in the string',
    ];
    $actual = notScrabble($string, $array);
    $this->assertEquals($actual['message'], $expected['message']);
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
