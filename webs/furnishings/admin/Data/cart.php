<?
require_once('mini.php');

//$type=1;//$_REQUEST['type'];
$gprodid=$_REQUEST['prodid'];
$gcustid=$_REQUEST['cust_id'];
$gorderdate=$_REQUEST['order_date'];
$gprice=$_REQUEST['price'];
$gshipping=$_REQUEST['shipping'];
$gsession=$PHPSESSID;
$gstatus=$_REQUEST['status'];
$gqty=$_REQUEST['qty'];
$gcomm=$_REQUEST['comments'];

	mysql_select_db($database_mini, $mini);
$query_showinfo = sprintf("SELECT count(oderid) as thecart FROM oders where sessionid='$gsession' ");
$showinfo = mysql_query($query_showinfo, $mini) or die(mysql_error());
//$totalRows_showinfo =mysql_fetch_assoc($showinfo);
//$totshowinfo = mysql_num_rows($showinfo);




?>

<a href="updatecart.php?ID=<? echo $gsession ?>">Cart Items:</a>  <?php do{ 
 echo $row_showinfo['thecart'];
}  while ($row_showinfo = mysql_fetch_assoc($showinfo));
?> | 
<a href="checkout.php">Checkout</a>