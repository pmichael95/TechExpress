    <?php session_start(); ?>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">TechExpres</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) echo " class=\"active\""; ?>><a href="./">Home</a></li>
            <li <?php if (strpos($_SERVER['PHP_SELF'], 'category.php')) echo " class=\"active\""; ?> class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown">Categories <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php 
                //Query for the categories.
                    $categoryQuery = "SELECT * FROM `category` ORDER BY `categoryName`";
                    $categories = $myDB->query($categoryQuery);

                    if ($categories) {
                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Show them.
                        print "<li><a href='category.php?id=".$categories["$row"]['categoryID']."'>";
                        print $categories["$row"]['categoryName'];
                        print '</a></li>';
                      }
                    }
                  ?>
              </ul>
              <li>
                <?php 
                //Show the name of the currently logged in user.
                  if(isset($_SESSION['name'])){
                    echo '<a>Hi, '.$_SESSION['name'].'!</a></li>';
                    echo '<li><a href=\'/admin/\'>Administration</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                  }
                  else{
                    echo '<a href="login.php">Login</a></li>';
                  }
                ?>
              
          </ul>
          <div class="col-sm-3 col-md-3 pull-right">
            <form class="navbar-form" role="search" action="search.php">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
          </div>     
        </div>
      </div>
    </nav>