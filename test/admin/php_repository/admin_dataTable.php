<?php

include "../../includes/db.php";
include "../../includes/functions.php";

if(isset($_POST['action'])){
    if($_POST['action']=="Employee_Table"){

            $column = array("", "LastName", "FirstName", "NickName", "", "" );

            $search = "%".$_POST["search"]["value"]."%";
            $query = "SELECT * FROM employee_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

            if(isset($_POST["search"]["value"])){											
                if(!empty($_POST["search"]["value"])){
                    $query .='AND (LastName LIKE ? ';
                    $query .='OR FirstName LIKE ? ';
                    $query .='OR NickName LIKE ?) ';
                }
            }

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY LastName ASC ';
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
                odbc_execute($result, array($search, $search, $search));
                $count = odbc_num_rows($result);
                // $result = odbc_fetch_array($stmt);
            }
            else{
                $table = odbc_exec($conn, $query);
                $count = odbc_num_rows($table);
                $result = odbc_exec($conn, $query.$query1);
            }

            $data = array();
            
            $n = 1;
            $lessAdmin = 1;

            while($row = odbc_fetch_array($result)){
                $id  = $row['EmployeeID'];
                $FirstName = $row['FirstName'];
                $LastName = $row['LastName'];
                $NickName = $row['NickName'];

                $sub_array = array();

                $query_admin = "SELECT * FROM usercredential_tbl WHERE EmployeeID = '".$id."'";
                $result2 = odbc_exec($conn, $query_admin);
                $counter = odbc_num_rows($result2);

                if($counter > 0){
                    continue;
                    $lessAdmin ++;
                }
                else{
                    $nickname = "";
                    if($NickName == "" || $NickName == null){
                        $nickname = "---";
                    }
                    else{
                        $nickname = $NickName;
                    }

                    $query = "SELECT LastName, FirstName, MiddleName, NickName, ";
                    $query .="(SELECT TOP 1 PasterID FROM paster_tbl WHERE EmployeeID = '".$id."' and IsActive = 1 and IsDeleted = 0 ORDER BY DateCreated DESC ) as 'PasterID',  ";
                    $query .="(SELECT TOP 1 StackerID FROM stacker_tbl WHERE EmployeeID = '".$id."' and IsActive = 1 and IsDeleted = 0 ORDER BY DateCreated DESC ) as 'StackerID'  ";
                    $query .="FROM employee_tbl ";
                    $query .="WHERE EmployeeID = '".$id."' ";

                    $assigned_result = odbc_exec($conn, $query);

                    $paster = "";
                    $stacker = "";
                    $tag = "";

                    while($row_assigned = odbc_fetch_array($assigned_result)){
                        if($row_assigned['PasterID']!="" || $row_assigned['PasterID']!=null){
                            $paster = "Paster";
                        }
                        else{
                            $paster = "---";
                        }
    
                        if($row_assigned['StackerID']!="" || $row_assigned['StackerID']!=null){
                            $stacker = "Stacker";
                        }
                        else{
                            $stacker = "---";
                        }
                    }   


                    if($paster == "---" and $stacker == "---"){
                        $tag = "---";
                    }
                    else if($paster == "Paster" and $stacker == "---"){
                        $tag = '<span class="badge badge-primary p-2">'.$paster.'</span>';
                    }
                    else if($paster == "---" and $stacker == "Stacker"){
                        $tag = '<span class="badge badge-success p-2">'.$stacker.'</span>';
                    }
                    else{
                        $tag = '<span class="badge badge-primary p-2">'.$paster.'</span>&nbsp;<span class="badge badge-success p-2">'.$stacker.'</span>';
                    }


                    $sub_array[] = $n;
                    $sub_array[] = htmlspecialchars($LastName);
                    $sub_array[] = htmlspecialchars($FirstName);
                    $sub_array[] = htmlspecialchars($nickname);
                    $sub_array[] = $tag;
                    $sub_array[] = '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group" role="group" aria-label="button group">

                            <button type="button" class="btn btn-outline-primary btn-sm" onclick = "view('.$id.')"><i class="fa fa-eye"></i></button>

                            <button type="button" class="btn btn-outline-success btn-sm" onclick = "edit('.$id.')"><i class="fa fa-pencil-alt"></i></button>

                            <button type="button" class="btn btn-outline-danger btn-sm" onclick = "del('.$id.')"><i class="fa fa-trash-alt"></i></button>

                        </div>
                        </div>
                    ';


                    $n ++;
                }
               
                

                $data[] = $sub_array;
            }

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count - $lessAdmin,
                'data' => $data,
                'recordsTotal' => $count - $lessAdmin
            );

            echo json_encode($output);
    }

    else if($_POST['action']=="Plate_Table"){

            $column = array("", "PlateType", "Line", "DateCreated", "");
            $search = "%".$_POST["search"]["value"]."%";
            $query = "SELECT * FROM platetype_tbl ";
            $query .="WHERE IsActive = 1 and IsDeleted = 0 ";

            if(isset($_POST["search"]["value"])){											
                if(!empty($_POST["search"]["value"])){
                    $query .='AND PlateType LIKE ? ';
                }
            }

            if(isset($_POST["order"])){

                $query .='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir']. ' ';
            } 

            else{

                $query .='ORDER BY PlateTypeID ASC ';
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
                odbc_execute($result, array($search, $search, $search));
                $count = odbc_num_rows($result);
                // $result = odbc_fetch_array($stmt);
            }
            else{
                $table = odbc_exec($conn, $query);
                $count = odbc_num_rows($table);
                $result = odbc_exec($conn, $query.$query1);
            }

            $data = array();
            
            $n = 1;
            $lessAdmin = 1;

            while($row = odbc_fetch_array($result)){
                $id  = $row['PlateTypeID'];
                $plate = $row['PlateType'];
                $polarity = $row['PolarityID'];
                $date = $row['DateCreated'];

                $line_text = "";

                if($polarity == 1){
                    $line_text = "Cominco";
                }
                else if($polarity == 2){
                    $line_text = "Delphi";
                }

                $sub_array = array();

                $sub_array[] = $n;
                $sub_array[] = $plate;
                $sub_array[] = $line_text;
                $sub_array[] = date('M d, Y',strtotime($date));
                $sub_array[] = '<div class="btn-toolbar text-center" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group" role="group" aria-label="button group">

                        <button type="button" class="btn btn-outline-primary btn-sm" onclick = "viewPlate('.$id.')"><i class="fa fa-eye"></i></button>

                        <button type="button" class="btn btn-outline-success btn-sm" onclick = "editPlate('.$id.')"><i class="fa fa-pencil-alt"></i></button>

                        <button type="button" class="btn btn-outline-danger btn-sm" onclick = "delPlate('.$id.')"><i class="fa fa-trash-alt"></i></button>

                    </div>
                    </div>
                ';


                $n ++;
               
                $data[] = $sub_array;
            }

            $output = array(
                'draw' => intval($_POST['draw']),
                'recordsFiltered' => $count,
                'data' => $data,
                'recordsTotal' => $count 
            );

            echo json_encode($output);
    }
}

?>