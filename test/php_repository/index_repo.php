<?php

    include "../includes/db.php";
    include "../includes/functions.php";

    date_default_timezone_set("Asia/Manila");
    $date = date('Y-m-d');//date uploaded
    $dateNav = date('M d, Y');
    $time =  date("H:i:s");
    $time2 = date("h:i a");
    $day = date("l");
    $year = date("Y"); //year
    $timestamp = $date.' '.$time;

    if(isset($_POST["action"])){
        
        if($_POST["action"] == "usergetter"){
            $output = 1;
            if(!isset($_COOKIE['GPuserID'])){
                $output = 0;
            }

            echo json_encode($output);
        }

        else if($_POST["action"] == "usersetter"){
            $output = "";
            $userID = 0;

            if(isset($_POST['userID'])){
                $userID = $_POST['userID'];
            }

            $query = "select UserWorkStation from userworkstation_tbl where UserWorkstationID = '".$userID."' and IsActive = 1 and IsDeleted = 0 ";
            $fetch = odbc_exec($conn, $query);

            while($row = odbc_fetch_array($fetch)){
                $output = $row['UserWorkStation'];
                setcookie("GPuserID",$userID,time()+3600 * 24 * 365, '/');
                setcookie("GPuser",$row['UserWorkStation'],time()+3600 * 24 * 365, '/');
            }
            
            echo json_encode($output);
        }

        else if($_POST["action"] == "NavDate"){
            $arr = array(
                'navdate'=> $dateNav,
                'default'=>$date
            );
            
            echo json_encode($arr);
        }

        else if($_POST["action"]=="curingBoothSelection"){
            $process = "";
            if(isset($_POST["process"])){
                $process = $_POST["process"];
            }

            $query = "SELECT * ";
            $query .="FROM curringbooth_tbl ";
            $query .="WHERE CurringProcessID = (select CurringProcessID from curringprocess_tbl where Process = '".$process."' and IsActive = 1 and IsDeleted = 0) ";
            $query .="AND IsActive = 1 and IsDeleted = 0 ";
            $fetch = odbc_exec($conn, $query);
            $count = odbc_num_rows($fetch) & 0xffffffff;

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Choose..</option>';

                while($row = odbc_fetch_array($fetch)){

                    $curing_Id     = $row['CurringBoothID'];
                    $curing_Name   = $row['CurringBooth'];

                    $output .='<option value="'.$curing_Id.'">'.$curing_Name.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST["action"]=="line"){
            $processVal = isset($_POST['ProcessVal']) ? $_POST['ProcessVal'] : 0;
            $PolaritySetter = $_COOKIE['GPuserID'];
            $setter = isset($_POST['setterID']) ? $_POST['setterID'] : 0;
            $newPolarity = 0;
            if($setter != 0){
                if($PolaritySetter == 1){
                    $newPolarity = 2;
                }
                else if($PolaritySetter == 2){
                    $newPolarity = 1;
                }
            }
            else{
                $newPolarity = $PolaritySetter;
            }

            if($newPolarity==1 || $processVal=="Tunnel"){
                $query = "SELECT * ";
                $query .="FROM line_tbl ";
                $query .="WHERE IsActive = 1 and IsDeleted = 0 ";
                $query .="and Line like 'Cominco%'";

                $fetch = odbc_exec($conn, $query);

                if($fetch){

                    $output ='';

                    $output .='<option selected disabled value="">Choose..</option>';

                    while($row = odbc_fetch_array($fetch)){

                        $line_Id     = $row['LineID'];
                        $line_Name   = $row['Line'];

                        $output .='<option value="'.$line_Id.'">'.$line_Name.'</option>';
                    }

                    
                }
            }
            else if($newPolarity==2){
                $query = "SELECT * ";
                $query .="FROM line_tbl ";
                $query .="WHERE IsActive = 1 and IsDeleted = 0 ";
                $query .="and Line like 'Delphi%'";

                $fetch = odbc_exec($conn, $query);

                if($fetch){

                    $output ='';

                    $output .='<option selected disabled value="">Choose..</option>';

                    while($row = odbc_fetch_array($fetch)){

                        $line_Id     = $row['LineID'];
                        $line_Name   = $row['Line'];

                        $output .='<option value="'.$line_Id.'">'.$line_Name.'</option>';
                    }

                    
                }
            }
            else{
                $query = "SELECT * ";
                $query .="FROM line_tbl ";
                $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

                $fetch = odbc_exec($conn, $query);

                if($fetch){

                    $output ='';

                    $output .='<option selected disabled value="">Choose..</option>';

                    while($row = odbc_fetch_array($fetch)){

                        $line_Id     = $row['LineID'];
                        $line_Name   = $row['Line'];

                        $output .='<option value="'.$line_Id.'">'.$line_Name.'</option>';
                    }

                    

                    
                }
            }
            $arr = array(
                'output' => $output,
                'setter' => $PolaritySetter
            );

            echo json_encode($arr);
            
        }

        else if($_POST["action"]=="plate"){
            $lineID = isset($_POST['lineID']) ? $_POST['lineID'] : 0;
            $polarity = 0;

            $queryline = "SELECT * FROM line_tbl ";
            $queryline .= "WHERE LineID = '".$lineID."' ";
            $lineResult = odbc_exec($conn, $queryline);
            while($row = odbc_fetch_array($lineResult)){
                $polarity = $row['PolarityID'];
            }

            $query = "SELECT * ";
            $query .="FROM platetype_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 and PolarityID = '".$polarity."' ";

            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Choose..</option>';

                while($row = odbc_fetch_array($fetch)){

                    $plate_Id     = $row['PlateTypeID'];
                    $plate_Name   = $row['PlateType'];

                    $output .='<option value="'.$plate_Id .'">'.$plate_Name.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST["action"]=="oxide"){
            $query = "SELECT * ";
            $query .="FROM oxidetype_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Choose..</option>';

                while($row = odbc_fetch_array($fetch)){

                    $oxide_Id     = $row['OxideTypeID'];
                    $oxide_Name   = $row['OxideType'];

                    $output .='<option value="'.$oxide_Id.'">'.$oxide_Name.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST["action"]=="batch"){
            $output ='';

            $output .='<option selected disabled value="">Choose..</option>';

            for($i = 1; $i <= 30; $i++){

                $output .='<option value="'.$i.'">'.$i.'</option>';
            }

            echo json_encode($output);
        }

        else if($_POST["action"]=="paster"){
            $query = "SELECT * ";
            $query .="FROM employee_tbl emp ";
            $query .="JOIN paster_tbl paster ON emp.EmployeeID = paster.EmployeeID ";
            $query .="WHERE emp.IsActive = 1 and emp.IsDeleted = 0 and paster.IsActive = 1 and paster.IsDeleted = 0 ";

            $fetch = odbc_exec($conn, $query);
            confirmQuery($fetch);

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Choose..</option>';

                while($row = odbc_fetch_array($fetch)){

                    $emp_Id     = $row['EmployeeID'];
                    $Last_Name   = htmlspecialchars($row['LastName']);
                    $First_Name   = htmlspecialchars($row['FirstName']);

                    $output .='<option value="'.$emp_Id.'">'.$Last_Name.', '.$First_Name.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST["action"]=="stacker"){
            $query = "SELECT * ";
            $query .="FROM employee_tbl emp ";
            $query .="JOIN stacker_tbl stacker ON emp.EmployeeID = stacker.EmployeeID ";
            $query .="WHERE emp.IsActive = 1 and emp.IsDeleted = 0 and stacker.IsActive = 1 and stacker.IsDeleted = 0 ";

            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Choose..</option>';

                while($row = odbc_fetch_array($fetch)){

                    $emp_Id     = $row['EmployeeID'];
                    $Last_Name   = htmlspecialchars($row['LastName']);
                    $First_Name   = htmlspecialchars($row['FirstName']);

                    $output .='<option value="'.$emp_Id.'">'.$Last_Name.', '.$First_Name.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST["action"]=="shift"){
            $output ='';

            $output .='<option selected disabled value="">Choose...</option>
            <option value="1st">1st</option>
            <option value="2nd-D">2nd-D</option>
            <option value="2nd-N">2nd-N</option>
            <option value="3rd">3rd</option>';

            echo json_encode($output);
        }

        else if($_POST["action"]=="processSummarry"){
            $boothID = 0;
            if(isset($_POST["boothId"])){
                $boothID = $_POST["boothId"];
            }
            $query = "SELECT CurringBooth ";
            $query .="FROM curringbooth_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 ";
            $query .="AND CurringBoothID = '$boothID' ";

            $fetch = odbc_exec($conn, $query);
            $total = 0;

            if($fetch){
                while($row = odbc_fetch_array($fetch)){
                    $total = $row['CurringBooth'];
                }
                echo json_encode($total);
            }
        }

        else if($_POST["action"]=="sheetNo"){
            $ClientStationName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $ClientStationIP = $_SERVER['REMOTE_ADDR'];
            $userworkID = $_COOKIE['GPuserID'];
            $userWorkstation = $_COOKIE['GPuser'];
            $count = strlen($userWorkstation)*-1;
            $IncrementValue = 0;
            $val = 0;
            if(isset($_POST["IncrementValue"])){
                $IncrementValue = $_POST["IncrementValue"];
            }

            $select = "SELECT * ";
            $select .="FROM sheet_tbl ";
            $select .="WHERE IsActive = 1 AND IsDeleted = 0 and UserWorkStationID = '".$userworkID."' ";
            // $select .="AND IsCompleted = 0 ";


            $result = odbc_exec($conn, $select);

            // confirmQuery($result);

            $count_result = odbc_num_rows($result);

            if($count_result !=0){
                $select2 = "SELECT TOP 1 SheetIncrement ";
                $select2 .="FROM sheet_tbl ";
                $select2 .="WHERE IsActive = 1 AND IsCompleted = 0 and UserWorkStationID = '".$userworkID."' order by SheetID DESC ";
                
                // $select2 .="AND IsCompleted = 0 ";
                $result2 = odbc_exec($conn, $select2);
                $val1 = 0;

                while($row_max = odbc_fetch_array($result2)){
                    $val1 = $row_max['SheetIncrement'];
                }
                $trimYear = substr($year,2);
                $userTrim = substr($userWorkstation, $count,1);
                $val =  'P12-'.substr($year,2).$userTrim.'-'.sprintf('%04d', $val1);
                echo json_encode($val);
            }
            else{
                $trimYear = substr($year,2);
                $userTrim = substr($userWorkstation, $count,1);
                $val =  'P12-'.substr($year,2).$userTrim.'-'.sprintf('%04d', $IncrementValue);
                echo json_encode($val);
            }

        }

        else if($_POST["action"]=="Incomplete"){

            $SheetNo = "";
            if(isset($_POST['SheetNoVal'])){
                $SheetNo = $_POST['SheetNoVal'];
            }

            $output = "";

            $select = "SELECT * ";
            $select .="FROM sheet_tbl ";
            $select .="WHERE IsActive = 1 AND IsDeleted = 0 ";
            $select .="AND IsCompleted = 0 ";
            $select .="AND SheetNo != '".$SheetNo."' ";


            $result = odbc_exec($conn, $select);

            // confirmQuery($result);

            $count_result = odbc_num_rows($result);

            if($count_result !=0){
                $output .= '<div class="container card p-1 mb-2">
                <span class="float-left text-sucess" style="font-size:13px;font-weight:bold;">Incomplete Tray</span>
                <hr class="bg-light my-0">
                  <div class="row">';
                while($row = odbc_fetch_array($result)){
                    $output .= '<div class="col-sm-3">
                                    <button type="button" class="btn btn-light btn-sm text-success mt-1" style="border-color: #8c8c8c; font-weight:bold;font-size:11px;" onclick="GetOnTray('.$row['SheetID'].')">
                                    '.$row['SheetNo'].' <span class="badge badge-warning" style="font-size:9px;">INC</span>
                                    <span class="sr-only">incomplete</span>
                                    </button>
                                </div>';
                }

                $output .='</div>
                </div>';

                echo json_encode($output);
            }
        }

        else if($_POST['action']=="AddSheet"){
            $ClientStationName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $ClientStationIP = $_SERVER['REMOTE_ADDR'];
            $processVal = "";
            $setter = 0;
            $userWorkstation = $_COOKIE['GPuser'];
            $count = strlen($userWorkstation)*-1;
            if(isset($_POST['processVal'])){
                $processVal = $_POST['processVal'];
            }

            if(isset($_POST['setterval'])){
                $setter = $_POST['setterval'];
            }
            $select2 = "SELECT * ";
            $select2 .="FROM sheet_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
            $result = odbc_exec($conn, $select2);

            // confirmQuery($result);

            $count_result = odbc_num_rows($result);
            $result = 0;
            $val = '';
            $val2 = '';
            if($count_result !=0){
                $select3 = "SELECT * ";
                $select3 .="FROM sheet_tbl ";
                $select3 .="WHERE SheetID = (select max(SheetID) from sheet_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."') ";
                $result2 = odbc_exec($conn, $select3);
                $MaxValue = 0;

                // confirmQuery($result2);
                while($row_max = odbc_fetch_array($result2)){
                    $MaxValue = $row_max['SheetIncrement']+1;
                }
                

                $trimYear = substr($year,2);
                $userTrim = substr($userWorkstation, $count,1);
                $val =  'P12-'.$trimYear.$userTrim.'-'.sprintf('%04d', $MaxValue);

                $insert = "INSERT INTO sheet_tbl(SheetNo, SheetIncrement, CurringProcessID, WorkStationID, UserWorkStationID) ";
                $insert .="SELECT '".$val."', '".$MaxValue."', CurringProcessID, (SELECT Top 1 WorkStationID FROM workstation_tbl WHERE StationName = '".$ClientStationName."' AND StationIP = '".$ClientStationIP."' AND IsActive = 1 AND IsDeleted = 0 order by WorkStationID ASC), '".$_COOKIE['GPuserID']."'  FROM curringprocess_tbl ";
                $insert .="WHERE Process = '".$processVal."' ";
                

                $insertResult = odbc_exec($conn, $insert);
                $val2 =  'P12-'.$trimYear.'-'.sprintf('%04d', $MaxValue+1);
                if($insertResult){
                    $result = 1;
                }
                else{
                    $val = '';
                    $result = 2;
                }
            }
            else{
                $MaxValue = 1;
                $trimYear = substr($year,2);
                $userTrim = substr($userWorkstation, $count,1);
            
                $val =  'P12-'.$trimYear.$userTrim.'-'.sprintf('%04d',  $MaxValue);

                $insert = "INSERT INTO sheet_tbl(SheetNo, SheetIncrement, CurringProcessID, WorkStationID, UserWorkStationID) ";
                $insert .="SELECT '".$val."', '".$MaxValue."', CurringProcessID, (SELECT TOP 1 WorkStationID FROM workstation_tbl WHERE StationName = '".$ClientStationName."' AND StationIP = '".$ClientStationIP."' AND IsActive = 1 AND IsDeleted = 0 order by WorkStationID ASC), '".$_COOKIE['GPuserID']."'  FROM curringprocess_tbl ";
                $insert .="WHERE Process = '".$processVal."' ";

                $insertResult = odbc_exec($conn, $insert);
                $val2 =  'P12-'.$trimYear.'-'.sprintf('%04d', $MaxValue+1);

                $result = 3;
            }
        
            $arr = array(
                'SheetNo' => $val,
                'result' => $result
            );
            echo json_encode($arr);
            
        }

        else if($_POST['action']=="curingBoothNo"){
            $CuringBoothVal = 0;
            $ActiveSheetVal = '';
            if(isset($_POST['CuringBoothVal'])){
                if($_POST['CuringBoothVal'] != ""){
                    $CuringBoothVal = $_POST['CuringBoothVal'];
                }
                
            }
            if(isset($_POST['ActiveSheetNoVal'])){
                $ActiveSheetVal = $_POST['ActiveSheetNoVal'];
            }

            if($CuringBoothVal > 0){
                $CurringBoothTxt = '';
                $selectCuringBooth = "SELECT * ";
                $selectCuringBooth .= "FROM curringbooth_tbl ";
                $selectCuringBooth .= "WHERE CurringBoothID = '".$CuringBoothVal."' ";
                $selectCuringBooth .="AND IsActive = 1 and IsDeleted = 0 ";
                $CuringSelect = odbc_exec($conn, $selectCuringBooth);
                // confirmQuery($CuringSelect);
                while($CuringBooth = odbc_fetch_array($CuringSelect)){
                    $CurringBoothTxt = $CuringBooth['CurringBooth'];
                }
            
                $count = 0;
                $select = "SELECT COUNT(*) as counter ";
                $select .= "FROM sheetdetail_tbl ";
                $select .= "WHERE SheetID = (SELECT SheetID FROM sheet_tbl WHERE SheetNo = '".$ActiveSheetVal."') ";
                $select .="AND CurringBoothID = '".$CuringBoothVal."' ";
                $select .="AND IsActive = 1 and IsDeleted = 0";

                $result = odbc_exec($conn, $select);

                // confirmQuery($result);

                while($row = odbc_fetch_array($result)){
                    $count = $row['counter']+1;
                }
                
                echo json_encode($CurringBoothTxt.'-'.$count);
            }
            else{
                echo json_encode('---');
            }

            
        }

        else if($_POST['action']=="lotNo"){
            $InializeValue = 1;
            $LineID = 0;
            $userWorkstation = $_COOKIE['GPuser'];
            $count = strlen($userWorkstation)*-1;
            $userTrim = substr($userWorkstation, $count,1);
            if(isset($_POST['initializeVal'])){
                $InializeValue = $_POST['initializeVal'];
            }
            if(isset($_POST['LineID'])){
                $LineID = $_POST['LineID'];
            }

            $Line = '';

            $select = "SELECT * FROM line_tbl ";
            $select .= "WHERE LineID = '".$LineID."' ";
            $select .= "AND IsActive = 1 AND IsDeleted = 0";
            $result = odbc_exec($conn, $select);
            // confirmQuery($result);
            while($LineRow = odbc_fetch_array($result)){
                $Line = $LineRow['Line'];
            }
            
            $firstLetter = substr($Line, 0, 1);
            $leadZero = substr($Line, strlen($Line)-1);
            // $lastLetter = str_pad($leadZero, 2, '0', STR_PAD_LEFT);
            $lastLetter = $leadZero;
            $line_2 = explode(" ", $Line); 
            $endedLetter = "";
       

            $selectAll = "SELECT * FROM sheetdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
            $resultAll = odbc_exec($conn, $selectAll);
            // confirmQuery($resultAll);

            $counter = odbc_num_rows($resultAll);

            $Increment = 0;
            $LotNumber = "";
            $trimYear = substr($year,2);
            $MonthNum = date('m', strtotime($date));
            $DayNum = date('j', strtotime($date));

            if($counter !=0){
                $selectAll2 = "SELECT Top 1 LotNumberIncrement FROM sheetdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
                $selectAll2 .= "order by DateCreated DESC ";
                $resultAll2 = odbc_exec($conn, $selectAll2);
                // confirmQuery($resultAll2);
                while($resultIncrementRow = odbc_fetch_array($resultAll2)){
                    $Increment = $resultIncrementRow['LotNumberIncrement']+1;
                }
                // $LotNumber = "P12".$firstLetter.$lastLetter.$Increment;
                $LotNumber = $firstLetter.$lastLetter.$trimYear.$MonthNum.$userTrim.$DayNum.sprintf('%05d', $Increment+1);
            }
            else{
                $InializeValue++;
                $Increment = $InializeValue;
                // $LotNumber = "P12".$firstLetter.$lastLetter.$InializeValue;
                $LotNumber = $firstLetter.$lastLetter.$trimYear.$MonthNum.$userTrim.$DayNum.sprintf('%05d', $Increment);
            }

            echo json_encode($LotNumber);
        }

        else if($_POST['action']=="AddSheetDetail"){
            $SheetNo = "";
            $ProcessTxt = "";
            $CurringBoothID = 0;
            $CurringBoothNo = "";
            $Shift = "";
            $LineID = 0;
            $PlateTypeID = 0;
            $OxideTypeID = 0;
            $RackNo = "";
            $BatchNo = "";
            $SteamHoodNo = "";
            $LotNumber = "";
            $Quantity = 0;
            $MoisetureContent = 0;
            $PasterID = 0;
            $StackerID = 0;

            $result = 0;

            if(isset($_POST['SheetNoVal'])){
                $SheetNo = $_POST['SheetNoVal'];
            }
            if(isset($_POST['ProcesstxtVal'])){
                $ProcessTxt = $_POST['ProcesstxtVal'];
            }
            if(isset($_POST['CurringBoothVal'])){
                $CurringBoothID = $_POST['CurringBoothVal'];
            }
            if(isset($_POST['CuringBoothNoHideVal'])){
                $CurringBoothNo = $_POST['CuringBoothNoHideVal'];
            }
            if(isset($_POST['shiftVal'])){
                $Shift = $_POST['shiftVal'];
            }
            if(isset($_POST['LineIDVal'])){
                $LineID = $_POST['LineIDVal'];
            }
            if(isset($_POST['PlateTypeIDVal'])){
                $PlateTypeID = $_POST['PlateTypeIDVal'];
            }
            if(isset($_POST['OxideTypeIDVal'])){
                $OxideTypeID = $_POST['OxideTypeIDVal'];
            }
            if(isset($_POST['RackNoVal'])){
                $RackNo = $_POST['RackNoVal'];
            }
            if(isset($_POST['BatchNoVal'])){
                $BatchNo = $_POST['BatchNoVal'];
            }
            if(isset($_POST['SteamHoodNoVal'])){
                $SteamHoodNo = $_POST['SteamHoodNoVal'];
            }
            if(isset($_POST['LotNumberVal'])){
                $LotNumber = $_POST['LotNumberVal'];
            }
            if(isset($_POST['QuantityVal'])){
                $Quantity = $_POST['QuantityVal'];
            }
            if(isset($_POST['MoisetureContentVal'])){
                $MoisetureContent = $_POST['MoisetureContentVal'];
            }
            if(isset($_POST['PasterEmpIDVal'])){
                $PasterID = $_POST['PasterEmpIDVal'];
            }
            if(isset($_POST['StackerEmpIDVal'])){
                $StackerID  = $_POST['StackerEmpIDVal'];
            }

            $SetsheetNo = 1;
            $lotNumberTObeIncrement = 0;
            $COAHelper = $SheetNo.$CurringBoothNo;
            $result = 0;
            if($Quantity <= 0 ){
                $result = 1;
            }
            else{
                $select = "SELECT * FROM sheet_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
                // $select .= "WHERE SheetNo = '".$SheetNo."' ";
                $select .= "AND IsActive = 1 and IsDeleted = 0 ";

                $result_query = odbc_exec($conn, $select);
                $count = odbc_num_rows($result_query);
                if($count !=0){
                    // echo json_encode("meron");

                    $queryLotNo = "SELECT * FROM sheetdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
                    $queryLotResult = odbc_exec($conn, $queryLotNo);
                    $countLotResult = odbc_num_rows($queryLotResult);
                    $lotNumberTObeIncrement = 0;
                    if($countLotResult !=0){
                        $queryMaxLotNumberIncrement = "SELECT * FROM sheetdetail_tbl ";
                        $queryMaxLotNumberIncrement .= "WHERE SheetDetailID = (SELECT MAX(SheetDetailID) FROM sheetdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."') ";
                        $resultMaxLotNumberIncrement = odbc_exec($conn, $queryMaxLotNumberIncrement);
                        if($resultMaxLotNumberIncrement){
                            while($rowMaxLotNumberIncrement = odbc_fetch_array($resultMaxLotNumberIncrement)){
                                $lotNumberTObeIncrement = $rowMaxLotNumberIncrement['LotNumberIncrement'] + 1;
                            }
                        }
                        else{
                            $result = 1;
                        }
                    }

                    $query = "INSERT INTO ";
                    $query .="sheetdetail_tbl(SheetID, LineID, Shift, PlateTypeID, OxideTypeID, CurringBoothID, CurringBoothNo, RackNo, BatchNo, SteamHoodNo, LotNumber, PasterID, StackerID, COAHelper, Quantity, MoiseContent, LotNumberIncrement, UserWorkStationID) ";
                    $query .="SELECT  ";
                    $query .="SheetID, '".$LineID."', '".$Shift."', '".$PlateTypeID."', '".$OxideTypeID."', '".$CurringBoothID."', '".$CurringBoothNo."', '".$RackNo."', '".$BatchNo."','".$SteamHoodNo."', '".$LotNumber."', '".$PasterID."', '".$StackerID."', '".$COAHelper."', '".$Quantity."', '".$MoisetureContent."', '".$lotNumberTObeIncrement."', '".$_COOKIE['GPuserID']."'  ";
                    $query .="FROM sheet_tbl  ";
                    $query .="WHERE  SheetNo = '".$SheetNo."' ";

                    $result = odbc_exec($conn, $query);
                    // confirmQuery($result);

                    if($result){
                        $result = 2;
                    }
                    else{
                        $result = 3;
                    }
                    
                }
                else{
                    // echo json_encode("wala");

                    $queryLotNo = "SELECT * FROM sheetdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
                    $queryLotResult = odbc_exec($conn, $queryLotNo);
                    $countLotResult = odbc_num_rows($queryLotResult);
                    $lotNumberTObeIncrement = 0;
                    if($countLotResult !=0){
                        $queryMaxLotNumberIncrement = "SELECT * FROM sheetdetail_tbl ";
                        $queryMaxLotNumberIncrement .= "WHERE SheetDetailID = (SELECT MAX(SheetDetailID) FROM sheetdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' ) ";
                        $resultMaxLotNumberIncrement = odbc_exec($conn, $queryMaxLotNumberIncrement);
                        // confirmQuery($resultMaxLotNumberIncrement);
                        if($resultMaxLotNumberIncrement){
                            while($rowMaxLotNumberIncrement = odbc_fetch_array($resultMaxLotNumberIncrement)){
                                $lotNumberTObeIncrement = $rowMaxLotNumberIncrement['LotNumberIncrement'] + 1;
                            }
                            
                        }
                        else{
                            $result = 1;
                        }
                    }
                    $userWorkstation = $_COOKIE['GPuser'];
                    $count = strlen($userWorkstation)*-1;
                    $userTrim = substr($userWorkstation, $count,1);

                    $trimYear = substr($year,2);
                    $val =  'P12-'.substr($year,2).$userTrim.'-'.sprintf('%04d', $SetsheetNo);

                    $insert = "INSERT INTO sheet_tbl(SheetNo, SheetIncrement, CurringProcessID, UserWorkStationID) ";
                    $insert .="SELECT '".$val."', '".$SetsheetNo."', CurringProcessID, '".$_COOKIE['GPuserID']."'  FROM curringprocess_tbl ";
                    $insert .="WHERE Process = '".$ProcessTxt."' ";

                    $insertResult = odbc_exec($conn, $insert);

                    if($insertResult){
                        $last_Id = 0;
                        $getLastID = "select top 1 SheetID from sheet_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' order by DateCreated DESC ";
                        $lastquery = odbc_exec($conn, $getLastID);
                        while($row = odbc_fetch_array($lastquery)){
                            $last_Id = $row['SheetID'];
                        }
                        
                        $query = "INSERT INTO ";
                        $query .="sheetdetail_tbl(SheetID, LineID, Shift, PlateTypeID, OxideTypeID, CurringBoothID, CurringBoothNo, RackNo, BatchNo, SteamHoodNo, LotNumber, PasterID, StackerID, COAHelper, Quantity, MoiseContent, LotNumberIncrement, UserWorkStation) ";
                        $query .="VALUES (  ";
                        $query .="'".$last_Id."', '".$LineID."', '".$Shift."', '".$PlateTypeID."', '".$OxideTypeID."', '".$CurringBoothID."', '".$CurringBoothNo."', '".$RackNo."', '".$BatchNo."','".$SteamHoodNo."', '".$LotNumber."', '".$PasterID."', '".$StackerID."', '".$COAHelper."', '".$Quantity."', '".$MoisetureContent."', '".$lotNumberTObeIncrement."', '".$_COOKIE['GPuserID']."')";

                        $result = odbc_exec($conn, $query);
                        // confirmQuery($result);

                        if($result){
                            $result = 2;
                        }
                        else{
                            $result = 3;
                        }
                    }
                }
            }

            

            $arr = array('result'=>$result,
                            'activeProcess'=>$ProcessTxt,
                            'SheetNo'=>$SheetNo,
                            'lotnumber'=>$LotNumber
                        );

            echo json_encode($arr);
        }

        else if($_POST['action']=="updateProcess"){
            $processtxt = "";
            $sheetval = "";
            $result = 0;

            if(isset($_POST['process'])){
                $processtxt = $_POST['process'];
            }

            if(isset($_POST['sheetTxt'])){
                $sheetval = $_POST['sheetTxt'];
            }

            $updateQuery = "UPDATE sheet_tbl ";
            $updateQuery .= "SET CurringProcessID = (SELECT CurringProcessID FROM curringprocess_tbl WHERE Process = '".$processtxt."') ";
            $updateQuery .="WHERE SheetNo = '".$sheetval."'";

            $updateQueryResult = odbc_exec($conn, $updateQuery);

            if($updateQueryResult){
                $result = 1;
            }
            else{
                $result = 2;
            }
            $arr = array(
                'result'=>$result,
                'process'=>$processtxt
            );
            echo json_encode($arr);
        }

        else if($_POST['action']=="getOnTray"){
            $SheetValID = 0;
            $SheetValText = "";

            $SheetNo = "";
            $CurringProcessID = "";
            $CurringProcess = "";

            if(isset($_POST['SheetNo'])){
                $SheetValID = $_POST['SheetNo'];
            }

            if(isset($_POST['SheetNoVal'])){
                $SheetValText = $_POST['SheetNoVal'];
            }

            $query = "SELECT s.SheetNo, cp.CurringProcessID, cp.Process FROM sheet_tbl s ";
            $query .= "JOIN curringprocess_tbl cp ON s.CurringProcessID = cp.CurringProcessID ";
            $query .= "WHERE s.SheetID = ".$SheetValID." ";
            $query .= "AND s.IsActive=1 AND s.IsDeleted = 0 ";
            $query .= "AND cp.IsActive=1 AND cp.IsDeleted = 0 ";

            $result = odbc_exec($conn, $query);
            confirmQuery($result);
            if($result){
                while($row = odbc_fetch_array($result)){
                    $SheetNo = $row['SheetNo'];
                    $CurringProcessID = $row['CurringProcessID'];
                    $CurringProcess = $row['Process'];
                }
                
            }

            $arr = array(
                "SheetNo"=>$SheetNo,
                "ProcessID"=>$CurringProcessID,
                "Process"=>$CurringProcess
            );

            echo json_encode($arr);
        }

        else if($_POST['action']=="complete"){
            $sheetVal = "";
            $result = 0;

            if(isset($_POST['SheetNoVal'])){
                $sheetVal = $_POST['SheetNoVal'];
            }

            $completeQuery = "Update sheet_tbl ";
            $completeQuery .="SET IsCompleted = 1 ";
            $completeQuery .="WHERE SheetNo = '".$sheetVal."' ";

            $completeResult = odbc_exec($conn, $completeQuery);

            if($completeQuery){
                $result = 1;
            }
            else{
                $result = 2;
            }

            $arr = array(
                "result"=>$result,
                "sheetNo"=>$sheetVal
            );
            echo json_encode($arr);
        }

        else if($_POST['action']=="checkItems"){
            $sheetNo = "";
            if(isset($_POST['sheetcheck'])){
                $sheetNo = $_POST['sheetcheck'];
            }

            $counter = 0;
            $result = 0;

            $query = "SELECT * FROM sheetdetail_tbl ";
            $query .="WHERE SheetID = (SELECT SheetID FROM sheet_tbl WHERE SheetNO = '".$sheetNo."') ";

            $queryResult = odbc_exec($conn, $query);
            $count = odbc_num_rows($queryResult);
            if($count!=0){
                if($queryResult){
                    while($row = odbc_fetch_array($queryResult)){
                        if($row['MoiseContent']==0){
                            $counter +=1;
                        }
                    }
                }

                if($counter != 0){
                    $result = 2;
                }
                else{
                    $result = 3;
                }
            }
            else{
                $result = 1;
            }
            
            $arr = array(
                'result'=>$result,
                'SheetNo' =>$sheetNo
            );
            echo json_encode($arr);
        }

        else if($_POST['action']=="sheetNoPrint"){
            // $query = "SELECT * ";
            // $query .="FROM sheet_tbl ";
            // $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

            $query = "SELECT * ";
            $query .="FROM sheet_tbl ";
            // $query .="LEFT JOIN sheetdetail_tbl sd ON s.SheetID = sd.SheetID ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 and UserWorkStationID = '".$_COOKIE['GPuserID']."' and IsCompleted = 1 order by  SheetID ASC";
            
            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Sheet No...</option>';

                while($row = odbc_fetch_array($fetch)){

                    $Sheet_Id     = $row['SheetID'];
                    $Sheet_no   = $row['SheetNo'];

                    $output .='<option value="'.$Sheet_Id.'">'.$Sheet_no.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST['action']=="lotNoPrint"){
            $query = "SELECT * ";
            $query .="FROM sheetdetail_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 and UserWorkStationID = '".$_COOKIE['GPuserID']."' ";

            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                $output .='<option selected disabled value="">Lot No...</option>';

                while($row = odbc_fetch_array($fetch)){

                    $Sheetdetail_Id     = $row['SheetDetailID'];
                    $Lot_no   = $row['LotNumber'];

                    $output .='<option value="'.$Sheetdetail_Id.'">'.$Lot_no.'</option>';
                }

                echo json_encode($output);
            }
        }

        else if($_POST['action']=="qr"){
            $lotnumber = "";
            $dataQRUrl = "";
            $result = 0;

            if(isset($_POST['lotnumber'])){
                $lotnumber = $_POST['lotnumber'];
            }

            if(isset($_POST['qrURL'])){
                $dataQRUrl = $_POST['qrURL'];
            }

            $QRname = $lotnumber.'.png';
            $subfolder = '../QRuploads/';

            $query = "INSERT INTO sheetdetailqr(SheetDetailID, QRDataUrl) ";
            $query .="SELECT SheetDetailID, '".$QRname."' FROM  sheetdetail_tbl ";
            $query .="WHERE LotNumber = '".$lotnumber."' ";

            $result = odbc_exec($conn, $query);

            if($result){
                $result = 1;
                file_put_contents($subfolder.$QRname,file_get_contents($dataQRUrl));
            }
            else{
                $result = 2;
            }

            $arr = array(
                'result' => $result,
                'imageData' =>$dataQRUrl
            );
            echo json_encode($arr);
        }

        else if($_POST['action']=="openModal"){
            $sheetDetailID = 0;
            if(isset($_POST['sheetdetailID'])){
                $sheetDetailID = $_POST['sheetdetailID'];
            }

            $query = "SELECT s.SheetNo, sd.LotNumber, sd.Shift, pt.PlateType, sd.Quantity, sd.MoiseContent, l.Line, sd.RackNo FROM sheetdetail_tbl sd ";
            $query .="JOIN sheet_tbl s ON sd.SheetID = s.SheetID ";
            $query .="JOIN platetype_tbl pt ON sd.PlateTypeID = pt.PlateTypeID ";
            $query .="JOIN line_tbl l ON sd.LineID = l.LineID ";
            $query .="WHERE SheetDetailID = '".$sheetDetailID."'";
            $query_result = odbc_exec($conn, $query);
            while($row = odbc_fetch_array($query_result)){
                $SheetNo = $row['SheetNo'];
                $LotNo = $row['LotNumber'];
    
                $Shift = $row['Shift'];
                $PlateType = $row['PlateType'];
    
                $Line = $row['Line'];
                $RackNo = $row['RackNo'];
    
                $pcs = "";
                if($row['Quantity'] > 1){
                    $pcs = "pcs";
                }
                else{
                    $pcs = "pc";
                }
    
                $Qty = number_format($row['Quantity'])." ".$pcs;
                $MC = floatval($row['MoiseContent'])."%";
                $MC_val = floatval($row['MoiseContent']);
                $qty_val = $row['Quantity'];
    
    
                $arr = array(
                    'SheetNo' => $SheetNo,
                    'LotNo'   => $LotNo,
                    'Shift'   => $Shift,
                    'PlateType' => $PlateType,
                    'Qty'     => $Qty,
                    'MC'      => $MC,
                    'MC_val'  => $MC_val,
                    'qty_val' => $qty_val,
                    'Line' => $Line,
                    'RackNo' => $RackNo
                );
    
                echo json_encode($arr);
            }

        }

        else if($_POST['action']=="EditShift"){
            $activeShift = "";
            if(isset($_POST['ActiveShift'])){
                $activeShift = $_POST['ActiveShift'];
            }

            $shift = array('1st', '2nd-D', '2nd-N', '3rd');

            $count = count($shift);

            $output = '';

            $output .='<option selected value="'.$activeShift.'">'.$activeShift.'</option>';

            for($i=0;$i<$count;$i++){
                if($activeShift != $shift[$i]){
                    $output .='<option value="'.$shift[$i].'">'.$shift[$i].'</option>';
                }
            }

            echo json_encode($output);
        }

        else if($_POST['action']=="EditPlateType"){
            $activePlate = "";
            if(isset($_POST['ActivePlateType'])){
                $activePlate = $_POST['ActivePlateType'];
            }

            $query = "SELECT * ";
            $query .="FROM platetype_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                

                while($row = odbc_fetch_array($fetch)){
                    if($activePlate == $row['PlateType']){
                        $output .='<option selected value="'.$row['PlateTypeID'].'">'.$row['PlateType'].'</option>';
                    }
                    else{
                        $plate_Id     = $row['PlateTypeID'];
                        $plate_Name   = $row['PlateType'];

                        $output .='<option value="'.$plate_Id .'">'.$plate_Name.'</option>';
                    }
                    
                }

                echo json_encode($output);
            }
        }

        else if($_POST['action']=="EditLine"){
            $activeLine = "";
            if(isset($_POST['ActiveLine'])){
                $activePlate = $_POST['ActiveLine'];
            }

            $query = "SELECT * ";
            $query .="FROM line_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

            $fetch = odbc_exec($conn, $query);

            if($fetch){

                $output ='';

                

                while($row = odbc_fetch_array($fetch)){
                    if($activePlate == $row['Line']){
                        $output .='<option selected value="'.$row['LineID'].'">'.$row['Line'].'</option>';
                    }
                    else{
                        $line_Id     = $row['LineID'];
                        $line_Name   = $row['Line'];

                        $output .='<option value="'.$line_Id .'">'.$line_Name.'</option>';
                    }
                    
                }

                echo json_encode($output);
            }
        }

        else if($_POST['action']=="update"){
            $sheetdetailID = 0;
            $shift = "";
            $platetype = 0;
            $qty = 0;
            $mc = 0;
            $Line = 0;
            $RackNo = "";

            if(isset($_POST['sheetdetailId'])){
                $sheetdetailID = $_POST['sheetdetailId'];
            }

            if(isset($_POST['shift'])){
                $shift = $_POST['shift'];
            }

            if(isset($_POST['platetype'])){
                $platetype = $_POST['platetype'];
            }

            if(isset($_POST['qty'])){
                $qty = $_POST['qty'];
            }

            if(isset($_POST['mc'])){
                $mc = $_POST['mc'];
            }

            if(isset($_POST['Line'])){
                $Line = $_POST['Line'];
            }

            if(isset($_POST['RackNo'])){
                $RackNo = $_POST['RackNo'];
            }
            
            $result = 0;

            $updateQuery = "UPDATE sheetdetail_tbl ";
            $updateQuery .="SET Shift = '".$shift."', PlateTypeID = '".$platetype."', ";
            $updateQuery .="Quantity = '".$qty."', MoiseContent = '".$mc."', ";
            $updateQuery .="LineID = '".$Line."', RackNo = '".$RackNo."' ";
            $updateQuery .="WHERE SheetDetailID = '".$sheetdetailID."' ";

            $updateResult = odbc_exec($conn, $updateQuery);

            if($updateResult){
                $result = 1;
            }
            
            echo json_encode($result);
        }

        else if($_POST['action']=="getPlateTxt"){
            $plateTypeID = 0;
            $platetypetext = "";

            if(isset($_POST['plateTypeID'])){
                $plateTypeID = $_POST['plateTypeID'];
            }

            $query = "SELECT * FROM platetype_tbl ";
            $query .= "WHERE PlateTypeID = '".$plateTypeID."' ";
            $queryResult = odbc_exec($conn, $query);
            // confirmQuery($queryResult);
            while($row = odbc_fetch_array($queryResult)){
                $platetypetext = $row['PlateType'];
            }

            echo json_encode($platetypetext);
        }

        else if($_POST['action']=="getLineTxt"){
            $lineID = 0;
            $LineTxt = "";

            if(isset($_POST['lineID'])){
                $lineID = $_POST['lineID'];
            }

            $query = "SELECT * FROM line_tbl ";
            $query .= "WHERE LineID = '".$lineID."' ";
            $queryResult = odbc_exec($conn, $query);
            // confirmQuery($queryResult);
            while($row = odbc_fetch_array($queryResult)){
                $LineTxt = $row['Line'];
            }
            echo json_encode($LineTxt);
        }

        //------for scrap field---
        else if($_POST['action']=="totalChange"){
            $shift = "";
            $lineID = 0;
            $plateTypeID = 0;
            $dateval = "";

            if(isset($_POST['shiftval'])){
                $shift = $_POST['shiftval'];
            }
            if(isset($_POST['lineval'])){
                $lineID = $_POST['lineval'];
            }
            if(isset($_POST['platetype'])){
                $plateTypeID = $_POST['platetype'];
            }
            if(isset($_POST['dateval'])){
                $dateval = $_POST['dateval'];
            }
            $total = 0;
            $totalStr = "";
            $str = "";

            $query = "SELECT SUM(Quantity) as 'Total' FROM sheetdetail_tbl ";
            $query .="WHERE Shift = '".$shift."' and LineID = '".$lineID."' and PlateTypeID = '".$plateTypeID."' and DateCreated between '".$dateval." 00:00:00' and '".$dateval." 23:59:59' ";
            $queryResult = odbc_exec($conn, $query);

            if($queryResult){
                while($row = odbc_fetch_array($queryResult)){
                    if($row['Total'] > 1){
                        $str = "pcs";
                    }
                    else{
                        $str = "pc";
                    }
    
                    $totalStr = number_format($row['Total'])." ".$str;
                    $total = $row['Total'];
                }

            }

            $arr = array(
                'totalStr'=>$totalStr,
                'total'=>$total
            );

            echo json_encode($arr);
        }

        else if($_POST['action']=="submitScrap"){
            $dateAdd = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            $shift = "";
            $lineID = 0;
            $PlateTypeID = 0;
            $date = "";
            $SRPlate = "";
            $SRPaste = "";
            $Trimmings = "";
            $outputtotal = "";
            $result = 0;

            if(isset($_POST['shift'])){
                $shift = $_POST['shift'];
            }
            if(isset($_POST['line'])){
                $lineID = $_POST['line'];
            }
            if(isset($_POST['platetype'])){
                $PlateTypeID = $_POST['platetype'];
            }
            if(isset($_POST['date'])){
                $date = $_POST['date'];
            }
            if(isset($_POST['SRPlate'])){
                $SRPlate = $_POST['SRPlate'];
            }
            if(isset($_POST['SRPaste'])){
                $SRPaste = $_POST['SRPaste'];
            }
            if(isset($_POST['Trimmings'])){
                $Trimmings = $_POST['Trimmings'];
            }
            if(isset($_POST['outputtotal'])){
                $outputtotal = $_POST['outputtotal'];
            }

            $select = "SELECT * FROM scrapdetail_tbl ";
            $select .="WHERE Shift = '".$shift."' and  LineID = '".$lineID."' and PlateTypeID= '".$PlateTypeID."' and  AddDate = '".$date."' ";
            $selectQuery = odbc_exec($conn, $select);
            $count = odbc_num_rows($selectQuery);

            if($count == 0){
                $query = "INSERT INTO scrapdetail_tbl(LineID, PlateTypeID, Shift, SRPlate, SRPaste, Trimmings, TotalOutput, AddDate, UserWorkStationID) ";
                $query .="SELECT '".$lineID."', '".$PlateTypeID."', '".$shift."', '".$SRPlate."', '".$SRPaste."', '".$Trimmings."', SUM(Quantity), '".$date."', '".$_COOKIE['GPuserID']."' ";
                $query .="FROM sheetdetail_tbl WHERE Shift = '".$shift."' and  LineID = '".$lineID."' and PlateTypeID= '".$PlateTypeID."' and  DateCreated between '".$date." 00:00:00' AND  '".$dateAdd." 05:59:59' ";

                $insertQuery = odbc_exec($conn, $query);

                if($insertQuery){
                    $result = 1;
                    $id=0;
                    $getscraplast = "select top 1 ScrapDetailID from scrapdetail_tbl where UserWorkStationID = '".$_COOKIE['GPuserID']."' order by DateCreated DESC ";
                    $result = odbc_exec($conn, $getscraplast);
                    while($row = odbc_fetch_array($result)){
                        $id = $row['ScrapDetailID'];
                    }
                    
                    $insertReturn = InsertLogs($id, $conn, $SRPlate, $SRPaste, $Trimmings);
                    
                }
                else{
                    $result = 0;
                }
            }
            else{
                $id = 0;
                while($row = odbc_fetch_array($selectQuery)){
                    $id = $row['ScrapDetailID'];
                }   
                
                $update = "UPDATE scrapdetail_tbl ";
                $update .="SET SRPlate = (SELECT SRPLate FROM scrapdetail_tbl WHERE ScrapDetailID = '".$id."') + '".$SRPlate."', DateModified = getdate(), TotalOutput = '".$outputtotal."'  WHERE ScrapDetailID = '".$id."' ";
                $update = odbc_exec($conn, $update);

                if($update){
                    $result = 2;
                    InsertLogs($id, $conn, $SRPlate, $SRPaste, $Trimmings);
                    
                }
                else{
                    $result = 0;
                }
            }

            

            echo json_encode($result);
        }

        else if($_POST['action']=="cardCounter"){
            $wholeDay = 0;
            $Day12D = 0;
            $Night12N = 0;

            $dateVal = "";
            if(isset($_POST['date'])){
                $dateVal = $_POST['date'];
            }

            $queryw = "SELECT SUM(TotalOutput) as 'WholeDay' FROM scrapdetail_tbl ";
            $queryw .= "WHERE AddDate = '".$dateVal."' ";
            $querywResult = odbc_exec($conn, $queryw);
            $count = odbc_num_rows($querywResult);
            if($count !=0){
                while($querywRow = odbc_fetch_array($querywResult)){
                    $wholeDay = number_format($querywRow['WholeDay']);
                }
                
            }
            else{
                $wholeDay = 0;
            }


            $query12h = "SELECT SUM(TotalOutput) as '12H' FROM scrapdetail_tbl ";
            $query12h .= "WHERE AddDate = '".$dateVal."' and Shift in ('1st','2nd-D') ";
            $query12hResult = odbc_exec($conn, $query12h);
            $count12h = odbc_num_rows($query12hResult);
            if($count12h !=0){
                while($querywRow12h = odbc_fetch_array($query12hResult)){
                    $Day12D = number_format($querywRow12h['12H']);
                }
                
            }
            else{
                $Day12D = 0;
            }


            $query12hN = "SELECT SUM(TotalOutput) as '12HN' FROM scrapdetail_tbl ";
            $query12hN .= "WHERE AddDate = '".$dateVal."' and Shift in ('2nd-N','3rd') ";
            $query12hNResult = odbc_exec($conn, $query12hN);
            $count12hN = odbc_num_rows($query12hNResult);
            if($count12hN !=0){
                while($querywRow12hN = odbc_fetch_array($query12hNResult)){
                    $Night12N = number_format($querywRow12hN['12HN']);
                }
                
            }
            else{
                $Night12N = 0;
            }
            
            

            $arr = array(
                'WholeDay'=>$wholeDay,
                'Day12H' =>$Day12D,
                'Day12N' =>$Night12N
            );

            echo json_encode($arr);
        }

        else if($_POST['action']=="booth"){
            $curingboothID = 0;
            $curringbooth = '';

            if(isset($_POST['booth'])){
                $curingboothID = $_POST['booth'];
            }

            $query = "SELECT * FROM curringbooth_tbl ";
            $query .="WHERE CurringBoothID = '".$curingboothID."' and IsDeleted = 0 and IsActive = 1 ";
            $result = odbc_exec($conn, $query);
            while($row = odbc_fetch_array($result)){
                $curringbooth = $row['CurringBooth'];
            }

            echo json_encode($curringbooth);
        }

        //----Locking Curing Booth---

        else if($_POST['action']=="lockCuringBooth"){
            $sheetNo = "";
            $curringBoothID = 0;
            $curringBoothTxt = "0";
            $output ="";
            $setter = 0;
            $id = 0;
            $stat = 0;
            $activeProcess = "";
            $rowVal = 0;

            if(isset($_POST['ActiveSheetNo'])){
                $sheetNo = $_POST['ActiveSheetNo'];
            }

            if(isset($_POST['CuringBooth'])){
                $curringBoothID = $_POST['CuringBooth'];
            }
            
            if(isset($_POST['stat'])){
                $stat = $_POST['stat'];
            }

            if(isset($_POST['ActiveProcess'])){
                $activeProcess = $_POST['ActiveProcess'];
            }

            $query = "SELECT * FROM sheetdetail_tbl ";
            $query .="WHERE SheetID = (SELECT SheetID FROM sheet_tbl WHERE SheetID = '".$sheetNo."')";
            $result = odbc_exec($conn, $query);

            $count = odbc_num_rows($result);

            if($count !=0){
                $setter = 1;
                
                while($row1 = odbc_fetch_array($result)){
                    $rowVal = $row1['CurringBoothID'];
                }

                $queryCuringBooth = "SELECT * FROM curringbooth_tbl WHERE CurringBoothID = '".$rowVal."' ";
                $resultCurringBooth = odbc_exec($conn, $queryCuringBooth);

                while($row = odbc_fetch_array($resultCurringBooth)){
                    $curringBoothTxt = $row['CurringBooth'];
                    $output .= "<option value = '".$rowVal."'>".$curringBoothTxt."</option>";
                }
                
            }
            else{
                $output .= '<option selected disabled value="">Choose..</option>';
            }

            // if($activeProcess=="OSI & CAT"){
            //     $activeProcess = "Tunnel";
            // }
            // else if($activeProcess=="Tunnel"){
            //     $activeProcess = "OSI & CAT";
            // }

            $arr = array(
                'result'=>$setter,
                'Curring'=>$curringBoothTxt,
                'count'=>$count,
                'output'=>$output,
                'id'=>$rowVal,
                'SheetNo'=>$sheetNo,
                'Active'=>$activeProcess
            );

            echo json_encode($arr);
        }

        //----report--

        //----Working station block
        else if($_POST['action']=="station"){
            $MAC = exec('getmac');
            $MAC = strtok($MAC, ' ');
            $ClientStationName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $ClientStationIP = $_SERVER['REMOTE_ADDR'];
            $output = 0;

            $query = "SELECT TOP 1 StationName, StationIP, PhysicalMacAddr FROM workstation_tbl ";
            $query .= "WHERE StationName = '".$ClientStationName."' and StationIP = '".$ClientStationIP."' and PhysicalMacAddr = '".$MAC."' and IsActive = 1 and IsDeleted = 0 ";

            $fetch = odbc_exec($conn, $query);
            $count = odbc_num_rows($fetch) & 0xffffffff;

            if($count ==0){

                $stmt = odbc_prepare($conn, "INSERT INTO workstation_tbl(StationName, StationIP, PhysicalMacAddr) VALUES(?, ?, ?)");
        
                $results = odbc_execute($stmt, array($ClientStationName, $ClientStationIP, $MAC));
        
                odbc_close($conn);
        
                if($results){
                    $output = 0;
                }
            }
            else{
                $output = 1;
                while($row = odbc_fetch_array($fetch)){
                    $ClientStationName = $row['StationName'];
                    $ClientStationIP = $row['StationIP'];
                    $MAC = $row['PhysicalMacAddr'];
                }
                
            }
            $arr = array(
                'StationName'=> $ClientStationName,
                'StationIP'=> $ClientStationIP,
                'MacAddr'=> $MAC
            );

            // PHP code to get the MAC address of Server
            // $mac2 = system('ipconfig/all');
            // echo $mac;
  

            echo json_encode($arr);

        }
        //----Working station block End

        //---Check for the process

        else if($_POST['action']=='checkProcess'){
            $process = "";
            $ClientStationName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $ClientStationIP = $_SERVER['REMOTE_ADDR'];
            $result = 0;
            $workStationID = 0;
            $curringprocessID = 0;
            $sheetId = 0;

            if(isset($_POST['process'])){
                $process = $_POST['process'];
            }

            $select = "SELECT * FROM sheet_tbl ";
            $select .="WHERE  WorkStationID = (SELECT WorkStationID FROM workstation_tbl WHERE StationName = '".$ClientStationName."' AND StationIP = '".$ClientStationIP."' AND IsActive = 1 AND IsDeleted = 0) and UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
            $select .=" AND IsActive = 1 AND IsDeleted = 0 AND IsCompleted = 0 ";

            $result_query = odbc_exec($conn, $select);

            $count = odbc_num_rows($result_query);

            if($count !=0){
                while($row_result1 = odbc_fetch_array($result_query)){
                    $workStationID = $row_result1['WorkStationID'];
                    $curringprocessID = $row_result1['CurringProcessID'];
                    $sheetId = $row_result1['SheetID'];
                }
                
                
                $result = 1;

                $query = "SELECT * FROM sheetdetail_tbl ";
                $query .="WHERE SheetID = '".$sheetId."' ";
                $result2_query = odbc_exec($conn, $query);
                $countDetail = odbc_num_rows($result2_query);
            }
            else{
                $result = 0;
            }

            $arr = array(
                'process'=>$process,
                'StationName'=>$ClientStationName,
                'StationIP'=>$ClientStationIP,
                'result'=>$result,
                'count'=>$count,
                'count2'=>$countDetail,
                'clientID'=>$workStationID,
                'processID'=>$curringprocessID
            );

            echo json_encode($arr);
        }

        else if($_POST['action']=='check'){
            $ClientStationName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $ClientStationIP = $_SERVER['REMOTE_ADDR'];
            $process = "";

            $select = "SELECT Process FROM curringprocess_tbl ";
            $select .="WHERE CurringProcessID = (SELECT Top 1 CurringProcessID FROM sheet_tbl WHERE WorkStationID = (SELECT WorkStationID FROM workstation_tbl WHERE StationName = '".$ClientStationName."' AND StationIP = '".$ClientStationIP."') and UserWorkStationID = '".$_COOKIE['GPuserID']."' order by DateCreated DESC ) ";

            $result = odbc_exec($conn, $select);

            if($result){
                while($row = odbc_fetch_array($result)){
                    $process = $row['Process'];
                }
                echo json_encode($process);
            }

        }

        else if($_POST['action']=='getSheet'){
            $clientID = 0;
            $process = "";
            $sheetNo = "";

            if(isset($_POST['clientID'])){
                $clientID = $_POST['clientID'];
            }

            if(isset($_POST['process'])){
                $process = $_POST['process'];
            }

            $select = "SELECT * FROM sheet_tbl ";
            $select .="WHERE WorkStationID = '".$clientID."' ";
            $select .="AND CurringProcessID = (SELECT CurringProcessID FROM curringprocess_tbl WHERE Process = '".$process."') and UserWorkStationID = '".$_COOKIE['GPuserID']."' ";

            $result_query = odbc_exec($conn, $select);

            if($result_query){
                while($row = odbc_fetch_array($result_query)){
                    $sheetNo = $row['SheetID'];
                }
            }
            echo json_encode($sheetNo);
        }

        else if($_POST['action']=='getter'){
            $process = "";
            $ClientStationName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            $ClientStationIP = $_SERVER['REMOTE_ADDR'];
            $SheetID = 0;

            if(isset($_POST['process'])){
                $process = $_POST['process'];
            }

            $query = "SELECT * FROM sheet_tbl ";
            $query .="WHERE CurringProcessID = (SELECT CurringProcessID FROM curringprocess_tbl WHERE Process = '".$process."') ";
            $query .="AND WorkStationID = (SELECT TOP 1 WorkStationID FROM workstation_tbl WHERE StationName = '".$ClientStationName."' AND StationIP = '".$ClientStationIP."' order by WorkStationID ASC) AND IsCompleted = 0 and UserWorkStationID = '".$_COOKIE['GPuserID']."' ";
            $result_query = odbc_exec($conn, $query);
            $SheetID = 0;
            $count = odbc_num_rows($result_query);
            if($count!=0){
                while($row = odbc_fetch_array($result_query)){
                    $SheetID = $row['SheetID'];
                }
            }
            
            $arr = array(
                'count'=>$count,
                'sheetID'=>$SheetID
            );

            echo json_encode($arr);
        }

        //----check for nullable items---
        else if($_POST['action']=='CheckNullItem'){
            $SheetID = 0;
            if(isset($_POST['sheetID'])){
                $SheetID = $_POST['sheetID'];
            }

            $query = "SELECT sd.SheetDetailID, cb.CurringBooth FROM sheetdetail_tbl sd ";
            $query .="JOIN curringbooth_tbl cb ON sd.CurringBoothID = cb.CurringBoothID ";
            $query .="WHERE sd.SheetID = '".$SheetID."' order by sd.SheetDetailID ASC ";
            $result = odbc_exec($conn, $query);

            $count = odbc_num_rows($result);
            $result2 = 0;
            $counter = 1;
            $curringbooth = "";
            
            if($count !=0){
                
                while($row=odbc_fetch_array($result)){
                    $sheetdetailID = $row['SheetDetailID'];
                    $curringbooth = $row['CurringBooth'];

                    $boothNo = $curringbooth."-".$counter;

                    $update = "UPDATE sheetdetail_tbl ";
                    $update .="SET CurringBoothNo = '".$boothNo."' ";
                    $update .="WHERE SheetDetailID = '".$sheetdetailID."' ";
                    $Update_result = odbc_exec($conn, $update);

                    $counter ++;
                }
                $result2 = 1;
                echo json_encode($curringbooth."-".$counter);
            }
            else{
                echo json_encode("---");
            }

            
        }
        //----check for nullable items---

        else if($_POST['action']=='email'){

            com_load_typelib("outlook.application"); 
    
            if (!defined("olMailItem")) {
                        define("olMailItem",0);
            }
    
            $outlook_Obj = new COM("outlook.application") or die("Unable to start Outlook");
    
            //just to check you are connected.        
            
            $oMsg = $outlook_Obj->CreateItem(0);        
            $oMsg->Recipients->Add('Mark.cruz@motolite.com');
            $oMsg->Recipients->Add('carlo.cayabyab@motolite.com');
            $oMsg->Recipients->Add('arnold.delacruz@motolite.com');
            // $oMsg->Recipients->Add($address2);
            // $oMsg->Recipients->Add($address3);
            // $oMsg->Recipients->Add($address4);
            $oMsg->Subject="test"; 
            //$oMsg->BodyFormat = olFormatHTML;
            $oMsg->HTMLBody="<h5>hi</br>This is a test email, no-reply</h5>";
            $oMsg->Attachments->Add('C:\xampp\htdocs\PBI-GP_Monitoring\test\system_file\95print.pdf');
            $oMsg->Save();
            $oMsg->Display(); 
            $oMsg->Send();
        }

    }

?>

