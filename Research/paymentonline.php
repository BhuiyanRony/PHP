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
     $insertOrder = $ct->orderProduct($cmrId);
     $delData =$ct->delCustomerCart();
     header("Location:success.php");
   }
?>
<style>
.division {width: 50%;float: left;}
.tblone{width: 500px;margin:0 auto;border: 2px solid #ddd; }
.tblone tr td{text-align: justify;}

.tbltwo {float:right;text-align:left;width: 60%;border: 2px solid #ddd;margin-right: 14px;margin-top: 12px;}
.tbltwo tr td{text-align: justify;padding: 5px 10px;}
.ordernow{padding-bottom: 30px;}
.ordernow  input{width: 200px;margin: 20px auto 0;text-align: center;padding: 5px;font-size: 30px; display: block; background: #ff0000;color: #fff;border-radius: 3px;} 
</style>


<form id="payment_gw" name="payment_gw" method="POST" action="https://sandbox.sslcommerz.com/gwprocess/v3/process.php">
  



  <div class="main"> 
    <div class="content">
      <div class="section group">
           <div class="division">
             <table class="tblone">
              <tr>
                 <th>No</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
              </tr>
            <?php 
                          $getPro = $ct->getCartProduct();
                          if ($getPro) {
                            $i  = 0;
                            $sum = 0;
                            $qty = 0;
                            while ($result = $getPro->fetch_assoc()) {
                              $i++;            
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $result['productName']; ?></td>
                <td>$ <?php echo $result['price']; ?></td>
                <td><?php echo $result['quantity']; ?></td>
                <td>$ <?php
                $total = $result['price'] * $result['quantity'];
                echo $total;
                ?></td>
              </tr>
              <?php
               $qty = $qty + $result['quantity'];
                             $sum = $sum + $total;
                          
                           ?>

              


              <?php } } ?>
                  </table>
            <table class="tbltwo">
              <tr>
                <td>Sub Total</td>
                <td>:</td>
                <td>$ <?php echo $sum; ?></td>
              </tr>
              <tr>
                <td>VAT</td>
                <td>:</td>
                <td>10% ($<?php echo $vat = $sum * 0.1; ?>) </td>
              </tr>
              <tr>
                <td>Grand Total</td>
                <td>:</td>
                <td><?php
                                  $vat    = $sum * 0.1;
                                  $gtotal = $sum + $vat;
                                  echo $gtotal;
                 ?> 
                 </td>

              <input type="hidden" name="total_amount" value="<?php echo $gtotal; ?>" />
              <input type="hidden" name="store_id" value="testbox" />
              <input type="hidden" name="tran_id" value="58ff22927f82b" />
              <input type="hidden" name="success_url" value="https://sandbox.sslcommerz.com/developer/success.php" />
              <input type="hidden" name="fail_url" value="https://sandbox.sslcommerz.com/developer/fail.php" />
              <input type="hidden" name="cancel_url" value="https://sandbox.sslcommerz.com/developer/cancel.php" />
              <input type="hidden" name="version" value="3.00" /> 


              </tr>
              <tr>
                <td>Quantity</td>
                <td>:</td>
                <td><?php echo $qty; ?></td>
              </tr>
             </table>

           </div>
           <div class="division">
             <?php
        $id = Session:: get("cmrId");
        $getdata = $cmr->getCustomerData($id);
        if ($getdata) {
          while ($result = $getdata->fetch_assoc()) {
      ?>
             <table class="tblone"> 
             <tr>
              <td colspan="3"><h2>Your Profile Details</h2></td>
             </tr>
               <tr>
                <td width="20%">Name</td>
                <td width="5%">:</td>
                <td><?php echo $result['name'];?></td>
               </tr>
               <tr>
                <td>Phone</td>
                <td>:</td>
                <td><?php echo $result['phone'];?></td>
               </tr>
               <tr>
                <td>Email</td>
                <td>:</td>
                <td><?php echo $result['email'];?></td>
               </tr>
               <tr>
                <td>Address</td>
                <td>:</td>
                <td><?php echo $result['address'];?></td>
               </tr>
               <tr>
                <td>City</td>
                <td>:</td>
                <td><?php echo $result['city'];?></td>
               </tr>
               <tr>
                <td>Zip-Code</td>
                <td>:</td>
                <td><?php echo $result['zip'];?></td>
               </tr>
               <tr>
                <td>Country</td>
                <td>:</td>
                <td><?php echo $result['country'];?></td>
               </tr>
               <tr>
                <td></td>
                <td></td>
                <td><a href="editprofile.php">Update Details</a></td>
               </tr>
             </table>

              <input type="hidden" name="cus_name" value="<?php echo $result['name']; ?>">
              <input type="hidden" name="cus_email" value="<?php echo $result['email']; ?>"> 
              <input type="hidden" name="cus_add1" value="<?php echo $result['address']; ?>">
              <input type="hidden" name="cus_city" value="<?php echo $result['city']; ?>">
              <input type="hidden" name="cus_postcode" value="<?php echo $result['zip']; ?>">
              <input type="hidden" name="cus_country" value="<?php echo $result['country']; ?>">
              <input type="hidden" name="cus_phone" value="<?php echo $result['phone']; ?>">



             <?php } } ?>
           </div>      
       </div>
     </div>

     <div class="ordernow">
          <input type="submit" name="submit" value="Pay Now" />
        </div>
  </div>

 
</form>



<?php include 'inc/footer.php';?>