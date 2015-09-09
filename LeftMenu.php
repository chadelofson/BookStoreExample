<?php
include('Connection.php');
include("utilities.php");
$SQL="SELECT CategoryID, CategoryName
      FROM bookcategories
      WHERE NOT CategoryName = 'Morse Code'
      ORDER BY CategoryName";

$result=SelectRecord($SQL);

?>
<div class="menuContainer">
    <div class="menuSearch" >
        <img border="0" src="http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/search_heading.gif" width="170" height="19" alt="search">
        <div class="menuBorder">
            <form action="SearchBrowse.php" method="GET">
                  <input type="text" name="search" size="20">
                  <input type="submit" value="Search Books">
            </form>
        </div>
    </div>

    <div class="menuBrowse" >
        <img border="0" src="http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/browse_heading.gif" width="170" height="19" alt="browse">
        <div class="menuBorder">
<?php
while ($row=  mysql_fetch_array($result)) {
    echo "<a href='SearchBrowse.php?catID=". $row[CategoryID] . "'>" . $row['CategoryName'] . "(" . bookCount($row['CategoryID']) . ")</a><br />\n";
}
?>
         </div>
    </div>
</div>
