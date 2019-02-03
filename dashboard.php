<?php 
    require_once('Connections/connection.php');
    if (!isset($_SESSION))
    session_start();
    if(!isset($_SESSION['Username']))
    header("Location: login.php");
    mysql_select_db($database_connection, $connection);
    $query_expiring = "SELECT * FROM expiringmedicines ORDER BY expiryDate";
    $expiring = mysql_query($query_expiring, $connection) or die(mysql_error());
    $row_expiring = mysql_fetch_assoc($expiring);
    $totalRows_expiring = mysql_num_rows($expiring);
    $query_lowquan = "SELECT * FROM smallquantitymedicines WHERE quantity>0 and (expiryDate >= DATE(now())) ORDER BY quantity";
    $lowquan = mysql_query($query_lowquan, $connection) or die(mysql_error());
    $row_lowquan = mysql_fetch_assoc($lowquan);
    $totalRows_lowquan = mysql_num_rows($lowquan);
    $query_todaysales = "SELECT * FROM todaytransaction ORDER BY transaction_id DESC";
    $todaysales = mysql_query($query_todaysales, $connection) or die(mysql_error());
    $row_todaysales = mysql_fetch_assoc($todaysales);
    $totalRows_todaysales = mysql_num_rows($todaysales);
    $query_report1 = "SELECT SUM(todaytransaction.Price) as todayProfit FROM todaytransaction";
    $report1 = mysql_query($query_report1, $connection) or die(mysql_error());
    $row_report1 = mysql_fetch_assoc($report1);
    $query_report2 = "SELECT SUM(monthtransaction.Price) as monthProfit FROM monthtransaction";
    $report2 = mysql_query($query_report2, $connection) or die(mysql_error());
    $row_report2 = mysql_fetch_assoc($report2);
    $query_report3 = "SELECT SUM(transactionslist.Price) as totalProfit FROM transactionslist";
    $report3 = mysql_query($query_report3, $connection) or die(mysql_error());
    $row_report3 = mysql_fetch_assoc($report3);
    $query_report4 = "SELECT SUM(inventorylist.quantity) as totalMed FROM inventorylist";
    $report4 = mysql_query($query_report4, $connection) or die(mysql_error());
    $row_report4 = mysql_fetch_assoc($report4);
    date_default_timezone_set("US/Arizona"); 
     $year=date("Y");
     $query_monthlyprofit = "SELECT * FROM monthlyprofit where year=$year";
    $monthlyprofit = mysql_query($query_monthlyprofit);
    while ($row_monthlyprofit = mysql_fetch_assoc($monthlyprofit)){
      $dataset1[]=array($row_monthlyprofit['month'],$row_monthlyprofit['profit']);
    } 
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Home</title>
    <?php include('imports/stylesheet.php'); ?>
  </head>
  <body class="home">
    <?php include('imports/header.php'); ?>
    <div class="user-dashboard">
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 hvr-grow">
          <div class="info-box animated fadeInDown">
            <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Today sells</span>
              <span class="info-box-number">$<?php echo $row_report1['todayProfit']; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 hvr-grow">
          <div class="info-box animated fadeInDown">
            <span class="info-box-icon bg-red"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">This Month sells</span>
              <span class="info-box-number">$<?php echo $row_report2['monthProfit']; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 hvr-grow">
          <div class="info-box animated fadeInDown">
            <span class="info-box-icon bg-green"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total sells</span>
              <span class="info-box-number">$<?php echo $row_report3['totalProfit']; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 hvr-grow">
          <div class="info-box animated fadeInDown">
            <span class="info-box-icon bg-yellow"><i class="fa fa-archive"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Inventory</span>
              <span class="info-box-number"><?php echo $row_report4['totalMed']; ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class='col-md-12'>
          <div class="box box-primary animated fadeInDown">
            <div class="box-header">
              <i class="fa fa-bar-chart-o"></i>
              <h3 class="box-title">Monthly sells</h3>
            </div>
            <div class="box-body">
              <div id="bar-chart" style="height: 300px;"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4  hvr-grow">
          <div class="info-box bg-green   animated fadeInDown">
            <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Today transactions</span>
              <span class="info-box-number"><?php echo $totalRows_todaysales; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-4 hvr-grow">
          <div class="info-box bg-yellow   animated fadeInDown">
            <span class="info-box-icon"><i class="fa fa-flask"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Low quantity</span>
              <span class="info-box-number"><?php echo $totalRows_lowquan; ?></span>
            </div>
          </div>
        </div>
        <div class="col-md-4 hvr-grow">
          <div class="info-box bg-red   animated fadeInDown">
            <span class="info-box-icon"><i class="fa fa-hourglass-half"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Expiring medicines</span>
              <span class="info-box-number"><?php echo $totalRows_expiring; ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class='col-md-4'>
          <div class="box box-default   animated fadeInDown">
            <div class="box-header with-border">
              <h3 class="box-title">Today sales</h3>
            </div>
            <div class="box-body">
              <table class="table table-hover table-striped table-responsive">
                <tbody>
                  <?php do { ?>
                  <tr class="bg-green">
                    <td><?php echo $row_todaysales['brandName']; ?></td>
                    <td><?php echo $row_todaysales['quantity']; ?></td>
                    <td>$<?php echo $row_todaysales['Price']; ?></td>
                  </tr>
                  <?php } while ($row_todaysales = mysql_fetch_assoc($todaysales)); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class='col-md-4'>
          <div class="box box-default   animated fadeInDown">
            <div class="box-header with-border">
              <h3 class="box-title">Low quantity</h3>
            </div>
            <div class="box-body">
              <table class="table table-hover table-striped table-responsive">
                <tbody>
                  <?php do { ?>
                  <tr class="bg-yellow">
                    <td><?php echo $row_lowquan['brandName']; ?></td>
                    <td><?php echo $row_lowquan['expiryDate']; ?></td>
                    <td><?php echo $row_lowquan['quantity']; ?></td>
                  </tr>
                  <?php } while ($row_lowquan = mysql_fetch_assoc($lowquan)); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class='col-md-4'>
          <div class="box box-default   animated fadeInDown">
            <div class="box-header with-border">
              <h3 class="box-title">Expiring medicines</h3>
            </div>
            <div class="box-body">
              <table class="table table-hover table-striped table-responsive">
                <tbody>
                  <?php $medid=1; do { ?>
                  <tr class="bg-red">
                    <td><?php echo $row_expiring['brandName']; ?></td>
                    <td><?php echo $row_expiring['expiryDate']; ?></td>
                    <td><?php echo $row_expiring['quantity']; ?></td>
                  </tr>
                  <?php  $medid=$medid+1; } while ($row_expiring = mysql_fetch_assoc($expiring)); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
    var dataset1= <?php echo json_encode($dataset1); ?>;
    var bar_data = {
              data: dataset1,
              color: "#3c8dbc"
            };
</script>
<?php include('imports/scripts.php'); ?>
<script>
      $(document).ready(function () {
       $('[data-toggle="offcanvas"]').click(function(){
         $("#navigation").toggleClass("hidden-xs"); });
          $.plot("#bar-chart", [bar_data], {
            grid: {
              borderWidth: 1,
              borderColor: "#f3f3f3",
              tickColor: "#f3f3f3"
            },
            series: {
              bars: {
                show: true,
                barWidth: 0.5,
                align: "center"
              }
            },
            xaxis: {
              ticks:[[1,"January"],[2,"February"],[3,"March"],[4,"April"],[5,"May"],[6,"June"],[7,"July"],[8,"August"],[9,"September"],[10,"October"],[11,"November"],[12,"December"]]
            }
          });
       });
    </script>
</body>
</html>
        