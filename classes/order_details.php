<?php

class OrderDetails
{

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
    private $sh_fname;
    private $sh_lname;
    private $sh_address1;
    private $sh_address2;
    private $sh_country;
    private $sh_state_c;
    private $sh_zip;
    private $order_id;

    function __construct(
        $username,
        $fname,
        $lname,
        $email,
        $address1,
        $address2,
        $country,
        $state_c,
        $zip,
        $sh_fname,
        $sh_lname,
        $sh_address1,
        $sh_address2,
        $sh_country,
        $sh_state_c,
        $sh_zip,
        $order_id
    ) {
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
        $this->sh_fname    = $sh_fname;
        $this->sh_lname    = $sh_lname;
        // $this->sh_email    = $sh_email;
        $this->sh_address1 = $sh_address1;
        $this->sh_address2 = $sh_address2;
        $this->sh_country  = $sh_country;
        $this->sh_state_c  = $sh_state_c;
        $this->sh_zip      = $sh_zip;
        $this->order_id = $order_id;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getOrderid()
    {
        return $this->order_id;
    }

    function getEmail()
    {
        return $this->email;
    }
}
