<?php 
// include 'project.xml'; for xml header specifications
include 'filepath to databaseQueries';

//debugging function. prints selected whatever stateless obj in a somewhat more formatted xml way
function prePrint($obj){
    echo "<pre>". print($obj)."</pre>";
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
    if(null !== ifXml($obj)){
        ifXml($obj);
        testInput($obj);
        return true;
    }
 else {
    echo "not xml"; // perhaps perform another check for other types of builds, like json encoding;
    prePrint ($obj);
    testInput($obj);
    return false;
    }
}
//function to check the file version corresponds with the project dependency, if dependency is xml
function fileVersion($obj) {
	echo "<?xml version=".print($obj) ."encoding='UTF-8'?>";
}
//function to change the name of the project dependency,if dependency is xml
function insertNameTag($obj) {
	echo "<name>".print($obj)."</name>";
}
//function to change the file version of the project dependency is xml
function insertCommentTag($obj) {
	echo "<comment>".print($obj)."</comment>";
}
//function to chage the project tag of the project dependency , if dependency is xml
function insertProjectsTag($obj) {
	echo "<projects>".print($obj)."</projects>";
}
function insertBuildSpecTag($obj) {
	echo "<buildSpec>". print($obj). "</buildSpec>";
}
// create a db handler with PDO lib. note(alexa) please look into depth here. Much might come to a 2nd db
global $dataBaseHandler;
$dataBaseHandler = new PDO($DB_HOST, $DB_USER, $DB_PASS);
    if($dataBaseHandler) {
        echo "Connected!";
    }
$dataBaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//REST GLOBALs types, methods to check if the data inputed is passed correctly, we need our flow :)
prePrint($_GET);
prePrint($_POST);
prePrint($_COOKIE);
prePrint($_ENV);
prePrint($_SERVER);

//trim, and bare minimum of data sanitization
function testInput($obj) {
  $obj = trim($obj);
  $obj = stripslashes($obj);
  $obj = htmlspecialchars($obj);
  return $obj;
}


//function that sorts 2 arrays and checks if they are equal
function identicalValues( $dataset1 , $dataset2 )
{
    sort($dataset1);
    sort($dataset2);
    return $dataset1 == $dataset2;
}



function ifNull($obj) 
{
    if ($obj == NULL) 
        return true;
    else 
        return false;       
}
//function that checks if struct1 is different from struct2
function remaingorn($struct1, $struct2) {
    if(ifNull($struct1) && ifNull($struct2)) {
        // check to see if it actually prints the data, and how it looks like :)
        echo ($struct1);
        echo($struct2);
	    $plusCount = $minusCount = 0;
        testInput($struct1);
        testInput($struct2);
        foreach($struct1 as $dataSize1 => $numberOfBits1) {
            foreach($struct2 as $dataSize2 => $numberOfBits2)
            {
                if(!identicalValues($numberOfBits1, $numberOfBits2))
                    
			$minusCount = $numberOfBits1 - $numberOfBits2;
		    	$plusCount =  $numberOfBits1 + $numberOfBits2;
            }
        }

    	if (($minusCount + $plusCount) > 0 ) {
	        echo "The Plus Count is the bigger Data Set, returns a pozitive value"; 
            return 1;
        } else if (($minusCount + $plusCount) < 0) { 
            echo "The Minus Count is the Bigger Data Set, returns a negative value";
	        return -1;		
	    } else if (($minusCount + $plusCount) === 0 ){    
            echo "the structures might be identical, a sort and a recussion is in need here";
            return 0; 
        }	
    }
}

?>
