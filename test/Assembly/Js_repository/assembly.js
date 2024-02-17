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
            AssemblyReportTable('', '', 1)
            // chart1("chart1", data.default)b
        }
    });
}

function AssemblyReportTable(dateFrom, dateTo, setter){
    var FromDate = dateFrom
    var ToDate = dateTo
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
                FromDate:FromDate,
                ToDate:ToDate,
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

$('#filterDateOption').on('change', function(e){
    e.preventDefault();
    var value = $(this).val()

    var DateFrom = $('#DateFrom').val()
    var DateTo = $('#DateTo').val()
    var resultID = $('#result').val()

    if(value == 5){
        $('#dateRangeFilter').removeClass('d-none');
    }
    else if(value == 1){
        $('#dateRangeFilter').addClass('d-none');
    }

    AssemblyReportTable(DateFrom, DateTo, value)
})

$('#DateFrom').on('change', function(){
    var filterDateOptionID = $('#filterDateOption').val()
    var DateFrom = $(this).val()
    var DateTo = $('#DateTo').val()

    AssemblyReportTable(DateFrom, DateTo, filterDateOptionID)
})

$('#DateTo').on('change', function(){
    var filterDateOptionID = $('#filterDateOption').val()
    var DateFrom = $('#DateFrom').val()
    var DateTo = $(this).val()

    AssemblyReportTable(DateFrom, DateTo, filterDateOptionID)
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