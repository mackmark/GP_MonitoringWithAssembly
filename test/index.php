
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <meta name="description" content="GP Monitoring, Philippine Battery Inc, Plates Department">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/bootstrap4.6.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/datatables.min.css"/>

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.min.css">

    <!-- style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- print CSS -->
    <link rel="stylesheet" href="assets/css/print.min.css">

    <!-- Title Icon -->
    <link rel="icon" type="image/png" href="https://www.motoliteexpress.com/wp-content/uploads/2022/06/gold-150x150.png">
    <link rel="apple-touch-icon" href="https://www.motoliteexpress.com/wp-content/uploads/2022/06/gold-150x150.png">

    <title>PBI-GP_Monitoring | Data Entry</title>

  </head>
  <body style="background-color:#F7F8FF;">

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
                <div class="d-flex justify-content-start">
                  <div>
                    <label class="switch">
                      <input type="checkbox" id="switch" checked>
                      <span class="slider round"></span>
                    </label>
                  </div>

                  <div>
                    <span class="nav-link active" id="switch_txt" style="width:100px;">####</span>
                  </div>
                </div>
                
              </li>
              
              <li class="nav-item d-none d-md-block d-lg-block">
                <span class="nav-link">|</span>
              </li>
              <li class="nav-item active">
                  <a class="nav-link" type="button" href="" id="shiftPage"><i class="fa fa-prescription-bottle-alt"></i> Add Reject</a>
              </li>
              <li class="nav-item d-none d-md-block d-lg-block">
                <span class="nav-link">|</span>
              </li>
              <li class="nav-item active">
              <a class="nav-link" href="#" ><i class="fa fa-calendar-alt"></i>&nbsp;<span id="navdate">###</span></a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
              </li> -->
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
          </div>
        </div>
    </nav>

    <div class="container shadow-sm p-1 mb-5 bg-white rounded position-relative" id="page1" style="top:10vh;"> 
      <div class="row no-gutters">
        <div class="col-lg-5 p-1">
        <div class="card">
            <div class="card-header bg-light">
              <div class="d-flex justify-content-between mt-0">
                  <div>
                    <span class="text-muted d-block" style="font-weight:bold;font-size:12px;line-height:10px;">Sheet No.: </span>
                    <span id="sheetNo" class="text-success d-block" style="font-weight:bold;line-height:25px;">### </span>
                  </div>
                  <div>
                  <span class="text-muted d-block" style="font-weight:bold;font-size:12px;line-height:10px;">Process: </span>
                    <span class="text-success d-block" id="processtxt" style="font-weight:bold;line-height:25px;">###</span>
                  </div>
                  <div>
                    <i class="fa fa-redo-alt text-success position-relative" style="font-size:23px;top:5px;cursor:pointer;"
                    onclick = "AddRefresh()"></i>
                  </div>
              </div>
            </div>
            <div class="card-body bg-white">
                <form class="mt-0">
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="curringbooth" class="text-muted" style="font-size:12px;font-weight:bold;">Curing Booth</label>
                        <select id="curringbooth" name="curringbooth" class="form-control text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="curingboothNo" class="text-muted" style="font-size:12px;font-weight:bold;">Curing Booth No.</label>
                        <input type="text" disabled  class="form-control" id="curingboothNo" style="font-size:13px;font-weight:bold;" value="---">
                        <input type="hidden" class="form-control" id="curingboothNoHide" style="font-size:13px;font-weight:bold;">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="Shift" class="text-muted" style="font-size:12px;font-weight:bold;">Shift</label>
                        <select id="Shift" class="form-control text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>
                      </div>
                      <!-- <div class="form-group col-md-4"></div> -->
                   </div>


                   <hr class="my-1">
                   <div class="form-row" id="changePolarityContainer">
                      <div class="form-group form-check col-md-4">
                      </div>
                      <div class="form-group form-check col-md-4 text-center">
                        <input type="checkbox" class="form-check-input position-relative" id="changePolarity" style="font-size:12px;top:3px;">
                        <label class="form-check-label text-muted" for="changePolarity" style="font-size:12px;font-weight:bold;" id="changePolarityText"></label>
                      </div>
                   </div>
                   
                   <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="line" class="text-muted" style="font-size:12px;font-weight:bold;">Line</label>
                        <select id="line" name="line" class="form-control text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="Plate Type" class="text-muted" style="font-size:12px;font-weight:bold;">Plate Type</label>
                        <select id="plate" name="plate" class="form-control text-success" style="font-size:12px;font-weight:bold;" required>
                        <option selected disabled value="">Choose..</option>
                        </select>
                        <input type="hidden" id="platetxtHolder">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="Oxide" class="text-muted" style="font-size:12px;font-weight:bold;">Oxide Type</label>
                        <select id="Oxide" name="Oxide" class="form-control text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>
                      </div>

                      
                   </div>

                   <div class="form-row">
                      
                      <div class="form-group col-md-2"></div>
                      <!-- <div class="form-group col-md-4"></div> -->
                      
                   </div>
                   <hr class="my-1">
                   <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="Rack" class="text-muted" style="font-size:12px;font-weight:bold;">Rack No.</label>
                        <input type="text" class="form-control text-success" id="Rack" style="font-size:13px;font-weight:bold;" required>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="Batch" class="text-muted" style="font-size:12px;font-weight:bold;">Batch No.</label>
                        <select id="Batch" name="Batch" class="form-control text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>
                      </div>

                      <div class="form-group col-md-4">
                        <label for="SteamHood" class="text-muted" style="font-size:12px;font-weight:bold;">SteamHood No.</label>
                        <input type="text" class="form-control text-success" id="SteamHood" style="font-size:13px;font-weight:bold;" value="---" required>
                      </div>
                   </div>

                   <hr class="my-1">

                   <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="LotNumber" class="text-muted" style="font-size:12px;font-weight:bold;">Lot Number</label>
                        <input type="text" class="form-control text-success" id="LotNumber" style="font-size:13px;font-weight:bold;" disabled value="---">
                      </div>

                      <div class="form-group col-md-4">
                        <label for="qty" class="text-muted" style="font-size:12px;font-weight:bold;">Quantity</label>
                        <input type="number" class="form-control text-success" id="qty" style="font-size:13px;font-weight:bold;" value = "0"  required>
                      </div>
                      <!-- <div class="form-group col-md-4"></div> -->

                      <div class="form-group col-md-4">
                        <label for="moise" class="text-muted" style="font-size:12px;font-weight:bold;">Moisture Content</label>
                        <input type="number" class="form-control text-success" id="moise" style="font-size:13px;font-weight:bold;" value = "0">
                      </div>
                   </div>

                   <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="paster" class="text-muted" style="font-size:12px;font-weight:bold;">Paster</label>
                        <select id="paster" name="paster" class="form-control d-block text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>

                        <label for="stacker" class="text-muted" style="font-size:12px;font-weight:bold;">Stacker</label>
                        <select id="stacker" name="stacker" class="form-control d-block text-success" style="font-size:13px;font-weight:bold;" required>
                        </select>

                      </div>

                      <!-- <div class="form-group col-md-4">
                        
                      </div> -->
                      <!-- <div class="form-group col-md-4"></div> -->

                      <div class="form-group col-md-6">
                        <div class="container">
                            <button type="button" class="btn btn-outline-success mx-auto btn-sm position-relative d-none d-xl-block d-lg-block" onclick="AddSheetDetail()" style="top:33px;"><i class="fa fa-save"></i> Save & Print</button>

                            <button type="button" class="mx-auto btn btn-outline-success btn-sm d-block d-sm-none d-md-block d-lg-none d-xl-none" onclick="AddSheetDetail()"><i class="fa fa-save"></i> Save & Print</button>
                        </div>
                      </div>
                   </div>

                </form>
            </div>
          </div>
        </div>

        <div class="col-lg-7 p-1">
        <!-- <div id="IncTray"></div> -->
        <div class="card">
            <div class="card-header bg-white">
              <div class="row">
                <div class="col-lg-4">
                    <span class="mx-auto text-muted" style="font-size:13px;font-weight:bold;">Tag Printing</span>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                      <select class="custom-select" id="SheetNoPrint" aria-label="Example select with button addon" style="font-size:13px;">
                      </select>
                      <div class="input-group-append">
                        <button aria-label="Name" class="btn btn-outline-success btn-sm" onclick="SheetPrint()"><i class="fa fa-print"></i></button>
                      </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="input-group">
                      <select class="custom-select" id="LotNoPrint" aria-label="Example select with button addon" style="font-size:13px;">
                      </select>
                      <div class="input-group-append">
                        <button aria-label="Name" class="btn btn-outline-success btn-sm" onclick="LotPrint()"><i class="fa fa-print"></i></button>
                      </div>
                    </div>
                </div>

              </div>
            </div>
            <div class="card-body bg-white p-1">
                <div class="d-flex justify-content-between mt-2 mb-2">
                      <div style="padding-left:15px;">
                        <span class="text-muted" style="font-size:12px;font-weight:bold;">Summary</span>
                      </div>
                      <div id="CuringBoothProcess">
                        <!-- <span class="text-muted" style="font-size:13px;">Curing Booth <span class="badge badge-primary" style="font-size:17px;" >OSI 7</span></span> -->
                      </div>
                      <div style="padding-right:15px;">
                        <button type="button" class="btn btn-success btn-sm" style="font-size:12px;" onclick="complete()">COMPLETED</button>
                      </div>
                </div>
              
                
                <div class="table-responsive" style="top:5%;padding-left: 0;padding-right: 0;">
                  <table  class="display table-hover table-hover table-bordered compact" id="Sheet_tbl" style="width:100%;">
                  
                      <thead class="text-white text-center bg-dark" style="font-size:12px;">
                        <tr>
                          <th scope="col" class="text-center">ACTION</th>
                          <th scope="col" class="text-center">ITEM</th>
                          <th scope="col" class="text-center">LINE</th>
                          <th scope="col" class="text-center">SHIFT</th>
                          <th scope="col" class="text-center" style="white-space:nowrap;">RACK NO.</th>
                          <th scope="col" class="text-center" style="white-space:nowrap;">PLATE TYPE</th>
                          <th scope="col" class="text-center">QTY</th>
                          <th scope="col" class="text-center" style="white-space:nowrap;">LOT NO.</th>
                          <!-- <th scope="col">MC</th> -->
                        </tr>
                      </thead>
                      <tbody class="text-dark text-center" style="font-size:12px;font-weight:bold;">

                      </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
        </div>
      </div>
    </div>

    <!--Modal add reject-->
    <div class="modal fade" id="AddReject" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <p class="modal-title" id="staticBackdropLabel"><i class="text-success fa fa-prescription-bottle-alt"></i>&nbsp;Add Reject</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row no-gutters">
                <div class="col-lg-12 p-1">
                  <div class="container-fluid shadow-sm p-1 bg-white rounded">
                    <div class="row no-gutters">
                        <div class="col-lg-5 p-1">
                          <div class="container text-center mt-4">
                            <input type="date" class="form-control text-success" id="scrapActual" style="font-weight:bold;font-size:13px;">
                          </div>
                        </div>
                        <!-- <div class="col-lg-1"></div> -->
                        <div class="col-lg-2 p-1">
                          <div class="container text-center">
                              <span class="text-muted" style="font-size:13px;font-weight:bold;">Whole Day</span>
                          </div>
                          <div class="container-fluid shadow-sm p-1 bg-white rounded border border-success text-center" onclick = "WDay()" style="cursor:pointer;">
                            <i class="text-success fa fa-prescription-bottle-alt" style="font-size:35px;"></i>
                            <hr class="my-1 bg-light">
                            <span class="text-success" style="font-size:13px;font-weight:bold;" id="wholeday">100,000</span>
                          </div>
                        </div>
                        <div class="col-lg-2 p-1">
                          <div class="container text-center">
                              <span class="text-muted" style="font-size:13px;font-weight:bold;">12-H Day</span>
                          </div>
                          <div class="container-fluid shadow-sm p-1 bg-white rounded border border-warning text-center" onclick = "HDay()" style="cursor:pointer;">
                            <i class="text-warning fa fa-prescription-bottle-alt" style="font-size:35px;"></i>
                            <hr class="my-1 bg-light">
                            <span class="text-warning" style="font-size:13px;font-weight:bold;" id="Day12H">100,000</span>
                          </div>
                        </div>
                        <div class="col-lg-2 p-1">
                          <div class="container text-center">
                              <span class="text-muted" style="font-size:13px;font-weight:bold;">12-H Night</span>
                          </div>
                          <div class="container-fluid shadow-sm p-1 bg-white rounded border border-primary text-center" onclick = "NDay()" style="cursor:pointer;">
                            <i class="text-primary fa fa-prescription-bottle-alt" style="font-size:35px;"></i>
                            <hr class="my-1 bg-light">
                            <span class="text-primary" style="font-size:13px;font-weight:bold;" id="Day12N">100,000</span>
                          </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <!-- <div class="col-lg-2 p-1">
                          <div class="container text-center">
                              <span class="text-muted" style="font-size:13px;font-weight:bold;">Whole Day</span>
                          </div>
                          <div class="container-fluid shadow-sm p-1 bg-white rounded border border-success text-center">
                            <i class="text-success fa fa-prescription-bottle-alt" style="font-size:35px;"></i>
                            <hr class="my-1 bg-light">
                            <span class="text-success" style="font-size:13px;font-weight:bold;">100,000</span>
                          </div>
                        </div> -->
                    </div>
                    <hr class="my-1 bg-light">
                    <form>
                        <div class="form-row">
                          <div class="form-group col-md-3">
                              <label for="shiftreject" class="text-muted" style="font-size:13px;font-weight:bold;">Shift</label>
                              <select id="shiftreject" class="form-control" style="font-size:13px;">
                              </select>
                          </div>
                          <div class="form-group col-md-3">
                              <label for="linereject" class="text-muted" style="font-size:13px;font-weight:bold;">Line</label>
                              <select id="linereject" class="form-control" style="font-size:13px;">
                              </select>
                          </div>
                          <div class="form-group col-md-3">
                              <label for="platetypereject" class="text-muted" style="font-size:13px;font-weight:bold;">Plate Type</label>
                              <select id="platetypereject" class="form-control" style="font-size:13px;">
                              </select>
                          </div>
                          <div class="form-group col-md-3">
                              <label for="outputreject" class="text-muted" style="font-size:13px;font-weight:bold;">Total Output</label>
                              <input type="text" id="outputreject" class="form-control text-dark" style="font-size:13px;font-weight:bold;" disabled>
                              <input type="hidden" id="outputrejecthide" class="form-control text-dark" style="font-size:13px;font-weight:bold;">
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-3">
                              <label for="srplate" class="text-muted" style="font-size:13px;font-weight:bold;">SRPlate</label>
                              <input type="number" id="srplate" class="form-control" style="font-size:13px;">
                          </div>
                          <div class="form-group col-md-3">
                              <label for="srpaste" class="text-muted" style="font-size:13px;font-weight:bold;">SRPaste</label>
                              <input type="number" id="srpaste" class="form-control" style="font-size:13px;">
                          </div>
                          <div class="form-group col-md-3">
                              <label for="trimmings" class="text-muted" style="font-size:13px;font-weight:bold;">Trimmings</label>
                              <input type="number" id="trimmings" class="form-control" style="font-size:13px;">
                          </div>
                          <div class="form-group col-md-3">
                            <div class="container text-center position-relative" style="top:30px;">
                              <button type="button" class="btn btn-sm btn-outline-success" onclick="submitScrap()">ADD</button>
                            </div>
                          </div>
                        </div>
                    </form>
                  </div>

                    <div class="container-fluid shadow-sm p-1 mt-2 bg-white rounded" style="top:5%;">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-lg-4"></div>
                              <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                              <!-- <form>
                                  <div class="form-group mb-2">
                                    <select class="form-control" id="scrapCategory" style="font-size:13px;">
                                      <option selected value = "1">Breakdown</option>
                                      <option value = "2">Summary</option>
                                    </select>
                                  </div>
                                </form> -->
                            </div>
                        </div>
                    </div>
                      
                      <div class="table-responsive">
                        <table class="table table-hover table-hover table-bordered" id="Scrap_tbl" style="width:100%;">
                            <thead class="thead-dark text-center" style="font-size:10px;">
                              <tr>
                                <th scope="col">NO.</th>
                                <th scope="col" style="white-space:nowrap;">DATE ADDED</th>
                                <th scope="col">SHIFT</th>
                                <th scope="col">LINE</th>
                                <th scope="col" style="white-space:nowrap;">PLATE TYPE</th>
                                <th scope="col" style="white-space:nowrap;">TOTAL OUTPUT</th>
                                <th scope="col" style="white-space:nowrap;">SR PLATE</th>
                                <th scope="col" style="white-space:nowrap;">SR PASTE</th>
                                <th scope="col" style="white-space:nowrap;">TRIMMINGS</th>
                              </tr>
                            </thead>
                            <tbody class="text-dark text-center" style="font-size:11px;font-weight:bold;">

                            </tbody>
                          </table>
                      </div>
                      
                    </div>

                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal add reject-->

    <!--Modal Lot number edit-->
    <div class="modal fade" id="editLotNumber" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <p class="modal-title" id="staticBackdropLabel"><i class='text-success fa fa-pencil-alt'></i>&nbsp;Edit Item</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <form>
              <input type="hidden" id="Idholder">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="Edit_sheetNo" style="font-size:12px;">Sheet Number</label>
                  <input type="text" class="form-control text-success" id="Edit_sheetNo" style="font-size:12px;font-weight:bold;" disabled>
                </div>
                <div class="form-group col-md-6">
                  <label for="Edit_lotNo" style="font-size:12px;">Lot Number</label>
                  <input type="text" class="form-control text-success" id="Edit_lotNo" style="font-size:12px;font-weight:bold;" disabled>
                </div>
              </div>
            </form>

            <hr class="my-1 bg-light">

            <form>
              <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="Edit_shift" style="font-size:12px;">Shift</label>
                    <select id="Edit_shift" class="form-control" style="font-size:12px;"></select>
                </div>

                <div class="form-group col-md-6">
                  <label for="Edit_platetype" style="font-size:12px;">Plate Type</label>
                  <select id="Edit_platetype" class="form-control" style="font-size:12px;"></select>
                </div>

                <div class="form-group col-md-6">
                  <label for="Edit_line" style="font-size:12px;">Line</label>
                  <select id="Edit_line" class="form-control" style="font-size:12px;"></select>
                </div>

                <div class="form-group col-md-6">
                  <label for="Edit_rack" style="font-size:12px;">Rack No.</label>
                  <input type="text" class="form-control" id="Edit_rack" style="font-size:12px;">
                </div>

                <div class="form-group col-md-6">
                  <label for="Edit_qty" id="qty_lbl" style="font-size:12px;">Quantity</label>
                  <input type="number" class="form-control" id="Edit_qty" style="font-size:12px;" value="0">
                </div>

                <div class="form-group col-md-6">
                  <label for="Edit_moise" id="moise_lbl" style="font-size:12px;">Moiseture Content</label>
                  <input type="number" class="form-control" id="Edit_moise" style="font-size:12px;" value="0">
                </div>

              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success btn-sm" onclick="update()">Update</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal Lot number edit End-->

    <!--Modal Confirmation-->
    <div class="modal fade" id="confirmModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
              <div class="container text-center mt-3">
                  <i class="fa fa-exclamation-circle text-warning" style="font-size:50px;"></i>
                  <h2 class="mt-3" id="qtyHolder"></h2>
                  <p>Please ensure that all detail below are correct</p>
                  <hr class="my-1 bg-light">
                  <div class="row">
                    <div class="col-lg-6">
                      <p style="font-weight:bold;font-size:12px;">Line : </br><span id="lineHolder" class="text-danger" style="font-weight:bold;font-size:25px;">Cominco 1</span></p>
                    </div>
                    <div class="col-lg-6">
                      <p style="font-weight:bold;font-size:12px;">Plate Type : </br><span id="plateHolder" class="text-danger" style="font-weight:bold;font-size:25px;">XUEXTA095MN</span></p>
                    </div>
                  </div>
                  
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success btn-sm" id="btnconfirm" onclick="AddDetailModal()">Proceed</button>
          </div>
        </div>
      </div>
    </div>
    <!--Modal Confirmation End-->

    <div class="modal fade" id="loadPrintModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel4" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content">
          <div class="modal-body">
              <div class="container text-center">
                  <img src="assets/images/print.gif" alt="" height="200" width="250">
              </div>
          </div>
          </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="userselection" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-header">
              <div class="container text-center">
                <h5 class="modal-title text-success" id="staticBackdropLabel">Select user</h5>
              </div>
                
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> -->
                <!-- </button> -->
            </div>
            <div class="modal-body">
                <div class="container text-center">
                    <form>
                      <div class="form-group">
                        <select class="form-control" id="userselect">
                          <option selected value = "0" disabled>Choose...</option>
                          <option value="1">Cominco workstation - Negative Plate</option>
                          <option value="2">Delphi workstation - Positive Plate</option>
                          <option value = "3">Administrator</option>
                        </select>
                      </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                <div class="container text-center">
                  <button type="button" class="btn btn-outline-success" onclick = "selectUser()">Select</button>
                </div>
                
            </div>
            </div>
        </div>
    </div>



    <nav class="navbar navbar-expand-lg navbar-light bg-success fixed-bottom">
        <div class="container p-0">
            <p id="station" class="text-white mt-2" style="line-height:11px;"> </p>
            <p id="workstation" class="text-white mt-2" style="line-height:11px;"
            ><?php 
            if(isset($_COOKIE['GPuser'])){
              echo $_COOKIE['GPuser'];
            }
            ?>
          </p>
        </div>
    </nav>

    <div id="qr" class="d-none"></div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/bootstrap4.6.2/js/bootstrap.bundle.min.js"></script>
    <!--DataTable -->
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/dataTables.responsive.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <!-- <script src="assets/js/pdfmake.min.js"></script> -->
    <!-- <script src="assets/js/vfs_fonts.js"></script> -->
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/jquery.tabledit.min.js"></script>
    <!--DataTable END-->

    <script src="assets/QR_generator/jquery.qrcode.min.js"></script>
    <script src="assets/js/print.min.js"></script>

    <script src="assets/js/sweetalert.min.js"></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="js_repository/index.js"></script>
    <script src="js_repository/index_dataTable.js"></script>
  </body>
</html>

