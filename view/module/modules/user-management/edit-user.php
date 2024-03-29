<?php
session_start();
include_once '../../../../model/role_model.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role_id'])) {
    // Redirect to the login page
    header("Location: http://localhost/BcsKSM/view/login/login.php");
    exit(); // Make sure to exit after a header redirect
}
$userRoleID = $_SESSION['user']['role_id'];
    // Redirect to the admin page
    switch ($userRoleID) {
        case 2:
            header("Location: http://localhost/BcsKSM/view/users/chef/chef.php");
            break;
        case 3:
            header("Location: http://localhost/BcsKSM/view/users/stock-manager/stockmanager.php");
            break;
        case 4:
            header("Location: http://localhost/BcsKSM/view/users/cashier/cashier.php");
            break;
        }

include_once '../../../../model/user_model.php';
$userObj = new user();
$editroleResult = $userObj->getroles();

$user_id = $_GET['id'];
$userResult = $userObj->getaspecificuser($user_id);
$userrow = $userResult->fetch_assoc();
?>


<html>

<head>
    <title>Restaurant Management System</title>
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
    <!--user navigation end-->
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
    <div class="container-fluid edit-user-container" >
    <div class="row edit-user-column    align-items-center justify-content-center">
            <div class="col-auto edit-user-card-col  p-5">
            <div class="card edit-user-profile-card">
            <div class="card-header edit-user-card-header text-center m-0">
                    <H3>Edit User</H3>
                </div>
                <div class="card-body">
                <form id="edit-user-form" action="../../../../controller/user_controller.php?status=edit-user"
                    enctype="multipart/form-data" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />

                    <div class="col">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="F-name">First Name</span>
                            </div>
                            <input type="text" class="form-control" id="firstName" name="users_fname"
                                value="<?php echo $userrow['Fname'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="L-name">Last Name</span>
                            </div>
                            <input type="text" class="form-control" id="lastName" name="users_lname"
                                value="<?php echo $userrow['Lname'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="Email">Email</span>
                            </div>
                            <input type="text" class="form-control" id="user_Email" name="users_email"
                                value="<?php echo $userrow['user_email'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="Unic">NIC</span>
                            </div>
                            <input type="text" class="form-control" id="user_Nic" name="users_nic"
                                value="<?php echo $userrow['user_nic'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="Udob">Date of birth</span>
                            </div>
                            <input type="date" class="form-control" id="user_dob" name="users_dob"
                                value="<?php echo $userrow['user_dob'] ?>">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="Contact">Contact Number</span>
                            </div>
                            <input type="text" class="form-control" id="user_Contact" name="users_cno"
                                value="<?php echo $userrow['user_contactNo'] ?>">
                        </div>
                    </div>

                    <div class=" d-flex flex-column">
                        <select class="forms-select mb-3" id="userRole" aria-label="Users Role" name="users_role"
                            required>
                            <option value="">----</option>
                            <?php
                            while ($rolerow = $editroleResult->fetch_assoc()) {
                                ?>
                                <option name="user_role" value="<?php echo $rolerow["role_id"]; ?>" <?php
                                   if ($userrow["role_id"] == $rolerow["role_id"]) {
                                       ?> selected="selected" <?php
                                   }
                                   ?>>
                                    <?php echo $rolerow["role_name"]; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row btnrow">
                        <div class="col text-center">
        <button class="btn custom-outline-button back-btn btn-lg" href="user.php"><i class="bi bi-arrow-return-left"></i></button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#removeUserModal">Remove User
                            </button>
                            <input type="submit" class="btn btn-outline-primary" value="Update"/>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="removeUserModal" tabindex="-1" role="dialog" aria-labelledby="RemoveusermodalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeUsertitle">Remove User</h5>
                    <button type="button" class="btn-close modalclosetbtn" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                    <a type="button" class="btn btn-outline-danger"
                        href="../../../../controller/user_controller.php?status=delete-user&userid=<?php echo $user_id ?>">Remove
                        User</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="edituser.js"></script>
    <script type="text/javascript" src="../../../../commons/clock.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

</html>