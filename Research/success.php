<?php include 'inc/header.php';?>
  <?php 
  $login = Session::get("cuslogin");
  if ($login == false) {
      header("Location:login.php");
  }
?>

<?php
   if (isset($_GET['orderid']) && $_GET['orderid'] == 'order') {
     $cmrId = Session::get("cmrId");
     $delData =$ct->delCustomerCart();
     header("Location:orderdetails.php");
   }
?>



<style>
 .psuccess{width: 500px;min-height: 200px;text-align: center;border: 1px solid #ddd;margin: 0 auto;padding: 20px;}
 .psuccess h2{border-bottom: 1px solid #ddd;margin-bottom: 20px;padding-bottom: 10px;}
.psuccess p{font-size: 18px;line-height: 25px;text-align: left;}
</style>
  <div class="main"> 
    <div class="content">
      <div class="section group">
        <div class="psuccess">
        <h2>Success</h2>
        <?php
          $cmrId = Session::get("cmrId");
          $amount = $ct->payableAmount($cmrId);
          if($amount){
             $sum = 0;
          while ($result = $amount->fetch_assoc()) {
          	$price = $result['price'];
          	$sum = $sum+$price;
             }
          }
        ?>
          <p>Total Payable Amount(Including Vat) : $
           <?php
                $vat = $sum * 0.1;
                $total = $sum+$vat;
                echo $total;
           ?>
          <p>Print <a href="invoice.php"><u><strong>INVOICE</<strong></u></a> first then go to order details</p>
          </p>
          <p>Thanks for Purchase.Receive Your Order Successfully.We will contact you as soon as possible with delivery details.Here is your order details... <a href="?orderid=order"> Visit Here..</a></p>
        </div>           
       </div>
     </div>
  </div>
   <?php include 'inc/footer.php';?>