
$(document).ready(function () {
    GetUser()
    getSetStation()
    $('#switch_txt').text('OSI & CAT')
    $('#processtxt').text('OSI & CAT')
    getter('OSI & CAT')
    navdate()
    navdate_scrap()
    Line()
    Plate()
    OxideType()
    Batch()
    Paster()
    Stacker()
    Shift()
    //------------------Inialize value for incrementing sheetNo-------------
    // SheetNo(712)
    //------------------Inialize value for incrementing sheetNo End----------
    // startWorker()
    sheetNoPrint()
    LotNoPrint() 
});

async function GetUser(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'usergetter'
        },
        success: function (data) {
            var result = JSON.parse(data)

            if(result==0){
                $('#userselection').modal('show')
            }
        }
    });
}

async function selectUser(){
    var userID = $('#userselect').val()
    if(userID != null){
        const action = await $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php_repository/index_repo.php",
            data: {
                action:'usersetter',
                userID:userID
            },
            success: function (data) {
                getter('OSI & CAT')
                setTimeout(() => {
                    location.href = "index.php"
                }, 2000);
                
            }
        });
    }
    else{
        alert("Please identify your production role")
    }
    
}


async function getter(process){
    var processtxt = process

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'getter',
            process:processtxt
        },
        success: function (data) {
            var count = JSON.parse(data.count)

            if(count !=0){
                GetOnTray(data.sheetID)
            }
            else{
                AddSheet()
            }
            LockCuringSelection(data.sheetID)
            checkNullItem(data.sheetID)
        }
    });
}

async function checkNullItem(sheetID){
    
    const action = $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'CheckNullItem',
            sheetID:sheetID
        },
        success: function (data) {
            $('#curingboothNo').val(data)
            $('#curingboothNoHide').val(data)
        }
    });
}

$('#shiftPage').on('click', function(e){
    e.preventDefault()
    var date = $('#scrapActual').val()
    cardCounter()
    navdate_scrap()
    Line_reject()
    Plate_reject()
    Shift_reject()
    ScrapTable(date, 0)
    $('#AddReject').modal("show")
})

async function getSetStation(){
    const station = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'station'
        },
        success: function (data) {
            $('#station').text("Station : "+data.StationName)
        }
    });
}

$('#shiftreject').on('change',function(e){
    e.preventDefault()
    totalChange()
})

$('#linereject').on('change',function(e){
    e.preventDefault()
    totalChange()
})

$('#platetypereject').on('change',function(e){
    e.preventDefault()
    totalChange()
})

$('#scrapActual').on('change',function(e){
    e.preventDefault()
    var date = $(this).val()
    totalChange()
    ScrapTable(date)
    cardCounter()
})

async function totalChange(){
    var shift = $('#shiftreject').val()
    var line = $('#linereject').val()
    var platetype = $('#platetypereject').val()
    var date = $('#scrapActual').val()

    // var SRPlate = $('#srplate').val()
    // var SRPaste = $('#srpaste').val()
    // var Trimmings = $('#trimmings').val()

    if(shift != null && line != null && platetype !=null){
        const action = await $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php_repository/index_repo.php",
            data: {
                action:'totalChange',
                shiftval:shift,
                lineval:line,
                platetype:platetype,
                dateval:date
            },
            success: function (data) {
                $('#outputreject').val(data.totalStr)
                $('#outputrejecthide').val(data.total)
            }
        });
    }

}

