<html>
    <head>
        <title>Restaurant Management System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">    
    </head>
    <body>
        <!--      navbar-->
        <nav class="navbar navbar-expand-sm navbar-light bg-light"style="height:70px">
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Account
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><Span><i class="bi bi-lock"></i></Span>Settings</a></li>
                                <li><a class="dropdown-item" href="#"><span><i class="bi bi-box-arrow-right"></i></span>Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <a class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <i class="bi bi-list"></i>
        </a>
        <hr>
        <!--user navigation-->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="width:fit-content">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#menuManagementSubMenu">Menu Management</a>
                        <!-- Sublist -->
                        <div id="menuManagementSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../module/chef/menu-management/categories.php" >Categories</a></li>
                                <li class="list-group-item"><a href="../../module/chef/menu-management/items.php">Items</a></li>
                                <li class="list-group-item"><a href="../../module/chef/menu-management/pricing.php">Pricing</a></li>
                                <li class="list-group-item"><a href="../../module/chef/menu-management/availability.php">Availability</a></li> 
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#ingredientsManagementSubMenu">Ingredients Management</a>
                        <!-- Sublist -->
                        <div id="ingredientsManagementSubMenu" class="collapse">
                            <ul class="list-group">
                                <li class="list-group-item"><a href="../../module/chef/ingredients-management/ingredients.php">Ingredients</a></li>
                                <li class="list-group-item"><a href="../../module/chef/ingredients-management/stock.php">Stock</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <a href="../../dashboards/dashboard.php">Dashboard</a>
                    </li>

                </ul>
            </div>

        </div>
        <!--user navigation-->





        <script type="text/javascript">
            function updateClock() {
                var now = new Date();
                var dname = now.getDay(),
                        mo = now.getMonth(),
                        dnum = now.getDate(),
                        yr = now.getFullYear(),
                        hou = now.getHours(),
                        min = now.getMinutes(),
                        sec = now.getSeconds(),
                        pe = "AM";
                if (hou == 0) {
                    hou = 12;
                }
                if (hou > 12) {
                    hou = hou - 12;
                    pe = "PM";
                }
                Number.prototype.pad = function (digits) {
                    for (var n = this.toString(); n.length < digits; n = 0 + n)
                        ;
                    return n;

                }

                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var week = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var ids = ["dayname", "month", "daynum", "year", "hour", "minutes", "seconds", "period"];
                var values = [week[dname], months[mo], dnum.pad(2), yr, hou.pad(2), min.pad(2), sec.pad(2), pe];
                for (var i = 0; i < ids.length; i++)
                    document.getElementById(ids[i]).firstChild.nodeValue = values[i];
            }
            function initClock() {
                updateClock();
                window.setInterval(updateClock, 1000);
            }
            initClock();
        </script>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>