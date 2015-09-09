<?php
include('Connection.php');
include('ListAuthors.php');
include('Header.php');
$custID=$_GET['custID'];
$custID= $custID/200 - 800;
?>
<div class="pageContainer">
        <div class="leftColumn">

<?php
include('LeftMenu.php');
?>
        </div>
<div class="content">
<?php
//if(strlen($_GET['catID'])>0) {
       
    $SQL="SELECT DISTINCT o.orderID, b.isbn,b.title,i.qty,orderdate
          FROM bookdescriptions b,bookorders o,bookorderitems i,bookauthors a, bookauthorsbooks ab
          WHERE o.custID=$custID AND b.isbn=i.isbn AND o.orderID=i.orderID AND a.authorID=ab.authorID AND b.isbn=ab.isbn
          ORDER BY orderdate DESC,title";
    
    $result=SelectRecord($SQL);
    $count=mysql_num_rows($result);
    echo "<div class=\"pageTitle2\">";
    echo "You have $count ordered books";
    echo "</div>\n";
    

    $prev = 0;
while ($row=mysql_fetch_array($result)) {
    $isbn=$row['isbn'];
    if ($row['orderID']!= $prev) echo "<hr />";
    ?>
    <div class="bookHistory">
    <a href="ProductPage.php?isbn=<?php echo $isbn; ?>">
        <?php
        
       echo "<img class=\"History\" src=\"http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/" . $row['isbn'] . ".01.THUMBZZZ.jpg\" />";
           ?>
                  </a>
             <?php
             if ($row['orderID']!= $prev) {
             ?>
                 <b>Order ID: <?php echo $row['orderID']+1000 ; ?></b>&nbsp;&nbsp;
                 
             <?php
             }    
                 $date = date('F j Y',$row['orderdate']);
                 echo $date;
             ?>
                 <br /> 
 		         <a class="booktitle" href="ProductPage.php?isbn=<?php echo $isbn; ?>"><?php echo $row['title']; ?></a><br />
                         <span class="authors">by <?php echo fListAuthors($isbn); ?></span><br />
                  Qty: <?php echo $row['qty']; ?><br /><br />
    </div>
<?php
    //if ($row['orderID']!= $prev) echo "<hr />";
    $prev=$row['orderID'];
}
?>  
</div>

<?php
include('Footer.php');
?>
</div>
</body>
</html>