async function submitScrap(){
    var shift = $('#shiftreject').val()
    var line = $('#linereject').val()
    var platetype = $('#platetypereject').val()
    var date = $('#scrapActual').val()

    var SRPlate = $('#srplate').val()
    var SRPaste = $('#srpaste').val()
    var Trimmings = $('#trimmings').val()

    var outputtotal = $('#outputrejecthide').val()

    if(outputtotal != 0){
        const action = await $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php_repository/index_repo.php",
            data: {
                action:"submitScrap",
                shift:shift,
                line:line,
                platetype:platetype,
                date:date,
                SRPlate:SRPlate,
                SRPaste:SRPaste,
                Trimmings:Trimmings,
                outputtotal:outputtotal
            },
            success: function (data) {
                var result = JSON.parse(data)
                if(result==1){
                    swal({
                        title: "Successful",
                        text: "Scrap data has been saved!",
                        icon: "success",
                        buttons: false,
                        dangerMode: true,
                    })
                    $('#outputreject').val("")
                    $('#srplate').val("")
                    $('#srpaste').val("")
                    $('#trimmings').val("")
                    $('#outputrejecthide').val(0)
                    $('#outputreject').val(0)
                    ScrapTable(date)
                    cardCounter()
                    Line_reject()
                    Plate_reject()
                    Shift_reject()
                }
                else if(result == 2){
                    swal({
                        title: "Successful",
                        text: "Data updated!",
                        icon: "success",
                        buttons: false,
                        dangerMode: true,
                    })
                    $('#outputreject').val("")
                    $('#srplate').val("")
                    $('#srpaste').val("")
                    $('#trimmings').val("")
                    $('#outputrejecthide').val(0)
                    $('#outputreject').val(0)
                    ScrapTable(date)
                    cardCounter()
                    Line_reject()
                    Plate_reject()
                    Shift_reject()
                }
                else{
                    swal({
                        title: "Error!",
                        text: "Something wrong Erro x14500",
                        icon: "error",
                        buttons: false,
                        dangerMode: true,
                    })
                }
                
            }
        });
    }
    else{
        swal({
            title: "No Data",
            text: "Please select item to reject",
            icon: "error",
            buttons: false,
            dangerMode: true,
        })
    }

    
}

async function cardCounter(){
    var date = $('#scrapActual').val()
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'cardCounter',
            date:date
        },
        success: function (data) {
            var valWholeday = 0;
            var val12HDay = 0;
            var val12NDay = 0;
            if(data.WholeDay!=null){
                valWholeday = data.WholeDay
            }

            if(data.Day12H != null){
                val12HDay = data.Day12H;
            }

            if(data.Day12N != null){
                val12NDay = data.Day12N;
            }

            $('#wholeday').html(valWholeday)
            $('#Day12H').html(val12HDay)
            $('#Day12N').html(val12NDay)
        }
    });
}


$('#scrapCategory').on('change', function(){
    var summary = $(this).val()
    var date = $('#scrapActual').val()

    if(summary==1){
         ScrapTable(date)
    }
    else{
        ScrapTableSummary(date)
    }
})

$('#switch').click(function(){
    if($(this).prop("checked") == true){
        console.log("Checkbox is checked.");
        $('#switch_txt').text('OSI & CAT');
        $('#processtxt').text('OSI & CAT')
        CurringBoothSelection('OSI & CAT')
        getter('OSI & CAT')
        // checkProcess()
    }
    else if($(this).prop("checked") == false){
        console.log("Checkbox is unchecked.");
        $('#switch_txt').text('Tunnel');
        $('#processtxt').text('Tunnel')
        CurringBoothSelection('Tunnel')
        getter('Tunnel')
        // checkProcess()
    }
    ProcessShifter()
    Line()
    SetToNull()
});

async function updateProcess(processTxt){
    var SheetNoVal = $('#sheetNo').text()
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'updateProcess',
            process:processTxt,
            sheetTxt:SheetNoVal
        },
        success: function (data) {
            var result = JSON.parse(data.result);
            if(result==1){
                console.log("Updated!");
                $('#processtxt').text(data.process)
                if($('#processtxt').text()=="OSI & CAT"){
                    $('#switch').prop("checked") == true
                    $('#switch_txt').text('OSI & CAT')
                    // checkforProcess('OSI & CAT')
                }
                else{
                    $('#switch').prop("checked") == false
                    $('#switch_txt').text('Tunnel')
                    // checkforProcess('Tunnel')
                }
            
                console.log(SheetNoVal)
                LockCuringSelection()
            }
            else{
                console.log("Error!");
            }
        }
    });
}

async function getSheetNo(clientID, process){
    // alert(process)
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'getSheet',
            clientID:clientID,
            process:process
        },
        success: function (data) {
            GetOnTray(data)
        }
    });
}

async function navdate(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'NavDate'
        },
        success: function (data) {
            $('#navdate').text(data.navdate)
            // $('#scrapActual').val(data.default)
        }
    });
}

async function navdate_scrap(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'NavDate'
        },
        success: function (data) {
            // $('#navdate').text(data.navdate)
            $('#scrapActual').val(data.default)
            totalChange()
            ScrapTable(data.default)
            cardCounter()
        }
    });
    
}

