<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CIS4301 Final Database Project">
    <meta name="author" content="">

    <title>Online Store - Orders</title>

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
                        <a href="orders.php">Orders</a>
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
                <h1>Orders</h1>
                <p class="lead">Review your previously created orders.</p>
            </div>
        </div>        
        <div class="row">
            <div class="col-lg-12 text-center">
              <table class="table table-striped">
               <?
                    $objConnect = oci_connect($username = 'prose',
                                              $password = '24997843p',
                                              $connection_string = '//oracle.cise.ufl.edu/orcl');

                    $strSQL = "SELECT  * FROM webuser  WHERE (IS_STAFF = 1)";
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
                <thead>
                  <tr>
                    <th class="text-center">Order ID</th>
                    <th class="text-center">Date</th>
                    <th class="text-center"># of items</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">View</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>101</td>
                    <td>12/01/2015</td>
                    <td>3</td>
                    <td>$100.00</td>
                    <td><a href="updateorder.html" class="btn btn-primary">View Order</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>