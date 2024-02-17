<?php

    // $db['db_host'] = "localhost";
    // $db['db_user'] = "root";
    // $db['db_pass'] = "";
    // $db['db_name'] = "pbi_gp_monitoring_db";

    // foreach($db as $key => $value){
    //     define(strtoupper($key), $value);
    // }
    // $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // if($con){
    //     echo 'Connected';
    // }


    // $server = "172.26.129.20";
	// define('DB_SERVER', $server);
	// define('DB_USERNAME', 'Macnumba1!');
	// define('DB_PASSWORD', 'EarlGavhin27!');
	// // define('DB_NAME', 'pbi_gp_monitorings_db');
    // define('DB_NAME', 'pbi_gp_monitorings_db');

	// $con = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

	
	// if($con===false){
	// 	die("Error: no database connected". mysqli_connect_error());
	// }
    // // else{
    // //     echo "Connected";
    // // }


$conn = odbc_connect('Gp Monitoring','','');

// if($conn){
//      echo "Connected";
// }

?>