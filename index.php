<?php
include_once('Connection.php');
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
$SQL="SELECT isbn, title, description
      FROM bookdescriptions
      ORDER BY RAND()
      LIMIT 3";

$result=SelectRecord($SQL);

while ($row=mysql_fetch_array($result)) {
    $isbn=$row['isbn'];
    $description = substr($row['description'],0,100);
    $pos = strpos($row['description'], " ", 99);
    $description .= substr($row['description'],101,$pos);
?>
    <div class='bookSimple'>
        <a class='booktitle' href="ProductPage.php?isbn=<?php echo $isbn; ?>"><?php echo $row['title'] ?></a><br />
        <a href='ProductPage.php?isbn=<?php echo $isbn; ?>'> 
            <img class='Book' alt="<?php echo $row['title']; ?>" src='http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/bookimages/<?php echo $isbn; ?>.01.THUMBZZZ.jpg'>
        </a>
        <p>
            <?php echo $description; ?>
            <a href='ProductPage.php?isbn=<?php echo $isbn; ?>'>more...</a>
        </p>
    </div>
<?php
}
?>  
</div>

<?php
include('Footer.php');
?>
</div>

</body>
</html>
