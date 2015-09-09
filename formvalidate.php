<?php

function RedFont($message) {
        echo "<span style='color:red'>" . $message . "</span>";
}

function ValidateEmail($email) {
    $emailre="^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$^";
    if (!(preg_match($emailre,$email)) || !(strlen($email)>0)) {
        return false;
    } else {
        return true;
    }
}

function ValidateLocation($city,$state,$zip) {
        
}

function CleanNumber ($UserInput) {
        $pattern = "/[^0-9]/";
        $UserInput = preg_replace($pattern, "", $UserInput);
        return substr($UserInput,0,6);
}

function CleanString ($UserInput, $MaxLen) {
        $UserInput=trim($UserInput);
        $UserInput = strip_tags($UserInput);
        $UserInput = substr($UserInput,0,$MaxLen);
        return str_replace("'","''",$UserInput);
}

function CleanPrice($price) {
        $UserInput=trim($price);
        $pattern = "/^\$?[0-9]+(,[0-9]{3})*(\.[0-9]{2})?$/";
        $UserInput = preg_replace($pattern,"",$UserInput);
}

function CleanText($str) {
        $str = mysql_real_escape_string($str);
        $str = stripslashes($str);
        $str = htmlentities($str);
        $str = strip_tags($str);
        return $str;
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
