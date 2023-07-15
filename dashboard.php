<?php 
include './config/connection.php';

// Calculate the start and end date of the current week


  $date = date('Y-m-d');
  
  $year =  date('Y'); 
  $month =  date('m');

  $week_start = date('Y-m-d', strtotime('this week', strtotime($date)));
$week_end = date('Y-m-d', strtotime('next week', strtotime($date)));



  $queryToday = "SELECT COUNT(*) AS `today` 
               FROM `appointments` 
               WHERE `status` = 'Active';";

$queryWeek = "SELECT COUNT(*) AS `week` 
              FROM `appointments` 
              WHERE `date` BETWEEN '$week_start' AND '$week_end' AND `status` = 'Active';";

$queryYear = "SELECT count(*) as `year` 
  from `patient_visits` 
  where YEAR(`visit_date`) = YEAR('$date');";

$queryMonth = "SELECT count(*) as `month` 
  from `patient_visits` 
  where YEAR(`visit_date`) = $year and 
  MONTH(`visit_date`) = $month;";

  $todaysCount = 0;
  $currentWeekCount = 0;
  $currentMonthCount = 0;
  $currentYearCount = 0;

$countPatients = "SELECT COUNT(*) AS total_patients FROM patients;";
  

  try {

    $stmtCountPatients = $con ->prepare($countPatients);
    $stmtCountPatients -> execute();
    $r = $stmtCountPatients->fetch(PDO::FETCH_ASSOC);
    $patientsCount = $r['total_patients'];

    $stmtToday = $con->prepare($queryToday);
    $stmtToday->execute();
    $r = $stmtToday->fetch(PDO::FETCH_ASSOC);
    $todaysCount = $r['today'];

    $stmtWeek = $con->prepare($queryWeek);
    $stmtWeek->execute();
    $r = $stmtWeek->fetch(PDO::FETCH_ASSOC);
    $currentWeekCount = $r['week'];

    $stmtYear = $con->prepare($queryYear);
    $stmtYear->execute();
    $r = $stmtYear->fetch(PDO::FETCH_ASSOC);
    $currentYearCount = $r['year'];

    $stmtMonth = $con->prepare($queryMonth);
    $stmtMonth->execute();
    $r = $stmtMonth->fetch(PDO::FETCH_ASSOC);
    $currentMonthCount = $r['month'];

  } catch(PDOException $ex) {
     echo $ex->getMessage();
   echo $ex->getTraceAsString();
   exit;
  }


  try {

    $query = "SELECT `id`, `name`, `contactnumber`, 
    `reason`,`status`, date_format(`date`, '%d %b %Y') as `date`, 
    TIME_FORMAT(`time`, '%h:%i %p') as `time`
    FROM `appointments`
    WHERE `status` = 'Active'
    ORDER by `date` ASC ";
    
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
 <title>Camet - Candelaria Dental Clinic - Patient Management System</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

  .dark-mode .bg-fuchsia, .dark-mode .bg-maroon {
    color: #fff!important;

}

.default-bg{
  background:#0049B3;
  color:white;
}

.componentTitle{
 font-family: 'Poppins', sans-serif;
 color:#0049B3;
 font-weight:900;
}

i{
  color:white;
}

.apppointmentContent{
  margin-left:-1em;
  width:100.5%;
}

.minimize{
  color:#0049B3;
}

.bg-line{
  border-top: 4px solid #0049B3;
}
</style>
</head>
<body class="hold-transition sidebar-mini light-mode layout-fixed layout-navbar-fixed">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->

<?php 

include './config/header.php';
include './config/sidebar.php';
?>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="componentTitle">OVERVIEW</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box default-bg">
              <div class="inner">
                <h3><?php echo $todaysCount;?></h3>

                <p>Expected Appointments</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar-day"></i>
              </div>
             
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box default-bg">
              <div class="inner">
                <h3><?php echo $currentWeekCount;?></h3>

                <p>Current Week</p>
              </div>
              <div class="icon">
                <i class="fa fa-calendar-week"></i>
              </div>
             
            </div>
          </div>
          <!-- ./col -->
         
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box default-bg">
              <div class="inner">
                <h3><?php echo $patientsCount;?></h3>

                <p>All Patients</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-injured"></i>
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content apppointmentContent">
      <!-- Default box -->
      <div class="card card-outline bg-line rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Appointments' List</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus minimize"></i>
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
                    <th>Appointee Name</th>
                    <th>Contact Number</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Time</th>
                    
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
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['contactnumber'];?></td>
                    <td><?php echo $row['reason'];?></td>
                    <td><?php echo $row['status'];?></td>
                    <td><?php echo $row['date'];?></td>
                    <td><?php echo $row['time'];?></td>
                    
                   
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



    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include './config/footer.php';?>  
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include './config/site_js_links.php';?>
<script>
  $(function(){
    showMenuSelected("#mnu_dashboard", "");
  })
</script>

</body>
</html>