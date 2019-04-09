<?php

class OrderDetails {
 
//  private $name;
//  private $age;

 private $username; 
 private $fname;    
 private $lname;    
 private $email;    
 private $address1; 
 private $address2; 
 private $country;  
 private $state_c;  
 private $zip;      
 private $order_id;

 function __construct( $username, $fname, $lname, $email, $address1, $address2, $country, $state_c, $zip, $order_id ) {
    //  $this->name = $name;
    //  $this->age = $age;
     $this->username = $username;
     $this->fname = $fname;   
     $this->lname = $lname;   
     $this->email = $email;   
     $this->address1 = $address1;
     $this->address2 = $address2;
     $this->country = $country; 
     $this->state_c = $state_c; 
     $this->zip = $zip; 
     $this->order_id = $order_id; 
 }

 function getUsername() {
     return $this->username;
 }

 function getOrderid() {
    return $this->order_id;
}

function getEmail() {
    return $this->email;
}

}
?>