async function CurringBoothSelection(processtxt){
    var process =  processtxt;

    // alert(process)

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'curingBoothSelection',
            process:process
        },
        success: function (data) {
            $('#curringbooth').html(data)
        }
    });
}

async function Line(){
    var Processtxt = $('#processtxt').text()
    var setterID = 0;
    if($('#changePolarity').prop("checked") == true){
        setterID = 1;
    }
    else if($('#changePolarity').prop("checked") == false){
        setterID = 0;
    }
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'line',
            ProcessVal:Processtxt,
            setterID:setterID
        },
        success: function (data) {
            $('#line').html(data.output)
            var setter = JSON.parse(data.setter)

            if(setter==1){
                $('#changePolarityText').text('Positive?')
            }
            else if(setter==2){
                $('#changePolarityText').text('Negative?')
            }
            else if(setter==3){
                $('#changePolarityContainer').addClass('d-none')
            }
        }
    });
}

async function Line_reject(){
    var Processtxt = $('#processtxt').text()
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'lineReject',
            ProcessVal:Processtxt
        },
        success: function (data) {
            $('#linereject').html(data)
        }
    });
}

async function Plate(){
    var lineID = $('#line').val()
    // alert(lineID)
    // alert(setter)
    if(lineID != null){
        $('#plate').prop('disabled', false)
        const action = await $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php_repository/index_repo.php",
            data: {
                action:'plate',
                lineID:lineID
            },
            success: function (data) {
                $('#plate').html(data)
            }
        });
    }
    else{
        $('#plate').prop('disabled', true)
    } 
}

$('#changePolarity').click(function(){
    Line()
});

async function Plate_reject(){
    var lineID = $('#linereject').val()

    if(lineID != null){
        $('#plate').prop('disabled', false)
        const action = await $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php_repository/index_repo.php",
            data: {
                action:'plate',
                lineID:lineID
            },
            success: function (data) {
                $('#platetypereject').prop('disabled', false)
                $('#platetypereject').html(data)
            }
        });
    }
    else{
        $('#platetypereject').prop('disabled', true)
    }
}

$('#linereject').on('change', function(){
    Plate_reject()
})

async function OxideType(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'oxide'
        },
        success: function (data) {
            $('#Oxide').html(data)
        }
    });
}

async function Batch(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'batch'
        },
        success: function (data) {
            $('#Batch').html(data)
        }
    });
}

async function Paster(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'paster'
        },
        success: function (data) {
            $('#paster').html(data)
        }
    });
}

async function Stacker(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'stacker'
        },
        success: function (data) {
            $('#stacker').html(data)
        }
    });
}

async function Shift(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'shift'
        },
        success: function (data) {
            $('#Shift').html(data)
        }
    });
}

async function Shift_reject(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'shift'
        },
        success: function (data) {
            $('#shiftreject').html(data)
        }
    });
}

function BoothProcess(){
    $('#CuringBoothProcess').html('<span class="text-muted" style="font-size:13px;">Curing Booth <span class="badge badge-primary" style="font-size:17px;" ><i class="fas fa-spinner fa-spin"></i></span></span>')
}

$('#curringbooth').on('change', async function(e){
    e.preventDefault()
    var booth = $('#curringbooth').val()

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'processSummarry',
            boothId:booth
        },
        success: function (data) {
            $('#CuringBoothProcess').html('<span class="text-muted" style="font-size:13px;">Curing Booth <span class="badge badge-primary" style="font-size:17px;" >'+data+'</span></span>')
            // LockCuringSelection()
            CuringBoothNo()
        }
    });
    
})


$('#line').on('change', function(){
    LotNo(0)
    Plate()
})

async function SheetNo(value){
    var inializeValue = value

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'sheetNo',
            IncrementValue:inializeValue
        },
        success: function (data) {
            $('#sheetNo').text(data)
            // IncompleteTray(data)
            ProcessShifter()
            SheetTable(data)
            LockCuringSelection()   
        }
    });
}

async function IncompleteTray(SheetNo){
    var SheetNoTxt = SheetNo
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'Incomplete',
            SheetNoVal:SheetNoTxt
        },
        success: function (data) {
            $('#IncTray').html(data)
            setTimeout(() => {
                CuringBoothNo()
            }, 1000);
            
        }
    });
    LockCuringSelection()
}

