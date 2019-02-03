<?php
  $logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
  if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  $_SESSION['Username'] = NULL;
  $_SESSION['Role'] = NULL;
  unset($_SESSION['Username']);
  unset($_SESSION['Role']);
  header("Location: ./login.php");
  }
  mysql_select_db($database_connection, $connection);
  $query_exmed = "SELECT * FROM expiringmedicines ORDER BY expiringmedicines.expiryDate";
  $exmed = mysql_query($query_exmed, $connection) or die(mysql_error());
  $row_exmed = mysql_fetch_assoc($exmed);
  $totalRows_exmed = mysql_num_rows($exmed);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-2 col-sm-1 hidden-xs animated fadeInLeft" id="navigation">
      <div class="logo">
        <img src="assets/img/logo.png" alt="Simple Pharmacy" class="hidden-xs hidden-sm">
      </div>
      <div class="navi">
        <ul id="side-menu">
          <li><a href="/pharmacy/dashboard.php"><i class="fa fa-home fa-fw"></i><span class="hidden-sm">Home</span></a></li>
          <li class="menu"><a href="/pharmacy/inventory.php"><i class="fa fa-database fa-fw"></i><span class="hidden-sm">Inventory</span></a></li>
          <li><a href="/pharmacy/medicine.php"><i class="fa fa-medkit fa-fw"></i><span class="hidden-sm">Medicine</span></a></li>
          <li><a href="/pharmacy/users.php"><i class="fa fa-user fa-fw"></i><span class=" hidden-sm">Users</span></a></li>
          <li><a href="/pharmacy/suppliers.php"><i class="fa fa-ambulance fa-fw"></i><span class="hidden-sm">Suppliers</span></a></li>
          <li><a href="/pharmacy/query.php"><i class="fa fa-filter fa-fw"></i><span class="hidden-sm">Query</span></a></li>
          <li><a href="/pharmacy/transactions.php"><i class="fa fa-history fa-fw"></i><span class="hidden-sm">Trade</span></a></li>
          <li><a href="/pharmacy/reports.php"><i class="fa fa-file-text fa-fw"></i><span class="hidden-sm">Trade Reports</span></a></li>
          <li><a href="/pharmacy/Expiringreports.php"><i class="fa fa-file-text fa-fw"></i><span class="hidden-sm">Expiring Reports</span></a></li>
          
        </ul>
      </div>
    </div>
    <div class="col-md-10 col-sm-11 ">
      <div class="row">
        <header>
          <div class="col-md-7">
            <nav class="navbar-default pull-left">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvas" data-target="#side-menu" aria-expanded="false">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
              </div>
            </nav>
            <h1>Simple PHARMACY MANAGEMENT SYSTEM</h1>
          </div>
          <div class="col-md-5">
            <div>
              <ul class=" header-top pull-right">
                <li><a href="transactions.php" class="add-transaction animated pulse ">Add Transaction</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
                    <span class="label label-danger"><?php echo $totalRows_exmed ?></span>
                  <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li>
                      <div class="navbar-content">
                        <h5>Expiring medicines</h5>
                        <table class="table table-hover table-striped table-responsive">
                          <tbody>
                            <?php do { ?>
                            <tr class="danger">
                              <td><?php echo $row_exmed['brandName']; ?></td>
                              <td><?php echo $row_exmed['expiryDate']; ?></td>
                              <td><?php echo $row_exmed['quantity']; ?></td>
                            </tr>
                            <?php } while ($row_exmed = mysql_fetch_assoc($exmed)); ?>
                          </tbody>
                        </table>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user-circle fa-lg" aria-hidden="true"></i>
                  <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li>
                      <div class="navbar-content">
                        <span>@<?php echo $_SESSION['Username']; ?></span>
                        <p class="text-muted small">
                          <?php echo $_SESSION['Role'];?>
                        </p>
                        <a href="<?php echo $logoutAction ?>" class="view btn-sm active hvr-float-shadow">Sign out</a> </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </header>
        </div>