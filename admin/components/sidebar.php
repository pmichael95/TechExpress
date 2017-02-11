<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo " class=\"active\""; ?>><a href="index.php">Statistics</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'products.php')) echo " class=\"active\""; ?>><a href="products.php">Products</a></li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'pricing.php')) echo " class=\"active\""; ?>><a href="pricing.php">Pricing</a></li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'categories.php')) echo " class=\"active\""; ?>><a href="categories.php">Categories</a></li>
          </ul>

          <?php 
            if($_SESSION['department'] == 1){
          ?>
          <ul class="nav nav-sidebar">
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'employees.php')) echo " class=\"active\""; ?>><a href="employees.php">Employees</a></li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'departments.php')) echo " class=\"active\""; ?>><a href="departments.php">Departments</a></li>
            <li><a href="log.txt">Log File</a></li>
          </ul>
          <?php } ?>
          <ul class="nav nav-sidebar">
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'orders.php')) echo " class=\"active\""; ?>><a href="orders.php">Orders</a></li>
          </ul>
        </div>