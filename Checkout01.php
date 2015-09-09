<?php
session_start();

$IsValid=true;
$postback = $_POST['postback'];
$email=$_POST['email'];
$emailre="^[\w-]+(\.[\w-]+)*@([a-z0-9-]+(\.[a-z0-9-]+)*?\.[a-z]{2,6}|(\d{1,3}\.){3}\d{1,3})(:\d{4})?$^";

if ($postback) {
    if (!(preg_match($emailre,$email)) || !(strlen($email)>0)) {
        $IsValid=false;
    } else {   
        $_SESSION['email']=$email;
        header("Location: Checkout02.php");
    }
}
include_once("Connection.php");
include("Header.php");    
include("formvalidate.php");
//Shopping cart uses cookies to store cart items.
//PHP script uses an array for adding, removing and displaying the cart items.
//Cookies can contain only string data so array must be serialized.
$count=0;
$cookieName = "myCart2";
// retrieve cookie and unserialize into $bookArray
if (isset($_COOKIE[$cookieName])) {
    $bookArray = unserialize($_COOKIE[$cookieName]);
    
    foreach($bookArray as $isbn => $qty) {
        $count += $qty;
    }
}
// Add items to cart




?>
<div class="pageContainer">
        <div class="leftColumn">

<?php
include('LeftMenu.php');
?>
        </div>
    <div class="content">
        <center>
        <span class="pageTitle">Your Account</span>
        </center>
        <p class="pageTitle2">
            <?php
                if ($count>0) {
                    echo "Buying online is quick and easy!<br />";
                    echo "You have $count item";
                    if ($count >1)
                        echo "s";
                    echo " in your cart";
                } else {
                    echo "Buying online is quick and easy!";
                }
            ?>
        </p>
        
  
        <div class="cartIcons" style="height: 100px;">
  
            <form method="POST"  > 
                <input type="hidden" name="postback" value="true" />
                <span class="pageTitle2">Email:</span> 
                <input type="text" name="email" size="36">
                <br />
                
                <br />
                <input type="image" src="http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/proceed-to-checkout.gif">
            </form>
        </div>
  
<?php
                    if (isset($postback) && !$IsValid) {
                        RedFont("Please Enter a valid email address");
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

