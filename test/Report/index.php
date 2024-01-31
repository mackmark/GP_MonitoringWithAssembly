
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

    <title>PBI-GP_Monitoring | Reports</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <div class="container">
          <a class="navbar-brand d-none d-xl-block d-lg-block" href="#" style="font-weight:bold;">GREEN PLATE MONITORING SHEET</a>
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
        <div class="container-fluid shadow-sm p-1 mb-3 mt-2 bg-white rounded">
            <div class="d-flex justify-content-between">
                <div class="p-3">
                    <input type="date" id="date_report" class="form-control">
                </div>
                <div class="p-3">
                    <select class="form-control" id="UserWorkstation">
                        <option selected value="1">Cominco</option>
                        <option value="2">Delphi</option>
                        <option value="4">Production Output</option>
                        <option value="3">Administrator</option>
                    </select>
                </div>
                <div class="p-3">
                    <button class="btn btn-outline-success btn-sm" id="reload">Refresh Data</button>
                </div>
            </div>
            
        </div>

        <div class="container shadow-sm p-1 rounded mt-2 bg-white">
            <div class="row no-gutters">
                <div class="col-lg-4 p-1 rounded border border-success text-center">
                    <p class="text-muted p-0">12H - Day Shift</p>
                    <div class="table-responsive justify-content-center">
                        <table class="table table-bordered" id="halfShiftD_tbl" style="width:100%;">
                            <thead class="thead-dark" style="font-size:11px;">
                                <tr>
                                    <!-- <th scope="col">NO.</th> -->
                                    <th scope="col" style="white-space:nowrap;">LINE</th>
                                    <th scope="col" style="white-space:nowrap;">SHIFT</th>
                                    <th scope="col" style="white-space:nowrap;">PLATE TYPE</th>
                                    <th scope="col" style="white-space:nowrap;">TOTAL OUPUT</th>
                                </tr>
                            </thead>
                            <tbody style="font-size:12px;">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 p-1 rounded border border-success text-center">
                    <p class="text-muted p-0">12H - Night Shift</p>
                    <div class="table-responsive justify-content-center">
                        <table class="table table-bordered" id="halfShiftN_tbl" style="width:100%;">
                            <thead class="thead-dark" style="font-size:11px;">
                                <tr>
                                    <!-- <th scope="col">NO.</th> -->
                                    <th scope="col" style="white-space:nowrap;">LINE</th>
                                    <th scope="col" style="white-space:nowrap;">SHIFT</th>
                                    <th scope="col" style="white-space:nowrap;">PLATE TYPE</th>
                                    <th scope="col" style="white-space:nowrap;">TOTAL OUPUT</th>
                                </tr>
                            </thead>
                            <tbody style="font-size:12px;">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4 p-1 rounded border border-success text-center">
                    <p class="text-muted p-0">Whole Day</p>
                    <div class="table-responsive justify-content-center">
                        <table class="table table-bordered" id="WholeDay_tbl" style="width:100%;">
                            <thead class="thead-dark" style="font-size:11px;">
                                <tr>
                                    <!-- <th scope="col">NO.</th> -->
                                    <th scope="col" style="white-space:nowrap;">LINE</th>
                                    <!-- <th scope="col" style="white-space:nowrap;">SHIFT</th> -->
                                    <th scope="col" style="white-space:nowrap;">PLATE TYPE</th>
                                    <th scope="col" style="white-space:nowrap;">TOTAL OUPUT</th>
                                </tr>
                            </thead>
                            <tbody style="font-size:12px;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="container shadow-sm p-1 mb-2 mt-2 bg-white rounded">
            <div class="table-responsive" id="reportContainer">
            <table class="table table-bordered" id="report_tbl" style="width:100%;">
                <thead class="thead-dark" style="font-size:11px;">
                    <tr>
                    <th scope="col">NO.</th>
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

    <script src="../js_repository/report.js"></script>
    <script src="../js_repository/index_dataTable.js"></script>
    <!-- <script src="../js_repository/reportChart.js"></script> -->
    
  </body>
</html>

