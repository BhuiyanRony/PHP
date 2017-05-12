
 <?php
    include 'lib/Session.php';
    Session::init();
    include 'lib/Database.php';
    include 'helpers/Format.php';

     spl_autoload_register(function($class){
     	include_once"classes/".$class.".php";

     });

     $db = new Database();
     $fm = new Format();
     $pd = new Product();
     $cat = new Category();
     $ct = new Cart();
     $cmr = new Customer();
     $mess = new Message();

?>
<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>


    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                            	<h3>Bhuiyan Store</h3>
                                <!-- <img src="http://nextstepwebs.com/images/logo.png" style="width:100%; max-width:300px;"> -->
                            </td>
                            
                            <td>

                              <?php
						        $id = Session:: get("cmrId");
						        $getdata = $cmr->getCustomerData($id);
						        if ($getdata) {
						        while ($result = $getdata->fetch_assoc()) {
						      ?>

                                Invoice #:
                                <?php 
									$invoiceCode = 'BS'.date("ymdhi");
									echo $invoiceCode;
                                 ?><br>
                                <?php echo "Created " . date("Y.m.d") . "<br>"; ?>
                            </td>

     		 <?php } } ?>

                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Bhuiyan Store<br>
                                AR Tower<br>
                                Kemal Ataturk Avenue, Bananai
                            </td>
                            
        <?php
        $id = Session:: get("cmrId");
        $getdata = $cmr->getCustomerData($id);
        if ($getdata) {
        while ($result = $getdata->fetch_assoc()) {
      ?>


                            <td>
                               <?php echo $result['name'];?><br>
                               <?php echo $result['email'];?><br>
                               <?php echo $result['address'];?>
                            </td>
                        </tr>

      <?php } } ?>

                    </table>
                </td>
            </tr>
            
           
            
            <tr class="heading">
                <td>
                    Item
                </td>

                <td>
                    Price
                </td>
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
            
            <tr class="item">
                <td>
                    <?php echo $result['productName']; ?> (<?php echo $result['quantity'] . ")";?>
                </td>

                
                
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


            
            <tr class="total">
                <td></td>
               
                
                <td>
                <?php
                
                 $vat    = $sum * 0.1;
                 $gtotal = $sum + $vat;
                 echo "Total(With VAT):" . $gtotal;
                 ?>
                </td>
            </tr>

         

        </table>


			<div style="text-align:center;">
			<br>
			<button onclick="myFunction()">Print this page</button>
			<form method="get" action="success.php">
			<br>
   			 <button type="submit">Back</button>
			</form>
			</div>
    		



			<script>
			function myFunction() {
			    window.print();
			}
			</script>

    </div>


    