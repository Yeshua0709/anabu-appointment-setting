<?php
include './config/connection.php';
include './common_service/common_functions.php';

$message = '';
if (isset($_POST['save_Appointment'])) {
  
    $hiddenId = $_POST['hidden_id'];

    $name = trim($_POST['name']);
    $phoneNumber = trim($_POST['contactnumber']);
    $reason = trim($_POST['reason']);
    $status = trim($_POST['status']);


   


    $name= ucwords(strtolower($name));
   
    
if ($name != '') {
      $query = "update `appointments` 
    set `name` = '$name', 
    `contactnumber` = '$phoneNumber', 
    `reason` = '$reason', 
    `status` = '$status'
    
where `id` = $hiddenId;";
try {

  $con->beginTransaction();

  $stmtPatient = $con->prepare($query);
  $stmtPatient->execute();

  $con->commit();

  $message = 'Appointment updated successfully.';

} catch(PDOException $ex) {
  $con->rollback();

  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
}
  header("Location:congratulation.php?goto_page=appointments&message=$message");
  exit;
}



try {
$id = $_GET['id'];
$query = "SELECT `id`, `name`, `contactnumber`, 
`reason`,`status`, date_format(`date`, '%m/%d/%Y') as `date`,  `time`
FROM `appointments` where `id` = $id;";

  $stmtPatient1 = $con->prepare($query);
  $stmtPatient1->execute();
  $row = $stmtPatient1->fetch(PDO::FETCH_ASSOC);

  $gender = $row['gender'];

$dob = $row['date']; 
} catch(PDOException $ex) {

  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 <?php include './config/data_tables_css.php';?>

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <title>Barangay Anabu I-E | Patient Management System</title>

  <style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

.content{
  margin:1.5em;
  margin-left:0;
}
.componentTitle{

  font-family: 'Poppins', sans-serif;
  color:#2A246A;
  font-weight:900;
  text-transform: uppercase;

}

label{
  color:#2A246A;
}

th,.bg-btn{
  background-color: #2A246A;
  color:white;
}
.bg-line{
  border-top: 4px solid #2A246A;
 
  margin:1.5em;
}

.content-header{
  margin-top:-3em;
}
.btnTop{
  margin-top:1px;
}
</style>


</head>
<body class="hold-transition sidebar-mini light-mode layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 <?php include './config/header.php';
include './config/sidebar.php';?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="componentTitle">APPOINTMENTS</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline  rounded-0 shadow bg-line">
        <div class="card-header">
          <h3 class="card-title">Update Appointment</h3>
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool btnTop" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
          <form method="post">
            <input type="hidden" name="hidden_id" 
            value="<?php echo $row['id'];?>">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Appointee Name</label>
              <input type="text" id="name" name="name" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['name'];?>" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['contactnumber'];?>" />
              </div>
              <br>
              <br>
              <br>
              
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Reason of Appointment</label>
                <input type="text" id="reason" name="reason" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['reason'];?>" />
              </div>

            
              
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Status</label>
                <input type="text" id="status" name="status" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $row['status'];?>" />
              </div>

              </div>
              
              <div class="clearfix">&nbsp;</div>
              <div class="row">
                <div class="col-lg-11 col-md-10 col-sm-10">&nbsp;</div>
              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                <button type="submit" id="save_Appointment" 
                name="save_Appointment" class="btn bg-btn btn-sm btn-flat btn-block">Save</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      
    </section>
     <br/>
     <br/>
     <br/>

 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php 
 include './config/footer.php';

  $message = '';
  if(isset($_GET['message'])) {
    $message = $_GET['message'];
  }
?>  
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include './config/site_js_links.php'; ?>
<?php include './config/data_tables_js.php'; ?>


<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
  showMenuSelected("#mnu_patients", "#mi_patients");

  var message = '<?php echo $message;?>';

  if(message !== '') {
    showCustomMessage(message);
  }
  $('#date_of_birth').datetimepicker({
        format: 'L'
    });
      
    
   $(function () {
    $("#all_patients").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#all_patients_wrapper .col-md-6:eq(0)');
    
  });

</script>
</body>
</html>