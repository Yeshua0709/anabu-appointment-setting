<?php
include './config/connection.php';
include './common_service/common_functions.php';


$message = '';
if (isset($_POST['save_Patient'])) {

    $patientName = trim($_POST['patient_name']);
    $address = trim($_POST['address']);
    $cnic = trim($_POST['cnic']);
    
    $dateBirth = trim($_POST['date_of_birth']);
    $dateArr = explode("/", $dateBirth);
    
    $dateBirth = $dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1];

    $phoneNumber = trim($_POST['phone_number']);

    $patientName = ucwords(strtolower($patientName));
    $address = ucwords(strtolower($address));

    $gender = $_POST['gender'];
if ($patientName != '' && $address != '' && 
  $cnic != '' && $dateBirth != '' && $phoneNumber != '' && $gender != '') {
      $query = "INSERT INTO `patients`(`patient_name`, 
    `address`, `cnic`, `date_of_birth`, `phone_number`, `gender`)
VALUES('$patientName', '$address', '$cnic', '$dateBirth',
'$phoneNumber', '$gender');";
try {

  $con->beginTransaction();

  $stmtPatient = $con->prepare($query);
  $stmtPatient->execute();
  $lastInsertId = $con->lastInsertId();//latest patient visit id
  $con->commit();

  $message = 'patient added successfully.';

  
  


  $toothStatus = 'unchecked';

  $querySecondTable = "INSERT INTO `dentalchart`(`patient_id`)
  VALUES
  ($lastInsertId)";

  $con->beginTransaction();

  $stmtSecondTable = $con->prepare($querySecondTable);

  $stmtSecondTable->execute();

  $con ->commit();

} catch(PDOException $ex) {

  $con->rollback();


  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
}
  header("Location:congratulation.php?goto_page=patients.php&message=$message");
  exit;
}



try {

$query = "SELECT `id`, `patient_name`, `address`, 
`cnic`, date_format(`date_of_birth`, '%d %b %Y') as `date_of_birth`, 
`phone_number`, `gender` 
FROM `patients` order by `patient_name` asc;";

  $stmtPatient1 = $con->prepare($query);
  $stmtPatient1->execute();

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
  <title>Camet - Candelaria Dental Clinic - Patient Management System</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    .content{
      margin:1.5em;
      margin-left:0;
    }

    label{
      color:#2A246A;
    }

    .componentTitle{
 font-family: 'Poppins', sans-serif;
 color:#2A246A;
 font-weight:600;
 text-transform: uppercase;
}

.bgBlue{
  background:#2A246A;
  color:white;
}

.bg-line{
  border-top: 4px solid #2A246A;
}

.btn-secondary{
  background:#2A246A;
}
.btn-secondary:hover{
  background-color: white;
  border-color: #2A246A;
  color:#2A246A;
}

.page-item.active .page-link{
  background:#2A246A;
  border-color:#2A246A;
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
            <h1 class="componentTitle">Patients</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline bg-line rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Add Patients</h3>
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
          <form method="post">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Patient Name</label>
              <input type="text" id="patient_name" name="patient_name" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              <br>
              <br>
              <br>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Address</label> 
                <input type="text" id="address" name="address" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Email</label>
                <input type="text" id="cnic" name="cnic" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <div class="form-group">
                  <label>Date of Birth</label>
                    <div class="input-group date" 
                    id="date_of_birth" 
                    data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#date_of_birth" name="date_of_birth" 
                        data-toggle="datetimepicker" autocomplete="off" />
                        <div class="input-group-append" 
                        data-target="#date_of_birth" 
                        data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Gender</label>
                <select class="form-control form-control-sm rounded-0" id="gender" 
                name="gender">
                  <?php echo getGender();?>
                </select>
                
              </div>
              </div>
              
              <div class="clearfix">&nbsp;</div>

              <div class="row">
                <div class="col-lg-11 col-md-10 col-sm-10 xs-hidden">&nbsp;</div>

              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
                <button type="submit" id="save_Patient" 
                name="save_Patient" class="btn bgBlue btn-sm btn-flat btn-block ">Save</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      
    </section>

    

 <section class="content">
      <!-- Default box -->
      <div class="card card-outline bg-line rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Patients' List</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
            <div class="row table-responsive">
              <table id="all_patients" 
              class="table table-striped dataTable table-bordered dtr-inline" 
               role="grid" aria-describedby="all_patients_info">
              
                <thead>
                  <tr class="bgBlue">
                    <th>S.No</th>
                    <th>Patient Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Date Of Birth</th>
                    <th>Phone Number</th>
                    <th>Gender</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <?php 
                  $count = 0;
                  while($row =$stmtPatient1->fetch(PDO::FETCH_ASSOC)){
                    $count++;
                  ?>
                  <tr>
                    <td><?php echo $count; ?></td>
                    <td><?php echo $row['patient_name'];?></td>
                    <td><?php echo $row['address'];?></td>
                    <td><?php echo $row['cnic'];?></td>
                    <td><?php echo $row['date_of_birth'];?></td>
                    <td><?php echo $row['phone_number'];?></td>
                    <td><?php echo $row['gender'];?></td>
                    <td>
                      <a href="update_patient.php?id=<?php echo $row['id'];?>" class = "btn bgBlue btn-sm btn-flat">
                      <i class="fa fa-edit"></i>
                      </a>
                    </td>
                   
                  </tr>
                <?php
                }
                ?>
                </tbody>
              </table>
            </div>
        </div>
     
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

   
    </section>
  </div>
    <!-- /.content -->
  
  <!-- /.content-wrapper -->
<?php 
 include './config/footer.php';

  $message = '';
  if(isset($_GET['message'])) {
    $message = $_GET['message'];
  }
?>  
  <!-- /.control-sidebar -->


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