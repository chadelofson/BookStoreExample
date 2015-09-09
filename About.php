<?php
include('Connection.php');
include('Header.php');
?>
<div class="pageContainer">
        <div class="leftColumn">

<?php
include('LeftMenu.php');
?>
        </div>
<div class="content">
<font face="Comic Sans MS" color="#CC0000">Site Features</font>
        <ul>
          <li>Site created by Chad Elofson, as a class project for <a href="http://yorktown.cbe.wwu.edu/sandvig/mis314/">MIS
            314</a> at Western Washington University. </li>
          <li>All product information is dynamically generated using PHP and mySQL.</li>
          <li>Product, customer and order information is stored in a mySQL database.</li>
          <li>Include files are used for all code that is used more
            than once (i.e. search/browse menu, ListAuthor function, 
            header and footer). </li>
          <br>
          <li><b>mySQL Database</b>
            <ul>
              <li>Is normailzed to 3rd normal form (or greater). Tables include:
                <ul>
                  <li>book details </li>
                  <li>book categories</li>
                  <li>relationship details-books (many-to-many) </li>
                  <li>authors</li>
                  <li>relationship authors-books  (many-to-many) </li>
                  <li>customers</li>
                  <li>orders</li>
                  <li>order items (one-to-many) </li>
                </ul>
              </li>
              <li>Database is  located on a separate database server for greater security and speed.</li>
            </ul>
          <li><b>Home page</b></li>
          <ul>
            <li>Selects three random items from from the
            database using a SQL statement.</li>
            <li>Generates the browse menu dynamically from the database using a SQL query that shows
              only the book categories that currently contain books.</li>
            <li>Truncates book descriptions at 250 characters.</li>
          </ul>
          <li><b>Search page</b>
                <ul>
                  <li>Cleans user entered data to protect against SQL Injection attacks and cross-site scripting. </li>
                  <li>Searches book title, description, author and
                    category fields in the database.</li>
                  <li>The mysql_num_rows() function is used
                    to count the number of books found by the search.</li>
                  <li>Responds gracefully to searches that return no matches.</li>
                </ul>
          </li>
          <li><b>Shopping cart page</b>
                <ul>
                  <li>Uses a cookie to store the ISBNs of items in the
                    cart.</li>
                </ul>
          </li>
          <li><b>Checkout pages</b>
                <ul>
                  <li>Searches the database for email addresses of existing
                    customer accounts and writes their shipping information in
                    the form on the order confirmation page.</li>
                </ul>
          </li>
          <li><b>Order Confirmation Page</b>
                <ul>
                  <li>Checks for shopping cart and prompts user if cart is
                    empty.</li>
                  <li>All fields are checked to make sure that they contain
                    information.</li>
                  <li>Checks email address in database and prompts user to try
                    again user if address not found.</li>
                  <li>Modifications made to customer information are updated in
                    the database.</li>
                  <li>Order information are written to the database.</li>
                  <li>An email is sent to the customer with the order
                    information.</li>
                    <li>The shopping cart is emptied by setting ItemCount to zero in the ShoppingCart cookie.</li>
                </ul>
          </li>
          <li><b>Order History Page</b>
                <ul>
                  <li>Searches the database for all orders associated with
                    e-mail address</li>
                  <li>If no matching email address is found user is prompted to
                    try again.</li>
                </ul>
          </li>
          <li><b>Enhancements</b>
                
                <p></li>
          <li>Thanks to Amazon.com for the use of its
            icons, book images and book descriptions.</li> 
          <li>Gives number of books per category on the side menu</li>
          <li>Same Page validation on <b>Checkout01</b> and <b>Checkout02</b></li>
          <li><b>OrderHistory</b> now groups the orders pragmattically by orderID</li>
</div>

<?php
include('Footer.php');
?>
</div>
</div>
</body>
</html>