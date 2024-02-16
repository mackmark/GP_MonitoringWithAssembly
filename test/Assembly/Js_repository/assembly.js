$(document).ready(function () {
    navdate()
});

function navdate(){
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/assembly.php",
        data: {
            action:'NavDate'
        },
        success: function (data) {
            $('#navdate').text(data.navdate)
            $('#scrapActual').val(data.default)
            $('#date_report').val(data.default)
            $('#hiddenDate').val(data.default)
            AssemblyReportTable(data.default, 1, 1)
            // chart1("chart1", data.default)b
        }
    });
}

function AssemblyReportTable(dateVal, userID, setter){
    var date = dateVal
    var userid = userID
    var setterId = setter

    $('#AssemblyReport_tbl').DataTable().destroy()
    var dataTable = $('#AssemblyReport_tbl').on('error.dt', function (e, settings, techNote, message) {
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
            url: "php_repository/assembly.php",
            type: "POST",
            // contentType: "application/json; charset=utf-8",
            dataType: 'JSON',
            data:{
                action:'AssemblyReport_Table',
                dateval:date,
                userid:userid,
                setterId:setterId
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

$('#filterData').on('change', function(e){
    e.preventDefault();
    var date = $('#hiddenDate').val()
    var value = $(this).val()
    AssemblyReportTable(date, 1, value)
})

function ViewData(lotNumber){
    var LotNumber = lotNumber
    // alert(LotNumber)
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/assembly.php",
        data: {
            action:'RunDetails',
            LotNumber:LotNumber
        },
        success: function (data) {
            $('#RunDetails').html(data)
            $('#modalViewAssembly').modal('show')
        }
    });
    
}