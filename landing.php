<?php
include './config/connection.php';
include './common_service/common_functions.php';


$message = '';
if (isset($_POST['save_Patient'])) {

    $name = trim($_POST['name']);
    $phoneNumber = trim($_POST['phone_number']);
    $reason = trim($_POST['reason']);

    $time = trim($_POST['time']);
    
    $dateBirth = trim($_POST['date_of_birth']);
    $dateArr = explode("/", $dateBirth);
    
    $dateBirth = $dateArr[2].'-'.$dateArr[0].'-'.$dateArr[1];

    $status = "Active";

    $name = ucwords(strtolower($name));
   
if ($name != '' && $reason != '' && 
  $time != '' && $dateBirth != '' && $phoneNumber != '' ) {
      $query = "INSERT INTO `appointments`(`name`, 
    `contactnumber`, `reason`, `status`, `date`, `time`)
VALUES('$name', '$phoneNumber', '$reason', '$status',
'$dateBirth', '$time');";
try {

  $con->beginTransaction();

  $stmtPatient = $con->prepare($query);
  $stmtPatient->execute();

  $con->commit();

  $message = 'Appointment added successfully.';

} catch(PDOException $ex) {
  $con->rollback();

  echo $ex->getMessage();
  echo $ex->getTraceAsString();
  exit;
}
}
  header("Location:congratulation.php?goto_page=landing.php&message=$message");
  exit;
}
?>
<!DOCTYPE html>

<html> 

<head>
<?php include './config/site_css_links.php';?>

