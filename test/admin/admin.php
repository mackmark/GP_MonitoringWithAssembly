<?php
    session_name('sessionGPAdmin');
    session_start();
    if(!isset($_COOKIE['GPAdmin_employeeID'])){
        echo "<script type='text/javascript'>location.href='index.php';</script>";
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

    <link rel="stylesheet" type="text/css" href="../assets/css/datatables.min.css"/>

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">GP Monitoring | Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">

                <li class="dropdown active">
                        <a class="d-inline-block text-white" href="#"><span class="fa fa-user-circle fa-2x position-relative" style="top:5px;"></span></a>
                        <a class="nav-link d-inline-block dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <?php echo $_COOKIE['GPAdmin_FirstName']. ' '. $_COOKIE['GPAdmin_LasttName']; ?>
                        </a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" onclick="Logout()" style="cursor:pointer;"><i class="fa fa-sign-out-alt"></i>&nbsp;Sign-out</a>
                        <!-- <a class="dropdown-item" href="#">Something else here</a> -->
                        </div>
                    </li>
                </ul>
            </div>
    </div>
    </nav>

    <div class="container position-relative" style="top:10vh;">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa fa-user-circle"></i>&nbsp;&nbsp;Manage Employee</button>
                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa fa-layer-group"></i>&nbsp;&nbsp;Manage Plate</button>
                <button class="nav-link" id="nav-myacc-tab" data-toggle="tab" data-target="#nav-myacc" type="button" role="tab" aria-controls="nav-myacc" aria-selected="false"><i class="fa fa-cog"></i>&nbsp;&nbsp;My Account</button>
                <!-- <button class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> -->
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                
                <div class="table-responsive p-3 shadow-sm mt-2 rounded bg-white mb-2">
                    <div class="container mb-2">
                        <button type="button" class="btn btn-success btn-sm ml-auto" onclick="AddEmpData()" style="z-index:-1;">Add Employee</button>
                    </div>
                    
                    <table class="table table-hovered table-bordered" id="employee_tbl" style="width:100%;">
                        <thead class="thead-dark text-center" style="font-size:13px;">
                            <tr>
                            <th scope="col">NO.</th>
                            <th scope="col">EMPLOYEE LASTNAME</th>
                            <th scope="col">EMPLOYEE FIRSTNAME</th>
                            <th scope="col">EMPLOYEE NICKNAME</th>
                            <th scope="col">ASSIGNED</th>
                            <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:13px;">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                <div class="table-responsive p-3 shadow-sm mt-2 rounded bg-white mb-2">
                    <div class="container mb-2">
                        <button type="button" class="btn btn-success btn-sm ml-auto" onclick="AddPlateData()" style="z-index:-1;">Add Plate</button>
                    </div>
                    
                    <table class="table table-hovered table-bordered" id="plate_tbl" style="width:100%;">
                        <thead class="thead-dark text-center" style="font-size:13px;">
                            <tr>
                            <th scope="col">NO.</th>
                            <th scope="col">PLATE TYPE</th>
                            <th scope="col">LINE</th>
                            <th scope="col">DATE ADDED</th>
                            <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:13px;">
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="tab-pane fade" id="nav-myacc" role="tabpanel" aria-labelledby="nav-myacc-tab">
                <div class="container mt-3">
                    <div class="container-sm shadow-lg mb-3 rounded bg-white p-3 text-center mt-3 " style="min-width:50vw;">
                            <p><i class="fa fa-address-card fa-4x"></i></p>
                            <p class="text-muted" style="font-weight:bold; font-size:20px;" id="admin_name">###</p>
                            <div class="row no-gutters">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4 text-center mb-3">
                                    <div class="input-group mb-3 mt-3">
                                        <input type="hidden" value="<?php echo $_COOKIE['GPAdmin_employeeID'] ?>" id="empID">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" id="username">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon2" id="password">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3"><i class="fa fa-eye" id="icon"></i></span>
                                        </div>
                                    </div>

                                    
                                    <button type="button" class="btn btn-success btn-md" onclick="updateCreds()">Update Credential</button>
                                   


                                </div>
                                <div class="col-lg-4"></div>
                            </div>
                    </div>
                </div>
            </div>

            <!-- <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                ...
            </div> -->

        </div>
    </div>


    <!-- modal block-->
    <!-- modal Block for Managing Employee Information -->
    <!-- modal for view -->
    <div class="modal fade" id="modalView" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
                <div class="container text-center">
                    <span class="login100-form-title">
                        <span class="text-success">Plates Department</span></br>
                        <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                        <hr class="my-0 bg-muted">
                    </span>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-3">
                        <div class="container shadow-sm bg-white rounded p-2 text-center border border-muted position-relative" style="top:-20px;">
                            <i class="fa fa-user-circle text-secondary fa-5x"></i>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="container shadow-sm bg-white rounded p-2 text-left position-relative" id="ViewContainer" style="top:-40px;"></div>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- modal for view end-->

    <!-- modal for edit -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
                <div class="container text-center">
                    <span class="login100-form-title">
                        <span class="text-success">Plates Department</span></br>
                        <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                        <hr class="my-0 bg-muted">
                    </span>
                </div>
                <div class="container shadow-sm bg-white rounded p-2 text-left position-relative" style="top:-40px;">
                    <div class="container text-center mb-2">
                        <i class="fa fa-user-circle text-secondary fa-5x"></i>
                    </div>
                    
                    <form>
                        <input type="hidden" id="idHolder">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="Lname" style="font-size:12px;">Last name</label>
                                <input type="text" class="form-control" id="Lname" style="font-size:10px;">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Fname" style="font-size:12px;">First name</label>
                                <input type="text" class="form-control" id="Fname" style="font-size:10px;">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Mname" style="font-size:12px;">Middle name</label>
                                <input type="text" class="form-control" id="Mname" style="font-size:10px;">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <!-- <label for="Lname" style="font-size:12px;">Last name</label>
                                <input type="text" class="form-control" id="Lname" style="font-size:10px;"> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Nname" style="font-size:12px;">Nick name</label>
                                <input type="text" class="form-control" id="Nname" style="font-size:10px;">
                            </div>
                            <div class="form-group col-md-4">
                                <!-- <label for="Mname" style="font-size:12px;">Middle name</label>
                                <input type="text" class="form-control" id="Mname" style="font-size:10px;"> -->
                            </div>
                        </div>
                    </form>
                    <hr class="my-0 bg-muted">

                    <div class="container mt-2 text-center">
                        <span class="text-muted mb-2" style="font-size:13px;">Designation</span>
                        <div class="row no-gutters">
                            <div class="col-lg-6 text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="paster" style="font-size:14px;">
                                    <label class="custom-control-label" for="paster" style="font-size:14px;">Paster</label>
                                </div>
                            </div>

                            <div class="col-lg-6 text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="stacker" style="font-size:14px;">
                                    <label class="custom-control-label" for="stacker" style="font-size:14px;">Stacker</label>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
                            
                            
            </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center">
            <button type="button" class="btn btn-success btn-sm" onclick="updateEmpData()">Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- modal for edit end-->

    <!-- modal for add -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
                <div class="container text-center">
                    <span class="login100-form-title">
                        <span class="text-success">Plates Department</span></br>
                        <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                        <hr class="my-0 bg-muted">
                    </span>
                </div>
                <div class="container shadow-sm bg-white rounded p-2 text-left position-relative" style="top:-40px;">
                    <div class="container text-center mb-2">
                        <i class="fa fa-user-circle text-secondary fa-5x"></i>
                    </div>
                    
                    <form>
                        <input type="hidden" id="idHolder">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="Lname" style="font-size:12px;">Last name</label>
                                <input type="text" class="form-control" id="LnameAdd" style="font-size:10px;">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Fname" style="font-size:12px;">First name</label>
                                <input type="text" class="form-control" id="FnameAdd" style="font-size:10px;">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Mname" style="font-size:12px;">Middle name</label>
                                <input type="text" class="form-control" id="MnameAdd" style="font-size:10px;" value = "---">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <!-- <label for="Lname" style="font-size:12px;">Last name</label>
                                <input type="text" class="form-control" id="Lname" style="font-size:10px;"> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Nname" style="font-size:12px;">Nick name</label>
                                <input type="text" class="form-control" id="NnameAdd" style="font-size:10px;" value = "---">
                            </div>
                            <div class="form-group col-md-4">
                                <!-- <label for="Mname" style="font-size:12px;">Middle name</label>
                                <input type="text" class="form-control" id="Mname" style="font-size:10px;"> -->
                            </div>
                        </div>
                    </form>
                </div>
                            
                            
            </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center">
            <button type="button" class="btn btn-success btn-sm" onclick="submitAddData()">Add</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- modal for add end-->
    <!-- modal Block for Managing Employee Information end-->


    <!-- modal Block for Managing Plate Information -->
    <!-- modal for view plate-->
    <div class="modal fade" id="modalViewPlate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
                <div class="container text-center">
                    <span class="login100-form-title">
                        <span class="text-success">Plates Department</span></br>
                        <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                        <hr class="my-0 bg-muted">
                    </span>
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-3">
                        <div class="container shadow-sm bg-white rounded p-2 text-center border border-muted position-relative" style="top:-20px;">
                            <i class="fa fa-layer-group text-secondary fa-5x"></i>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="container shadow-sm bg-white rounded p-2 text-left position-relative" id="ViewContainerPlate" style="top:-20px;"></div>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- modal for view end-->

    <!-- modal for edit plate-->
    <div class="modal fade" id="modalEditPlate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
                <div class="container text-center">
                    <span class="login100-form-title">
                        <span class="text-success">Plates Department</span></br>
                        <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                        <hr class="my-0 bg-muted">
                    </span>
                </div>

                <div class="container shadow-sm bg-white rounded p-2 text-left position-relative" style="top:-40px;">
                    <div class="container text-center mb-2">
                        <i class="fa fa-layer-group text-secondary fa-5x"></i>
                    </div>
                    
                    <form>
                        <input type="hidden" id="idHolderPlate">
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="platetype" style="font-size:12px;">Plate Type</label>
                                <input type="text" class="form-control" id="platetype" style="font-size:10px;font-weight:bold;">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="linePlate" style="font-size:12px;">Line</label>
                                <select id="linePlate" class="form-control" style="font-size:10px;">
                                </select>
                            </div>
        
                        </div>
                    </form>
                </div>
                            
                            
            </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center">
            <button type="button" class="btn btn-success btn-sm" onclick="updatePlateData()">Update</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- modal for edit end-->

    <!-- modal for add plate-->
    <div class="modal fade" id="modalAddPlate" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="container-fluid">
                <div class="container text-center">
                    <span class="login100-form-title">
                        <span class="text-success">Plates Department</span></br>
                        <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                        <hr class="my-0 bg-muted">
                    </span>
                </div>

                <div class="container shadow-sm bg-white rounded p-2 text-left position-relative" style="top:-40px;">
                    <div class="container text-center mb-2">
                        <i class="fa fa-layer-group text-secondary fa-5x"></i>
                    </div>
                    
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-7">
                                <label for="platetypeAdd" style="font-size:12px;">Plate Type</label>
                                <input type="text" class="form-control" id="platetypeAdd" style="font-size:10px;font-weight:bold;">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="linePlateAdd" style="font-size:12px;">Line</label>
                                <select id="linePlateAdd" class="form-control" style="font-size:10px;">
                                    <option selected value="0">Choose...</option>
                                    <option value = "1">Cominco</option>
                                    <option value = "2">Delphi</option>
                                </select>
                            </div>
        
                        </div>
                    </form>
                </div>
                            
                            
            </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center">
            <button type="button" class="btn btn-success btn-sm" onclick="submitAddPlateData()">Add</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <!-- modal for add end-->
    <!-- modal Block for Managing Plate Information end-->
	<!-- modal block end-->

	
<!--===============================================================================================-->	
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>

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
<!--===============================================================================================-->
	<script src="../assets/js/select2.min.js"></script>
  <script src="../assets/js/sweetalert.min.js"></script>
<!--===============================================================================================-->
<!--===============================================================================================-->
  <script src="js_repository/admin.js"></script>
  <script src="js_repository/admin_dataTable.js"></script>

</body>
</html>