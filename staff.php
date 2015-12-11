#!/usr/local/bin/php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CIS4301 Final Database Project">
    <meta name="author" content="">

    <title>Online Store - Staff Site Management</title>

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
                <h1>Staff Store Management</h1>
                <p class="lead">View, edit and delete all users and products.</p>
            </div>
        </div>        
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="row">
                    <div class="col-sm-6 text-right" style="padding-right:5px">
                        <h3 style="margin-top:0">Users</h3>
                    </div>
                    <div class="col-sm-6 text-left" style="vertical-align:middle">
                        <a type="button" class="btn btn-xs btn-success" href="addUser.php">Add New</a>
                    </div>
                </div>
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
                    <th class="text-center col-md-3">User id</th>
                    <th class="text-center col-md-3">Name</th>
                    <th class="text-center col-md-2">Email</th>
                    <th class="text-center col-md-1">Staff</th>
                    <th class="text-center col-md-1">View</th>
                    <th class="text-center col-md-1">Delete</th>
                  </tr>
                </thead>
                <tbody>
                <?
                    for($i=$Page_Start;$i<$Page_End;$i++)
                    {
                        ?>
                      <tr>
                        <td><div align="center"><?=$Result["USERID"][$i];?></div></td>
                        <td class="text-left"><?=$Result["USERNAME"][$i];?></td>
                        <td class="text-left"><?=$Result["EMAIL"][$i];?></td>
                        <td class="text-center"><?=$Result["IS_STAFF"][$i];?></td> 
                        <td><a href="updateUser.php?USRID=<?=$Result["USERID"][$i];?>" class="btn btn-primary">Update Info</a></td>
                        <td><a href="deleteuser.html" class="btn btn-danger">Delete User</a>
                       </tr>

                        <?
                    }
                     oci_close($objConnect);
                ?>  
                </tbody>
              </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="row">
                    <div class="col-sm-6 text-right" style="padding-right:5px">
                        <h3 style="margin-top:0">Products</h3>
                    </div>
                    <div class="col-sm-6 text-left" style="vertical-align:middle">
                        <a type="button" class="btn btn-xs btn-success" href="addProduct.html">Add New</a>
                    </div>
                </div>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-left">Product</th>
                    <th class="text-left">Description</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="productName" value="Product 1 Name">
                    </td>
                    <td class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="productDescription" value="Description">
                    </td>
                    <td class="col-sm-2 col-md-2">
                        <input type="text" class="form-control text-center" id="productPrice" value="$100.00">
                    </td>
                    <td class="col-sm-1 col-md-1">25</td>
                    <td class="col-sm-1 col-md-1">
                        <div class="form-group">
                          <div class="col-md-12">
                          <div class="radio">
                            <label for="active-0A">
                              <input type="radio" name="activeA" id="active-0A" value="0" checked="checked">
                              Active
                            </label>
                            </div>
                          <div class="radio">
                            <label for="active-1A">
                              <input type="radio" name="activeA" id="active-1A" value="1">
                              Inactive
                            </label>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td><a href="updateProduct.html" class="btn btn-primary">Update Info</a></td>
                    <td class="col-sm-1 col-md-1"><button type="button" class="btn btn-danger">Delete Product</button></td>
                  </tr>
                  <tr>
                    <td class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="productName" value="Product 2 Name">
                    </td>
                    <td class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="productDescription" value="Description">
                    </td>
                    <td class="col-sm-2 col-md-2">
                        <input type="text" class="form-control text-center" id="productPrice" value="$200.00">
                    </td>
                    <td class="col-sm-1 col-md-1">10</td>
                    <td class="col-sm-1 col-md-1">
                        <div class="form-group">
                          <div class="col-md-12">
                          <div class="radio">
                            <label for="active-0B">
                              <input type="radio" name="activeB" id="active-0B" value="0" checked="checked">
                              Active
                            </label>
                            </div>
                          <div class="radio">
                            <label for="active-1B">
                              <input type="radio" name="activeB" id="active-1B" value="1">
                              Inactive
                            </label>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td><a href="updateProduct.html" class="btn btn-primary">Update Info</a></td>
                    <td class="col-sm-1 col-md-1"><button type="button" class="btn btn-danger">Delete Product</button></td>
                  </tr>
                  <tr>
                    <td class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="productName" value="Product 3 Name">
                    </td>
                    <td class="col-sm-3 col-md-3">
                        <input type="text" class="form-control" id="productDescription" value="Description">
                    </td>
                    <td class="col-sm-2 col-md-2">
                        <input type="text" class="form-control text-center" id="productPrice" value="$300.00">
                    </td>
                    <td class="col-sm-1 col-md-1">42</td>
                                        <td class="col-sm-1 col-md-1">
                        <div class="form-group">
                          <div class="col-md-12">
                          <div class="radio">
                            <label for="active-0C">
                              <input type="radio" name="activeC" id="active-0C" value="0" checked="checked">
                              Active
                            </label>
                            </div>
                          <div class="radio">
                            <label for="active-1C">
                              <input type="radio" name="activeC" id="active-1C" value="1">
                              Inactive
                            </label>
                            </div>
                          </div>
                        </div>
                    </td>
                    <td><a href="updateProduct.html" class="btn btn-primary">Update Info</a></td>
                    <td class="col-sm-1 col-md-1"><button type="button" class="btn btn-danger">Delete Product</button></td>
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