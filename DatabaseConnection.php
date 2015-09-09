<?php

function ConnectToDatabase() {
    $connection = mysql_connect("yorktown.cbe.wwu.edu","121elofsoc","battlecat1")
            or die('Connection error: ' . mysql_error());
       
    mysql_select_db("121elofsoc",$connection)
            or die('Database not found: ' . mysql_error());
        
}

function InsertRecord($SQL) {
        return mysql_query($SQL) or die ("Insert error: " . mysql_error());
         
}

function DeleteRecord($SQL) {
        $result=mysql_query($SQL) or die ("Delete error: " . mysql_error());
        return $result;
}

function SelectRecord($SQL) {
        $result= mysql_query($SQL) or die ("Select error: " . mysql_error());
        return $result;
}

function UpdateRecord($SQL) {
        return mysql_query($SQL) or die ("Update error: " . mysql_error());
        //return $result;
}

function RowCount($result) {
        return mysql_num_rows($result);
}
?>
