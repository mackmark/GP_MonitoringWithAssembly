<?php
  session_name('sessionGPAdmin');
  session_start();
  if(isset($_COOKIE['GPAdmin_employeeID'])){
    echo "<script type='text/javascript'>location.href='admin.php';</script>";
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/bootstrap4.6.2/css/bootstrap.min.css">

    <!-- <link rel="stylesheet" type="text/css" href="../../assets/css/datatables.min.css"/> -->

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="../assets/fonts/fontawesome/css/all.min.css">

    <!-- style CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/animate.css">

    <link rel="stylesheet" type="text/css" href="../assets/css-hamburgers/hamburgers.min.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/select2.min.css">

    <link rel="stylesheet" type="text/css" href="../assets/css/util.css">
	  <link rel="stylesheet" type="text/css" href="../assets/css/main.css">

    <!-- print CSS -->
    <!-- <link rel="stylesheet" href="../../assets/css/print.min.css"> -->

    <!-- Title Icon -->
    <link rel="icon" type="image/png" href="https://www.motoliteexpress.com/wp-content/uploads/2022/06/gold-150x150.png">

    <title>PBI-GP_Monitoring | Admin</title>
  </head>
  <body>
	
    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100">
          <div class="login100-pic js-tilt" data-tilt>
            <img src="images/img-01.png" alt="IMG">
          </div>

          <form class="login100-form validate-form">
            <span class="login100-form-title">
              <span class="text-success">Plates Department</span></br>
              <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
            </span>

            <div class="wrap-input100 validate-input" data-validate = "Valid username is required">
              <input class="input100" type="text" name="uname" id="uname" placeholder="Username">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>

            <div class="wrap-input100 validate-input" data-validate = "Password is required">
              <input class="input100" type="password" name="pass" id="pass" placeholder="Password">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
            </div>
            
            <div class="container-login100-form-btn">
              <button class="login100-form-btn" id="login">
                Login
              </button>
            </div>

            <div class="text-center p-t-12">
              <span class="txt1 sr-only">
                Forgot
              </span>
              <a class="txt2 sr-only" href="#">
                Username / Password?
              </a>
            </div>

            <div class="text-center p-t-136">
              <a class="txt2 sr-only" href="#">
                Create your Account
                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
	
	

	
<!--===============================================================================================-->	
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<!--DataTable -->
    <script src="../assets/js/datatables.min.js"></script>
    <script src="../assets/js/dataTables.responsive.min.js"></script>
    <script src="../assets/js/dataTables.buttons.min.js"></script>
    <script src="../assets/js/jszip.min.js"></script>
    <script src="../assets/js/pdfmake.min.js"></script>
    <script src="../assets/js/vfs_fonts.js"></script>
    <script src="../assets/js/buttons.html5.min.js"></script>
    <script src="../assets/js/jquery.tabledit.min.js"></script>
    <!--DataTable END-->

	<script src="../assets/js/select2.min.js"></script>
  <script src="../assets/js/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script src="../assets/js/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.2
		})
	</script>
<!--===============================================================================================-->
	<script src="../assets/js/main.js"></script>
  <script src="js_repository/admin.js"></script>
  <script src="js_repository/admin_dataTable.js"></script>

</body>
</html>

