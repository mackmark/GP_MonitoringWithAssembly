
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
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- print CSS -->
    <link rel="stylesheet" href="../assets/css/print.min.css">

    <!-- Title Icon -->
    <link rel="icon" type="image/png" href="https://www.motoliteexpress.com/wp-content/uploads/2022/06/gold-150x150.png">

    <title>PBI-GP_Monitoring | Assembly Data</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
          <a class="navbar-brand d-none d-xl-block d-lg-block" href="#" style="font-weight:bold;">GREEN PLATE MONITORING SHEET |</a><span class="text-white position-relative" style="font-size:13px;top:5px;">Assembly Reference Data</span>
          <a class="navbar-brand d-block d-sm-none d-md-block d-lg-none d-xl-none" style="font-size:15px;" href="#" style="font-weight:bold;">GP MONITORING SHEET</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

              <li class="nav-item active">
                  <a class="nav-link" href="#" ><i class="fa fa-calendar-alt"></i>&nbsp;<span id="navdate">###</span></a>
              </li>
 
            </ul>

          </div>
        </div>
    </nav>

    <div class="container shadow-sm p-1 mb-5 bg-white rounded position-relative" id="page1" style="top:10vh;"> 
        <input type="hidden" id="hiddenDate">
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="container">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="filterDateOption">Filter option</label>
                            </div>
                            <select class="custom-select" id="filterDateOption">
                                <option selected value="1">Today</option>
                                <option value="2">Yesterday</option>
                                <option value="3">Last 7 days</option>
                                <option value="4">1 month</option>
                                <option value="5">Custom range</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-4 col-sm-4">
                    <div class="form-group row d-none" id="dateRangeFilter">
                        <label for="DateFrom" class="col-sm-1 col-form-label">From</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" id="DateFrom">
                        </div>
                        <label for="DateTo" class="col-sm-1 col-form-label">To</label>
                        <div class="col-sm-5">
                            <input type="date" class="form-control" id="DateTo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-2">
        <div class="container shadow-sm p-1 mb-2 mt-2 bg-white rounded">
            <div class="table-responsive" id="reportContainer">
            <table class="table table-bordered" id="AssemblyReport_tbl" style="width:100%;">
                <thead class="thead-dark" style="font-size:11px;">
                    <tr>
                    <th scope="col">NO.</th>
                    <th scope="col" style="white-space:nowrap;">VIEW</th>
                    <th scope="col" style="white-space:nowrap;">SHEET NO.</th>
                    <th scope="col" style="white-space:nowrap;">LOT NO.</th>
                    <th scope="col" style="white-space:nowrap;">CURING BOOTH</th>
                    <th scope="col" style="white-space:nowrap;">CURING BOOTH NO.</th>
                    <th scope="col" style="white-space:nowrap;">SHIFT</th>
                    <th scope="col" style="white-space:nowrap;">LINE</th>
                    <th scope="col" style="white-space:nowrap;">PLATE TYPE</th>
                    <th scope="col" style="white-space:nowrap;">OXIDE TYPE</th>
                    <th scope="col" style="white-space:nowrap;">RACK NO.</th>
                    <th scope="col" style="white-space:nowrap;">BATCH NO.</th>
                    <th scope="col" style="white-space:nowrap;">QUANTITY</th>
                    <th scope="col" style="white-space:nowrap;">MOISTURE CONTENT</th>
                    <th scope="col" style="white-space:nowrap;">PASTER</th>
                    <th scope="col" style="white-space:nowrap;">STACKER</th>
                    <th scope="col" style="white-space:nowrap;">DATE ADDED</th>
                    <th scope="col" style="white-space:nowrap;">TIME ADDED</th>
                    </tr>
                </thead>
                <tbody style="font-size:12px;">
                </tbody>
            </table>
            </div>
        </div>

        <div class="modal fade" id="modalViewAssembly" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="container text-center mb-3">
                            <span class="login100-form-title">
                                <span class="text-success" style="font-size:20px;">Plates Department</span></br>
                                <span class="text-muted" style="font-size:12px;">Philippine Batteries Incorporated</span>
                                <hr class="my-0 bg-muted">
                            </span>
                        </div>
                        <div class="container-fluid shadow-sm bg-white rounded mb-2 p-2" id="RunDetails">
                            
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
        
    </div>



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

    <!-- <script src="../assets/QR_generator/jquery-qrcode-0.18.0.min.js"></script>
    <script src="../assets/js/print.min.js"></script> -->

    <!-- <script src="../assets/js/sweetalert.min.js"></script>
    <script src="../assets/js/canvasjs.min.js"></script> -->

    <script src="js_repository/assembly.js"></script>
    <!-- <script src="../js_repository/reportChart.js"></script> -->
    
  </body>
</html>

