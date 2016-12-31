<!DOCTYPE HTML>
<html lang="en">

  <head>
      <!-- Also must include me if you use this index file, @za0ne101 -->
      <!-- Latest compiled and modified CSS -->
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="stylesheet" href="./font-awesome-4.6.3/css/font-awesome.min.css">

      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

      <!-- Latest compiled JavaScript -->
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
<?php
include('common.php');

    //creates a variable to save all billing data, now this is obviously wrongly located here, it needs an if  
    //if()
        $bills = getAllFacturi();
    //creates a variable to save page total
        $total = 0;

?>
<body>

    <div class="container main-container"> <!-- main container -->
        <div class="row" align="center">
            <div class="col-xs-12">
            <!-- header2-row -->
            <h2 class ="text-center">Situatia facturilor la data curenta</h2> <!-- page title -->
        </div>

        <div class="row"> <!-- add row -->
            <div class="col-xs-2 col-xs-offset-10">
                <a class="btn btn-large btn-primary btn-block" href="./factAdaugare.php"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Add</a>
            </div>
        </div>

        <div class="row"> <!-- Table row -->
        <div class="col-xs-12">
            <table class="text-center table table-striped table-hover" >
                <thead class="text-center"> <!-- Table head -->
                    <tr>
                        <th class="text-center">Nr. Crt.</th>
                        <th class="text-center">Serie / Nr</th>
                        <th class="text-center">Data</th>
                        <th class="text-center">Beneficiar</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Stare</th>
                        <th class="text-center">Vizualizare</th>
                        <th class="text-center">Editare</th>
                    </tr>
                </thead>

                <tbody> <!--table body -->
                <?php
                //declare and initalize variable total to array containing produse data from db
                $produse = getAllProduse();

                //calculates the produse total for each produs with a certain fact_id, used in total **php implementation**
                function totalProdus($id_fact) {
                    $total_local = 0;
                    $produse = getAllProdus($id_fact);
                    foreach($produse as $produs) {
                        $total_local += $produs["cantitate"] * $produs["pret_unitar"];
                    }
                    return $total_local;
                }

                // calculates the produse total for each produs with certain fact_id, but fetches data from a returned array calculated in sql  **sql fantom col implementation**
                $total_factura_tg = select_total_per_fact();
                $total_m = 0;

                foreach($bills as $factura) {
                    //gets the id number of the factura
                    //preprint($factura);
                    $fact_id = $factura['id'];
                    //var to store total on each factura data using php version of the code
                    $produse_total = 0;

                    //calculates the total per factura
                    if($total_factura_tg[$fact_id]['tg']) {
                        $total_f = round($total_factura_tg[$fact_id]['tg'],2);
                        $total_m += round($total_factura_tg[$fact_id]['tg'],2);

                    ?>
                        <tr>
                            <td class="text-center"><?php echo $fact_id + 1?></td>
                            <td class="text-center"><?php echo $factura["serie"]?>/<?php echo $factura["nr"]?></td>
                            <td class="text-center"><?php echo $factura["data_emiterii"]?></td>
                            <td class="text-center"><?php echo $factura["benef_denumire"]?></td>
                            <td class="text-center"><?php echo $total_f // total?></td>
                            <td class="text-center"><?php echo $factura["stare"]==1?"Platit":"Neplatit"?></td>
                            <td class="text-center"><a href= <?php echo "fact_view.php?idfact=".$factura["id"]?> class="btn btn-primary"><span class="fa fa-eye"></span> Vizualizeaza</a></td>
                            <td class="text-center"><a href= <?php echo "fact_edit.php?idfact=".$factura["id"]?> class="btn btn-primary"><span class="fa fa-edit"></span> Editeaza</a></td>
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
                        <th class="text-center"> Total General </td>
                        <th class="text-center"><?php echo  $total_m;?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>
</div>
</body>
</html>

