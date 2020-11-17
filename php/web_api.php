<?php
#
# Ptolemy Exchange ... PEX
# in 150 BC Ptolemy was the first to list the constellations
#
#eg: https://api.nasa.gov/planetary/apod?api_key=jDpuF0V85x4F99c50zfs182iKJgpnA7gbUKCKsgh


const APOD_API_ID_PHP = 1;
const APOD_API_URL_PHP = 'https://api.nasa.gov/planetary/apod';
const NASA_API_KEY_PHP = 'jDpuF0V85x4F99c50zfs182iKJgpnA7gbUKCKsgh';

const NASA_IMAGES_API_ID_PHP = 2;
// images and audio available
const NASA_IMAGES_API_URL_PHP = 'https://images-api.nasa.gov';

// PHP / server-side approach
class WebApi {
    # CLASS CONSTANTS
    
    # MEMBER FIELDS
    private $curl_obj;
    private $b_curl_obj_ok;
    private $api_url;

    // CONSTRUCTOR
    public function __constructor($api_id, $api_url, $api_key = "") {
        $this->api_url = "VOID";
        $this->$b_curl_obj_ok = TRUE;
        if ( !empty($api_id) && !empty($api_url) ) {
            if ($api_id == APOD_API_ID) {
                $this->api_url = $api_url . "?api_key=" . NASA_API_KEY;  
            }
            if ($this->api_url != "VOID") {
                $this->b_curl_obj_ok = $this->get_curl_obj($api_url); 
            }
        }
        else {
            $this->$b_curl_obj_ok = FALSE;
        }
    }
    
    //METHODS
    private function get_curl_obj($api_url) {
        $this->curl_obj = $this->initCurl($api_url); 
        return (! empty($curl_obj) );
    }

    function initCurl($api_url) {
        $this->curl_obj = curl_init();
        // curl_setopt($curlObj, CURLOPT_URL, 'https://api.name-fake.com/random/random/');
        // curl_setopt($curlObj, CURLOPT_URL, 'https://randomuser.me/api/');
        curl_setopt($this->curl_obj, CURLOPT_URL, $api_url);

        curl_setopt($this->curl_obj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl_obj, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->curl_obj, CURLOPT_HTTPHEADER, array('Accept: application/json') );
        // curl_setopt($curlObj, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    }  

    function closeCurl() {
        global $curlObj;
        curl_close($curlObj);
    }

}
//?                 CODE SNIPPETS
//* global $curlObj;
//* //global $candidates;
//* initCurl();
//*
//*  for ($iCandidate=0; $iCandidate<$iCandidates; $iCandidate++) {
//*
//*    //flag for candidate data details 
//*    $bDataValid = true;
//*
//*    //make call to API over internet
//*    $result = curl_exec($curlObj);
//*    if (curl_errno($curlObj)) { 
//*      echo 'Error: ' . curl_error($curlObj); 
//*    }      
//?    //convert JSON data returned to php-(assoc)array
//*    $response = json_decode($result, true);
//? PARSING THE RESULTANT PHP ASSOCIATIVE ARRAY
//*    //KEY INFO - NAME
//*    $name = $response['results'][0]['name'];
//*      $title = $name['title'];
//*      $fname = $name['first'];
//*      $lname = $name['last'];
//*    $gender   = $response['results'][0]['gender'];
//*    $age      = $response['results'][0]['dob']['age'];
//*    $location = $response['results'][0]['location'];
//*      $street = $location['street'];
//*        $addr_no     = $street['number'];
//*        $addr_street = $street['name'];
//*      $addr_city    = $location['city']; 
//*      $addr_country = $location['country']; 
//*      $postcode     = $location['postcode'];
//*    $phone  = $response['results'][0]['phone'];
//*    $mobile = $response['results'][0]['cell'];
//*    $email  = $response['results'][0]['email'];

//? technique works on any private or protected member fields
//? GETTER/SETTER - must be defined as PUBLIC
//? private $private_member;
//? protected $protected_member;
//? getter
//*public function __get($property_name_01) {
//*    if (property_exists($this, $property)) {
//*        return $this->$private_member;
//*    }
//*}
//? setter
//*public function __set($property_name_02, $value) {
//*    // var_dump(__METHOD__);
//*    if (property_exists($this, $property)) {
//*        $this->$protected_member = $value;
//*    }
//*}    
//*     TO USE
//* $a = new Test();
//* 
//? property 'name' exists
//* $a->name = 'test'; // will trigger __set
//* $n = $a->name;     // will trigger __get
//* 
//? property 'foo' is protected - meaning not accessible OR does not exist
//! NOTE $a->foo NOT $a->$foo
//* $a->foo = 'bar'; // will not trigger __set
//* $a = $a->foo;    // will not trigger __get

?>