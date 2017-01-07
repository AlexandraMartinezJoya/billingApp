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
      include_once('common.php');
      include_once('./db_queries/qryBind.php');
  ?>
  <body>
    <div class="container main-container"> <!-- main div container -->

      <div class="row col-xs-12 text-center" align="center"> <!-- header row -->
         <h2>Add a bill</h2>  <!-- page title -->
      </div>
</div>

<div class="row">
    <div class="col-xs-12">

 <form id="mainFormAdd" class="addForm form-group" name="mainFormName" method="post" action='javascript:alert( "success!" );'><!-- add form -->
 <p> <!-- Error notification span -->
     <span class="error">* required field</span>
</p> 
 <div class="row">
 <div class = "row" align="center">
  </body>
