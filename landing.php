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

    if ($name != '' && $reason != '' && $time != '' && $dateBirth != '' && $phoneNumber != '') {
        // Check if appointment with the same date and time exists
        $checkQuery = "SELECT COUNT(*) FROM `appointments` WHERE `date` = '$dateBirth' AND `time` = '$time'";
        $stmtCheck = $con->prepare($checkQuery);
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            // Appointment already exists, show an error message
            $message = 'Appointment with the same date and time already exists.';
        } else {
            // Insert the new appointment
            $query = "INSERT INTO `appointments`(`name`, `contactnumber`, `reason`, `status`, `date`, `time`) 
                      VALUES('$name', '$phoneNumber', '$reason', '$status', '$dateBirth', '$time');";

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
    } else {
        $message = 'Please fill in all required fields.';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <?php include './config/site_css_links.php';?>
    <?php include './config/data_tables_css.php';?>
    <title>Anabu 1-E Imus, Cavite</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;700&family=Lexend:wght@200;300;400;700&display=swap" rel="stylesheet">
    <style>
 /* Reset CSS */
 body, h1, h2, h3, p, ul, li, img {
            margin: 0;
            padding: 0;
            border: 0;
        }

        /* General Styles */
        body {
            font-family: "Lexend", Arial, sans-serif;
            background-color: #2A246A;
            color: #fff;
        }

        header {
            padding: 10px;
        }

        /* Navigation Styles */
        nav {
            padding-left: 2em;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            padding-right: 20px;
        }

        .logo img {
            height: 50px;
            margin-right: 10px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 400;
        }

        .navigation {
            padding-right: 5em;
            
            list-style: none;
            display: flex;
        justify-content: space-between;
        margin-right: -3em;
        }

        
        .navigation li {
            margin-right: 20px;
        }

        .navigation li:last-child {
            margin-right: 0;
        }

        .navigation a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            transition: color 0.2s;
            font-weight: 300;
        }

        .navigation a:hover {
            color: #ddd;
        }

        /* Slideshow Styles */
        .slideshow-container {
            max-width: 100%;
            overflow: hidden;
            position: relative;
            height: 900px;
        }

        .slideshow-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        /* Slideshow animation styles */
        .fade-in {
            opacity: 1;
        }

        @keyframes fade {
            0%, 100% {
                opacity: 0;
            }
            25%, 75% {
                opacity: 1;
            }
        }

        .dot-container {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }

        .dot {
            height: 10px;
            width: 10px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
        }

        .active {
            background-color: #717171;
        }

        /* Video Styles */
        .video-container {
            display: flex;
            justify-content: space-between;
            margin: 20px auto;
            max-width: 1200px;
            padding-bottom: 5em;
        }

        .video {
            width: 30%;
            background-color: #2A246A;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .video img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 1px;
        }

        .video-description {
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-size: 22px;
            line-height: 1.5;
            margin-top: 10px;
            color: #fff;
        }

        .watch-button {
            font-family: 'Lexend', Arial, sans-serif;
            font-size: 24px;
            color: #fff;
            background-color: #B92A30;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            align-self: flex-end;
        }

        /* Content Section Styles */
        .content-section {
            display: flex;
            background-color: #fff;
            padding: 40px;
            color: #333;
        }

        .content-left {
            flex: 1;
            text-align: left;
            font-size: 28px;
            line-height: 2;
            margin-right: 380px;
            margin-left: 150px;
    
            padding-right: 20px;
        }

        .content-right {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .content-right img {
            max-width: 100%;
            margin-right: 150px;
        }

        .content-button-container {
            text-align: left;
            margin-top: 20px;
        }

        .content-button {
            display: inline-block;
            font-size: 22px;
            padding: 10px 20px;
            background-color: #B92A30;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .content-button:hover {
            background-color: #861F24;
        }

        /* Health Services Section Styles */
        .health-services {
            background-color: #B92A30;
            text-align: center;
            color: #fff;
            padding: 50px 0;
        }

        .health-services h2 {
            font-family: "Lexend", Arial, sans-serif;
            font-size: 36px;
            font-weight: 400;
            margin: 0;
            padding: 20px;
            background-color: #B92A30;
        }

        /* Text Containers Styles */
        .text-containers {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 40px 20px;
            background-color: #2A246A;
        }

        .container-line {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .text-box {
            flex: 0 0 calc(33.33% - 20px);
            background-color: #fff;
            padding: 80px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .text-box h3, .text-box h4 {
            font-family: "Lexend", Arial, sans-serif;
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .text-box ul {
            font-family: "Lexend", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        .text-box li {
            list-style-type: disc;
            margin-left: 20px;
        }

        .text-box ul.sublist {
            list-style-type: none;
            margin-left: 20px;
        }

        .text-box ul.sublist li {
            list-style-type: none;
            margin-left: 0;
        }

        .text-box h4 {
            font-size: 22px;
            margin-top: 15px;
            color:white;
            background-color: #B92A30;
            padding: 10px 20px;
            display: inline-block;
        }

        .form{
            padding-top: 5em;
            padding-bottom: 5em;
            display: grid;
            place-items: center;
        }

        .formcon{
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            width: 30%;
        }
        .bookservices{
            display: flex;
            flex-direction: column;
            width: 100%;
            margin: 0;
            background-color: whitesmoke;
        }
        .bookheader p{
            font-size: 22px;
            padding: 2em;
            background-color:#B92A30 ;
            display: grid;
            place-items: center;
            font-size: 2.5em;
        }

        .formcon label{
            color: black;
            font-size: 1.3em;
            font-weight: 200;
        }

        .formcon input{
            border-radius: 20px;
            height: 40px;
            background-color:#D9D9D9 ;
            border: none;
            margin-bottom: .5em;
        }

        .formbutt button
        {
            margin-top: 1em;
            padding: .6em 3em .6em;
            font-family: "Lexend", Arial, sans-serif;
            font-size: 1.3em;
            border: none;
            border-radius: 20px;
            background-color: #B92A30;
            color: white;
        }

        .formfullname
        {
            display: flex;
            row-gap: 5em;
        }

        .formfullname input{
            width: 250px;
            height: 40px;
        }

        .footcontent{
            display: flex;
            justify-content: center;
            column-gap: 10em;
            padding: 5em 0em 5em;
            font-size: 1.3em;
        }

        .footleft
        {
            text-align: center;
            
        }

        .footright{
            display: flex;
            flex-direction: column;
        }

        .footright input{
            border: 1px solid white;
            background-color:#2A246A ;
            height: 40px;
            margin-bottom: .5em;
            margin-top: 1em;
        }

        .footright button{
            border-radius: 5px;
            border: none;
            color: #2A246A;
            font-family: "Lexend", Arial, sans-serif;
            font-size: .7em;
            padding: .8em;
            font-weight: 700;
        }

        .timeee{
            margin-left: 2em;
        }

        .subbt{
            border-radius: 5px;
            border: 2px solid #2A246A;
            font-family: "Lexend", Arial, sans-serif;
            font-size: .7em;
            padding: .8em;
            font-weight: 700;
            background-color:white;

        }

        hr{
            color: white;
            border: 1px solid white;
            width: 80%;
        }
        *{
            scroll-behavior: smooth;
           overflow-x: hidden;
        }
        .content-pane{
            color:#191919;
        }
    </style>
</head>
<body>
    <header>
        <nav>
        <div class="logo">
                <img src="asd.png" alt="Anabu 1-E Imus, Cavite Logo">
                <h1>Anabu 1-E Imus, Cavite</h1>
            </div>
            <ul class="navigation">
                <li><a href="#home">HOME</a></li>
                <li><a href="#about">ABOUT</a></li>
                <li><a href="#services">SERVICES</a></li>
                <li><a href="#book">BOOK AN APPOINTMENT</a></li>
            </ul>
        </nav>
    </header>

   <!-- Slideshow section -->
   <div class="slideshow-container">
        <img class="slideshow-img fade-in" src="sspic1.jpg" alt="Slide 1">
        <img class="slideshow-img" src="sspic2.jpg" alt="Slide 2">
        <img class="slideshow-img" src="sspic3.jpg" alt="Slide 3">

        <!-- Navigation indicator -->
        <div class="dot-container">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
    </header>
        <br>
        <br>
        <br>
        <br>
        <main>
        <div style="font-family: 'Lexend', Arial, sans-serif; text-align: center;">
            <div style="font-size: 28px; font-weight: 400; color: #fff; background-color: #B92A30; padding: 10px 20px; display: inline-block;">Recent News</div>
        </div>
            <br>
            <br>
        <!-- Video placeholders and descriptions -->
    <div class="video-container">
        <div class="video">
            <!-- Photo 1 Placeholder -->
            <img src="yt1.png" alt="Photo 1">
            <div class="video-description">
                <!-- Description for Photo 1 -->
            <br>
                <p>Bamban Aeta Medical Mission</p>
                <br>
                <a href="https://www.youtube.com/watch?v=CPLnxsgqjTc" target="_blank" class="watch-button">Watch</a>
            </div>
        </div>
        <div class="video">
            <!-- Photo 2 Placeholder -->
            <img src="yt2.png" alt="Photo 2">
            <div class="video-description">
                <!-- Description for Photo 2 -->
                <p>Anabu, Imus road repair</p>
                <br>
                <a href="https://www.youtube.com/watch?v=cXExjiLR2D0&t=2s" target="_blank" class="watch-button">Watch</a>
            </div>
        </div>
        <div class="video">
            <!-- Photo 3 Placeholder -->
            <img src="yt3.png" alt="Photo 3">
            <div class="video-description">
                <!-- Description for Photo 3 -->
                <p>Anabu Modular Treatment Plan</p>
                <br>
                <a href="https://www.youtube.com/watch?v=oerGhazoTUI&t=10s" target="_blank" class="watch-button">Watch</a>
            </div>
        </div>
    </div>

    <!-- Additional content sections -->
    <section class="content-section">
        <div class="content-left">
            <!-- Your text content goes here -->
            <h2 style="color: #2A246A;"id='about'>About Us</h2>
            <br>
            <p>Imus's borders include the residential district of Barangay Anabu 1-E, which is home to a multicultural population. Professionals, business owners, and skilled employees are among the residents of the barangay. The community is richer and has a more varied cultural fabric as a result of this variety.</p>
            <div class="content-button-container">
            <a href="#" class="content-button" >Know More</a>
        </div>
        </div>
        <div class="content-right" >
            <!-- Your big photo goes here -->
            <img src="building.jpg" alt="Big Photo">
        </div>
    </section>
    <section class="health-services">
    <div class="section-header">
        <h2>Health Services</h2>
    </div>
    <!-- Your content for the Health Services section goes here -->
    </section>
    <section class="text-containers">
    <div class="container-line" id='services'>
        <div class="text-box">
            <h4>For All</h4>
            <ul>
                <li>Medical Consultation</li>
                <li>Dental Consultation</li>
                <li>Dental Extraction</li>
                <li>Dental Fluoridation</li>
                <li>Dentures for Indigent Residents</li>
                <li>Discount on other Dental Services</li>
                <li>Fasting Blood Sugar (Digital FBS)</li>
                <li>Cholesterol Monitoring (Digital)</li>
            </ul>
        </div>
        <div class="text-box">
            <h4>For Women</h4>
            <ul>
                <li>Pap Smear & Vaginal Inspection with Acetic Acid (VIAA)</li>
                <li>Breast-I Examination and Palpation</li>
                <li>Pre-Natal Consultation</li>
                <li>Tetanus Toxoid Vaccination for Pregnant Women</li>
                <li>Supplementation of Vitamin A for Post-Partum Mothers (Within 1 Month upon Delivery)</li>
            </ul>
        </div>
        <div class="text-box">
            <h4>For Children</h4>
            <ul>
                <li>Purified Protein Derivate</li>
                <li>Vaccination for 0-15 Months </li>
                <br>
                <ul class="sublist">
                <li>- Barcille Calmette-Guerin</li>
                <li>- Hepatitis B Vaccine</li>
                <li>- Oral Polio Vaccine (1,2,3)</li>
                <li>- Pentavalent (Pental 1,2,3)</li>
                <li>- Inactive Poliomyelitis Vaccine (IPV)</li>
                <li>- Pneumococcal Conjugate Vaccine (PCV)</li>
                </ul>  
            </ul>
        </div>
    </div>
    <div class="container-line">
        <div class="text-box">
            <h4>For Men</h4>
            <ul>
                <li>Annual Digital Rectal Exam (DRE) for Prostate</li>
                <li>Annual Circumcision for Boys (9 Years & Above)</li>
            </ul>
        </div>
        <div class="text-box">
            <h4>Nutrition for All </h4>
            <ul>
                <li>Diet Counseling on Non-Communicable Diseases, Overweight and Obesity</li>
                <li>Micronutrients Powder for Kids</li>
                <li>Mag-Nanay Act Supplementation Feeding Program (First 1,000 Days)</li>
            </ul>
        </div>
        <div class="text-box">
            <h4>Yearly Activities</h4>
            <ul>
                <li>Annual Eye Checkup</li>
                <li>Annual Anti-Rabies Vaccination for Pets</li>
                <li>Annual Pet Blessing</li>
            </ul>
        </div>
    </div>


    <section class="bookservices">
        <div class="bookheader">
            <p>Set an Appointment in the Health Center</p>
        </div>

        <form action="landing.php" method="POST" id='book'>
        <div class="form">
            <div class="formcon">
            
            
            <label for="firstName">FULL NAME</label>
            <input type="text" id="firstName" name="name" required class="form-control form-control-sm rounded-0">

            <label for="email">REASON</label>
            <input type="text" id="email" name="reason" required class="form-control form-control-sm rounded-0">

            
            <label for="number">CONTACT NUMBER</label>
            <input type="text" id="number" name="phone_number" required class="form-control form-control-sm rounded-0">
            
        
            <div class="formfullname">

            <div class="topform">
            <div class="form-group">
                  
                  <label>APPOINTMENT DATE</label>
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
            
            <div class="topform timeee" >
            <label for="time">TIME</label>
            <input type="TIME" id="time" name="time" required class="form-control form-control-sm rounded-0 ">
            </div>
            
            
            </div>
            </div>

            <div class="subbt">
               <button type="submit" id="save_Patient" 
                name="save_Patient" class="btn bgBlue btn-sm btn-flat app-btn">Book Appointment</button>
            </div>
        </div>


        </form>
        


    </section>

    <div class="foot" style="width: 100%; padding:5em; display:grid; place-items:center; ">
        <div class="footop" style="display: grid; place-items:center; ">
            <img style="width: 300px;" src="asd.png" alt="">
            <p style="font-size: 3em; ">Barangay Anabu I-E</p>
            <p style="font-size: 1.5em; padding-bottom: 2em;">Imus City, Cavite</p>
        </div>

        <hr>

        <div class="footcontent">
            <div class="footleft">
                <p>Contact us</p>

                <p>24-Hour Command Center</p>
                <p>09972157320</p>
                <br>
                <p>Office of the Barangay Captain</p>
                <p>09972147320</p>
                <br>
                <p>anabu1e@gmail.com</p>
                <p>Anabu I-E, Imus City</p>

                <br>
                <br>
                <p style="font-style: bold; ">HOW TO GET THERE: </p>
                <br>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7729.187261869433!2d120.93754284626378!3d14.392907837311403!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d3d2d384e6eb%3A0xf44be72e3b8a5f09!2sAnabu%201-E%20Barangay%20Hall!5e0!3m2!1sen!2sph!4v1689779626711!5m2!1sen!2sph" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="footright">
                <p>BE PART OF OUR COMMUNITY!</p>
                <input type="text" id="fullName" name="fullName" placeholder="Name" required>
                <input type="text" id="fullName" name="fullName" placeholder="Your Email Address" required>
                <button type="submit"> SUBSCRIBE</button>
            </div>

            
        </div>
        <hr>
        <footer> <p>Copyright 2023 Barangay Anabu 1-E Imus City</p></footer>
       
    </div>
     <?php include './config/site_js_links.php'; ?>
    <?php include './config/data_tables_js.php'; ?>      
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
</section>
        <!-- Your other landing page content goes here -->
        </main>

         <script>
        // JavaScript for the slideshow and navigation indicator
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName("slideshow-img");
            let dots = document.getElementsByClassName("dot");

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.opacity = "0";
            }
            slideIndex++;

            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            for (let i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
            }

            slides[slideIndex - 1].style.opacity = "1";
            dots[slideIndex - 1].classList.add("active");

            setTimeout(showSlides, 3000); // Change slide every 3 seconds
        }

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
    
    <footer>
        <!-- Your footer content goes here -->
    </footer>

    <script>
    // Function to display the modal
    function showCustomMessage(message) {
        var modal = document.getElementById('modal');
        var modalContent = document.getElementById('modal-content');
        var closeBtn = document.getElementById('close-modal');

        modalContent.innerText = message;
        modal.style.display = 'block';

        closeBtn.onclick = function () {
            modal.style.display = 'none';
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    }

    // Check if there's a message from PHP and show the modal
    var message = '<?php echo $message; ?>';
    if (message !== '') {
        showCustomMessage(message);
    }
</script>
<!-- Modal Overlay -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span id="close-modal" class="close">&times;</span>
        <p id="modal-content"></p>
    </div>
</div>
</body>
</html>