async function AddSheet(){
    var processTxt = $('#processtxt').text()
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'AddSheet',
            processVal:processTxt,
        },
        success: function (data) {
            var ressult = JSON.parse(data.result)
            if(ressult==1){
                swal({
                    title: "New Sheet Added",
                    text: "Sheet Number: "+data.SheetNo,
                    icon: "info",
                    buttons: false,
                    dangerMode: true,
                })
            }
            SheetNo(0)
            Line()
            Plate()
            OxideType()
            Batch()
            Paster()
            Stacker()
            Shift()
            $('#Rack').val('')
        }
    });
}

async function LotNo(LotNoInializeValue){
    var InializeValue = 0
    var LineID = $('#line').val()

    if(LineID != null){
        const action = await $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "php_repository/index_repo.php",
            data: {
                action:'lotNo',
                initializeVal:InializeValue,
                LineID:LineID
            },
            success: function (data) {
                $('#LotNumber').val(data)
                // alert(data)
            }
        });
    }
    
}

function ProcessShifter(){
    var ActiveSheetNo = $('#sheetNo').text()
    var ActiveProcess = $('#processtxt').text()
    CurringBoothSelection(ActiveProcess)

    BoothProcess()
    // alert(ActiveProcess+' - '+ActiveSheetNo)
}

async function CuringBoothNo(){
    var CuringBooth = $('#curringbooth').val()
    var ActiveSheetNo = $('#sheetNo').text()

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'curingBoothNo',
            CuringBoothVal:CuringBooth,
            ActiveSheetNoVal:ActiveSheetNo
        },
        success: function (data) {
            $('#curingboothNo').val(data)
            $('#curingboothNoHide').val(data)
        }
    });
    
}

async function LockCuringSelection(sheetNo){
    var CuringBooth = $('#curringbooth').val()
    var ActiveSheetNo = sheetNo
    var setter = 0;
    var ActiveProcess = $('#processtxt').text()
    

    if(CuringBooth == null){
        setter = 0;
    }
    else{
        setter = CuringBooth;
    }

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'lockCuringBooth',
            CuringBooth:setter,
            ActiveSheetNo:ActiveSheetNo,
            ActiveProcess:ActiveProcess
        },
        success: function (data) {
            var result = JSON.parse(data.result)
            var count = JSON.parse(data.count)
            
            if(result==1 && count > 0){

                $('#curringbooth').html(data.output)
                $("#curringbooth").attr('disabled', 'disabled');
            }
            else{
                CurringBoothSelection(ActiveProcess)
                $("#curringbooth").prop('disabled', false);
            }
            // alert(data.Active+'-'+data.SheetNo+'-'+result+'-'+count)
        }
    });
    
}

function SetToNull(){
    setTimeout(() => {
        $('#curingboothNo').val('')
        $('#curingboothNoHide').val('')
    }, 500);
}

function AddSheetDetail(){
    var SheetNo = $('#sheetNo').text()
    var Processtxt = $('#processtxt').text()
    var CurringBooth = $('#curringbooth').val()
    var CuringBoothNoHide = $('#curingboothNoHide').val()
    var shift = $('#Shift').val()
    var LineID = $('#line').val()
    var PlateTypeID = $('#plate').val()
    var OxideTypeID = $('#Oxide').val()
    var RackNo = $('#Rack').val()
    var BatchNo = $('#Batch').val()
    var SteamHoodNo = $('#SteamHood').val()
    var LotNumber = $('#LotNumber').val()
    var Quantity = $('#qty').val()
    var MoisetureContent = $('#moise').val()
    var PasterEmpID = $('#paster').val()
    var StackerEmpID = $('#stacker').val()

    // alert(SheetNo+' - '+Processtxt+' '+CurringBooth+' '+CuringBoothNoHide+' '+shift+' '+LineID+' '+PlateTypeID+' '+OxideTypeID+' '+RackNo+' '+BatchNo+' '+SteamHoodNo+' '+LotNumber+' '+Quantity+' '+MoisetureContent+' '+PasterEmpID+' '+StackerEmpID)
    if(CurringBooth == null || shift == null || LineID == null || PlateTypeID == null || OxideTypeID == null || PasterEmpID == null || StackerEmpID == null || BatchNo == null){
        swal({
            title: "Selection",
            text: "Please select and complete all field ",
            icon: "error",
            buttons: false,
            dangerMode: true,
        })
    }
    else if(RackNo == ''){
        swal({
            title: "Rack No.",
            text: "Please provide a value for Rack Number ",
            icon: "error",
            buttons: false,
            dangerMode: true,
        })
    }
    else if(Quantity <= 0 || MoisetureContent <= 0){
        swal({
            title: "NO zero value",
            text: "Please enter a valid value for Quantity and Moiseture Content ",
            icon: "error",
            buttons: false,
            dangerMode: true,
        })
    }
    else{
        $('#confirmModal').modal('show')
        getPlateTypeText(PlateTypeID)
        getLineText(LineID)
        $('#qtyHolder').text(numberWithCommas(Quantity )+" pcs")
        $('#lineHolder').text($('#platetxtHolder').val())
        $('#plateHolder').text($('#platetxtHolder').val())
    }
    
}

