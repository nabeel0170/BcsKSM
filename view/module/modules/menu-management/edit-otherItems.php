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
$Item_id = base64_decode($_GET['itemId']);
$fooditemResult = $menuObj->getfoodItems();
$categoryResult = $menuObj->getcategories();
$otherItemResult = $menuObj->getOtherItems();
$otherItem = $menuObj->getanItem($Item_id);
$otherItem = $otherItem->fetch_assoc();
?>
<html>

<head>
    <title>Restaurant Management System</title>
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
    <?php
    if (isset($_GET["msg"])) {
        $msg = base64_decode($_GET["msg"]);
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
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

    <div class="row items-container common-container m-0">
        <div class="col-md-3 items-column">
            <div class="row items-list-row justify-content-center">
                <div class="row justify-content-center">
                    <div class="row justify-content-center align-items-center searchBarRow">

                        <div class="col-auto">
                            <input class="form-control " type="search" id="seachBar" placeholder="Search"
                                onkeyup="search()" aria-label="Search">
                        </div>
                        <div class="col-auto ">
                            <a class="btn  back-btn btn-md" href="items.php"><i class="bi bi-arrow-return-left"></i></a>
                        </div>
                    </div>

                    <div class="row">
                        <ul class="list-group list-row">
                            <?php
                            while ($foodrow = $fooditemResult->fetch_assoc()) {
                                $foodid = $foodrow['food_itemId'];
                                $foodid = base64_encode($foodid);
                                ?>
                                <a type="button" class="list-group-item"
                                    href="edit-foodItems.php?status=edit-foodItem&foodId=<?php echo $foodid ?>">
                                    <h5>
                                        <?php echo $foodrow['item_name']; ?>
                                    </h5>
                                </a>
                            <?php } ?>
                            <?php
                            while ($otherItemRow = $otherItemResult->fetch_assoc()) {
                                $otherItemId = $otherItemRow['item_id'];
                                $otherItemId = base64_encode($otherItemId);
                                ?>
                                <a type="button" class="list-group-item"
                                    href="edit-otherItems.php?status=edit-Item&itemId=<?php echo $otherItemId ?>">
                                    <h5>
                                        <?php echo $otherItemRow['item_name']; ?>
                                    </h5>
                                </a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col edit-items-column d-flex align-items-center justify-content-center">
            <div class="card edit-items-card">
                <div class="card-header edit-Item-card-header text-center">
                    <H3>Edit Item</H3>
                </div>
                <form id="edit-food-items-form" action="../../../../controller/menu_controller.php?status=edit-otherItem"
                    enctype="multipart/form-data" method="post">
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                        name="itemId" value="<?php echo $otherItem['item_id'] ?>">
                    <input type="hidden" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                        name="img_path_name" value="<?php echo $otherItem['img_path'] ?>">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Item</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup"
                            name="item_Name" value="<?php echo $otherItem['item_name'] ?>">
                    </div>
                    <div class="input-group">
                    <div class="input-group-prepend">
                            <span class="input-group-text placeholderdescription"
                                id="inputGroup-sizing-default">Description</span>
                        </div>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"
                            name="item_descript"> <?php echo $otherItem['description'] ?></textarea>
                    </div>
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="input-group-prepend input-group-prepend-img">
                                <input type="file" class="form-control" aria-label="Default"
                                    aria-describedby="inputGroup" name="item_image" id="item_image"
                                    onchange="readUrl(this);">
                            </div>
                        </div>

                        <div class="col-auto">
                        <img id="imgprev" src="<?php echo "../../../" . (isset($otherItem["img_path"]) ? $otherItem["img_path"] : ''); ?>" alt="Image Preview">
                        </div>
                        <div class="row m-0">
                            <select class="forms-select mb-3 mt-3" id="category" aria-label="category" name="category"
                                required>
                                <option value="">----</option>
                                <?php
                                while ($categoryrow = $categoryResult->fetch_assoc()) {
                                    ?>
                                    <option name="category_selected" value="<?php echo $categoryrow["category_id"]; ?>" <?php
                                       if ($otherItem["category_id"] == $categoryrow["category_id"]) {
                                           ?> selected="selected" <?php
                                       }
                                       ?>>
                                    <?php echo $categoryrow["category_name"]; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row mt-5 justify-content-center">
                    <div class="col-auto">

                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#removeItemModal">Remove Item
                    </button>
                    </div>
                    <div class="col-auto">
                    <button type="submit" class="btn btn-outline-primary">
                        update
                    </button>
                    </div>
                    </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="removeItemModal" tabindex="-1" role="dialog" aria-labelledby="removeitemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeitemtitle">Remove item</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this this item ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--outline-secondary" data-bs-dismiss="modal">Close</button>
                    <a type="button" class="btn btn-outline-danger"
                        href="../../../../controller/menu_controller.php?status=delete-item&itemId=<?php echo $Item_id ?>">Remove
                        item</a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function readUrl(input) {
            if (input.files && input.files[0]) {
                console.log(input.files[0]);
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#imgprev")
                        .attr('src', e.target.result)
                        .height(70)
                        .width(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script type="text/javascript" src="../../../../commons/clock.js"></script>
    <script type="text/javascript" src="items.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>