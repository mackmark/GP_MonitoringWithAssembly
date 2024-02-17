$(document).ready(function () {
    navdate()
});

function navdate(){
    $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "../php_repository/index_repo.php",
        data: {
            action:'NavDate'
        },
        success: function (data) {
            $('#navdate').text(data.navdate)
            $('#scrapActual').val(data.default)
            $('#date_report').val(data.default)
            ReportTable(data.default, 1)
            HalfDTable(data.default, 1)
            HalfNTable(data.default, 1)
            WholeTable(data.default, 1)
            // chart1("chart1", data.default)b
        }
    });
}
$('#UserWorkstation').on('change', function(e){
    e.preventDefault()
    var date = $('#date_report').val()
    var userid = $(this).val()

    ReportTable(date, userid)
    HalfDTable(date, userid)
    HalfNTable(date, userid)
    WholeTable(date, userid)

})
    

$('#date_report').on('change', function(){
    var userid = $('#UserWorkstation').val()
    ReportTable($(this).val(), userid)
    HalfDTable($(this).val(), userid)
    HalfNTable($(this).val(), userid)
    WholeTable($(this).val(), userid)
    // location.href = "?date="+$(this).val()
})

$('#reload').on('click', function(e){
    e.preventDefault()
    var userid = $('#UserWorkstation').val()
    var date = $('#date_report').val()
    ReportTable(date, userid)
    HalfDTable(date, userid)
    HalfNTable(date, userid)
    WholeTable(date, userid)
})

