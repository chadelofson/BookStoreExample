<?php
include_once('Connection.php');
include('ListAuthors.php');
include('Header.php');
?>
<div class="pageContainer">
        <div class="leftColumn">

<?php
include('LeftMenu.php');
?>
        </div>
<div class="content">
<?php
if (strlen($_GET['isbn'])>0) {
$ISBN=$_GET['isbn'];
$SQL="SELECT ISBN, title, price,publisher, description
      FROM bookdescriptions
      WHERE ISBN='$ISBN'";
} else {
    $SQL="SELECT ISBN, title,price, publisher, description
      FROM bookdescriptions
      ORDER BY RAND()
      LIMIT 1";
}
      

$result=SelectRecord($SQL);

$row=mysql_fetch_array($result);
    
    echo " <span class='bookTitle'>" . $row['title'] . "</span><br />\n";
    echo " <font size='-1'>by " . fListAuthors($row['ISBN']) . "</font><br />\n";
    echo "<a href=\"http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/" . $row['ISBN'] . ".01.LZZZZZZZ.jpg\">\n";
    echo "<img class='Book' src=\"http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/" . $row['ISBN'] . ".01.MZZZZZZZ.jpg\">\n";
    echo "</a> <br />";
    echo "<span class=\"priceLabel\">Price:</span>";
    echo "<span class=\"bookPriceB\">";
    echo $row['price'] . "</span> <br />";
    echo "<br /><b>ISBN:</b>" . $row['ISBN'] . "<br />";
    echo "<b>Publisher:</b>" . $row['publisher'] . "</span><br />";
    echo "<a href=\"ShoppingCart.php?addISBN=" . $row['ISBN'] . "\">";
    echo "    <img border=\"0\" src=\"http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/add-to-cart-small.gif\" align=\"right\"></a>";

    echo "<br /><br /><br /><br /><br />";
    echo "<p>";
    echo $row['description'];
    echo "</p>";
    echo "</div>\n";

?>  
</div>

<?php
include('Footer.php');
?>
</div>
</div>
</body>
</html>
