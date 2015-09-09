<?php
include('Connection.php');
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
if(strlen($_GET['catID'])>0) {
    
    $catID=$_GET['catID'];
    $SQL ="SELECT CategoryName
          FROM bookcategories
          WHERE CategoryID=$catID";
    $result=SelectRecord($SQL);
    
    $row=mysql_fetch_array($result);
    $category=$row['CategoryName'];
    
    
    $SQL="SELECT DISTINCT b.isbn, title,price, description, CategoryName
          FROM bookdescriptions b,bookcategoriesbooks bcb,bookcategories c
          WHERE b.ISBN=bcb.ISBN AND bcb.CategoryID=$catID AND c.CategoryID=$catID
          ORDER BY title,price";
    
    $result=SelectRecord($SQL);
    $count=mysql_num_rows($result);
    echo "<div class=\"pageTitle2\">";
    echo "$count books in <font color='#CC0000'>'" . $row['CategoryName'] . "'</font> category\n</div><br />\n";
    
} else if(strlen($_GET['search'])>0) {
    
    $search=$_GET['search'];
    
    $search=str_replace("'", "", $search);
    $SQL="SELECT DISTINCT d.isbn, title, description, price
          FROM bookauthors a, bookauthorsbooks ba, bookdescriptions d, bookcategoriesbooks cb, bookcategories c
          WHERE a.AuthorID = ba.AuthorID
          AND ba.ISBN = d.ISBN
          AND d.ISBN = cb.ISBN
          AND c.CategoryID = cb.CategoryID
          AND (
          CategoryName ='$search'
          OR title LIKE '%$search%'
          OR description LIKE '%$search%'
          OR publisher LIKE '%$search%'
          OR concat_ws(' ', strFName, strLName, strFName ) LIKE '%$search%'
          )";
      
      $result=SelectRecord($SQL);
      $count=mysql_num_rows($result);
      echo "<div class=\"pageTitle2\">";
      echo "$count books contain <font color='#CC0000'>'" . $search . "'</font> category\n</div><br />\n";
          
} else {
    
    $SQL="SELECT isbn, title, description
          FROM bookdescriptions
          ORDER BY RAND()
          LIMIT 3";
          $result=SelectRecord($SQL);
}


while ($row=mysql_fetch_array($result)) {
    $isbn=$row['isbn'];
    $description = substr($row['description'],0,100);
    $pos = strpos($row['description'], " ", 100);
    $description .= substr($row['description'],101,$pos);    
    ?>
    <div class="bookSimple">
    <a class="booktitle" href="ProductPage.php?isbn=<?php echo $isbn;?>"><?php echo $row['title']; ?></a><br />
    <font size='-1'>by <?php echo fListAuthors($isbn); ?> </font><br />
    <a href="ProductPage.php?isbn=<?php echo $isbn; ?>">
       <img class="Book" alt="<?php echo $row['title']; ?>" src="<?php echo "http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/$isbn.01.THUMBZZZ.jpg"; ?>" />
    </a>
    <p>
    <?php echo $description; ?>
    <a href="ProductPage.php?isbn=<?php echo $isbn; ?>">more...</a>
    </p>
    <br />
    </div>
<?php
}
?>  
</div>

<?php
include('Footer.php');
?>
</div>
</div>
</body>
</html>