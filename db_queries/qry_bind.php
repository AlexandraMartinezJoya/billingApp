<?php

    include_once('common.php');


    //function to return all the facturi found in db. returns me
    function getAllFacturi() {
        global $dbh;
        $stmt_f = $dbh->prepare('SELECT * FROM facturi');
        $stmt_f -> execute();
        $facturi = $stmt_f ->fetchAll();
        return $facturi;
    }

    //function to return the factura data searched after the id of the item. returns an array
    function getFactura($id_fact){
        global $dbh;
        $stmt_idf = $dbh->prepare('SELECT * from facturi WHERE id = :id');
        $stmt_idf->bindParam(':id', $id_fact);
        $stmt_idf -> execute();
        $facturi_gasite = $stmt_idf ->fetch(PDO::FETCH_ASSOC);
        return $facturi_gasite;
    }

    // function to select a field based on table col name and id, returns the aassociated data
    function get_fact_table_data($id_fact, $table_col_name) {
    $data = getFactura($id_fact);
    $denum = $data[$table_col_name];
    return $denum;
    }

    // gets all produse data containing in db. this is not that optimal if the db is going to be really big. I don't  know where i use this but i think it
    // be changed.
    function getAllProduse() {
        global $dbh;
        $stmt = $dbh->prepare('SELECT * FROM produs');
        $stmt -> execute();
        $produse = $stmt -> fetchAll();
        return $produse;
    }


    //gets data from produs table from db , returns an associtive array based on a forgein key select
    function getAllProdus($fk_id_fact) {
        global $dbh;
        $stmt_p = $dbh->prepare('SELECT * from produs WHERE id_fact = :id_fact');
        $stmt_p ->bindParam(':id_fact', $fk_id_fact);
        $stmt_p -> execute();
        $produse = $stmt_p ->fetchAll();
        return $produse;
    }

    // function insert_benef_name_data($denumire) {
    //     global $dbh;
    //     preprint($denumire);
    //     $sql = "INSERT INTO facturi (benef_denumire) VALUES (:benef_denum)";
    //     $stmt = $dbh ->prepare($sql);
    //     $stmt -> bindParam(':benef_denum', $denumire);
    //     $stmt -> execute();
    //     echo "done";
    // }


    // nnserts fact data to the db , takes in arguments as variables for each field
    function insert_benef_fact_data($denumire, $cui, $adresa, $cont_bancar, $data_emiterii, $data_scadenta, $serie, $numar) {
         global $dbh;
         $sql = "INSERT INTO facturi (benef_denumire, benef_cui, benef_adresa, benef_cont_bancar, data_emiterii, data_scadentei, serie, nr)
             VALUES (:benef_denum, :benef_cui, :benef_adresa, :benef_cont_bancar, :data_emiterii, :data_scadentei, :serie, :numar)";
         $stmt = $dbh ->prepare($sql);
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
         $id = $dbh->lastInsertId($sql);
//         preprint($id);
         return $id;
     }

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
    function insert_prod_data($prod_array, $fact_id) {
            foreach ($prod_array as $produs) {
                insert_row_data($produs, $fact_id);
            }
//            echo "Insert completed for all rows";
    }


    // insets table data in produs table, 1 row. constraint is that you need the row data stored as an array, and the forgein key id of the fact related to it
    function insert_row_data($row_Array, $fk_id) {
        global $dbh;
        $stmt = $dbh ->prepare('INSERT INTO produs (denumire, unit_masura, cantitate, pret_unitar, id_fact) VALUES(:prod_denum, :prod_um, :prod_pu, :prod_q, :id_fact)');
        $stmt -> bindParam(':id_fact', $fk_id);
        $stmt -> bindParam(':prod_denum', $row_Array["prod_denum"]);
        $stmt -> bindParam(':prod_um', $row_Array["prod_um"]);
        $stmt -> bindParam(':prod_pu', $row_Array["prod_pu"]);
        $stmt -> bindParam(':prod_q', $row_Array["prod_q"]);
        $stmt -> execute();
//        echo "<br>Insert completed for current row";
    }


    // updates the data in factura table, constraint is that the table data is stored in variables
    function update_fact_data($benefDenumire, $benefCui, $benefContBancar, $benefAdresa, $benefDataEmiterii, $benefDataScadenta, $factSerie, $factNr, $id_fact) {
        //code here... repeating quite a bit, you could reduce the code significantly by applying the param binding in a array
        global $dbh;
        $stmt = $dbh ->prepare('UPDATE facturi  SET benef_denumire = :benef_denumire, benef_cui = :benef_cui, benef_cont_bancar = :benef_cont_bancar,
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
    function update_prod_data($produse_array){
        foreach ($produse_array as $produs) {
            update_row_data($produs);
        }
    }

        function update_row_data($produs_array){
            global $dbh;
            $stmt = $dbh -> prepare('UPDATE produs SET denumire = :prod_denum, unit_masura  = :prod_um, cantitate = :prod_q, pret_unitar = :prod_pu
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
    function select_total_per_fact() {
        //code here..
        global $dbh;
        $stmt = $dbh -> prepare('SELECT p.id_fact, SUM( p.cantitate * p.pret_unitar) AS tg FROM produs p, facturi f WHERE p.id_fact = f.id GROUP BY f.id;');
        $stmt ->execute();
        $total_general = $stmt-> fetchall();
        return $total_general;
        //preprint($total_general);
    }

    //Deletes data from db table name produs , on id select
    function delete_prod_data($prod_id, $prod_array) {
        global $dbh;
        $stmt = $dbh -> prepare("DELETE FROM produs WHERE id =:id");
        $stmt -> bindParam(':id', $prod_id);
        $stmt -> execute();
//        echo "</br>records deleted.</br>";
    }

?>
