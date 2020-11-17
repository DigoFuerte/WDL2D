<?php
$curlObj = null;

//function to get data from web api
function getCandidates($iCandidates, &$candidates) {

global $curlObj;

initCurl();

for ($iCandidate=0; $iCandidate<$iCandidates; $iCandidate++) {

    //make call to API over internet
    $result = curl_exec($curlObj);
    if (curl_errno($curlObj)) { 
    echo 'Error: ' . curl_error($curlObj); 
    }
    
    //convery JSON return data to php-(assoc)array
    $response = json_decode($result, true);

    // echo "<br><hr><p>Selected Data ". ($iCandidate+1) . "</p>";
    //KEY INFO - NAME
    $name = $response['results'][0]['name'];
    $title = $name['title'];
    $fname = $name['first'];
    $lname = $name['last'];
    $gender = $response['results'][0]['gender'];
    $age = $response['results'][0]['dob']['age'];
    $location = $response['results'][0]['location'];
    $street = $location['street'];
        $addr_no = $street['number'];
        $addr_street = $street['name'];
    $addr_city = $location['city']; 
    $addr_country = $location['country']; 
    $postcode = $location['postcode'];
    $phone = $response['results'][0]['phone'];
    $mobile = $response['results'][0]['cell'];
    $email = $response['results'][0]['email'];

    //flag for candidate data details 
    $bDataValid = true;

    //the API sometimes returns empty fields
    //if any field is empty... repeat iteration in loop
    //$bDataValid
    //SHOULD REWRITE THIS BLOCK OF CODE ... use logic AND
    if (empty($name) && $bDataValid)         { $bDataValid = false; }
    if (empty($title) && $bDataValid)        { $bDataValid = false; }
    if (empty($fname) && $bDataValid)        { $bDataValid = false; }
    if (empty($lname) && $bDataValid)        { $bDataValid = false; }
    if (empty($gender) && $bDataValid)       { $bDataValid = false; }
    if (empty($age) && $bDataValid)          { $bDataValid = false; }
    if (empty($addr_no) && $bDataValid)      { $bDataValid = false; }
    if (empty($addr_street) && $bDataValid)  { $bDataValid = false; }
    if (empty($addr_city) && $bDataValid)    { $bDataValid = false; }
    if (empty($addr_country) && $bDataValid) { $bDataValid = false; }
    if (empty($postcode) && $bDataValid)     { $bDataValid = false; }
    if (empty($phone) && $bDataValid)        { $bDataValid = false; }
    if (empty($mobile) && $bDataValid)       { $bDataValid = false; }
    if (empty($email) && $bDataValid)        { $bDataValid = false; }


    if ($bDataValid) {
    $student = new Candidate();
    $student->title = $title;  
    $student->fname = $fname;  
    $student->lname = $lname;  
    $student->gender = $gender;  
    $student->age = $age;  
    $student->addr_no = $addr_no;  
    $student->addr_street = $addr_street;  
    $student->addr_city =  $addr_city;  
    $student->addr_country = $addr_country;  
    $student->postcode = $postcode;  
    $student->phone = $phone;  
    $student->mobile = $mobile;  
    $student->email = $email;  
    $student->getMark();                    
    // echo "<br>#######<br>";
    // echo var_dump($student);

    //append Candidate to global array
    array_push($candidates, $student);
    }
    else {
    //repeat this iteration 
    $iCandidate--;
    if (DEBUG) { echo "<br>#### REPEATING ITERATION ####"; }
    }

}//for-loop

closeCurl();

}//function getCandidates()

//global function ... pass by reference - curl_object
function initCurl($api_url, & $curlObj) {

    // global $curlObj;

    $curlObj = curl_init();

    // curl_setopt($curlObj, CURLOPT_URL, 'https://api.name-fake.com/random/random/');
    // curl_setopt($curlObj, CURLOPT_URL, 'https://randomuser.me/api/');
    curl_setopt($curlObj, CURLOPT_URL, $api_url);

    curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlObj, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curlObj, CURLOPT_HTTPHEADER, 
                          array('Accept: application/json')
               );
    // curl_setopt($curlObj, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

}  

//global function
function closeCurl() {

    global $curlObj;
    curl_close($curlObj);

}

?>