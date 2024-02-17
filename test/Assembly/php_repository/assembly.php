<?php
    include "../../includes/db.php";
    include "../../includes/functions.php";

    date_default_timezone_set("Asia/Manila");
    $date = date('Y-m-d');//date uploaded
    $dateNav = date('M d, Y');
    $time =  date("H:i:s");
    $time2 = date("h:i a");
    $day = date("l");
    $year = date("Y"); //year
    $timestamp = $date.' '.$time;

    $action = isset($_POST['action']) ? $_POST['action']: null;

    if($action=='AssemblyReport_Table'){
        $userid = 0;
        $FromDate = isset($_POST['FromDate']) ? $_POST['FromDate'] : null;
        $ToDate = isset($_POST['ToDate']) ? $_POST['ToDate'] : null;
        $setterId = isset($_POST['setterId']) ? $_POST['setterId'] : null;
        
        $dateAdd = date('Y-m-d h:m:s', strtotime("+1 day", strtotime($date)));

        $search = "%".$_POST["search"]["value"]."%";

        $column = array("", "", "SheetNo", "LotNumber", "CurringBooth", "CurringBoothNo", "Shift", "Line", "PlateType", "OxideType", "RackNo", "BatchNo", "Quantity", "MoiseContent", "Paster", "Stacker", "DateCreated", "" );

        $query = "SELECT s.SheetNo, sd.LotNumber, cb.CurringBooth, sd.CurringBoothNo, sd.Shift, l.Line, pl.PlateType, ox.OxideType, sd.RackNo, sd.BatchNo, sd.Quantity, sd.MoiseContent, concat(stacker.LastName, ', ',stacker.FirstName) as 'Paster', concat(paster.LastName, ', ',paster.FirstName) as 'Stacker', sd.DateCreated ";
        $query .="FROM sheetdetail_tbl sd ";
        $query .="JOIN sheet_tbl s ON sd.SheetID = s.SheetID ";
        $query .="JOIN curringbooth_tbl cb ON sd.CurringBoothID = cb.CurringBoothID ";
        $query .="JOIN line_tbl l ON sd.LineID = l.LineID ";
        $query .="JOIN platetype_tbl pl ON sd.PlateTypeID = pl.PlateTypeID ";
        $query .="JOIN oxidetype_tbl ox ON sd.OxideTypeID = ox.OxideTypeID ";
        $query .="JOIN employee_tbl paster ON sd.PasterID = paster.EmployeeID ";
        $query .="JOIN employee_tbl stacker ON sd.StackerID = stacker.EmployeeID ";
        $query .="WHERE sd.IsDeleted = 0 AND sd.IsActive = 1 ";

        if($setterId==1){
            $query .="AND sd.DateCreated BETWEEN '".$date." 06:00:00' AND  DATEADD(day, +1, '".$date." 06:00:00') ";
        }
        else if($setterId==2){
            $query .="AND sd.DateCreated BETWEEN DATEADD(day, -1, '".$date." 06:00:00') AND  DATEADD(day, +1, '".$date." 06:00:00') ";
        }
        else if($setterId==3){
            $query .="AND sd.DateCreated BETWEEN DATEADD(day, -7, '".$date." 06:00:00') AND  DATEADD(day, +1, '".$date." 06:00:00') ";
        }
        else if($setterId==4){
            $query .="AND sd.DateCreated BETWEEN DATEADD(month, -1, '".$date." 06:00:00') AND  DATEADD(day, +1, '".$date." 06:00:00') ";
        }
        else if($setterId==5){
            $query.="AND sd.DateCreated BETWEEN '".$FromDate." 00:00:00' AND  '".$ToDate." 23:59:59' ";
        }

        if(isset($_POST["search"]["value"])){											
            if(!empty($_POST["search"]["value"])){
                $query .='AND (sd.Shift LIKE ? ';
                $query .='OR sd.LotNumber LIKE ? ';
                $query .='OR l.Line LIKE ? ';
                $query .='OR cb.CurringBooth LIKE ? ';
                $query .='OR pl.PlateType LIKE ? ';
                $query .='OR s.SheetNo LIKE ?) ';
            }
        }

        if(isset($_POST["order"])){

            $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
        } 

        else{

            $query .='ORDER BY sd.DateCreated DESC ';
        }

        $query1 ='';

        if($_POST["length"] != -1){
            $query1 = 'OFFSET '. $_POST['start'].' ROWS
            FETCH NEXT '.$_POST['length'].' ROWS ONLY ';
        }

        $result = "";
        $count  = 0;

        if(!empty($_POST["search"]["value"])){
            $result = odbc_prepare($conn, $query.$query1);
            odbc_execute($result, array($search, $search, $search, $search, $search, $search));
            $count = odbc_num_rows($result);
            // $result = odbc_fetch_array($stmt);
        }
        else{
            $table = odbc_exec($conn, $query);
            $count = odbc_num_rows($table);
            $result = odbc_exec($conn, $query.$query1);
        }

        // confirmQuery($result);

        $data = array();
        
        $n = 1;

        while($row = odbc_fetch_array($result)){

            $sheetNo    = $row['SheetNo'];
            $lotNumber  = $row['LotNumber'];
            $booth      = $row['CurringBooth'];
            $boothNo    = $row['CurringBoothNo'];
            $shift      = $row['Shift'];
            $line       = $row['Line'];
            $plate      = $row['PlateType'];
            $oxide      = $row['OxideType'];
            $rackno     = $row['RackNo'];
            $batchno    = $row['BatchNo'];
            $qty        = $row['Quantity'];
            $MC         = $row['MoiseContent'];
            $paster     = htmlspecialchars($row['Paster']);
            $stacker    = htmlspecialchars($row['Stacker']);
            $dateAdd    = $row['DateCreated'];
            $timeAdd    = $row['DateCreated'];

            $pcs = "";
            if($qty > 1){
                $pcs = "pcs";
            }
            else{
                $pcs = "pc";
            }

            $sub_array = array();
            
            $sub_array[] = $n;
            $sub_array[] = '<button type="button" class="btn btn-sm btn-outline-success" onclick="ViewData(\''.$lotNumber.'\')"><i class="fa fa-eye"></i></button>';
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$sheetNo."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$lotNumber."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$booth."</span>";
            $sub_array[] = $boothNo;
            $sub_array[] = $shift;
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$line."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$plate."</span>";
            $sub_array[] = $oxide;
            $sub_array[] = $rackno;
            $sub_array[] = $batchno;
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".number_format($qty)." ".$pcs."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".floatval($MC)." %"."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$paster."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$stacker."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".date('M d, Y',strtotime($dateAdd))."</span>";
            $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".date('h:i:s A',strtotime($dateAdd))."</span>";


            $n ++;

            $data[] = $sub_array;
        }

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsFiltered' => $count,
            'data' => $data,
            "recordsTotal"=> $count
        );
        
        // file_put_contents("tableData.json", json_encode($output));a

        echo json_encode($output);
    }
    else if($action=='NavDate'){
        $arr = array(
            'navdate'=> $dateNav,
            'default'=>$date
        );
        
        echo json_encode($arr);
    }
    else if($action=='RunDetails'){
        $LotNumber = isset($_POST['LotNumber']) ? $_POST['LotNumber'] : null;

        $queryDetail = "SELECT sd.SheetDetailID, p.PlateType, qr.QRDataUrl, sd.Quantity, l.Line, sd.RackNo, sd.DateCreated, cb.CurringBooth, sd.Shift, sd.BatchNo, paster.LastName as 'PasterLname', paster.FirstName as 'PasterFname', stacker.LastName as 'stackerLname', stacker.FirstName as 'stackerFname', sd.MoiseContent, s.SheetNo ";
        $queryDetail .= "FROM sheetdetail_tbl sd ";
        $queryDetail .= "JOIN sheetdetailqr qr ON qr.SheetDetailID = sd.SheetDetailID ";
        $queryDetail .= "JOIN line_tbl l ON sd.LineID = l.LineID ";
        $queryDetail .= "JOIN platetype_tbl p ON sd.PlateTypeID = p.PlateTypeID ";
        $queryDetail .= "JOIN curringbooth_tbl cb ON sd.CurringBoothID = cb.CurringBoothID ";
        $queryDetail .= "JOIN employee_tbl paster ON sd.PasterID = paster.EmployeeID ";
        $queryDetail .= "JOIN employee_tbl stacker ON sd.StackerID = stacker.EmployeeID ";
        $queryDetail .= "JOIN sheet_tbl s ON sd.SheetID = s.SheetID ";
        $queryDetail .= "WHERE sd.LotNumber = '".$LotNumber."' ";

        $resultDetail = odbc_exec($conn, $queryDetail);
        $output = '';
        $qrCode = '';
        $plateType = "";
        $quantity = 0;
        $line = "";
        $rackno = "";
        $Date = "";
        $curringbooth = "";
        $shift = "";
        $batchNo = "";
        $pasterFname = "";
        $pasterLname = "";
        $stackerFname = "";
        $stackerLname = "";
        $sheetNo = "";
        $mc = "";

        if($resultDetail){
            while($rowDetail = odbc_fetch_array($resultDetail)){
                $qrCode = '../QRuploads/'.$rowDetail['QRDataUrl'];
                $plateType = $rowDetail['PlateType'];
                $quantity = $rowDetail['Quantity'];
                $line = $rowDetail['Line'];
                $rackno = $rowDetail['RackNo'];
                $Date = $rowDetail['DateCreated'];
                $curringbooth = $rowDetail['CurringBooth'];
                $shift = $rowDetail['Shift'];
                $batchNo = $rowDetail['BatchNo'];
                $pasterFname = $rowDetail['PasterFname'];
                $pasterLname = $rowDetail['PasterLname'];
                $stackerFname = $rowDetail['stackerFname'];
                $stackerLname = $rowDetail['stackerLname'];
                $sheetNo = $rowDetail['SheetNo'];
                $mc = floatval($rowDetail['MoiseContent']);

                $output = '<div class="row mt-1 text-center mb-2">
                                <div class="col-4">
                                </div>
                                <div class="col-4">
                                    <span class="mb-1 text-secondary" style="font-weight:bold; font-size:20px;">'.$LotNumber.'</span>
                                    <div class="container" >
                                        <img src="'.$qrCode.'" class="p-2" style="border:3px grey solid;border-radius:5px;" alt="">
                                    </div>
                                </div>
                                <div class="col-4">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <span class="text-muted">Plate Type:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$plateType.'</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Quantity Produced:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.number_format($quantity).' PCS</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <span class="text-muted">Line:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$line.'</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Rack No.:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$rackno.'</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <span class="text-muted">Date:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.date('d-M-y', strtotime($Date)).'</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Curing Booth:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$curringbooth.'</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <span class="text-muted">Shift:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$shift.'</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Batch No.:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$batchNo.'</span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <span class="text-muted">Paster:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$pasterLname.', '.$pasterFname.'</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Moisture Content:</span>
                                    <span class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$mc.'%</span>
                                </div>
                            </div>

                            <div class="row mt-3 mb-3">
                                <div class="col-6">
                                    <span class="text-muted">Stacker:</span>
                                    <span  class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$stackerLname.', '.$stackerFname.'</span>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted">Sheet No.:</span>
                                    <span  class="position-relative text-secondary" style="font-weight:bold; font-size:20px;top:3px;">'.$sheetNo.'</span>
                                </div>
                            </div>';
            }

            echo json_encode($output);
        }
        
    }
?>