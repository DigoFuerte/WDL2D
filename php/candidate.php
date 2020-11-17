<?php

class Candidate {
    //member fields
    public $title;
    public $fname;
    public $lname;
    public $gender;
    public $age;
    public $addr_no;
    public $addr_street;
    public $addr_city;
    public $addr_country;
    public $postcode;
    public $phone;
    public $mobile;
    public $email;
    public $mark;
    private $grade;

    //constrcutor ... empty constructor works
    public function __constructor() {
    // $this->mark =  getMark();  
    // $this->grade = getGrade($this->mark, $this->grade);                              
    }

    //constrcutor ... with parameters ... not working

    //class method
    public function getMark() {

        $this->mark = $this->getRandomIntMark();

        // determine grade from mark value
        $this->grade = $this->getGrade($this->mark);

    }

    //class method
    //function to generate better random numbers
    private function getRandomIntMark() {

        $resultantInteger = -100;
        do {
            $bytes = openssl_random_pseudo_bytes(1, $cstrong);
            $hex   = bin2hex($bytes);
            $resultantInteger = hexdec($hex);
        } 
        while ( ($resultantInteger < 0) || ($resultantInteger > 100) );

        if (DEBUG) {
            echo "<pre>";
            echo "int value from hex value: $resultantInteger";
            echo "</pre>";
        }

        return $resultantInteger;

    }

    //class method
    //arithmetic play function
    private function numberPlay() {

        static $runCounter = 0;
        $runCounter++;

        $mark = 0;      
        $bIsValidMark = false;
        $iloopCounter = 0;

        do {
            //Compose an integer value [0 ... 100]
            $iloopCounter++;

            //FIRST NUMBER
            $numPtOne = random_int( PHP_INT_MAX, PHP_INT_MAX );
            //SECOND NUMBER
            $numPtTwo = random_int( (-1)*PHP_INT_MAX, PHP_INT_MAX );

            if ( is_finite($numPtOne + $numPtTwo) ) {
                $strNumSum = (string)abs(($numPtOne + $numPtTwo));
                //take three characters
                $mark = (int)substr($strNumSum, -3);
                //randomly take three characters ... CAUSED PROBLEMS
                //                  TARGET STR,  START OF SUB-STRING                   , LENGTH                
                // $mark = (int)substr($strNumSum, ( random_int(3, (strlen($strNumSum))) ), -3);

                if ( ($mark > -1) && ($mark < 101) ) 
                {
                if (DEBUG) {
                    echo "<br>### NUMBER PLAY ## $runCounter ## LOOP ## $iloopCounter: MARK VALUE: $mark"; 
                }

                $bIsValidMark = true; 
                }
            } 
            elseif ( is_infinite($numPtOne + $numPtTwo) ) {
                if (DEBUG) {
                echo "<br>### NUMBER PLAY ## $runCounter ## LOOP ## : INFINITE NUMBER";
                }
            } 
            elseif ( !is_int($numPtOne + $numPtTwo) ) {
                if (DEFINE) {
                echo "<br>### NUMBER PLAY ## $runCounter ## LOOP ## : NON_INTEGER VALUE";
                }
            }

        } while ( !$bIsValidMark && $iloopCounter < 10000 );

        return [$mark, $iloopCounter];

    }//function numberPlay()

    //class method
    //function to assign grade for a given mark
    private function getGrade($mark) {

        $grade = '{Not graded}';
        $validMark = true;

        global $grades;

        if ($mark >= $grades['DISTINCTION'])
        $grade = 'DISTINCTION';      
        elseif ($mark >= $grades['MERIT'])
        $grade = 'MERIT';      
        elseif ($mark >= $grades['FIRST_CLASS'])
        $grade = 'FIRST CLASS';      
        elseif ($mark >= $grades['PASS'])
        $grade = 'PASS';      
        elseif ($mark < $grades['FAIL'])
        $grade = 'FAIL';      

        return $grade;

    } //function getGrade()

    //class method
    //function to display candidate information
    public function display() {
        $backgroundColour = "";
        switch ($this->grade) {
            case ("DISTINCTION"):
                $backgroundColour = "list-group-item list-group-item-primary";
                break;
            case ("MERIT"):
                $backgroundColour = "list-group-item list-group-item-success";
                break;
            case ("FIRST CLASS"):
                $backgroundColour = "list-group-item list-group-item-warning";
                break;
            case ("PASS"):
                $backgroundColour = "list-group-item list-group-item-secondary";
                break;
            default:
                //FAIL
                $backgroundColour = "list-group-item list-group-item-danger";
                break;
        }      
    
        //Display candidate information on browser with Bootstrap4
        $name = $this->title." ";
        $name .= $this->fname . " ";
        $name .= $this->lname; 

        $address = $this->addr_no." ";
        $address .= $this->addr_street . ", ";
        $address .= $this->addr_city . ", "; 
        $address .= $this->addr_country . ", "; 
        $address .= $this->postcode; 

        echo "<div>";
        echo "  <ul class='list-group'>";
        echo "    <li class='$backgroundColour'>";
                //put data here
        echo "      <table class='table'>";
        // echo "        <thead>";
        // echo "          <tr>";
        // echo "            <th scope='col'>...</th>";
        // echo "            <th scope='col'>Name</th>";
        // echo "          </tr>";
        // echo "        </thead>";
        echo "        <tbody>";
        echo "          <tr>";
        echo "            <th scope='row'>Name</th>";
        echo "            <td>$name</td>";
        echo "            <td></td><td></td>";
        echo "          </tr>";
        echo "          <tr>";
        echo "            <th scope='row'>Age</th>";
        echo "            <td>$this->age</td>";
        echo "            <th scope='row'>Gender</th>";
        echo "            <td>$this->gender</td>";
        echo "          </tr>";
        echo "          <tr>";
        echo "            <th scope='row'>Address</th>";
        echo "            <td>$address</td>";
        echo "            <td></td><td></td>";
        echo "          </tr>";
        echo "          <tr>";
        echo "            <th scope='row'>Phone</th>";
        echo "            <td>$this->phone</td>";
        echo "            <th scope='row'>Mobile</th>";
        echo "            <td>$this->mobile</td>";
        echo "          </tr>";
        echo "          <tr>";
        echo "            <th scope='row'>Email</th>";
        echo "            <td>$this->email</td>";
        echo "            <td></td><td></td>";
        echo "          </tr>";
        echo "          <tr>";
        echo "            <th scope='row'>Mark</th>";
        echo "            <td>$this->mark</td>";
        echo "            <th scope='row'>Grade</th>";
        echo "            <td>$this->grade</td>";
        echo "          </tr>";
        echo "        </tbody>";
        echo "        <tfoot>";
        echo "          <tr>";
        echo "            <div id='map' style='width: 320px; height: 480px;'></div>";
        echo "          </tr>";
        echo "        </tfoot>";
        echo "      </table>";
        echo "    </li>";
        echo "  </ul>";
        echo "</div>";

    }//function display()

}//class Candidate

?>