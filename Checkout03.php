<?php
session_start();
//$userinfo = ;

$custID=$_SESSION['userinfo'][0];
$email=$_SESSION['userinfo'][1];
$fname=$_SESSION['userinfo'][2];
$lname=$_SESSION['userinfo'][3];
$street=$_SESSION['userinfo'][4];
$city=$_SESSION['userinfo'][5];
$state=$_SESSION['userinfo'][6];
$zip=$_SESSION['userinfo'][7];

include_once("Connection.php");
include("Header.php");

?>
    <div class="pageContainer">
        <div class="leftColumn">
<?php
include("LeftMenu.php");
?>
        </div>
<?php
// Update if the string length is longer

    $cookieName = "myCart2";
    // retrieve cookie and unserialize into $bookArray
    //if (isset($_COOKIE[$cookieName])) {
        $bookArray = unserialize($_COOKIE[$cookieName]);
    //}
    setcookie($cookieName, null, time()-60000);
    if (empty($bookArray)) {
        ?>
        <div class="content">
        <div class="pageTitle">Account Information</div>
        Your customer information has been updated
    </div>
    <br />
    <a href="index.php">
                  <img border="0" src="images/continue-shopping.gif" width="121" height="19">
    </a>
    <br /><br />
    <?php
                    $ohCustID = ($custID+800)*200;
    ?>
    <a href="OrderHistory.php?custID=<?php echo $ohCustID; ?>">View Your Order History</a>
    </div>
     <?php   
    } else {
        $time=time();

        $SQL="INSERT into bookorders (custID,orderdate)
              VALUES ($custID,$time)";
        $result=InsertRecord($SQL);
        $orderID=mysql_insert_id();

        foreach($bookArray as $key => $qty) {
            $SQL = "INSERT INTO bookorderitems (orderID, isbn, qty, price) 
                    VALUES ($orderID, '$key', $qty, (select price from bookdescriptions where ISBN='$key'))";
            $result=InsertRecord($SQL);
        }
    


?>
<div class="content">
<div class="pageTitle">Order Confirmation</div>
<br />  
<table border="0" cellpadding="10" cellspacing="0" width="700" style="margin:0 auto 0 auto; text-align:left;">
   <tr>
      <td width="150" valign="top" class="boldLabel">
         Order Number:</td>
      <td width="550">
          <?php echo $orderID; ?>
      </td>
   </tr>

   <tr>
      <td valign="top" class="boldLabel">
         Shipping Address:</td>
      <td >
         <?php echo "$fname $lname<br />\n$street<br />\n$city, $state $zip\n"; ?>
      </td>
   </tr>

   <tr>
      <td valign="top" class="boldLabel">
         Books Shipped:</td>
      <td>
        <table>
            <tr>
                <td width='400'></td>
                <td width='50'>Qty.</td>
                <td width='150'>Price each</td>
                <td width='150'>Total</td>
            </tr>            
            
<?php
    // Develop Email
    $to = $email;
    $subject = "Order Confirmation from JAS Books";
    $body = "Order Confirmation from JAS Books\n\n";
    $body .= "Items shipped:\n\n";
    
    $count=0;
    $subtotal=0;
    $shipping=0;
    $total=0;
    
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
    while ($row = mysql_fetch_array($result)) {
        $subtotal += $bookArray[$row['isbn']]*$row['price'];
        $body .= $row['title'] . " Qty " . $bookArray[$row['isbn']] . "\n";
?>
            <tr>
               <td>
                   <a class="booktitle" href="ProductPage.php?isbn=<?php echo $row['isbn']; ?>"><?php echo $row['title'];?></a> 
               </td>
               <td align="center"><!-- qty -->
                   <?php echo $bookArray[$row['isbn']]; ?> 
               </td>
               <td>
                   <?php echo $row['price'] ?> 
               </td>
               <td>
                   <?php echo number_format($row['price']*$bookArray[$row['isbn']], 2); ?>
               </td>
            </tr>
<?php
         
    }
    $shipping = 3.49+($count-1)*0.99;
    $total = $subtotal+$shipping;
    
    $body .= "\nShipped to:\n";
    $body .= "$fname lname\n";
    $body .= "$street\n";
    $body .= "$city, $state $zip\n\n";
    $body .= "Order number: $orderID\n";
    $body .= "Total cost: $total\n\n";
    $body .= "Your order should arrive via UPS Ground within 5-10 business days.\n";
    $body .= "Thank you for shopping with JAS Books.";
    
?>
        </table>
         <br>
      </td>
   </tr>

</table>

<table border="0" cellpadding="0" cellspacing="0" width="400" style="margin:0 auto 0 auto; text-align:left; ">
   <tr>
      <td width="250"></td>
      <td width="75"> Sub-Total:</td>
      <td width="75" align="right"><?php echo number_format($subtotal,2,'.',''); ?></td>
         </tr>
         <tr>
            <td width="250"></td>
            <td width="75"> Shipping:</td>
            <td width="75" align="right"><?php echo number_format($shipping,2,'.',''); ?></td>
         </tr>
         <tr>
            <td width="250"></td>
            <td width="75"> Total:</td>
            <td width="75" align="right"><?php echo number_format($total,2,'.','');  ?></td>
                  </tr>
               </table>



            <br />
            <div align="center">
               <font face="Comic Sans MS">A confirmation has been sent to your email address.<br />
                  Thank you for shopping with JASBooks.com.</font>
               <br />
               <br />
               <br />
               <a href="index.php">
                  <img border="0" src="images/continue-shopping.gif" width="121" height="19"></a><br />
               <br />
               <?php
                    $ohCustID = ($custID+800)*200;
               ?>
               <a href="OrderHistory.php?custID=<?php echo $ohCustID; ?>">View Your Order History</a>
               </div>

               <br><br><br>
</div>

<?php
include("Footer.php");
?>
</div>
<?php
mail($email, $subject ,$body, 'From: elofsoc@students.wwu.edu');
    
}
?>
