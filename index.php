<!DOCTYPE html>
<html lang="en">

  <head>
<!-- coding standards now requites to mention my name if you use this. @AlexandraMartinez -->

      <!-- Bootstrap and FA CSS -->
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="./font-awesome-4.6.3/css/font-awesome.min.css">

      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <!-- Bootstrap JavaScript -->
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

<?php
include('common.php');
    if(session_start()) {
    //creates a variable to save all billing data, now this is obviously wrongly located here, it needs an if  
    //if()
        $bills = getAllBills();
    //creates a variable to save page total
    $grandTotal  = 0;

   // preprint($_SESSION); 
    }
?>
<body>

    <div class="container main-container"> <!-- main container -->
        <div class="row" align="center">
            <div class="col-xs-12">
            <!-- header2-row -->
            <h2 class ="text-center">All Bills View Page  </h2> <!-- page title -->
        </div>

        <div class="row"> <!-- add another bill -->
            <div class="col-xs-2 col-xs-offset-10">
                <a class="btn btn-large btn-primary btn-block" href="./billAdd.php"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Add</a>
            </div>
        </div>

        <div class="row"> <!-- Table row -->
        <div class="col-xs-12">
            <table class="text-center table table-striped table-hover" >
                <thead class="text-center"> <!-- Table head -->
                    <tr>
                        <th class="text-center">Number </th>
                        <th class="text-center">Serial Number</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Emitent</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">State</th>
                        <th class="text-center">View</th>
                        <th class="text-center">Edit</th>
                    </tr>
                </thead>

                <tbody> <!--table body -->
                <?php
                //declare and initalize variable total to array containing products data from db
                $products = getAllProducts();

                // calculates the products total for each produs with a certain id_fact which at this point we are not using, used in total **php implementation**
                // function totalProducts($id_fact) {
                //     $total_local = 0;
                //     $products = getAllProductsByID($id_fact);
                //     foreach($products as $produs) {
                //         $total_local += $produs["cantitate"] * $produs["pret_unitar"];
                //     }
                //     return $total_local;
                // }

                // calculates the products total for each produs with certain bill_id, but fetches data from a returned array calculated in sql  **sql fantom col implementation**
                $totalBill = selectTotalPerBill();
                $idNum = 0;

                foreach($bills as $bill) {
                    //gets the id number of the bill
                    //preprint($bill);
                    $idNum +=1;
                    $factId = $bill['id'];
                    //var to store total on each bill data using php version of the code
                    //$products_total = 0;

                    //calculates the total per bill
                    if($totalBill[$factId]['tg']) {
                        $singleRowTotalRoundedAt2 = round($totalBill[$factId]['tg'],2);
                        $grandTotal += round($totalBill[$factId]['tg'],2);

                    ?>
                        <tr>
                            <td class="text-center"><?php echo $idNum?></td>
                            <td class="text-center"><?php echo $bill["serie"]?>/<?php echo $bill["nr"]?></td>
                            <td class="text-center"><?php echo $bill["data_emiterii"]?></td>
                            <td class="text-center"><?php echo $bill["benef_denumire"]?></td>
                            <td class="text-center"><?php echo $singleRowTotalRoundedAt2 // total?></td>
                            <td class="text-center"><?php echo $bill["stare"]==1?"Platit":"Neplatit"?></td>
                            <td class="text-center"><a href= <?php echo "factView.php?idfact=".$bill["id"]?> class="btn btn-primary"><span class="fa fa-eye"></span> View</a></td>
                            <td class="text-center"><a href= <?php echo "factEdit.php?idfact=".$bill["id"]?> class="btn btn-primary"><span class="fa fa-edit"></span> Edit</a></td>
                        </tr>
                    <?php
                    }   
                }?>

            </tbody>
                <tfoot>
                    <tr>
                        <th/>
                        <th/>
                        <th/>
                        <th class="text-center"> Grand Total </td>
                        <th class="text-center"><?php echo  $grandTotal;?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>
</div>
</body>
</html>
