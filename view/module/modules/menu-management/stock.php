<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}
$userRoleID = $_SESSION['user']['role_id'];
    // Redirect to the home page
    switch ($userRoleID) {
        case 3:
            header("Location: http://localhost/BcsKSM/view/users/stock-manager/stockmanager.php");
            break;
        case 4:
            header("Location: http://localhost/BcsKSM/view/users/cashier/cashier.php");
            break;
        }
include_once '../../../../model/menu_model.php';
$menuObj = new menu();
$otherItemResult = $menuObj->getOtherItems();

?>

<html>

<head>
    <title>Restaurant Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../../../style/style.css">
    <link rel="stylesheet" type="text/css" href="../../../style/colors.css">
</head>

<body>
    <?php
    include '../../../commons/header.php';
    ?>
    <!--user navigation-->
    <?php
    // Include the sidebar file
    if ($userRoleID == 1) {
        include '../../../commons/admin-navigation.php';
    } elseif ($userRoleID == 2) {
        include '../../../commons/chef-navigation.php';
    } elseif ($userRoleID == 3) {
        include '../../../commons/stock-manager-navigation.php';
    } elseif ($userRoleID == 4) {
        include '../../../commons/cashier-navigation.php';
    }
    ?>

    <!--user navigation-->

    <div class="row m-0 Otheritems-container justify-content-center">
       <div class="col-md-12">
       <div class="row d-flex searchBarRow justify-content-start ">
            <?php
            if (isset($_GET["msg"])) {
                $msg = base64_decode($_GET["msg"]);
                ?>
                <div class="alert alert-success alert-dismissible fade show " role="alert">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0">
                            <?php echo $msg; ?>
                        </p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                </div>

                <?php
            }
            ?>
            <div class="col-auto">
            <input class="form-control m-2" type="search" id="seachBar" placeholder="Search" onkeyup="search()"
                aria-label="Search">
            </div>
        </div>
        <div class="row OtherItemsRow justify-content-center ">
        <?php
        while ($itemsrow = $otherItemResult->fetch_assoc()) {
            $item_id = $itemsrow["item_id"];
            $item_id = base64_encode($item_id);

            //display the items where the
        
            ?>
            <div class="card col-auto otheritemscard">
                <div class="row card-header allItem-card-header text-center">
                    <h5 class="card-title">
                        <?php echo $itemsrow["item_name"] ?>
                    </h5>
                </div>
                <div class="card-body">
                    <input type="hidden" value="<?php echo $itemsrow["item_id"] ?>">
                    <div class="row">
                        <img class="card-img-top" src="../../../<?php echo $itemsrow["img_path"] ?>" alt="Card image cap">
                    </div>

                    <div class="row mt-2 align-items-center justify-content-center">
                        <div class="col-auto p-0">
                            <h4>Remaining:</h4>
                        </div>
                        <div class="col-auto p-0">
                            <h4 class="quantity">
                                <?php
                                echo $itemsrow["available_quantity"];
                                ?>
                            </h4>
                        </div>

                    </div>
                </div>
                <div class=" row justify-content-center">
                        <button type="button " class="btn col-auto btn-outline-primary mb-2" id="editremQtybtn"
                            onclick="updatestock('<?php echo base64_decode($item_id) ?>', '<?php echo $itemsrow['item_name'] ?>')">
                            Update
                        </button>
                    </div>
            </div>
            
            <?php
        }
        ?>
        </div>
       </div>
    </div>


    <div class="modal fade" id="updatestockModal" tabindex="-1" role="dialog" aria-labelledby="updatestockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../../../../controller/menu_controller.php?status=update-item-stock"
                        enctype="multipart/form-data" method="post">
                        <div class="input-group">
                            <input type="hidden" class="form-control" aria-label="Text input with dropdown button"
                                name="item_id" id="item_id">
                            <input type="number" class="form-control" aria-label="Text input with dropdown button"
                                name="updatestockvalue" id="updatestockvalue" required>
                            <div class="input-group-append">
                                <select class="form-select" name="calculation-selector" id="calculation-selector">
                                    <option value="add">&#43; Add <i class="bi bi-plus"></i></option>
                                    <option value="subtract">&#45; Subtract <i class="bi bi-dash"></i></option>
                                </select>

                            </div>
                        </div>
                        <div class="row justify-content-end mt-3">
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>

                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-danger"
                                    onclick="resetstock()">Reset</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close  modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <p>Are you sure you want reset the values of this item?</p>
                    </div>
                    <div class="row justify-content-end">
                   <div class="col-auto">
                   <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                   </div>
                    <div class="col-auto">
                    <button type="button" class="btn btn-outline-danger" id="confirmBtn">Confirm</button>
                    </div>
                </div>
                </div>
                
            </div>
        </div>
    </div>




    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="stock.js"></script>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>