async function AddDetailModal(){
    $('#btnconfirm').prop('disabled', true)
    var SheetNo = $('#sheetNo').text()
    var Processtxt = $('#processtxt').text()
    var CurringBooth = $('#curringbooth').val()
    var CuringBoothNoHide = $('#curingboothNoHide').val()
    var shift = $('#Shift').val()
    var LineID = $('#line').val()
    var PlateTypeID = $('#plate').val()
    var OxideTypeID = $('#Oxide').val()
    var RackNo = $('#Rack').val()
    var BatchNo = $('#Batch').val()
    var SteamHoodNo = $('#SteamHood').val()
    var LotNumber = $('#LotNumber').val()
    var Quantity = $('#qty').val()
    var MoisetureContent = $('#moise').val()
    var PasterEmpID = $('#paster').val()
    var StackerEmpID = $('#stacker').val()

    var holder = "";

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data:{
            action:'AddSheetDetail',
            SheetNoVal:SheetNo,
            ProcesstxtVal:Processtxt,
            CurringBoothVal:CurringBooth,
            CuringBoothNoHideVal:CuringBoothNoHide,
            shiftVal:shift,
            LineIDVal:LineID,
            PlateTypeIDVal:PlateTypeID,
            OxideTypeIDVal:OxideTypeID,
            RackNoVal:RackNo,
            BatchNoVal:BatchNo,
            SteamHoodNoVal:SteamHoodNo,
            LotNumberVal:LotNumber,
            QuantityVal:Quantity,
            MoisetureContentVal:MoisetureContent,
            PasterEmpIDVal:PasterEmpID,
            StackerEmpIDVal:StackerEmpID
        },
        success: function (data) {
            // alert(data)
            var result = JSON.parse(data.result)
            if(result==1){
                console.log('Eror!')
            }
            else if(result==2){
                holder = data.lotnumber
                GenerateQR(data.lotnumber)
                Batch()
                $('#Rack').val('')
                OxideType()
                // Line()
                $('#LotNumber').val('---')
                $('#qty').val(0)
                $('#moise').val(0)
                // checkProcess()

                getter(Processtxt)
                CuringBoothNo()
                LotNo(10201)

                SheetTable(SheetNo)
                sheetNoPrint()
                LotNoPrint()

                $('#btnconfirm').prop('disabled', false)
                $('#confirmModal').modal('hide')
            }
        }
    });

    setTimeout(() => {
        print_lotnumber(holder)
    }, 2000);
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

async function getPlateTypeText(id){
    var plateTypeID = id
    var platetype = ""

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'getPlateTxt',
            plateTypeID:plateTypeID
        },
        success: function (data) {
            console.log(data)
            $('#plateHolder').text(data)
        }
    });
    
}

async function getLineText(id){
    var lineID = id
    

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'getLineTxt',
            lineID:lineID
        },
        success: function (data) {
            console.log(data)
            $('#lineHolder').text(data)
        }
    });
}

$('#qty').keyup(function () { 
    if($('#qty').val() < 0){
        $('#qty').val('')
    }
    else{
        var strNumber = $('#qty').val()  
        var number  = strNumber.replace(/^0+/, '');
        $('#qty').val(number)
    }
});