<?php include './config/data_tables_css.php';?>
    <title>Barangay Anabu I-E | Patient Management System</title>

    <style>
        body
        {
            padding: 0;
            margin: 0;
        }

        .navwindow2 a{
            padding-top: 2em;
            margin-top: 2em;
           
        }

        .app-btn{
            background: #0049B3;
            color:white;
            margin-left: 0.65em;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=IBM+Plex+Sans:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>
<div className='landgrp1'>
        <div className='landcontainer1'>
            
            <div className='landnav' style="padding: 0% 3% 0%; display: flex;align-items: center;justify-content:space-between; background-color: #bfdbfe; font-family: sans-serif; color:black; font-size: 1.3em;">

                <div className='navwindow1' style="display: flex;align-items: center;justify-content: center;color: #0049B3;font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">

                    <img style=" width: 40px; height: 40px; padding: .5em; max-height: 100%; max-width: 100%;" className='navlogo' src="logo2.png"/>

                    <p>Camet Candelaria</p>

                </div>

                <div className="navwindow2" style="display: flex;justify-content: center; align-items: center; column-gap: 3em; font-weight: lighter; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">

                    <a style="text-decoration: none;" href='' className='navlabel'><p style="color: #0049B3;">Home</p></a>
                    <a style="text-decoration: none;" href='' className='navlabel'><p style="color: #0049B3;">Services</p></a>
                    <a style="text-decoration: none;" href='' className='navlabel'><p style="color: #0049B3;">About</p></a>
                    <a style="text-decoration: none; background-color: #0049B3; padding: 0em .5em 0em; border-radius: 5px;" href='' className='navlabelbut'><p style="color: white;">Book Now</p></a>

                </div>
            </div>

            <div className='landwindow3' style="display: flex; align-items: center; padding: 0em 2em 8em;">
                    <div className='landleft1' style="display: flex; flex-direction: column; text-align: left;">
                         
                        <p className='landlefttext1' style="font-size:6.5em; font-family: 'IBM Plex Sans', sans-serif; font-weight: 100;">Smile with confidence, with our dental care excellence.</p>
                        <p className='landlefttext2' style="font-size:2em; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;">Achieve your perfect smile with our expert dental care. From routine cleanings to cosmetic dentistry, our experienced team provides high-quality care in a comfortable environment. Book your appointment today!</p>
                        <div className='landbutt' style="margin-top:3em;">
                        <a className='landbutton1' href='' style="color: white;
                        background-color: #0049B3;
                        padding: .8em 9em .8em;
                        text-decoration: none;
                        font-size: 1.3em;
                        font-family: 'IBM Plex Sans', sans-serif;
                        font-weight: 300;">Book an Appointment</a>
                        </div>
                    </div>
                    
                    <div className='landright1'>
                        <img className='rightlogo' src="logo2.png"/>
                    </div>

            </div>
        </div>
    </div>


    <div className='landgrp2' style="background-color: #bfdbfe; padding: 0em 0em 5em;">
        <div className='landcontainer2' style=" display: flex;justify-content: center; align-items: center;flex-direction: column;">

            <div className='landheader2' style="font-size: 10em;font-family: 'IBM Plex Sans', sans-serif;color: #0049B3; padding: .5em;">
                <p style="margin: 0;"> Services</p>
            </div>

            <div className='landflexbox2' style="display: flex; align-items: center; justify-content: center; column-gap: 3em;">

                <div className='landbox1' style="background-color: #0049B3; color: white; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;font-size: 2em;height: 600px;width: 400px;max-width: 100%; max-height: 100%; padding: 1em; list-style-type: none;
                font-size: 1.3em; padding: .5em 0em .5em;" >

                    <div className='header2_1' style="color: #bfdbfe; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; font-size: 2em;text-align: center; ">
                        <p>Preventive Care</p>
                    </div>

                    <ul style="list-style-type: none; font-size: 1.7em;">
                        <li>&bull; Checkups</li>
                        <li>&bull; Cleanings</li>
                        <li>&bull; X-Ray</li>
                        <li>&bull; Dental Sealant</li>
                        <li>&bull; Fluoride Treatment</li>
                    </ul>
                </div>

                <div className='landbox1' style="background-color: #0049B3; color: white; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;font-size: 2em;height: 600px;width: 400px;max-width: 100%; max-height: 100%; padding: 1em; list-style-type: none;
                font-size: 1.3em; padding: .5em 0em .5em;" >
                    <div className='header2_1' style="color: #bfdbfe; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; font-size: 2em;text-align: center;">
                        <p>Restorative Care</p>
                    </div>
                    <ul style="list-style-type: none; font-size: 1.7em;">
                        <li>&bull; Fillings</li>
                        <li>&bull; Crowns</li>
                        <li>&bull; Bridges</li>
                        <li>&bull; Root Canal Therapy</li>
                    </ul>
                </div>

                <div className='landbox1' style="background-color: #0049B3; color: white; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;font-size: 2em;height: 600px;width: 400px;max-width: 100%; max-height: 100%; padding: 1em; list-style-type: none;
                font-size: 1.3em; padding: .5em 0em .5em;" > 
                    <div className='header2_1' style="color: #bfdbfe; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; font-size: 2em;text-align: center; ">
                        <p>Cosmetic Dentistry</p>
                    </div>
                    <ul style="list-style-type: none; font-size: 1.7em;">
                        <li>&bull; Teeth Whitening</li>
                        <li>&bull; Veneers</li>
                        <li>&bull; Braces</li>
                        <li>&bull; Aligners</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

   
    <div className='landgrp3'>
        <div className='landcontainer3'>
            <div className='landflexbox3' style="display: flex;  flex-direction: column; align-items: center; justify-content: center;  text-align: center; max-width: 1600px; margin: 0 auto;">
                <div className='header3' style="font-family: 'IBM Plex Sans', sans-serif; font-weight: 300;
                font-size: 7em; color: #0049B3;">
                    <p>About Us</p>
                </div>
                <div className='text3' style="padding-top: 1em; padding-bottom: 6em; font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; font-size: 2em;">
                    <p>The dental clinic is a team of friendly and compassionate dental professionals dedicated to providing high-quality dental care services to their patients. They offer a wide range of dental services, including preventive care, complex restorative treatments, and cosmetic dentistry services. The clinic is equipped with state-of-the-art facilities and accepts most insurance plans, providing flexible payment options to fit patients' budgets and schedules.</p>
                </div>
            </div>
        </div>
    </div>

    <div className='landgrp4' style="background-color:#bfdbfe; height: 677x;">
        <div className='landcontainer4'>
                     
            <div className='landflexbox4' style="display: flex;  align-items: center; justify-content: space-between; padding: 0em 4em 0em;">
               
                <div className='landwindow4_1'>
                    <div className='landh4' style="font-family: 'IBM Plex Sans', sans-serif; font-weight: 300; font-size: 3em; color: #0049B3; padding-bottom: 0em;">
                 
                        <p>BOOK YOUR APPOINTMENT</p>
                    </div>
                    <form method="post">
            <div class="">
              <div class="">
              <label>Name</label>
              <input type="text" id="name" name="name" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>

              <div class="">
                <label>Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>


              <div class="">
                <label>Reason of Appointment</label> 
                <input type="text" id="reason" name="reason" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              <div class="">
                <label>Time</label>
                <input type="time" id="time" name="time" required="required"
                class="form-control form-control-sm rounded-0"/>
              </div>
              <div class="">
                <div class="form-group">
                  
                  <label>Appointment Date</label>
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
              
              
              </div>
              
              <div class="clearfix">&nbsp;</div>

              <div class="row">
                <div class="col-lg-11 col-md-10 col-sm-10 xs-hidden">&nbsp;</div>

              <div class="">
                <button type="submit" id="save_Patient" 
                name="save_Patient" class="btn bgBlue btn-sm btn-flat app-btn">Book Appointment</button>
              </div>
            </div>
          </form>
                    
                </div>
               
                <div className='landwindow4_2'>
                        <img className='rightlogo' src="girl.png"/>
                </div>
            </div>
        </div>
    </div>




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