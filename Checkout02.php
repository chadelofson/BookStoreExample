<?php
session_start();
$email=$_SESSION['email'];
include_once('Connection.php');
include('formvalidate.php');
$postback = $_POST['postback'];
if ($postback) {
    $IsValidEmail=ValidateEmail($_POST['email']);
    if (IsValidEmail && strlen($_POST['fname'])>0 && strlen($_POST['lname'])>0 && strlen($_POST['street'])>0 && strlen($_POST['city'])>0 && strlen($_POST['state'])>0 && strlen($_POST['zip'])>0) {
        $email = $_POST['email'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $custID = $_POST['custID'];
        
        
        if ($custID==0) {
            $SQL = "INSERT INTO bookcustomers (email,fname,lname,street,city,state,zip)
                    VALUES ('$email','$fname','$lname','$street','$city','$state','$zip')";
        
            $result=InsertRecord($SQL);
            $custID = mysql_insert_id();
        } else {
            $SQL = "UPDATE bookcustomers
                    SET email='$email',fname='$fname',lname='$lname',street='$street',city='$city',state='$state',zip='$zip'
                    WHERE custID=$custID";
            $result = UpdateRecord($SQL);
        }
        
        $_SESSION['userinfo'][0] = $custID;
        $_SESSION['userinfo'][1] = $email;
        $_SESSION['userinfo'][2] = $fname;
        $_SESSION['userinfo'][3] = $lname;
        $_SESSION['userinfo'][4] = $street;
        $_SESSION['userinfo'][5] = $city;
        $_SESSION['userinfo'][6] = $state;
        $_SESSION['userinfo'][7] = $zip;
        
        header("Location: Checkout03.php");
    } 
        
}


include('Header.php');



?>
<div class="pageContainer">
        <div class="leftColumn">

<?php
include('LeftMenu.php');



$SQL = "SELECT custID, fname, lname, email, street, city, state, zip
        FROM bookCustomers
        WHERE email='$email'";

$result=SelectRecord($SQL);
?>
        </div>
    <div class="content">
        <span class="pageTitle">Shipping Information</span>
<br><br>
<?php
if (mysql_num_rows($result) == 0 ) {
    $custID=0;
 echo "New Customer - Please provide your shipping address.";
 }
 else {
 echo "Returning Customer - Please confirm your mailing and e-mail addresses."; 
$row = mysql_fetch_array($result);
$custID=$row['custID'];

 }
?>
<br><br>
<form method="POST"  >

                            <table border="0" cellpadding="5" style="width:400px; margin:0 auto 0 auto; text-align:left;">

                                <tr>
                                    <td width="100">
                                        Email</td>
                                    <td width="300">
                                            <?php  if ($postback) { ?>
                                            <input type="text" name="email" size="21" value="<?php echo $_POST['email']; ?>"><br />
                                            <?php  } else { ?>
                                            <input type="text" name="email" size="21" value="<?php echo $email; ?>"><br />
                                            <?php
                                                   }
                                                if ($postback && !$IsValidEmail) {
                                                    RedFont("Invalid Email");
                                                }
                                            ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        First name</td>
                                    <td>
                                            <?php  if ($postback) { ?>
                                            <input type="text" name="fname" size="21" value="<?php echo $_POST['fname']; ?>"><br />
                                            <?php  } else { ?>
                                            <input type="text" name="fname" size="21" value="<?php echo $row['fname']; ?>"><br />
                                            <?php
                                                   }
                                                if ($postback && !(strlen($_POST['fname'])>0)) {
                                                    RedFont("Please enter a first name");
                                                }
                                            ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        Last name</td>
                                    <td>
                                            <?php  if ($postback) { ?>
                                            <input type="text" name="lname" size="21" value="<?php echo $_POST['lname']; ?>"><br />
                                            <?php  } else { ?>
                                            <input type="text" name="lname" size="21" value="<?php echo $row['lname']; ?>"><br />
                                            <?php
                                                   }
                                                if ($postback && !(strlen($_POST['lname'])>0)) {
                                                    RedFont("Please enter a last name");
                                                }
                                            ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Street </td>
                                    <td>
                                        <?php  if ($postback) { ?>
                                            <input type="text" name="street" size="21" value="<?php echo $_POST['street']; ?>"><br />
                                            <?php  } else { ?>
                                        <input type="text" name="street" size="21" value="<?php echo $row['street']; ?>"><br />
                                            <?php
                                                   }
                                                if ($postback && !(strlen($_POST['street'])>0)) {
                                                    RedFont("Please enter a street address");
                                                }
                                            ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        City</td>
                                    <td>
                                        <?php  if ($postback) { ?>
                                            <input type="text" name="city" size="21" value="<?php echo $_POST['city']; ?>"><br />
                                            <?php  } else { ?>
                                        <input type="text" name="city" size="21" value="<?php echo $row['city']; ?>"><br />
                                            <?php
                                                    }
                                                if ($postback && !(strlen($_POST['city'])>0)) {
                                                    RedFont("Please enter a city");
                                                }
                                            ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        State</td>
                                    <td>
                                        <?php  if ($postback) { ?>
                                            <input type="text" name="state" size="21" value="<?php echo $_POST['state']; ?>"><br />
                                            <?php  } else { ?>
                                        <input type="text" name="state" size="2" value="<?php echo $row['state']; ?>"><br />
                                            <?php
                                                   }
                                                if ($postback && !(strlen($_POST['state'])>0)) {
                                                    RedFont("Please enter a state");
                                                }
                                            ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        Zip</td>
                                    <td>
                                        <?php  if ($postback) { ?>
                                            <input type="text" name="zip" size="21" value="<?php echo $_POST['zip']; ?>"><br />
                                            <?php  } else { ?>
                                        <input type="text" name="zip" size="5" value="<?php echo $row['zip']; ?>"><br />
                                            <?php
                                                   }
                                                if ($postback && !(strlen($_POST['zip'])>0)) {
                                                    RedFont("Please enter a zip code");
                                                }
                                            ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        </td>
                                    <td>
                                        <input type="hidden" name="postback" value="true" />
                                        <input type="hidden" name="custID" value="<?php echo $custID;?>">
                                        <input type="image" src="http://yorktown.cbe.wwu.edu/sandvig/mis314/assignments/bookstore/images/buy-now.gif">
                                    </td>
                                </tr>
                            </table>
</form>
<br>
    <p align='center'>
        <?php  
            $ohCustID = ($custID+800)*200;
        ?>
                <a href="OrderHistory.php?custID=<?php echo $ohCustID; ?>">View Your Order History</a>  
        
    </div>
<?php
include('Footer.php');
?>
</div>
</div>
</body>
</html>
<?php

?>
