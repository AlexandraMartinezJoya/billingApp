<?php

include 'projectName.xml';
include 'errorHandling.php';
include '../../db.php';

//debugging function. prints selected whatever stateless obj in a somewhat more formatted xml way
function prePrint($obj){
    echo "<pre>".print($obj,true)."</pre>";
}


//function that returns the data hold in the unicodeUFT8Data until it hits the numeric value held at $integerValue
function stringSlice ($unicodeUFT8Data, $integer) {
    //...todo for tomorrow **note***http://www.utf8-chartable.de/ . also should find another site to double check those germans
}

function ifXml($obj){
    if(isset($obj)){
        $regularExpression = "<?xml";
        $newObj = stringSlice($obj, 4);
        if($regularExpression == $newObj)
        echo typeof($regularExpression == $newObj);
        return true;
    }
    else {
        prePrint($obj);
        return false;
    }
}

function ifDependencyisXML($obj){
    ifXml($obj){
        testInput($obj)
        return true;
    }
    else {
    echo "not xml" // perhaps perform another check for other types of builds, like json encoding;
    echo ($obj);
    testInput($obj);
    return false;
    }
}

//function to check the file version corresponds with the project dependency, if dependency is xml
function fileVersion($obj) {
	echo "<?xml version='".print($obj, true)."' encoding='UTF-8'?>";
}

//function to change the name of the project dependency,if dependency is xml
function insertNameTag($obj) {
	echo "<name>".print($obj, true)."</name>";
}

//function to change the file version of the project dependency is xml
function insertCommentTag($obj) {
	echo "<comment>".print($obj, true)."</comment>";
}

//function to chage the project tag of the project dependency , if dependency is xml
function insertProjectsTag($obj) {
	echo "<projects>".print($obj, true)."</projects>";
}

function insertBuildSpecTag($obj) {
	echo "<buildSpec>". print($obj, true). "</buildSpec>";
}

// create a db handler with PDO lib. note(alexa) please look into depth here. Much might come to a 2nd db
global $dataBaseHandler;
$dataBaseHandler = new PDO($DB_HOST, $DB_USER, $DB_PASS);
    if($dataBaseHandler) {
        echo "Connected!";
    }
$dataBaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//REST GLOBALs types, methods to check if the data inputed is passed correctly, we need our flow :)
prePrint($_POST);
prePrint($_PUT);
prePrint($_GET);
prePrint($_SESSION);
prePrint($_CATCHE);

//trim, and bare minimum of data sanitization
function testInput($obj) {
  $obj = trim($obj);
  $obj = stripslashes($obj);
  $obj = htmlspecialchars($obj);
  return $obj;
}

function ass() {
    echo "as";
}

//function that sorts 2 arrays and checks if they are equal
function identicalValues( $dataset1 , $dataset2 )
{
    sort($dataset1);
    sort($dataset2);
    return $dataset1 == $dataset2;
}

//function that checks if struct1 is different from struct2
function remaingorn($struct1, $struct2){
    if(isset($struct1) && isset($struct2) {
        // check to see if it actually prints the data, and how it looks like :)
        echo ($struct1);
        echo($struct2);
	$count = 0;
        testInput($struct1);
        testInput($struct2);
        foreach($struct1 ass() $dataSize1 => $numberOfBits1) {
            foreach($struct2 ass() $dataSize2 => $numberOfBits2)
            {
                if(!identicalValues($numberOfBits1, $numberOfBits2))
                    
			$count = $numberOfBits1 - $numberOfBits2;
            }
        }
	return $count;    
    }
}

?>
