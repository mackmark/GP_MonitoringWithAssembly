function SheetTable(SheetNo){
    var SheetVal = SheetNo
    $('#Sheet_tbl').DataTable().destroy()
    var dataTable = $('#Sheet_tbl').DataTable({

        "responsive": false,
        "processing": false,
        "serverSide": true,
        "bSort": false,
        "bInfo":false,
        "order" : [],
        "searching": false,   // Search Box will Be Disabled

        "ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled

        "info": false,         // Will show "1 to n of n entries" Text at bottom

        "lengthChange": false, // Will Disabled Record number per page

        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        "AutoWidth": false,

        "ajax" : {
            url: "php_repository/index_dataTable.php",
            type: "POST",
            data:{
                action:'Sheet_Table',
                SheetInialize:SheetVal
            }
        },
        // dom: 'lbfrtip',
            buttons: [
                { extend: 'copyHtml5', className: 'btn btn-outline-primary' },
                { extend: 'csvHtml5', className: 'btn btn-outline-primary' },
                { extend: 'excelHtml5', className: 'btn btn-outline-primary' }
                // { extend: 'pdfHtml5', className: 'btn btn-outline-primary' }
                
            ]
        // "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}

function ScrapTable(dateVal, setterVal){
    var date = dateVal
    var setter = setterVal
    $('#Scrap_tbl').DataTable().destroy()
    var dataTable = $('#Scrap_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": true,
        "bInfo":true,
        "order" : [],

        "ajax" : {
            url: "php_repository/index_dataTable.php",
            type: "POST",
            data:{
                action:'Scrap_Table',
                dateval:date,
                setter:setter
            }
        },
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-primary' },
            { extend: 'csvHtml5', className: 'btn btn-outline-primary' },
            { extend: 'excelHtml5', className: 'btn btn-outline-primary' }
            // { extend: 'pdfHtml5', className: 'btn btn-outline-primary' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}

function ScrapTableSummary(dateVal){
    var date = dateVal

    $('#Scrap_tbl').DataTable().destroy()
    var dataTable = $('#Scrap_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": true,
        "bInfo":true,
        "order" : [],

        "ajax" : {
            url: "php_repository/index_dataTable.php",
            type: "POST",
            data:{
                action:'ScrapSummary_Table',
                dateval:date
            }
        },
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-primary' },
            { extend: 'csvHtml5', className: 'btn btn-outline-primary' },
            { extend: 'excelHtml5', className: 'btn btn-outline-primary' }
            // { extend: 'pdfHtml5', className: 'btn btn-outline-primary' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}



function ReportTable(dateVal, userID){
    var date = dateVal
    var userid = userID

    $('#report_tbl').DataTable().destroy()
    var dataTable = $('#report_tbl').on('error.dt', function (e, settings, techNote, message) {
        console.log('An error has been reported by DataTables: ', message);
    }).DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        // "searching": false,
        "bSort": true,
        "bInfo":true,
        "order" : [],
        "ajax" : {
            url: "../php_repository/index_dataTable.php",
            type: "POST",
            // contentType: "application/json; charset=utf-8",
            dataType: 'JSON',
            data:{
                action:'Report_Table',
                dateval:date,
                userid:userid
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
              },
              "complete": function(xhr, responseText){
                console.log(xhr);
                console.log(responseText); //*** responseJSON: Array[0]
            }
            // success: function(data){
            //     alert(data.date)
            // }
        },
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-success' },
            { extend: 'csvHtml5', className: 'btn btn-outline-success' },
            { extend: 'excelHtml5', className: 'btn btn-outline-success' }
            // { extend: 'pdfHtml5', className: 'btn btn-outline-success' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })

}

function HalfDTable(dateVal, userID){
    var date = dateVal
    var userid = userID
    $('#halfShiftD_tbl').DataTable().destroy()
    var dataTable = $('#halfShiftD_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": false,
        "bInfo":false,
        "bPaginate": false,
        "searching": false,
        "order" : [],
        "ajax" : {
            url: "../php_repository/index_dataTable.php",
            type: "POST",
            data:{
                action:'HalfDayShift_Table',
                dateval:date,
                userid:userid
            }
        },
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-success' },
            { extend: 'csvHtml5', className: 'btn btn-outline-success' },
            { extend: 'excelHtml5', className: 'btn btn-outline-success' }
            // { extend: 'pdfHtml5', className: 'btn btn-outline-success' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}

function HalfNTable(dateVal, userID){
    var date = dateVal
    var userid = userID
    $('#halfShiftN_tbl').DataTable().destroy()
    var dataTable = $('#halfShiftN_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": false,
        "bInfo":false,
        "bPaginate": false,
        "searching": false,
        "order" : [],
        "ajax" : {
            url: "../php_repository/index_dataTable.php",
            type: "POST",
            data:{
                action:'HalfNightShift_Table',
                dateval:date,
                userid:userid
            }
        },
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-success' },
            { extend: 'csvHtml5', className: 'btn btn-outline-success' },
            { extend: 'excelHtml5', className: 'btn btn-outline-success' }
            // { extend: 'pdfHtml5', className: 'btn btn-outline-success' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}

function WholeTable(dateVal, userID){
    var date = dateVal
    var userid = userID
    $('#WholeDay_tbl').DataTable().destroy()
    var dataTable = $('#WholeDay_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": false,
        "bInfo":false,
        "bPaginate": false,
        "searching": false,
        "order" : [],
        "ajax" : {
            url: "../php_repository/index_dataTable.php",
            type: "POST",
            data:{
                action:'Whole_Table',
                dateval:date,
                userid:userid
            }
        },
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-success' },
            { extend: 'csvHtml5', className: 'btn btn-outline-success' },
            { extend: 'excelHtml5', className: 'btn btn-outline-success' }
            // { extend: 'pdfHtml5', className: 'btn btn-outline-success' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}