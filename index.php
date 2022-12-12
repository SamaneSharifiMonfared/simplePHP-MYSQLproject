<?php
if($_POST["Employee"]){
    $result_flag=1;

    include_once('assets/sqlserverinformation.php'); //the file with sql server credential
    include_once('assets/functions/functionsandclasses.php'); //the file with connection class
//form validation simple with laravel it is much easier and formed nicer

    if(!preg_match("/^[0-9]*$",$_POST['Employee'])){ //only number allowed
        $user_ID=$_POST['Employee']; //employee id from the form
    }else{
        echo "Hacked!";
        $user_ID=0;
    }

    $datematchstr="/^(20[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";

    if(!preg_match($datematchstr,$_POST['Employee'])){ //only dates
        $SD=$_POST['Startdate']; //start date;
    }else{
        echo "Hacked!";
        $SD=0;
    }
    if(!preg_match($datematchstr,$_POST['Employee'])){ //only dates
        $ED=$_POST['Enddate'];//end date for the search
    }else{
        echo "Hacked!";
        $ED=0;
    }



//query to access the data between two dates and for the user got selected!
    $querydata="SELECT * FROM dbovisitlog
WHERE log_visitorid =".$user_ID."
AND DATE(log_amended) >= '".$SD."'
AND DATE(log_amended) <= '".$ED."' ";

    $my_connection=new sqlConnection;// the class of sql connection aid
    $results=[];
    $results=$my_connection->mysql_fetch($conn,$querydata); // fetching the query

    $queryusers = "SELECT * FROM dbousers;"; //query to the table of all users

    $users=$my_connection->mysql_fetch($conn,$queryusers); //fetching users table (including the id and name of users)

//getting the name of employee from the employee table

    foreach($users as $user){
        if($user[0]==$user_ID){
            $name=$user[1];
        }
    }
//print_r($results);
//summation of all log In hours

    $sum=0;
    foreach($results as $result)
    {

        $dif = intval((strtotime($result[4])-strtotime($result[3]))/60);
        //sum of diffs
        $sum=$sum+$dif;

    }

    $dateDiff = $sum;

    $hours = intval($dateDiff/60);
    $minutes = $dateDiff%60;



}else{
    $result_flag=0;
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Task Samane</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">Task Samane</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-9 text-center">

        </div>
      </div>
        <div class="row">
            <?php if($result_flag==0){ ?>
            <p>Please enter the information below: (I assigned default values to reduce the errors could make but in a real application we use validation for input like: Message: cannot be empty or show the submit button after filling all!)</p>
            <form action="#" method="post">
                <label for="Startdate">Start Date:</label><br>
                <input type="date" id="Startdate" name="Startdate" value="2018-01-01"><br>
                <label for="Enddate">End Date:</label><br>
                <input type="date" id="Enddate" name="Enddate" value="2022-01-01"><br><br>
                <select name="Employee" class="col-4">
                <option value="1893">RICHARD</option>
                <option value="1878">APOS</option>
                <option value="1877">SIMA</option>
                <option value="1879">DIMITRIS</option>
                <option value="1880">LIAM</option>
                <option value="1881">JEREMY</option>
                <option value="1882">STAVROS</option>
            </select>
                <input type="submit" value="Submit">
            </form>
<?php }else{ ?>

            <div class="row icon-boxes">
                <table id="myTable" class="display">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Log In Duration</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <?php
                        if ($sum==0){
                            ?> <td>No Record for <?=$name?></td>
                        <?php } else{ ?>
                            <td><?=$name?></td>
                            <td><?=$hours?> Hours and <?=$minutes?> Min </td><?php } ?>
                    </tr>

                    </tbody>
                </table>
            </div>

            <?php } ?>






        </div>


         </div>
  </section><!-- End Hero -->

  <main id="main">


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
          Thanks, Samane.
      </div>

    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" type="text/css" href="/DataTables/datatables.css">

  <script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>
</body>

</html>