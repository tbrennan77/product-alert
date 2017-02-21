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
$query_showinfo = sprintf("SELECT oders.prodid, oders.qty, oders.price, products.prod_name FROM oders inner join products on oders.prodid=products.productid where sessionid='$gsession' ");
$showinfo = mysql_query($query_showinfo, $mini) or die(mysql_error());
//$totalRows_showinfo =mysql_fetch_assoc($showinfo);
$qtotals1 = mysql_num_rows($showinfo);
$qtotals=$qtotals1+1;


?>
<table width="188" border="2" cellspacing="1" cellpadding="1">
   <tr>
     <th scope="col"></th>
     <th scope="col"></th>
     <th scope="col"></th>
     <th scope="col"></th>
   </tr>
   
   <?php
 
    $i==0;
				do { 
				$i++;
	   $prodid1=$row_showinfo['prodid'];
	  
	   if($prodid1!=''){
		   $tprice1=$row_showinfo['price'];
		 //  setlocale(LC_MONETARY,"en_US");
          $theproductname=$row_showinfo['prod_name'];
		  $theproductname1=substr($theproductname,0,5);
             echo ("<div id=\"contactform\">");
		    echo ("<form name=\"updateforms$i\" ");
		   
	   echo ("<tr>");
     echo ("<td>".$theproductname1."</td>");
     echo ("<td>".money_format("%i", $tprice1)."</td>");
     echo ("<td> <input name=\"qty$i\" type=\"text\" id=\"qty$i\" size=\"1\" value=\"".$row_showinfo['qty']."\" />
</td>");
 echo ("<input name=\"thenumber$i\" type=\"hidden\" id=\"thenumber$i\" size=\"1\" value=\"".$i."\" />");
 echo ("<td><a href=\"#\" class=\"button mini\" onclick=\"updateform$i()\">update</a></td>");
	 echo ("</tr><input name=\"prodid$i\" type=\"hidden\" id=\"prodid$i\" size=\"1\" value=\"".$row_showinfo['prodid']."\" /><input name=\"session$i\" type=\"hidden\" id=\"session$i\" size=\"1\" value=\"".$gsession."\" /></form>"); }
	}  while ($row_showinfo = mysql_fetch_assoc($showinfo));?>   
  </div>
 </table>

<a href="checkout.php?sessionid=<? echo $gsession ?>"><br />
Proceed To Checkout
</a>
 <script language="javascript">
 var request = false;
   try {
     request = new XMLHttpRequest();
   } catch (trymicrosoft) {
     try {
	
       request = new ActiveXObject("Msxml2.XMLHTTP");
     } catch (othermicrosoft) {
       try {
         request = new ActiveXObject("Microsoft.XMLHTTP");
       } catch (failed) {
         request = false;
       }  
     }
   }</script>
<script language="javascript">
<? for($z=2;$z<=$qtotals;$z++){ ?>
function updateform<? echo $z ?>(){
	
	var gprodid<? echo $z ?>= document.updateforms<? echo $z ?>.prodid<? echo $z ?>.value;
	var gqty<? echo $z ?>= document.updateforms<? echo $z ?>.qty<? echo $z ?>.value;
	var gsessionid<? echo $z ?>= document.updateforms<? echo $z ?>.session<? echo $z ?>.value;
	var gthenumber<? echo $z ?>=document.updateforms<? echo $z ?>.thenumber<? echo $z ?>.value;
	if(gthenumber<? echo $z ?>==<? echo $z ?>){
		 var url<? echo $z ?> = "Data/ajaxupdates.php?sessionid=" + escape(gsessionid<? echo $z ?>) + "&qty="+ escape(gqty<? echo $z ?>) +"&type=1&prodid="+ escape(gprodid<? echo $z ?>) +""; 
	
	
     request.open("GET", url<? echo $z ?> , true);
	// alert(url);
	}
	
	
	
	
     request.onreadystatechange = updatePage<? echo $z ?>;
     request.send(null);

}

 function updatePage<? echo $z ?>() {
 
  if (request.readyState == 4) {
 var response = request.responseText;
      var updates<? echo $z ?> = new Array();
    if(response.indexOf('|' != -1)) {
    	updates<? echo $z ?> = response.split("|");
		alert(updates<? echo $z ?>);
		if(updates<? echo $z ?> != 0){
		//alert(updates1);
	
} }    }
   }
 <? } ?>
</script>