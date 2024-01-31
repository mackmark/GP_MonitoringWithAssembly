function EmployeeTable(){
    $('#employee_tbl').DataTable().destroy()
    var dataTable = $('#employee_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": true,
        "bInfo":true,
        "order" : [],

        "ajax" : {
            url: "php_repository/admin_dataTable.php",
            type: "POST",
            data:{
                action:'Employee_Table'
                // dateval:date,
                // setter:setter
            }
        },
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-primary' },
            { extend: 'csvHtml5', className: 'btn btn-outline-primary' },
            { extend: 'excelHtml5', className: 'btn btn-outline-primary' },
            { extend: 'pdfHtml5', className: 'btn btn-outline-primary' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}

function PlateTable(){
    $('#plate_tbl').DataTable().destroy()
    var dataTable = $('#plate_tbl').DataTable({
    
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "bSort": true,
        "bInfo":true,
        "order" : [],

        "ajax" : {
            url: "php_repository/admin_dataTable.php",
            type: "POST",
            data:{
                action:'Plate_Table'
                // dateval:date,
                // setter:setter
            }
        },
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copyHtml5', className: 'btn btn-outline-primary' },
            { extend: 'csvHtml5', className: 'btn btn-outline-primary' },
            { extend: 'excelHtml5', className: 'btn btn-outline-primary' },
            { extend: 'pdfHtml5', className: 'btn btn-outline-primary' }
            
        ],
    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
    })
}