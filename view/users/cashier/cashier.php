<?php
include_once '../../../model/menu_model.php';
$menuObj = new menu();
$categoryResult = $menuObj->getcategories();
?>
<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <!--      navbar-->
    <nav class="navbar navbar-expand-sm navbar-light bg-light" style="height:70px">
        <div class="container-fluid">
            <div class="d-flex flex-column datetime m-2">
                <div class="date">
                    <span id="dayname">Day</span>
                    <span id="month">Month</span>:
                    <span id="daynum">00</span>
                    <span id="year">Year</span>
                </div>
                <div class="time">
                    <span id="hour">00</span>:
                    <span id="minutes">00</span>:
                    <span id="seconds">00</span>:
                    <span id="period">AM</span>
                </div>

            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto"> <!-- Use "ml-auto" to push items to the right -->
                    <button type="button" class="btn btn-light" id="bell"><i class="bi  bi-bell"></i></button>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><span><i
                                            class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
        aria-controls="offcanvasExample">
        <i class="bi bi-list"></i>
    </a>
    <hr>
    <!--user navigation-->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offCanvasExample" aria-labelledby="offcanvas"
        style="width:fit-content">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"></h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="cashier.php">Cashier</a>

                </li>

            </ul>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#customerSubMenu">Customer Management</a>
                    <!-- Sublist -->
                    <div id="customerSubMenu" class="collapse">
                        <ul class="list-group">
                            <li class="list-group-item"><a
                                    href="../../module/cashier/customer-management/customer.php">Customers Details</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

    </div>
    <!--user navigation-->
    <div class="container-fluid" >
        <div class="row" style=""> 
            <div class="col" >
                <div class="row"  id="categories">
                    <div class="card col-md-2" style="margin:2px;">
                        <a class="card-link" onclick="showallfoodItems()">
                            <div class="card-body">
                                <div class="row">
                                    <h3 class="card-title">
                                        All
                                    </h3>
                                </div>

                            </div>
                        </a>
                    </div>
                    <?php
                    while ($categories = $categoryResult->fetch_assoc()) {
                        $categoryId = $categories['category_id'];
                        ?>

                        <div class="card col-md-2" style="margin:2px;">
                            <a class="card-link" onclick="filteritems(<?php echo $categoryId; ?>)">
                                <div class="card-body">
                                    <input type="hidden" id="category-id" value="<?php echo $categories['category_id']; ?>">
                                    <div class="row">
                                        <h3 class="card-title">
                                            <?php echo $categories["category_name"] ?>
                                        </h3>
                                    </div>

                                </div>
                            </a>
                        </div>

                    <?php } ?>
                </div>
                <div class="row" style="background-color:aqua;" id="fooditems-container" style="height:700px;"> </div>
                <div class="row" style="background-color:black;">orderlist</div>
            </div>
            <div class="col-md-2" style="background-color:yellow;">cart
                <div class="row" style="background-color:blue;">name</div>
                <div class="row" style="background-color:white;">items</div>
                <div class="row" style="background-color:green;">checkout</div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="cashier.js"></script>
    <script type="text/javascript" src="../../../commons/clock.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>