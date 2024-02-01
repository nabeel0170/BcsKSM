<?php
 session_start();
 include_once '../../../../model/role_model.php';
 if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}

$userRoleID = $_SESSION['user']['role_id'];
include_once '../../../../model/menu_model.php';
$menuObj = new menu();
$fooditemResult = $menuObj->getfoodItems();
$otheritemResult = $menuObj->getOtherItems();
?>
<html>
    <head>
        <title>Restaurant Management System</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">    
    </head>
    <body>
    <?php 
    include '../../../commons/header.php';
    ?>
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
        </a>
        <hr>
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
        </div>
        <!--user navigation-->
        <div class="row">
            <div class="col">
                
            <input class="form-control "  id="seachBar" type="search" placeholder="Search" aria-label="Search" onkeyup="search()">
                            <button class="btn btn-outline-success " type="submit">Search</button>

            </div>
            <div class="row">
            <?php 
        while($fooditems = $fooditemResult->fetch_assoc()){
            $foodid = $fooditems['food_itemId'];
            $foodid = base64_encode($foodid);
        ?>
        <div class="card" style="width: 18rem;margin:2px;">
            <img class="card-img-top" src="../../../<?php echo $fooditems["img_path"] ?>" alt="Card image cap">
            <div class="card-body">
                <input type="hidden" value="<?php echo $fooditems["food_itemId"] ?>">
                <div class="row"><p class="card-title"><?php echo $fooditems["item_name"] ?></p></div>
                <div class="row"><p class="card-title"><?php echo $fooditems["food_description"] ?></p></div>
                <div class="row"><p class="card-title"><?php echo  " Price:"." ". $fooditems["price"] ?></p></div>
                <div class="row"><p class="card-title"></p> 
                <button type="button" class="btn btn-primary"  id="editremQtybtn" onclick="setprice('<?php echo $foodid  ?>')">
  Change  price
    </button></div>
            </div>
        </div>
        <?php } 
        ?>
            <?php 
        while($otheritemsrow = $otheritemResult->fetch_assoc()){
            $item_id = $otheritemsrow['item_id'];
            $item_id = base64_encode($item_id);
        ?>
        <div class="card" style="width: 18rem;margin:2px;">
            <img class="card-img-top" src="../../../<?php echo $otheritemsrow["img_path"] ?>" alt="Card image cap">
            <div class="card-body">
                <input type="hidden" value="<?php echo $otheritemsrow["item_id"] ?>">
                <div class="row"><p class="card-title"><?php echo $otheritemsrow["item_name"] ?></p></div>
                <div class="row"><p class="card-title"><?php echo $otheritemsrow["description"] ?></p></div>
                <div class="row"><p class="card-title"><?php echo  " Price:"." ". $otheritemsrow["price"] ?></p></div>
                <div class="row"><p class="card-title"></p> 
                <button type="button" class="btn btn-primary"  id="editremQtybtn" onclick="setItemprice('<?php echo base64_decode($item_id)  ?>')">
  Change  price
    </button></div>
            </div>
        </div>
        <?php } 
        ?>
            </div>
        </div>
        <div class="modal fade" id="setpriceModal" tabindex="-1" role="dialog" aria-labelledby="setpriceModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="set-price-form" action="../../../../controller/menu_controller.php?status=set-price" enctype="multipart/form-data" method="post" >
      <div class="input-group">
  <input type="hidden" class="form-control" aria-label="Text input with dropdown button" name="food_id" id="food_id" >
  <input type="text" class="form-control" aria-label="Text input with dropdown button" name="price" id="price" >

</div>
<button type="submit" class="btn btn-primary">Save changes</button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
        <script type="text/javascript" src="../../../../commons/clock.js"></script>
        <script type="text/javascript" src="pricing.js"></script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>