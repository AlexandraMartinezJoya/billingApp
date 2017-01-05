<?php

// this is a wrapper for a mysql db connect. a safer way to store this data is to put it in a separate file and after, include the file
$DB_HOST = 'mysql:host=localhost;dbname=facturi';
$DB_USER = 'root';
$DB_PASS = '';

    //function to return all the bills found in db
    function getAllBills() {
        global $dataBaseHandler;
        $stmt_f = $dataBaseHandler->prepare('SELECT * FROM facturi');
        $stmt_f -> execute();
        $facturi = $stmt_f ->fetchAll();
        return $facturi;
    }

    //function to return the factura data searched after the id of the item. returns an array
    function getBillData($idBill){
        global $dataBaseHandler;
        $stmt_idf = $dataBaseHandler->prepare('SELECT * from facturi WHERE id = :id');
        $stmt_idf->bindParam(':id', $idBill);
        $stmt_idf -> execute();
        $facturi_gasite = $stmt_idf ->fetch(PDO::FETCH_ASSOC);
        return $facturi_gasite;
    }

    // function to select a field based on table col name and id, returns the aassociated data
    function getTableBillData($idBill, $tableColName) {
    $data = getFactura($idBill);
    $denum = $data[$tableColName];
    return $denum;
    }

    // gets all products data from in db. this is not that optimal if the db is going to be really big. 
        function getAllProducts() {
        global $dataBaseHandler;
        $stmt = $dataBaseHandler->prepare('SELECT * FROM produs');
        $stmt -> execute();
        $products = $stmt -> fetchAll();
        return $products;
    }


    //gets data from produs table from db , returns an associtive array based on a forgein key select
    function getAllProductsByForgeinKey($fkIDFact) {
        global $dataBaseHandler;
        $stmt_p = $dataBaseHandler->prepare('SELECT * from produs WHERE id_fact = :id_fact');
        $stmt_p ->bindParam(':id_fact', $fkIDFact);
        $stmt_p -> execute();
        $forgeinKeyProducts = $stmt_p ->fetchAll();
        return $forgeinKeyProducts;
    }

    // function insert_benef_name_data($denumire) {
    //     global $dataBaseHandler;
    //     preprint($denumire);
    //     $sql = "INSERT INTO facturi (benef_denumire) VALUES (:benef_denum)";
    //     $stmt = $dataBaseHandler ->prepare($sql);
    //     $stmt -> bindParam(':benef_denum', $denumire);
    //     $stmt -> execute();
    //     echo "done";
    // }


    // inserts fact data to the db , takes in arguments as variables for each field
    function insertBeneficiaryBillData($denumire, $cui, $adresa, $cont_bancar, $data_emiterii, $data_scadenta, $serie, $numar) {
         global $dataBaseHandler;
         $sql = "INSERT INTO facturi (benef_denumire, benef_cui, benef_adresa, benef_cont_bancar, data_emiterii, data_scadentei, serie, nr)
             VALUES (:benef_denum, :benef_cui, :benef_adresa, :benef_cont_bancar, :data_emiterii, :data_scadentei, :serie, :numar)";
         $stmt = $dataBaseHandler ->prepare($sql);
         preprint($stmt);
         $stmt -> bindParam(':benef_denum', $denumire);
         $stmt -> bindParam(':benef_cui', $cui);
         $stmt -> bindParam(':benef_adresa', $adresa);
         $stmt -> bindParam(':benef_cont_bancar', $cont_bancar);
         $stmt -> bindParam(':data_emiterii', $data_emiterii);
         $stmt -> bindParam(':data_scadentei', $data_scadenta);
         $stmt -> bindParam(':serie', $serie);
         $stmt -> bindParam(':numar', $numar);
         $stmt -> execute();
//         echo  'records inserted successfully'."<br>";
         $id = $dataBaseHandler->lastInsertId($sql);
//         preprint($id);
         return $id;
     }

        // Code sample by Stefancu
        //  function handle_produse_post() {
         //
        //      $produse = filter_input('POST', 'produse', );
         //
        //      foreach ($_POST['produse'] as $produs) {
        //          insert_prod_data($produs['prod_denumire'], $produs['um'], produs['pret_unitar'], produs[q]);
         //
        //          foreach ($array as $keyP => $valuep) {
        //              # code...
        //          }
        //          # code...
        //      }
        //  }


    // insert prepared statement for data in produs. takes post data as a matrix and sends it to the forgein key relation
    function insertProductData($prod_array, $fact_id) {
            foreach ($prod_array as $produs) {
                insert_row_data($produs, $fact_id);
            }
//            echo "Insert completed for all rows";
    }


    // insets table data in produs table, 1 row. constraint is that you need the row data stored as an array, and the forgein key id of the fact related to it
    function insertProductRowData($row_Array, $fk_id) {
        global $dataBaseHandler;
        $stmt = $dataBaseHandler ->prepare('INSERT INTO produs (denumire, unit_masura, cantitate, pret_unitar, id_fact) VALUES(:prod_denum, :prod_um, :prod_pu, :prod_q, :id_fact)');
        $stmt -> bindParam(':id_fact', $fk_id);
        $stmt -> bindParam(':prod_denum', $row_Array["prod_denum"]);
        $stmt -> bindParam(':prod_um', $row_Array["prod_um"]);
        $stmt -> bindParam(':prod_pu', $row_Array["prod_pu"]);
        $stmt -> bindParam(':prod_q', $row_Array["prod_q"]);
        $stmt -> execute();
//        echo "<br>Insert completed for current row";
    }


    // updates the data in factura table, constraint is that the table data is stored in variables
    function updateBillData($benefDenumire, $benefCui, $benefContBancar, $benefAdresa, $benefDataEmiterii, $benefDataScadenta, $factSerie, $factNr, $id_fact) {
        //code here... repeating quite a bit, you could reduce the code significantly by applying the param binding in a array
        global $dataBaseHandler;
        $stmt = $dataBaseHandler ->prepare('UPDATE facturi  SET benef_denumire = :benef_denumire, benef_cui = :benef_cui, benef_cont_bancar = :benef_cont_bancar,
                                                    benef_adresa = :benef_adresa, data_emiterii = :data_emiterii, data_scadentei = :data_scadentei,
                                                    serie = :serie, nr = :nr
                                                WHERE id = :id');
        $stmt -> bindParam(':id', $id_fact);
        $stmt -> bindParam(':benef_denumire', $benefDenumire);
        $stmt -> bindParam(':benef_cui', $benefCui);
        $stmt -> bindParam(':benef_cont_bancar', $benefContBancar);
        $stmt -> bindParam(':benef_adresa', $benefAdresa);
        $stmt -> bindParam(':data_scadentei', $benefDataScadenta);
        $stmt -> bindParam(':data_emiterii', $benefDataEmiterii);
        $stmt -> bindParam(':serie', $factSerie);
        $stmt -> bindParam(':nr', $factNr);
        $stmt -> execute();
        echo $stmt->rowCount() . " records UPDATED successfully";
    }


    // updates data in produs table , with a forgein key match constraint
    function updateProductData($produse_array){
        foreach ($produse_array as $produs) {
            update_row_data($produs);
        }
    }

        function updateRowData($produs_array){
            global $dataBaseHandler;
            $stmt = $dataBaseHandler -> prepare('UPDATE produs SET denumire = :prod_denum, unit_masura  = :prod_um, cantitate = :prod_q, pret_unitar = :prod_pu
                                        WHERE id = :id');
            $stmt -> bindParam(':id', $produs_array["id"]);
            $stmt -> bindParam(':prod_denum', $produs_array["prod_denum"]);
            $stmt -> bindParam(':prod_um', $produs_array["prod_um"]);
            $stmt -> bindParam(':prod_pu', $produs_array["prod_pu"]);
            $stmt -> bindParam(':prod_q', $produs_array["prod_q"]);
            $stmt ->execute();
//            echo "records UPDATED";
            }

    // Selects data from db tables to return the multiplication of two fields, using a forgein key id.
    function selectTotalPerBill() {
        //code here..
        global $dataBaseHandler;
        $stmt = $dataBaseHandler -> prepare('SELECT p.id_fact, SUM( p.cantitate * p.pret_unitar) AS tg FROM produs p, facturi f WHERE p.id_fact = f.id GROUP BY f.id;');
        $stmt ->execute();
        $total_general = $stmt-> fetchall();
        return $total_general;
        //preprint($total_general);
    }

    //Deletes data from db table name produs , on id select
    function deleteProductData($prod_id, $prod_array) {
        global $dataBaseHandler;
        $stmt = $dataBaseHandler -> prepare("DELETE FROM produs WHERE id =:id");
        $stmt -> bindParam(':id', $prod_id);
        $stmt -> execute();
//        echo "</br>records deleted.</br>";
    }

?>
