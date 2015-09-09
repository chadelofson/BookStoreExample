<?php
function bookCount($CategoryID) {
    $SQL="SELECT COUNT(ISBN)as total
          FROM bookcategoriesbooks
          WHERE CategoryID=$CategoryID";
    
    $result = mysql_query($SQL);
    $row = mysql_fetch_array($result);
    return $row['total'];
}

?>
