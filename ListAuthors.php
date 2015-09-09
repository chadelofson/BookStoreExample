<?php

/*List Authors Function:
    This function uses ISBN as an input parameter and returns a string of author names formatted as
    hyperlinks. To use the function:
    1. Copy this code into a file in your bookstore folder named "ListAuthors.php".
    2. Include this file in your page using: include_once("ListAuthors.php")
    3. To list authors, call the function and pass in the ISBN of the book using:
       echo ListAuthors($ISBN);
       where $ISBN is a variable containing the book's ISBN.
    This function requires that you have an open database connection to your database.
    You are welcome to modify this script.
   */
   function fListAuthors($ISBN) {

        $SQL = "SELECT strFName, strLName
                FROM bookauthors, bookauthorsbooks
                WHERE bookauthorsbooks.ISBN = '$ISBN'
                AND bookauthors.AuthorID = bookauthorsbooks.AuthorID
                ORDER BY strLName";

        $result = mysql_query($SQL) or die('SQL error: ' . mysql_error());
        while ($row = mysql_fetch_array($result)) {
            $LName = $row['strLName'];
            $FName = $row['strFName'];
            $AuthorList .= "<a href='SearchBrowse.php?search=".
                           "$LName'>$FName $LName</a>, ";
        }

        //remove the last comma
        return substr_replace($AuthorList, "",-2);
   }

?>
