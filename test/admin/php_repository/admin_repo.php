<?php

 include "../../includes/db.php";
 include "../../includes/functions.php";

 if(isset($_POST['action'])){
    
    if($_POST['action']=="login"){
        $username = "";
        $password = "";

        if(isset($_POST['uname'])){
            $username = $_POST['uname'];
        }

        if(isset($_POST['password'])){
            $password = $_POST['password'];
        }

        $result = Login($username, $password, $conn);

        if($result == 1){
             session_name('sessionGPAdmin');
             session_start();
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="view"){
        $id = 0;
        $output = '';
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $query = "SELECT LastName, FirstName, MiddleName, NickName, ";
        $query .="(SELECT TOP 1 PasterID FROM paster_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC) as 'PasterID',  ";
        $query .="(SELECT TOP 1 StackerID FROM stacker_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC) as 'StackerID'  ";
        $query .="FROM employee_tbl ";
        $query .="WHERE EmployeeID = '".$id."' ";
        $result = odbc_exec($conn, $query);
        // confirmQuery($result);
        while($row = odbc_fetch_array($result)){
            $middle = "";
            $nickname = "";

            if($row['MiddleName']=="" || $row['MiddleName']==null){
                $middle = "---";
            }
            else{
                $middle = $row['MiddleName'];
            }

            if($row['NickName']=="" || $row['NickName']==null){
                $nickname = "---";
            }
            else{
                $nickname = $row['NickName'];
            }

            $output .='
            <span class="text-muted" style="font-size:12px;">Last name:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$row['LastName'].'</b></span></br>
            <span class="text-muted" style="font-size:12px;">First name:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$row['FirstName'].'</b></span></br>
            <span class="text-muted" style="font-size:12px;">Middle name:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$middle.'</b></span></br>
            <span class="text-muted" style="font-size:12px;">Nick name:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$nickname.'</b></span></br>
            ';

            if($row['PasterID']!="" || $row['PasterID']!=null){
                $paster = "Paster";
            }
            else{
                $paster = "---";
            }

            if($row['StackerID']!="" || $row['StackerID']!=null){
                $stacker = "Stacker";
            }
            else{
                $stacker = "---";
            }

            if($paster == "---" and $stacker == "---"){
                $output .= '<span class="text-muted" style="font-size:12px;">Designation:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">---</b></span>';
            }
            else if($paster == "Paster" and $stacker == "---"){
                $output .= '<span class="text-muted" style="font-size:12px;">Designation:&nbsp;&nbsp;</span><span class="badge badge-primary p-1">'.$paster.'</span>';
            }
            else if($paster == "---" and $stacker == "Stacker"){
                $output .= '<span class="text-muted" style="font-size:12px;">Designation:&nbsp;&nbsp;</span><span class="badge badge-success p-1">'.$stacker.'</span>';
            }
            else{
                $output .= '<span class="text-muted" style="font-size:12px;">Designation:&nbsp;&nbsp;</span><span class="badge badge-primary p-1">'.$paster.'</span>&nbsp;<span class="badge badge-success p-1">'.$stacker.'</span>';
            }

            echo json_encode($output);
        }

        
    }

    else if($_POST['action']=="edit"){
        $id = 0;
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $query = "SELECT LastName, FirstName, MiddleName, NickName, ";
        $query .="(SELECT TOP 1 PasterID FROM paster_tbl WHERE EmployeeID = '".$id."' and IsActive = 1 and IsDeleted = 0 ORDER BY DateCreated DESC) as 'PasterID',  ";
        $query .="(SELECT TOP 1 StackerID FROM stacker_tbl WHERE EmployeeID = '".$id."' and IsActive = 1 and IsDeleted = 0 ORDER BY DateCreated DESC) as 'StackerID'  ";
        $query .="FROM employee_tbl ";
        $query .="WHERE EmployeeID = '".$id."' ";
        $result = odbc_exec($conn, $query);

        // confirmQuery($result);

        while($row = odbc_fetch_array($result)){
            $lastname = $row['LastName'];
            $firstname = $row['FirstName'];
            $middle = "";
            $nickname = "";
            $paster = 0;
            $stacker = 0;

            if($row['MiddleName']=="" || $row['MiddleName']==null){
                $middle = "---";
            }
            else{
                $middle = $row['MiddleName'];
            }

            if($row['NickName']=="" || $row['NickName']==null){
                $nickname = "---";
            }
            else{
                $nickname = $row['NickName'];
            }


            if($row['PasterID']!="" || $row['PasterID']!=null){
                $paster = "Paster";
            }
            else{
                $paster = "---";
            }

            if($row['StackerID']!="" || $row['StackerID']!=null){
                $stacker = "Stacker";
            }
            else{
                $stacker = "---";
            }

            if($paster == "---" and $stacker == "---"){
                $paster = 0;
                $stacker = 0;
            }
            else if($paster == "Paster" and $stacker == "---"){
                $paster = 1;
                $stacker = 0;
            }
            else if($paster == "---" and $stacker == "Stacker"){
                $paster = 0;
                $stacker = 1;
            }
            else{
                $paster = 1;
                $stacker = 1;
            }

            $arr = array(
                'lastname'=>$lastname,
                'firstname'=>$firstname,
                'middlename'=>$middle,
                'nickname'=>$nickname,
                'paster'=>$paster,
                'stacker'=>$stacker
            );

            echo json_encode($arr);
        }

        
    }

    else if($_POST['action']=="update"){
        $id = 0;
        $lname = "";
        $fname = "";
        $mname = "";
        $nname = "";
        $pasterID = 0;
        $stackerID = 0;

        $result = 0;

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        if(isset($_POST['lname'])){
            $lname = $_POST['lname'];
        }

        if(isset($_POST['fname'])){
            $fname = $_POST['fname'];
        }

        if(isset($_POST['mname'])){
            $mname = $_POST['mname'];
        }

        if(isset($_POST['nname'])){
            $nname = $_POST['nname'];
        }

        if(isset($_POST['pasterID'])){
            $pasterID = $_POST['pasterID'];
        }

        if(isset($_POST['stackerID'])){
            $stackerID = $_POST['stackerID'];
        }

        $updateEmp = "UPDATE employee_tbl ";
        $updateEmp .="SET FirstName = '".htmlspecialchars($fname)."', ";
        $updateEmp .="LastName = '".htmlspecialchars($lname)."', ";
        $updateEmp .="MiddleName = '".htmlspecialchars($mname)."', ";
        $updateEmp .="NickName = '".htmlspecialchars($nname)."', ";
        $updateEmp .="DateModified = getdate() ";
        $updateEmp .="WHERE EmployeeID = '".$id."' ";

        $updateResult = odbc_exec($conn, $updateEmp);

        if($updateResult){
            $result = 1;

            if($pasterID != 0){
                $updatePaster = "UPDATE paster_tbl ";
                $updatePaster .= "SET IsActive = 0, IsDeleted = 1, DateModified = getdate() ";
                $updatePaster .= "WHERE PasterID = (SELECT TOP 1 PasterID FROM paster_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC )  ";

                $updatePasterResult = odbc_exec($conn, $updatePaster);

                if($updatePasterResult){
                    $insertPaster = "INSERT INTO paster_tbl(EmployeeID) ";
                    $insertPaster .="Values('".$id."') ";

                    $insertPasterResult = odbc_exec($conn, $insertPaster);

                    if($insertPasterResult){
                        $result = 1;
                    }
                    else{
                        $result = 0;
                    }
                }
                else{
                    $result = 0;
                }
            }
            else{
                $updatePaster = "UPDATE paster_tbl ";
                $updatePaster .= "SET IsActive = 0, IsDeleted = 1, DateModified = getdate() ";
                $updatePaster .= "WHERE PasterID = (SELECT TOP 1 PasterID FROM paster_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC)  ";

                $updatePasterResult = odbc_exec($conn, $updatePaster);

                if($updatePasterResult){
                    $result = 1;
                }
                else{
                    $result = 0;
                }

            }

            if($stackerID != 0){
                $updateStacker = "UPDATE stacker_tbl ";
                $updateStacker .= "SET IsActive = 0, IsDeleted = 1, DateModified = getdate() ";
                $updateStacker .= "WHERE StackerID = (SELECT TOP 1 StackerID FROM stacker_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC)  ";

                $updateStackerResult = odbc_exec($conn, $updateStacker);

                if($updateStackerResult){
                    $insertStacker = "INSERT INTO stacker_tbl(EmployeeID) ";
                    $insertStacker .="Values('".$id."') ";

                    $insertStackerResult = odbc_exec($conn, $insertStacker);

                    if($insertStackerResult){
                        $result = 1;
                    }
                    else{
                        $result = 0;
                    }
                }
                else{
                    $result = 0;
                }
            }
            else{
                $updateStacker = "UPDATE stacker_tbl ";
                $updateStacker .= "SET IsActive = 0, IsDeleted = 1, DateModified = getdate() ";
                $updateStacker .= "WHERE StackerID = (SELECT TOP 1 StackerID FROM stacker_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC)  ";

                $updateStackerResult = odbc_exec($conn, $updateStacker);

                if($updateStackerResult){
                    $result = 1;
                }
                else{
                    $result = 0;
                }

            }
        }
        else{
            $result = 0;
        }



        if($result==1){
            $query = "SELECT LastName, FirstName, MiddleName, NickName, ";
            $query .="(SELECT TOP 1 PasterID FROM paster_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC ) as 'PasterID',  ";
            $query .="(SELECT TOP 1 StackerID FROM stacker_tbl WHERE EmployeeID = '".$id."' ORDER BY DateCreated DESC ) as 'StackerID'  ";
            $query .="FROM employee_tbl ";
            $query .="WHERE EmployeeID = '".$id."' ";
            $result1 = odbc_exec($conn, $query);

            // confirmQuery($result1);

            while($row = odbc_fetch_array($result1)){
                $lastname = $row['LastName'];
                $firstname = $row['FirstName'];
                $middle = "";
                $nickname = "";
                $paster = 0;
                $stacker = 0;

                if($row['MiddleName']=="" || $row['MiddleName']==null){
                    $middle = "---";
                }
                else{
                    $middle = $row['MiddleName'];
                }

                if($row['NickName']=="" || $row['NickName']==null){
                    $nickname = "---";
                }
                else{
                    $nickname = $row['NickName'];
                }


                if($row['PasterID']!="" || $row['PasterID']!=null){
                    $paster = "Paster";
                }
                else{
                    $paster = "---";
                }

                if($row['StackerID']!="" || $row['StackerID']!=null){
                    $stacker = "Stacker";
                }
                else{
                    $stacker = "---";
                }

                if($paster == "---" and $stacker == "---"){
                    $paster = 0;
                    $stacker = 0;
                }
                else if($paster == "Paster" and $stacker == "---"){
                    $paster = 1;
                    $stacker = 0;
                }
                else if($paster == "---" and $stacker == "Stacker"){
                    $paster = 0;
                    $stacker = 1;
                }
                else{
                    $paster = 1;
                    $stacker = 1;
                }

                $arr = array(
                    'result' => $result,
                    'lastname'=>$lastname,
                    'firstname'=>$firstname,
                    'middlename'=>$middle,
                    'nickname'=>$nickname,
                    'paster'=>$paster,
                    'stacker'=>$stacker
                );

                echo json_encode($arr);
            }

            
        }
        // else{
        //     $arr = array(
        //         'result' => $result
        //     );
        //     echo json_encode($arr);
        // }

    }

    else if($_POST['action']=="delete"){
        $id = 0;
        $result = 0;
        
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $query = "UPDATE employee_tbl ";
        $query .="SET IsActive = 0, IsDeleted = 1, DateModified = getdate() ";
        $query .="WHERE EmployeeID ='".$id."' ";

        $query_result = odbc_exec($conn, $query);

        if($query_result){
            $result = 1;
        }
        else{
            $result = 0;
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="addEmpData"){
        $lname = "";
        $fname = "";
        $mname = "";
        $nname = "";
        $result = 0;

        if(isset($_POST['lname'])){
            $lname = $_POST['lname'];
        }

        if(isset($_POST['fname'])){
            $fname = $_POST['fname'];
        }

        if(isset($_POST['mname'])){
            $mname = $_POST['mname'];
        }

        if(isset($_POST['nname'])){
            $nname = $_POST['nname'];
        }

        $insert = "INSERT INTO employee_tbl(LastName, FirstName, MiddleName, NickName) ";
        $insert .="VALUES('".htmlspecialchars($lname)."', '".htmlspecialchars($fname)."', '".htmlspecialchars($mname)."', '".htmlspecialchars($nname)."') ";
        $insert_result = odbc_exec($conn, $insert);

        if($insert_result){
            $result = 1;
        }
        else{
            $result = 0;
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="logout"){
        $result = 0;
        if(Logout()){
            $result = Logout();
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="viewPlate"){
        $id = 0;
        $output = "";

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $query = "SELECT * FROM platetype_tbl ";
        $query .="WHERE IsActive = 1 and IsDeleted = 0 and PlateTypeID = '".$id."' ";

        $queryResult = odbc_exec($conn, $query);

        while($row = odbc_fetch_array($queryResult)){
            $line_txt = "";

            if($row['PolarityID']==1){
                $line_txt = "Cominco";
            }
            else if($row['PolarityID']==2){
                $line_txt = "Delphi";
            }

            $date = date('M d, Y',strtotime($row['DateCreated']));
            $output .='
            <span class="text-muted" style="font-size:12px;">Plate Type:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$row['PlateType'].'</b></span></br>
            <span class="text-muted" style="font-size:12px;">Line&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$line_txt.'</b></span></br>
            <span class="text-muted" style="font-size:12px;">Date Added:&nbsp;&nbsp;<b style="font-size:15px;" class="text-black">'.$date.'</b></span></br>
            ';

            echo json_encode($output);
        }

        

    }

    else if($_POST['action']=="editPlate"){
        $id = 0;
        $output = "";
        $line_str = "";

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $query = "SELECT * FROM platetype_tbl WHERE PlateTypeID = $id ";
        $queryResult = odbc_exec($conn, $query);
        while($row = odbc_fetch_array($queryResult)){
            if($row['PolarityID']==1){
                $line_str = "Cominco";
    
                $output .=" <option selected value='1'>".$line_str."</option>
                            <option value='2'>Delphi</option>
                ";
            }
            else if($row['PolarityID']==2){
                $line_str = "Delphi";
    
                $output .=" <option selected value='2'>".$line_str."</option>
                            <option value='1'>Comico</option>
                ";
            }
    
            $plateType = $row['PlateType'];
    
            $arr = array(
                'platetype'=>$plateType,
                'line'=>$output,
                'id'=>$id
            );
    
            echo json_encode($arr);
        }

        

    }

    else if($_POST['action']=="updatePlate"){
        $id = 0;
        $plate = "";
        $PolarityID = 0;
        $result = 0;

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        if(isset($_POST['plate'])){
            $plate = $_POST['plate'];
        }

        if(isset($_POST['line'])){
            $PolarityID = $_POST['line'];
        }

        $updateQuery = "UPDATE platetype_tbl ";
        $updateQuery .="SET PlateType = '".$plate."', PolarityID = '".$PolarityID."', ";
        $updateQuery .="DateModified = getdate() WHERE PlateTypeID = '".$id."' ";
        $execute = odbc_exec($conn, $updateQuery);

        if($execute){
            $result = 1;
        }
        else{
            $result = 0;
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="deletePlate"){
        $id = 0;
        $result = 0;
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $updateQuery = "UPDATE platetype_tbl ";
        $updateQuery .="SET IsActive = 0, IsDeleted = 1, ";
        $updateQuery .="DateModified = getdate() WHERE PlateTypeID = '".$id."' ";
        $execute = odbc_exec($conn, $updateQuery);

        if($execute){
            $result = 1;
        }
        else{
            $result = 0;
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="submitPlateData"){
        $plateType = "";
        $polarityID = 0;
        $result = 0;

        if(isset($_POST['plateType'])){
            $plateType = $_POST['plateType'];
        }

        if(isset($_POST['polarityID'])){
            $polarityID = $_POST['polarityID'];
        }

        $insert = "INSERT INTO platetype_tbl(PlateType, PolarityID) ";
        $insert .= "VALUES ('".$plateType."', '".$polarityID."') ";

        $executeQuery = odbc_exec($conn, $insert);

        if($executeQuery){
            $result = 1;
        }
        else{
            $result = 0;
        }

        echo json_encode($result);
    }

    else if($_POST['action']=="adminCred"){
        $id = 0;

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        $query = "SELECT * FROM usercredential_tbl u ";
        $query .= "JOIN employee_tbl e ON u.EmployeeID = e.EmployeeID ";
        $query .= "WHERE u.EmployeeID = '".$id."' ";
        $executeQuery = odbc_exec($conn, $query);
        while($row = odbc_fetch_array($executeQuery)){
            $uname = $row['UserName'];
            $pass = $row['Password'];
            $admin = $row['FirstName'].' '.$row['LastName'];

            $arr = array(
                'admin_name'=> $admin,
                'uname'=>$uname,
                'pass'=>$pass
            );

            echo json_encode($arr);
        }
        
    }

    else if($_POST['action']=="updateCred"){
        $id = 0;
        $uname = "";
        $pass = "";
        $result = 0;

        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }

        if(isset($_POST['uname'])){
            $uname = $_POST['uname'];
        }

        if(isset($_POST['pass'])){
            $pass = $_POST['pass'];
        }

        $query = "UPDATE usercredential_tbl ";
        $query .="SET UserName = '".htmlspecialchars($uname)."', Password = '".$pass."' ";
        $query .="WHERE EmployeeID = '".$id."' and IsActive = 1 and IsDeleted = 0 ";

        $executeQuery = odbc_exec($conn, $query);

        if($executeQuery){
            $result = 1;
        }
        else{
            $result = 0;
        }

        echo json_encode($result);
    }
 }

?>