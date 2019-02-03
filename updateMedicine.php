<?php
    require_once('Connections/connection.php');
    if (!isset($_SESSION))
    session_start();
    if(!isset($_SESSION['Username']))
    header("Location: login.php");
    if($_SESSION['Role']!='admin')
    header("Location: dashboard.php");
    include('imports/functions.php');
    $editFormAction = $_SERVER['PHP_SELF'];
    if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
    }
    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    $updateSQL = sprintf("UPDATE medicine SET genericName=%s, brandName=%s, price=%s, supplier_id=%s, type=%s WHERE medicine_id=%s",
    GetSQLValueString($_POST['genericName'], "text"),
    GetSQLValueString($_POST['brandName'], "text"),
    GetSQLValueString($_POST['price'], "double"),
    GetSQLValueString($_POST['supplierName'], "int"),
    GetSQLValueString($_POST['type'], "text"),
    GetSQLValueString($_GET['medicine_id'], "int"));
    mysql_select_db($database_connection, $connection);
    $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());
    $updateGoTo = "medicine.php?st=u";
    if (isset($_SERVER['QUERY_STRING'])) {
    header(sprintf("Location: medicine.php?st=u"));
    }
    }
    $query_medicine = "SELECT * FROM medicinelist where medicine_id=$_GET[medicine_id]";
    $medicine = mysql_query($query_medicine, $connection) or die(mysql_error());
    $row_medicine = mysql_fetch_assoc($medicine);
    mysql_select_db($database_connection, $connection);
    $query_suppliers = "SELECT * FROM supplier ORDER BY supplier_id ASC";
    $suppliers = mysql_query($query_suppliers, $connection) or die(mysql_error());
    $row_suppliers = mysql_fetch_assoc($suppliers);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Medicine</title>
        <?php include('imports/stylesheet.php'); ?>
    </head>
    <body class="home">
        <?php include('imports/header.php'); ?>
        <div class="user-dashboard">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 animated fadeInDown">
                    <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
                        <h1>Update Medicine</h1>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">Generic Name</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" required type="text" name="genericName" value="<?php echo $row_medicine['genericName']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label">Brand Name</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" required type="text" name="brandName" value="<?php echo $row_medicine['brandName']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label class="control-label" >Price</label>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input class="form-control" required type="number" name="price" value="<?php echo $row_medicine['price']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 ">
                                <label class="control-label" >Type</label>
                            </div>
                            <div class="col-sm-6 ">
                                <select name="type" class="form-control">
                                    <option value="<?php echo $row_medicine['type']; ?>">Current: <?php echo $row_medicine['type']; ?></option>
                                    <option value="digestive system">Digestive System</option>
                                    <option value="cardiovascular system">Cardiovascular System</option>
                                    <option value="central nervous system">Central nervous System</option>
                                    <option value="pain">Pain</option>
                                    <option value="consciousness">Consciousness</option>
                                    <option value="musculo-skeletal system">Musculo-skeletal System</option>
                                    <option value="eye">Eye</option>
                                    <option value="ear,nose and oropharynx">Ear,nose and oropharynx</option>
                                    <option value="respiratory system">Respiratory System</option>
                                    <option value="endocrine system">Endocrine System</option>
                                    <option value="urinary system">Urinary System</option>
                                    <option value="contraception">Contraception</option>
                                    <option value="obstetrics and gynecology">Obstetrics and gynecology</option>
                                    <option value="skin">Skin</option>
                                    <option value="infections and infestations">Infections and infestations</option>
                                    <option value="immune system">Immune System</option>
                                    <option value="allergic system">Allergic System</option>
                                    <option value="nutrition">Nutrition</option>
                                    <option value="neoplastic disorders">Neoplastic disorders</option>
                                    <option value="diagnostics">Diagnostics</option>
                                    <option value="euthanasia">Euthanasia</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 ">
                                <label class="control-label" >Supplier Name</label>
                            </div>
                            <div class="col-sm-6 ">
                                <select name="supplierName" class="form-control">
                                    <option value="<?php echo $row_medicine['supplier_id']; ?>">Current: <?php echo $row_medicine['supplier_name']; ?></option>
                                    <?php do { ?>
                                    <option value="<?php echo $row_suppliers['supplier_id']; ?>"><?php echo $row_suppliers['supplier_name']; ?></option>
                                    <?php } while ($row_suppliers = mysql_fetch_assoc($suppliers)); ?>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-default" type="submit">UPDATE </button>
                        <button class="btn btn-default" type="reset">RESET </button>
                        <input type="hidden" name="MM_update" value="form1">
                    </form><br>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include('imports/scripts.php'); ?>
</body>
</html>