<?php
include('Connection.php');
//Shopping cart uses cookies to store cart items.
//PHP script uses an array for adding, removing and displaying the cart items.
//Cookies can contain only string data so array must be serialized.

$cookieName = "myCart2";
// retrieve cookie and unserialize into $bookArray
if (isset($_COOKIE[$cookieName])) {
    $bookArray = unserialize($_COOKIE[$cookieName]);
}
// Add items to cart
$addISBN = CleanISBN($_GET['addISBN']);
if (strlen($addISBN) > 0) {
    if (isset($addISBN, $bookArray)) {
        // Increment by +1
        $bookArray[$addISBN] += 1;
    } else {
        // Add new item to cart
        $bookArray[$addISBN] = 1;
    }
}
// Remove items from cart
$deleteISBN = CleanISBN($_GET['deleteISBN']);
if (strlen($deleteISBN) > 0) {
    if (isset($bookArray[$deleteISBN])) {
        // Deincrement by 1
        $bookArray[$deleteISBN] -= 1;
        // remove ISBN from array if qty==0
        if ($bookArray[$deleteISBN] == 0) {
            unset($bookArray[$deleteISBN]);
        }
    }
}
if (isset($bookArray)) {
    // Write cookie
    setcookie($cookieName, serialize($bookArray), time() + 60 * 60 * 24 * 180);
    
    //Count total books in cart
    $totalbooks = 0;
    foreach($bookArray as $isbn => $qty) {
        $totalbooks += $qty;
    }
    setCookie('BookCount', $totalbooks,  time() + 60 * 60 * 24 * 180);
}
//***************************************************
//You do not need to modify any code above this point
//***************************************************
include('Header.php');
$subtotal = 0;
$total = 0;
$count = 0;
?>


<div class="pageContainer">
<div class="leftColumn">
<?php include('LeftMenu.php'); ?>  
</div>
<div class="container">
<center>
    
<p>        
<? echo $totalbooks . " item";
if ($totalbooks != 1) {
    echo 's';
}
echo ' in your cart'
?> 
</p>

<table border='0' cellpadding='5' width='500px'>
    <tr>
        <th>Title</th>
        <th> Qty. </th>
        <th>Price each</th>
        <th>Total</th>
        <th> </th>
    </tr>
<?

if (count($bookArray)) {
    foreach($bookArray as $isbn => $qty) {
        $count += $qty;
    }
    
    $SQL= "Select isbn, title, price
               FROM bookdescriptions
               WHERE isbn=";
    foreach (array_keys($bookArray) as $book) {
        $SQL .= "'$book' OR isbn=";
    }
    $SQL=substr($SQL, 0, strlen($SQL)-9);
    $result=SelectRecord($SQL);
    
    while($row=mysql_fetch_array($result)) {
        $subtotal += $bookArray[$row['isbn']]*$row['price'];
?>
       <tr>
          <td width="75">
              <a class="booktitle" href="ProductPage.php?isbn=<? echo $row['isbn']; ?>"> <?php echo $row['title']; echo $bookArray[$row['$isbn']];?></a> 
          </td>
          
          <td width="75">
              <?php echo $bookArray[$row['isbn']]; ?> 
          </td >
          <td width="75" class="bookPrice">
              <?php echo $row['price'] ?>
          </td>
          <td width="75" class="bookPrice">
              <?php echo number_format($row['price']*$bookArray[$row['isbn']], 2); ?>
          </td>
          <td width="75">
               <a href="ShoppingCart.php?addISBN=<? echo $row['isbn']; ?>">Add</a><br>
               <a href="ShoppingCart.php?deleteISBN=<? echo $row['isbn']; ?>">Remove</a>
          </td>
          
       </tr>
       
        <?
        echo $bookArray[$row['$isbn']];
        $count = $count + $bookArray[$row['$isbn']];
    }
} 
if ($count!=0) {
$shipping = 3.49+($count-1)*0.99;
$total = $subtotal+$shipping;
} else {
    $shipping=0;
}
?>
       <tr>
            <td width="350"></td>
            <td width="75"> Sub-Total:</td>
            <td width="75" align="right" class="bookPrice"><?php echo number_format($subtotal,2,'.',''); ?> </td>
          </tr>
              <tr>
            <td width="350"></td>
            <td width="75"> Shipping:*</td>
            <td width="75" align="right" class="bookPrice"><?php echo number_format($shipping,2,'.',''); ?></td>
          </tr>
          <tr>
            <td width="350"></td>
            <td width="75"><b>Total:</b></td>
            <td width="75" align="right" class="bookPrice"><b><?php echo number_format($total,2,'.','');  ?></b></td>
          </tr>

</table>
    
<div class="cartIcons">
            <a href="index.php"> <img border="0" src="http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/continue-shopping.gif" width="121" height="19" alt="Continue shopping" style="float:left;" /></a>
            <a href="checkout01.php"> <img border="0" src="http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/proceed-to-checkout.gif" width="183" height="31" alt="Proceed to checkout" style="float:right;" ></a>
        </div>


        <p style="width:400px; margin:10px auto; text-align:center;">* Shipping is $3.49 for the first book and $.99 for each additional book. To assure
        reliable delivery and to keep your costs low we send all books via UPS ground. </p>


</center>
   </div>
</div>
<?php 
include('footer.php');
//// ********************************************
// Utilities **********************************
function CleanISBN($isbn)
{
    return preg_replace("/[^0-9X]{1,}/", "" , substr($isbn, 0, 10));
}
?>
</body>
</html>