$('#moise').keyup(function () { 
    if($('#moise').val() < 0){
        $('#moise').val('')
    }
    // else{
    //     var strNumber = $('#moise').val()  
    //     var number  = parseFloat(strNumber);
    //     $('#moise').val(number)
    // }
});

async function GetOnTray(SheetID){
    var SheetValID = SheetID
    var SheetNotxt = $('#sheetNo').text()

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'getOnTray',
            SheetNo:SheetValID,
            SheetNoVal:SheetNotxt
        },
        success: function (data) {
            // alert(data.SheetNo+' '+data.ProcessID+' '+data.Process)

            $('#processtxt').text(data.Process)
            $('#sheetNo').text(data.SheetNo)
            if($('#processtxt').text()=="OSI & CAT"){
                $('#switch').prop("checked") == true
                $('#switch_txt').text('OSI & CAT')
                // checkProcess()
            }
            else{
                $('#switch').prop("checked") == false
                $('#switch_txt').text('Tunnel')
                // checkProcess()
            }
            // checkProcess()
            // GenerateQR(data.SheetNo)
            SheetTable(data.SheetNo)
            Line()
        }
    });
}

async function complete(){
    var sheetNo = $('#sheetNo').text()

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'checkItems',
            sheetcheck:sheetNo
        },
        success: function (data) {
            var result = JSON.parse(data.result);

            if(result==1){
                swal({
                    title: "No Data",
                    text: "Please provide data first",
                    icon: "info",
                    buttons: false,
                    dangerMode: true,
                })
            }
            else if(result==2){
                swal({
                    title: "Moisture Content - Zero Value",
                    text: "System destect a zero value moisture content",
                    icon: "error",
                    buttons: false,
                    dangerMode: true,
                })
            }
            else if(result==3){
                swal({
                    title: data.SheetNo+" data entry confirmation",
                    text: "Do you want to continue?",
                    icon: "warning",
                    dangerMode: true,
                    buttons:{
                        cancel: "No",
                        ok: "Yes"
                    },
                    
                })
                .then((complete) => {
                    if (complete) {

                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "php_repository/index_repo.php",
                            data: {
                                action:'complete',
                                SheetNoVal:data.SheetNo
                            },
                            success: function (data2) {
                                var result = JSON.parse(data2.result);
                                if(result == 1){
                                    SheetNo(data2.result)
                                    // IncompleteTray(data.sheetNo)
                                    $('#curingboothNo').val('---')
                                    $('#LotNumber').val('---')
                                    $('#Rack').val('')
                                    Line()
                                    Plate()
                                    OxideType()
                                    Batch()
                                    $('#LotNumber').val('---')
                                    $('#qty').val(0)
                                    $('#moise').val(0)
                                    Paster()
                                    Stacker()
                                    Shift()
                                    sheetNoPrint()
                                    LotNoPrint()
                                    CompletePrint()
                                    AddSheet()
                                    // CuringBoothNo()
                                    // LotNo(10201)
                                }
                                else{
                                    swal({
                                        title: "Error",
                                        text: "Can't proceed to this action",
                                        icon: "error",
                                        buttons: false,
                                        dangerMode: true,
                                    })
                                }
                            }
                        });
                    }

                })
            }

        }
    });

    

}

async function sheetNoPrint(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data:{
            action:'sheetNoPrint'
        },
        success: function (data) {
            $('#SheetNoPrint').html(data)
        }
    });
}

async function LotNoPrint(){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data:{
            action:'lotNoPrint'
        },
        success: function (data) {
            $('#LotNoPrint').html(data)
        }
    });
}

async function editItemModal(id){
    var sheetDetailID = id
    $('#editLotNumber').modal('show')
    $('#Idholder').val(sheetDetailID)

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'openModal',
            sheetdetailID:sheetDetailID
        },
        success: function (data) {
            $('#Edit_sheetNo').val(data.SheetNo)
            $('#Edit_lotNo').val(data.LotNo)
            $('#Edit_qty').val(data.qty_val)
            $('#Edit_moise').val(data.MC_val)
            $('#Edit_rack').val(data.RackNo)

            $('#qty_lbl').html("<span class='text-muted' style='font-weight:bold;'>Quantity |</span> <span class='text-success' style = 'font-weight:bold;font-size:15px;'>"+data.Qty+"</span>")

            if(data.MC_val != 0){
                $('#moise_lbl').html("<span class='text-muted' style='font-weight:bold;'>Moisture Content |</span> <span class='text-success' style = 'font-weight:bold;font-size:15px;'>"+data.MC+"</span>")
            }
            else{
                $('#moise_lbl').html("<span class='text-muted' style='font-weight:bold;'>Moisture Content |</span> <span class='text-danger' style = 'font-weight:bold;font-size:15px;'>"+data.MC+"</span>")
            }


            shiftEdit(data.Shift)
            plateTypeEdit(data.PlateType)
            lineEdit(data.Line)
        }
    });

}

