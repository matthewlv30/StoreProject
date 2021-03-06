#!/usr/local/bin/php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CIS4301 Final Database Project">
    <meta name="author" content="">

    <title>Online Store</title>

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
                <h1>Welcome to our online store!</h1>
                <p class="lead">Search and select products to add to your cart!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="form-group">
                  <div class="col-md-12">
                    <a href="signIn.php" class="btn btn-primary">Sign In</a>
                    <a href="register.php" class="btn btn-info">Register</a>
                  </div>
                <br><br>
                </div>
            </div>
        </div>            
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3 style="padding-bottom:10px">Products</h3>
                <div class="form-group">
            <form name="frmSearch" method="get" action="<?=$_SERVER['SCRIPT_NAME'];?>">
                    <input class="search form-control" name="txtKeyword" type="text" id="txtKeyword" value="<?=$_GET["txtKeyword"];?>" placeholder="Search for a product">
                    </form>
                </div>
            </div>
        </div>        
    <div class="row">
        <div class="col-lg-12 text-center">
              <?
                if($_GET["txtKeyword"] != "")
                    {
                    $objConnect = oci_connect($username = 'prose',
                                              $password = '24997843p',
                                              $connection_string = '//oracle.cise.ufl.edu/orcl');

                    $strSQL = "SELECT  * FROM product  WHERE (PRODUCTID LIKE '%".$_GET["txtKeyword"]."%'or 
                    SUPID LIKE '%".$_GET["txtKeyword"]."%' or
                    DESCRIPTION LIKE '%".$_GET["txtKeyword"]."%'
                    )";
                    $objParse = oci_parse($objConnect, $strSQL);
                    oci_execute ($objParse,OCI_DEFAULT);

                    $Num_Rows = oci_fetch_all($objParse, $Result);

                    $Per_Page = 2;   // Per Page

                    $Page = $_GET["Page"];
                    if(!$_GET["Page"])
                    {
                        $Page=1;
                    }

                    $Prev_Page = $Page-1;
                    $Next_Page = $Page+1;

                    $Page_Start = (($Per_Page*$Page)-$Per_Page);
                    if($Num_Rows<=$Per_Page)
                    {
                        $Num_Pages =1;
                    }
                    else if(($Num_Rows % $Per_Page)==0)
                    {
                        $Num_Pages =($Num_Rows/$Per_Page) ;
                    }
                    else
                    {
                        $Num_Pages =($Num_Rows/$Per_Page)+1;
                        $Num_Pages = (int)$Num_Pages;
                    }
                    $Page_End = $Per_Page * $Page;
                    IF ($Page_End > $Num_Rows)
                    {
                        $Page_End = $Num_Rows;
                    }
                ?>  
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center col-sm-3 col-md-3">Product ID</th>
                    <th class="text-left col-sm-4 col-md-4">Description</th>
                    <th class="text-left col-sm-2 col-md-2">Price</th>
                    <th class="text-center col-sm-2 col-md-2">Stock</th>
                    <th class="text-left col-sm-2 col-md-2">Supplier ID</th>
                    <th class="text-center col-sm-1 col-md-1">Quantity</th>
                    <th class="text-center col-sm-1 col-md-1">Buy</th>
                  </tr>
                </thead>
                <tbody>
                <?
                    for($i=$Page_Start;$i<$Page_End;$i++)
                    {
                        ?>
                      <tr>
                        <td><div align="center"><?=$Result["PRODUCTID"][$i];?></div></td>
                        <td class="text-left"><?=$Result["DESCRIPTION"][$i];?></td>
                        <td class="text-left"><?=$Result["PRICE"][$i];?></td>
                        <td class="text-center"><?=$Result["STOCKQUANTITY"][$i];?></td>
                        <td class="text-center"><?=$Result["SUPID"][$i];?></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                         <input type="number" class="form-control" id="addquantity" value=""></td>  
                        <td><button type="button" class="btn btn-primary">Add to Cart</button></td>
                      </tr>
                        <?
                    }
                ?>  
                </tbody>
              </table>
              <br>
                Total <?= $Num_Rows;?> Record : <?=$Num_Pages;?> Page :
            <?
                if($Prev_Page)
                {
                    echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&txtKeyword=$_GET[txtKeyword]'><< Back</a> ";
                }

                for($i=1; $i<=$Num_Pages; $i++){
                    if($i != $Page)
                    {
                        echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i&txtKeyword=$_GET[txtKeyword]'>$i</a> ]";
                    }
                    else
                    {
                        echo "<b> $i </b>";
                    }
                }
                if($Page!=$Num_Pages)
                {
                    echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page&txtKeyword=$_GET[txtKeyword]'>Next>></a> ";
                }
                
                oci_close($objConnect);

                }   
             ?>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>