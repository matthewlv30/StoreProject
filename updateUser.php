#!/usr/local/bin/php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CIS4301 Final Database Project">
    <meta name="author" content="">

    <title>Online Store - Update User</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        padding-top: 70px;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><b>Online Store</b></a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="orders.html">Orders</a>
                    </li>
                    <li>
                        <a href="cart.html">Shopping Cart</a>
                    </li>
                    <li>
                        <a href="account.php">Manage Account</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>


    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h1>Update User</h1>
                <p class="lead">View and update existing user information.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <form class="form-horizontal" name="frmUPD" method="POST">
                <fieldset>

                <div class="form-group">
                  <label class="col-md-4 control-label" for="Name">Full Name</label>  
                  <div class="col-md-5">
                  <input id="Name" name="Name" type="text" placeholder="First Last" class="form-control input-md">
                    
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 control-label" for="email">Email Address</label>  
                  <div class="col-md-5">
                  <input id="email" name="email" type="text" placeholder="email@domain.com" class="form-control input-md">
                    
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 control-label" for="address">Address</label>  
                  <div class="col-md-5">
                  <input id="address" name="address" type="text" placeholder="123 Pine St, Gainesville, FL 32608" class="form-control input-md">
                    
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 control-label" for="password">Password</label>
                  <div class="col-md-4">
                    <input id="password" name="password" type="password" placeholder="password" class="form-control input-md">
                    
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-md-12">
                    <button id="deleteAccount" name="deleteAccount" class="btn btn-danger">Delete User</button>
                    <button id="saveChanges" name="saveChanges" class="btn btn-primary">Save Changes</button>
                  </div>
                </div>
				<?php
               $objConnect = oci_connect($username = 'prose',
                                $password = '24997843p',
                                $connection_string = '//oracle.cise.ufl.edu/orcl');

                $strSQL = "SELECT * FROM WEBUSER WHERE USERID = '".$_GET["USRID"]."' ";
                $objParse = oci_parse ($objConnect, $strSQL);
				oci_execute ($objParse,OCI_DEFAULT);
				$objResult = oci_fetch_array($objParse);
				if(!$objResult)
						{
							echo "Not found uSERID=".$_GET["USERID"];
						}
			    else {
                if (isset($_POST['saveChanges'])) {
				$strSQL = "UPDATE WEBUSER SET ";
				$strSQL .="USERNAME= '".$_POST["Name"]."' ";
				$strSQL .=",ADDRESS = '".$_POST["address"]."' ";
				$strSQL .=",USERPASSWORD = '".$_POST["password"]."' ";
				$strSQL .=",EMAIL = '".$_POST["email"]."' ";
				$strSQL .="WHERE USERID = '".$_GET["USRID"]."' ";
				$objParse = oci_parse($objConnect, $strSQL);
				
				$objExecute = oci_execute($objParse, OCI_DEFAULT);
                  if($objExecute)
                  {
                    oci_commit($objConnect); //*** Commit Transaction ***//
                    echo "Account Updated";
                  }
                 else
                   {
                     oci_rollback($objConnect); //*** RollBack Transaction ***//
                     echo "Error Save [".$strSQL."]";
                   }
 
                 }
                 else if (isset($_POST['deleteAccount'])) {
                      echo "Not Updated";
                 }
               }
                  oci_close($objConnect);
                ?>
                </fieldset>
                </form>

            </div>
        </div>           
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>