async function shiftEdit(shift){
    var ActiveShift = shift

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'EditShift',
            ActiveShift:ActiveShift
        },
        success: function (data) {
            $('#Edit_shift').html(data)
        }
    });
}

async function plateTypeEdit(plate){
    var ActivePlate = plate

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'EditPlateType',
            ActivePlateType:ActivePlate
        },
        success: function (data) {
            $('#Edit_platetype').html(data)
        }
    });
}

async function lineEdit(line){
    var ActiveLine = line

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'EditLine',
            ActiveLine:ActiveLine
        },
        success: function (data) {
            $('#Edit_line').html(data)
        }
    });
}

async function update(){
    var Shift = $('#Edit_shift').val()
    var PlateType = $('#Edit_platetype').val()
    var Qty = $('#Edit_qty').val()
    var MC = $('#Edit_moise').val()
    var sheetDetailID = $('#Idholder').val()
    var sheetNo = $('#Edit_sheetNo').val()
    var Line = $('#Edit_line').val()
    var RackNo = $('#Edit_rack').val()

    // alert(Shift+ " "+PlateType+" "+Qty+" "+MC)

    if(Qty <= 0 || Qty == null){
        alert("Qty should not be zero or blank")
    }
    else if(MC <= 0 || MC == null){
        alert("Moiseture Content should not be zero or blank")
    }
    else{
        const action = await $.ajax({
            type: "POST",
            url: "php_repository/index_repo.php",
            dataType: "JSON",
            data: {
                action:'update',
                sheetdetailId:sheetDetailID,
                shift:Shift,
                platetype:PlateType,
                qty:Qty,
                mc:MC,
                Line:Line,
                RackNo:RackNo

            },
            success: function (data) {
                var result = JSON.parse(data)
                if(result==1){
                    swal({
                        title: "Successful",
                        text: "Data has been updated",
                        icon: "success",
                        buttons: false,
                        dangerMode: true,
                        timer:1000
                    })
                }
                else{
                    swal({
                        title: "Something went wrong",
                        text: "Error detection",
                        icon: "error",
                        buttons: false,
                        dangerMode: true,
                        timer:1000
                    })
                }
                $('#Edit_qty').val(0)
                $('#Edit_moise').val(0)
                SheetTable(sheetNo)
                $('#editLotNumber').modal('hide')
            }
        });
    }
}

async function print_lotnumber(lotnumber){
    var setter_id = lotnumber

    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "assets/FPDF/LotNumberTest.php",
        data: {
            lot_id:setter_id
        },
        success: function (data) {
            setter_id = data
            $('#loadPrintModal').modal('show');
        }
    });

    setTimeout(() => {
        $('#loadPrintModal').modal('hide');
        printPdf(setter_id)
    }, 3000);

}

async function GenerateQR(lotnumber){
    $('#qr').empty();

    $('#qr').qrcode({
        width: 100,
        height: 100,
        text: lotnumber
    })

    var canvas = document.querySelector("#qr canvas");
    var dataURL = canvas.toDataURL("image/png");
    console.log(dataURL);

    // $('#my_image').attr('src',dataURL);
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'qr',
            lotnumber:lotnumber,
            qrURL:dataURL
        },
        success: function (data) {
            var result = JSON.parse(data.result)

            if(result==1){
                console.log("Insert")
                console.log(data.imageData)
            }
            else{
                console.log("Error")
            }
        }
    });
}

function LotPrint(){
    var LotNo = $('#LotNoPrint').val()
    if(LotNo !=null){

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "assets/FPDF/SelectLotTest.php",
            data: {
                lotID:LotNo
            },
            success: function (data) {
                LotNo = data
                $('#loadPrintModal').modal('show');
            }
        });

        setTimeout(() => {
            $('#loadPrintModal').modal('hide');
            printPdf(LotNo)
        }, 3000);

        

    }
    else{
        swal({
            title: "Info",
            text: "Please select Lot Number",
            icon: "info",
            buttons: false,
            dangerMode: true,
        })
    }
    
}

