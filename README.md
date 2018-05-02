I got a small problem for you. All I want to do is give a count and appropriate answers.

 

function contains($string, array $array) {

    $count = 0;

    foreach($array as $value) {

        if (false !== strpos($string,$value)) {

            ++$count;

        };

    }

    return $count == count($array);

}

 

function contains2($string, array $array)

{

    foreach($array as $a) {

        if (strpos($string,$a) !== false) return true;

    }

    return false;

}

 

 

$string = "one three two";

$array = array ("one","two","three");

 

if (contains($string, $array)) {

    print 'array contains all of these numbers';

}

elseif (contains2($string, $array)) {

    print 'array contains one of these numbers';

}

 

I would like to have other answers:

 

“array contains $count of these numbers”

“array contains the number …” if string only contains that number

“array contains numbers …, …” if string contains more than one number the are listed delimited by a , and this is also stored as a string called $numbers

“array contains all of these numbers”
