<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    date_default_timezone_set("Asia/Manila");
    $dateInit = date('Y-m-d');//date uploaded
    $dateNav = date('M d, Y');
    $time =  date("H:i:s");
    $time2 = date("h:i:s a");
    $day = date("l");
    $year = date("Y"); //year
    $timestamp = $dateInit.' '.$time;

    if(isset($_POST['action'])){

        if($_POST['action']=="Sheet_Table"){
            $SheetNo = '';

            if(isset($_POST['SheetInialize'])){
                $SheetNo = $_POST['SheetInialize'];
            }

            $column = array("", "Item", "Line", "Shift", "RackNo", "PlateType", "Quantity", "LotNumber", "");

            $query ="SELECT sd.SheetDetailID, sd.CurringBoothNo as 'Item',  l.Line as 'Line', sd.Shift, sd.RackNo, p.PlateType as 'PlateType', sd.Quantity, sd.LotNumber, sd.MoiseContent ";
            $query .="FROM sheetdetail_tbl sd ";
            $query .="JOIN sheet_tbl s ON sd.SheetID = s.SheetID ";
            $query .="JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .="JOIN platetype_tbl p ON sd.PlateTypeID = p.PlateTypeID ";
            $query .="JOIN curringbooth_tbl cb ON sd.CurringBoothID = cb.CurringBoothID ";
            $query .="JOIN employee_tbl paster ON sd.PasterID = paster.EmployeeID ";
            $query .="JOIN employee_tbl stacker ON sd.StackerID = stacker.EmployeeID ";
            $query .="WHERE  sd.SheetID = (SELECT SheetID FROM sheet_tbl WHERE SheetNo = '".$SheetNo."') AND sd.IsActive = 1 AND sd.IsDeleted = 0 ";

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY sd.DateCreated ASC ';
            }

            $query1 ='';

            if($_POST["length"] != -1){

                $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            }
            $table = odbc_exec($conn, $query);

            $count = odbc_num_rows($table);

            $result = odbc_exec($conn, $query . $query1);

            $data = array();
            
            $n = 1;

            while($row = odbc_fetch_array($result)){

                $SheetDetailID  = $row['SheetDetailID'];
                $item           = $row['Item'];
                $line           = $row['Line'];
                $shift          = $row['Shift'];
                $rackNo         = $row['RackNo'];
                $plate          = $row['PlateType'];
                $item_qty       = $row['Quantity'];
                $lotnumber      = $row['LotNumber'];
                $MC             = $row['MoiseContent'];

                $sub_array = array();
                if($MC==0){
                    $sub_array[] = "
                                <a type='button' class='text-danger' onclick='editItemModal(".$SheetDetailID.")'><i class='fa fa-pencil-alt' style='font-size:10px;'></i></a>
                    ";
                }
                else{
                    $sub_array[] = "
                                <a type='button' class='text-primary' onclick='editItemModal(".$SheetDetailID.")'><i class='fa fa-pencil-alt' style='font-size:10px;'></i></a>
                    ";
                }
                
                $sub_array[] = "<span style='white-space:nowrap;'>".$item."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$line."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$shift."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$rackNo."</span>";
                $sub_array[] = $plate;
                $sub_array[] = number_format($item_qty);
                $sub_array[] = $lotnumber;
                // if($MC==0){
                //     $sub_array[] = "<span class='text-danger'>".$MC."% </span>";
                // }
                // else{
                //     $sub_array[] = $MC.'%';
                // }
                
                $n++;

                $data[] = $sub_array;
            }

            $added_row = 16-$n;
            $counter = 1;
            for($i = 0;$i <= $added_row; $i++){
                $sub_array2[] = "<span style='color: transparent;'>".$counter."</span>";
                $sub_array2[] = "";
                $sub_array2[] = "";
                $sub_array2[] = "";
                $sub_array2[] = "";
                $sub_array2[] = "";
                $sub_array2[] = "";
                $sub_array2[] = "";
                $counter++;
                $data[] = $sub_array2;
            }

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data
            );

            echo json_encode($output);
        }

        else if($_POST['action']=="Scrap_Table"){
            $date = '';
            $setter = 0;

            $dateAdd = date('Y-m-d', strtotime("+1 day", strtotime($date)));

            if(isset($_POST['dateval'])){
                $date = $_POST['dateval'];
            }

            if(isset($_POST['setter'])){
                $setter = $_POST['setter'];
            }

            $column = array("", "AddDate", "Shift", "Line", "PlateType", "TotalOutput", "SRPlate", "SRPaste", "Trimmings");

            $query ="SELECT sc.ScrapDetailID, sc.AddDate, sc.Shift, l.Line, p.PlateType, sc.TotalOutput, sc.SRPlate, sc.SRPaste, sc.Trimmings ";
            $query .="FROM scrapdetail_tbl sc ";
            $query .="JOIN line_tbl l ON sc.LineID = l.LineID ";
            $query .="JOIN platetype_tbl p ON sc.PlateTypeID = p.PlateTypeID ";
            $query .="WHERE  sc.AddDate = '".$date."' ";

            if($setter == 1){
                $query .="AND sc.Shift in ('1st', '2nd-D')  ";
            }
            else if($setter == 2){
                $query .="AND sc.Shift in ('3rd', '2nd-N')  ";
            }

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY sc.AddDate ASC ';
            }

            $query1 ='';

            $table = odbc_exec($conn, $query);

            $count = odbc_num_rows($table);

            $result = odbc_exec($conn, $query . $query1);

            // confirmQuery($result);

            $data = array();
            
            $n = 1;

            while($row = odbc_fetch_array($result)){

                $ScrapDetailID  = $row['ScrapDetailID'];
                $addDate        = $row['AddDate'];
                $line           = $row['Line'];
                $shift          = $row['Shift'];
                $plate          = $row['PlateType'];
                $item_qty       = $row['TotalOutput'];
                $SRPlate        = $row['SRPlate'];
                $SRPaste        = $row['SRPaste'];
                $Trimmings      = $row['Trimmings'];

                $srplatequery = "Select Sum(SRPlate) as 'SRPLAte' from scraplogs_tbl where ScrapDetailID = ".$ScrapDetailID." ";
                $srplateresult = odbc_exec($conn, $srplatequery);
                $srplate = 0;
                while($rowplate = odbc_fetch_array($srplateresult)){
                    $srplate = $rowplate['SRPLAte'];
                }

                $pcs = "";
                if($item_qty > 1){
                    $pcs = "pcs";
                }
                else{
                    $pcs = "pc";
                }

                $sub_array = array();
               
                $sub_array[] = $n;
                $sub_array[] = "<span style='white-space:nowrap;'>".date('M d, Y',strtotime($addDate))."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$shift."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$line."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$plate."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".number_format($item_qty)." ".$pcs."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$srplate."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$SRPaste."</span>";
                $sub_array[] = "<span style='white-space:nowrap;'>".$Trimmings."</span>";

                $n ++;

                $data[] = $sub_array;
            }

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data,
                "recordsTotal"=> $count
            );

            echo json_encode($output);
            
        }

        else if($_POST['action']=="Report_Table"){
            $date = '';
            $userid = 0;
            if(isset($_POST['dateval'])){
                $date = $_POST['dateval'];
            }
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
            
            $dateAdd = date('Y-m-d h:m:s', strtotime("+1 day", strtotime($date)));
            $search = "%".$_POST["search"]["value"]."%";

            $column = array("", "SheetNo", "LotNumber", "CurringBooth", "CurringBoothNo", "Shift", "Line", "PlateType", "OxideType", "RackNo", "BatchNo", "Quantity", "MoiseContent", "Paster", "Stacker", "DateCreated", "" );

            $query = "SELECT s.SheetNo, sd.LotNumber, cb.CurringBooth, sd.CurringBoothNo, sd.Shift, l.Line, pl.PlateType, ox.OxideType, sd.RackNo, sd.BatchNo, sd.Quantity, sd.MoiseContent, concat(stacker.LastName, ', ',stacker.FirstName) as 'Paster', concat(paster.LastName, ', ',paster.FirstName) as 'Stacker', sd.DateCreated ";
            $query .="FROM sheetdetail_tbl sd ";
            $query .="JOIN sheet_tbl s ON sd.SheetID = s.SheetID ";
            $query .="JOIN curringbooth_tbl cb ON sd.CurringBoothID = cb.CurringBoothID ";
            $query .="JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .="JOIN platetype_tbl pl ON sd.PlateTypeID = pl.PlateTypeID ";
            $query .="JOIN oxidetype_tbl ox ON sd.OxideTypeID = ox.OxideTypeID ";
            $query .="JOIN employee_tbl paster ON sd.PasterID = paster.EmployeeID ";
            $query .="JOIN employee_tbl stacker ON sd.StackerID = stacker.EmployeeID ";
            $query .="WHERE sd.DateCreated BETWEEN '".$date." 06:00:00' AND  DATEADD(day, +1, '".$date." 06:00:00') AND sd.IsDeleted = 0 AND sd.IsActive = 1 ";
            if($userid==4){
                $query .="AND sd.UserWorkStationID in (1,2) ";
            }
            else{
                $query .="AND sd.UserWorkStationID = ".$userid." ";
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
                $query .='ORDER BY sd.SheetDetailID ASC ';
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
            }
            else{
                $table = odbc_exec($conn, $query);
                $count = odbc_num_rows($table);
                $result = odbc_exec($conn, $query.$query1);
            }
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

            echo json_encode($output);
            
        }

        else if($_POST['action']=="HalfDayShift_Table"){
            $userid = 0;
            $date = '';
            $pcs2 = "";
            if(isset($_POST['dateval'])){
                $date = $_POST['dateval'];
            }
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }

            $dateAdd = date('Y-m-d h:m:s', strtotime("+1 day", strtotime($date)));

            $column = array("Line", "Shift", "PlateType", "Total" );

            $query = "SELECT l.Line, sd.Shift, p.PlateType, sum(sd.Quantity) as 'Total' ";
            $query .= "FROM sheetdetail_tbl sd ";
            $query .= "JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .= "JOIN platetype_tbl p ON sd.PlateTypeID = p.PlateTypeID ";
            $query .= "WHERE sd.DateCreated BETWEEN '".$date." 06:00:00' AND DATEADD(day, +1, '".$date." 06:00:00') ";
            $query .= "AND sd.Shift in ('1st','2nd-D') ";
            if($userid==4){
                $query .="AND sd.UserWorkStationID in (1,2) ";
            }
            else{
                $query .="AND sd.UserWorkStationID = ".$userid." ";
            }
            $query .= "GROUP BY l.Line, sd.Shift, p.PlateType ";
            

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY Line ASC ';
            }

            $query1 ='';

            if($_POST["length"] != -1){

                $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            }

            $table = odbc_exec($conn, $query);

            $count = odbc_num_rows($table);

            $result = odbc_exec($conn, $query . $query1);

            // confirmQuery($result);

            $data = array();
            
            $n = 1;

            $grandTotal = 0;

            while($row = odbc_fetch_array($result)){

                $shift      = $row['Shift'];
                $line       = $row['Line'];
                $plate      = $row['PlateType'];
                $qty        = $row['Total'];

                $pcs = "";
                if($qty > 1){
                    $pcs = "pcs";
                }
                else{
                    $pcs = "pc";
                }

                $sub_array = array();
               
                // $sub_array[] = $n;
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$line."</span>";
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$shift."</span>";
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$plate."</span>";
                $sub_array[] = "<span class='text-danger' style='white-space:nowrap;font-weight:bold;'>".number_format($qty )." ".$pcs."</span>";


                $n ++;
                $grandTotal += $qty;

                $data[] = $sub_array;
            }
            if($grandTotal > 1){
                $pcs2 = "pcs";
            }
            else if($grandTotal < 1){
                $pcs2 = "";
            }
            else{
                $pcs2 = "pc";
            }
            $sub_array2[] = "";
            $sub_array2[] = "";
            $sub_array2[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>Total</span>";
            $sub_array2[] = "<span class='text-danger' style='white-space:nowrap;font-weight:bold;'>".number_format($grandTotal)." ".$pcs2."</span>";
            $data[] = $sub_array2;

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data
            );

            echo json_encode($output);

        }

        else if($_POST['action']=="HalfNightShift_Table"){
            $userid = 0;
            $date = '';
            $pcs2 = "";
            if(isset($_POST['dateval'])){
                $date = $_POST['dateval'];
            }
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
            $dateAdd = date('Y-m-d h:m:s', strtotime("+1 day", strtotime($date)));

            $column = array("Line", "Shift", "PlateType", "Total" );

            $query = "SELECT l.Line, sd.Shift, p.PlateType, sum(sd.Quantity) as 'Total' ";
            $query .= "FROM sheetdetail_tbl sd ";
            $query .= "JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .= "JOIN platetype_tbl p ON sd.PlateTypeID = p.PlateTypeID ";
            $query .= "WHERE sd.DateCreated BETWEEN '".$date." 06:00:00' AND DATEADD(day, +1, '".$date." 06:00:00') ";
            $query .= "AND sd.Shift in ('3rd','2nd-N') ";
            if($userid==4){
                $query .="AND sd.UserWorkStationID in (1,2) ";
            }
            else{
                $query .="AND sd.UserWorkStationID = ".$userid." ";
            }
            $query .= "GROUP BY l.Line, sd.Shift, p.PlateType ";

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY Line ASC ';
            }

            $query1 ='';

            if($_POST["length"] != -1){

                $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            }

            $table = odbc_exec($conn, $query);

            $count = odbc_num_rows($table);

            $result = odbc_exec($conn, $query . $query1);

            $data = array();
            
            $n = 1;

            $grandTotal = 0;

            while($row = odbc_fetch_array($result)){

                $shift      = $row['Shift'];
                $line       = $row['Line'];
                $plate      = $row['PlateType'];
                $qty        = $row['Total'];

                $pcs = "";
                if($qty > 1){
                    $pcs = "pcs";
                }
                else{
                    $pcs = "pc";
                }

                $sub_array = array();
               
                // $sub_array[] = $n;
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$line."</span>";
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$shift."</span>";
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$plate."</span>";
                $sub_array[] = "<span class='text-danger' style='white-space:nowrap;font-weight:bold;'>".number_format($qty )." ".$pcs."</span>";


                $n ++;
                $grandTotal += $qty;

                $data[] = $sub_array;
            }
            if($grandTotal > 1){
                $pcs2 = "pcs";
            }
            else if($grandTotal < 1){
                $pcs2 = "";
            }
            else{
                $pcs2 = "pc";
            }

            $sub_array2[] = "";
            $sub_array2[] = "";
            $sub_array2[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>Total</span>";
            $sub_array2[] = "<span class='text-danger' style='white-space:nowrap;font-weight:bold;'>".number_format($grandTotal)." ".$pcs2."</span>";
            $data[] = $sub_array2;

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data
            );

            echo json_encode($output);

        }

        else if($_POST['action']=="Whole_Table"){
            $userid = 0;
            $date = '';
            $pcs2 = "";
            if(isset($_POST['dateval'])){
                $date = $_POST['dateval'];
            }
            
            if(isset($_POST['userid'])){
                $userid = $_POST['userid'];
            }
            $dateAdd = date('Y-m-d h:m:s', strtotime("+1 day", strtotime($date)));

            $column = array("Line", "PlateType", "Total" );

            $query = "SELECT l.Line, p.PlateType, sum(sd.Quantity) as 'Total' ";
            $query .= "FROM sheetdetail_tbl sd ";
            $query .= "JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .= "JOIN platetype_tbl p ON sd.PlateTypeID = p.PlateTypeID ";
            $query .= "WHERE sd.DateCreated BETWEEN '".$date." 06:00:00' AND DATEADD(day, +1, '".$date." 06:00:00') ";
            if($userid==4){
                $query .="AND sd.UserWorkStationID in (1,2) ";
            }
            else{
                $query .="AND sd.UserWorkStationID = ".$userid." ";
            }
            $query .= "GROUP BY l.Line, p.PlateType ";
            $query .='ORDER BY l.Line ASC ';

            // if(isset($_POST["order"])){

            //     $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            // } 

            // else{

                
            // }

            $query1 ='';

            if($_POST["length"] != -1){

                $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            }

            $table = odbc_exec($conn, $query);

            $count = odbc_num_rows($table);

            $result = odbc_exec($conn, $query . $query1);

            confirmQuery($result);

            $data = array();
            
            $n = 1;

            $grandTotal = 0;

            while($row = odbc_fetch_array($result)){

                // $shift      = $row['Shift'];
                $line       = $row['Line'];
                $plate      = $row['PlateType'];
                $qty        = $row['Total'];

                $pcs = "";
                if($qty > 1){
                    $pcs = "pcs";
                }
                else{
                    $pcs = "pc";
                }

                $sub_array = array();
               
                // $sub_array[] = $n;
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$line."</span>";
                
                $sub_array[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>".$plate."</span>";
                $sub_array[] = "<span class='text-danger' style='white-space:nowrap;font-weight:bold;'>".number_format($qty )." ".$pcs."</span>";


                $n ++;
                $grandTotal += $qty;

                $data[] = $sub_array;
            }
            if($grandTotal > 1){
                $pcs2 = "pcs";
            }
            else if($grandTotal < 1){
                $pcs2 = "";
            }
            else{
                $pcs2 = "pc";
            }

            $sub_array2[] = "";
            $sub_array2[] = "<span class='text-dark' style='white-space:nowrap;font-weight:bold;'>Total</span>";
            $sub_array2[] = "<span class='text-danger' style='white-space:nowrap;font-weight:bold;'>".number_format($grandTotal)." ".$pcs2."</span>";
            $data[] = $sub_array2;

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data
            );

            echo json_encode($output);

        }

        else if($_POST['action']=="ScrapSummary_Table"){
            $date = '';
            $dateAdd = date('Y-m-d h:m:s', strtotime("+1 day", strtotime($date)));

            $column = array("", "SheetNo", "LotNumber", "CurringBooth", "CurringBoothNo", "Shift", "Line", "PlateType", "OxideType", "RackNo", "BatchNo", "Quantity", "MoiseContent", "Paster", "Stacker", "DateCreated" );

            $query = "SELECT s.SheetNo, sd.CurringBoothNo, sd.LotNumber, cb.CurringBooth, sd.Shift, l.Line, pl.PlateType, ox.OxideType, sd.RackNo, sd.BatchNo, sd.Quantity, sd.MoiseContent, concat(stacker.LastName, ', ',stacker.FirstName) as 'Paster', concat(paster.LastName, ', ',paster.FirstName) as 'Stacker', sd.DateCreated ";
            $query .="FROM sheetdetail_tbl sd ";
            $query .="JOIN sheet_tbl s ON sd.SheetID = s.SheetID ";
            $query .="JOIN curringbooth_tbl cb ON sd.CurringBoothID = cb.CurringBoothID ";
            $query .="JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .="JOIN platetype_tbl pl ON sd.PlateTypeID = pl.PlateTypeID ";
            $query .="JOIN oxidetype_tbl ox ON sd.OxideTypeID = ox.OxideTypeID ";
            $query .="JOIN employee_tbl paster ON sd.PasterID = paster.EmployeeID ";
            $query .="JOIN employee_tbl stacker ON sd.StackerID = stacker.EmployeeID ";
            $query .="WHERE sd.DateCreated between '".$date." 00:00:00' and '".$dateAdd." 05:59:59'  AND sd.IsDeleted = 0 AND sd.IsActive = 1 ";
            // $query .="AND  ";

            // if(isset($_POST["search"]["value"])){											

            //     $query .='AND (sd.Shift LIKE "%'.$_POST["search"]["value"].'%" ';
            //     $query .='OR l.Line LIKE "%'.$_POST["search"]["value"].'%" ';
            //     $query .='OR cb.CurringBooth LIKE "%'.$_POST["search"]["value"].'%" ';
            //     $query .='OR pl.PlateType LIKE "%'.$_POST["search"]["value"].'%" ';
            //     $query .='OR s.SheetNo LIKE "%'.$_POST["search"]["value"].'%") ';
            // }

            // $query .= "GROUP BY sd.CurringBoothNo, s.SheetNo ";

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY CurringBoothNo ASC ';
            }

            $query1 ='';

            if($_POST["length"] != -1){

                $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
            }

            $table = odbc_exec($conn, $query);

            $count = odbc_num_rows($table);

            $result = odbc_exec($conn, $query . $query1);

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
                $paster     = $row['Paster'];
                $stacker    = $row['Stacker'];
                $dateAdd    = $row['DateCreated'];

                $pcs = "";
                if($qty > 1){
                    $pcs = "pcs";
                }
                else{
                    $pcs = "pc";
                }

                $sub_array = array();
               
                $sub_array[] = $n;
                $sub_array[] = "<span class='text-success' style='white-space:nowrap;font-weight:bold;'>".$sheetNo."</span>";
                $sub_array[] = "<span class='text-success' style='white-space:nowrap;font-weight:bold;'>".$lotNumber."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$booth."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$boothNo."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$shift."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$line."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$plate."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$oxide."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$rackno."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$batchno."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".number_format($qty)." ".$pcs."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$MC." %</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$paster."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".$stacker."</span>";
                $sub_array[] = "<span style='white-space:nowrap;font-weight:bold;'>".date('M d, Y',strtotime($dateAdd))."</span>";


                $n ++;

                $data[] = $sub_array;
            }

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data
            );

            echo json_encode($output);
            
        }
    }
?>