function printPdf(lotNo){
    printJS('PBI-GP_Monitoring/test/system_file/'+lotNo+'print.pdf')
}

function printSheetPdf(lotNo){
    printJS('PBI-GP_Monitoring/test/system_file/Sheet'+lotNo+'print.pdf')
}

function printCompletePdf(lotNo){
    printJS('PBI-GP_Monitoring/test/system_file/'+lotNo+'.pdf')
}

function SheetPrint(){
    var SheetNo = $('#SheetNoPrint').val()
    if(SheetNo !=null){
        // var url = '../assets/FPDF/SheetNoPrintTest.php?SheetID='+SheetNo;
        // // window.open(url);
        // window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=no,top=50,right=150,width=400,height=400");

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "assets/FPDF/SheetNoPrintTest.php",
            data: {
                SheetID:SheetNo
            },
            success: function (data) {
                SheetNo = data
                $('#loadPrintModal').modal('show');
            }
        });

        setTimeout(() => {
            $('#loadPrintModal').modal('hide');
            printSheetPdf(SheetNo)
        }, 3000);
    }
    else{
        swal({
            title: "Info",
            text: "Please select Sheet Number",
            icon: "info",
            buttons: false,
            dangerMode: true,
        })
    }
    
}

function CompletePrint(){
    var SheetNo = $('#sheetNo').text()

    if(SheetNo !=null){
        // var url = '../assets/FPDF/SheetNoPrintTest.php?SheetID='+SheetNo;
        // // window.open(url);
        // window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=no,top=50,right=150,width=400,height=400");

        $.ajax({
            type: "POST",
            dataType: "JSON",
            url: "assets/FPDF/CompleteTest.php",
            data: {
                SheetID:SheetNo
            },
            success: function (data) {
                SheetNo = data
                $('#loadPrintModal').modal('show');
            }
        });

        setTimeout(() => {
            $('#loadPrintModal').modal('hide');
            printCompletePdf(SheetNo)
        }, 3000);
    }
    else{
        swal({
            title: "Info",
            text: "Please select Sheet Number",
            icon: "info",
            buttons: false,
            dangerMode: true,
        })
    }
}

function HDay(){
    var setter = 1
    var date = $('#scrapActual').val()
    ScrapTable(date, setter)
}

function NDay(){
    var setter = 2
    var date = $('#scrapActual').val()
    ScrapTable(date, setter)
}

function WDay(){
    var setter = 0
    var date = $('#scrapActual').val()
    ScrapTable(date, setter)
}

async function process(booth){
    const action = await $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "php_repository/index_repo.php",
        data: {
            action:'booth',
            booth:booth
        },
        success: function (data) {
            $('#CuringBoothProcess').html('<span class="text-muted" style="font-size:13px;">Curing Booth <span class="badge badge-primary" style="font-size:17px;" >'+data+'</span></span>')
        }
    });
}

function AddRefresh(){
    Paster()
    Stacker()

    swal({
        title: "Data is refresh",
        text: "Data is refresh ",
        icon: "success",
        buttons: false,
        dangerMode: true,
    })
    $.ajax({
        type: "POST",
        url: "php_repository/index_repo.php",
        data: {
            action:'email'
        },
        // dataType: "dataType",
        success: function (data) {
            // console.log(data)
        }
    });
}

//---------Worker JS------------
function startWorker() {
    if(typeof(Worker) !== "undefined") {
        if(typeof(w) == "undefined") {
            w = new Worker("js_repository/worker.js")
             }
            w.onmessage = function(event) {
            // var setter = $('#result').val(event.data)
            // workweek_adjust()
            navdate()
            // LotNo(10201)
            // LotNo(10201)
            
            var booth = $('#curringbooth').val()
            if(booth != null){
                process(booth)
            }
            else{
                BoothProcess()
            }
            CuringBoothNo()
            

            console.log("print")
        }
    } else {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Workers..."
    }
}

function stopWorker() { 
    w.terminate()
    w = undefined
}
//---------Worker JS End---------