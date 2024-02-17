$(document).ready(function(){
  EmployeeTable()
  PlateTable()
})


$('#login').on('click', async function(e){
    e.preventDefault()

    var uname = $('#uname').val()
    var password = $('#pass').val()

    if(uname != "" && password != ""){
        const action = await $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "php_repository/admin_repo.php",
          data: {
            action:'login',
            uname:uname,
            password:password
          },
          success: function (data) {
            var result = JSON.parse(data)

            if(result == 1){
              location.href='admin.php';
            }
          }
        });
    }
    else{
      swal({
          title: "Incomplete",
          text: "Please complete all field ",
          icon: "error",
          buttons: false,
          dangerMode: true,
      })
    }
})

//Manage employee

async function view(id){
  
  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
      action:'view',
      id:id
    },
    success: function (data) {
      $('#modalView').modal("show");
      $('#ViewContainer').html(data)
    }
  });
}

async function edit(id){

  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
      action:'edit',
      id:id
    },
    success: function (data) {
      $('#modalEdit').modal("show");
      $('#Lname').val(data.lastname)
      $('#Fname').val(data.firstname)
      $('#Mname').val(data.middlename)
      $('#Nname').val(data.nickname)
      $('#idHolder').val(id)

      console.log(data.paster+' '+data.stacker)

      if(data.paster==0 && data.stacker==0){
        $('#paster').prop('checked', false)
        $('#stacker').prop('checked', false)
      }
      else if(data.paster==1 && data.stacker==0){
        $('#paster').prop('checked', true)
        $('#stacker').prop('checked', false)
      }
      else if(data.paster==0 && data.stacker==1){
        $('#paster').prop('checked', false)
        $('#stacker').prop('checked', true)
      }
      else{
        $('#paster').prop('checked', true)
        $('#stacker').prop('checked', true)
      }
    }
  });
 
}

async function updateEmpData(){
    var lname = $('#Lname').val()
    var fname = $('#Fname').val()
    var mname = $('#Mname').val()
    var nname = $('#Nname').val()
    var id = $('#idHolder').val()

    var pasterID = 0
    var Stacker = 0

    if($('#paster').prop('checked')==false && $('#stacker').prop('checked')==false){
        pasterID = 0
        Stacker = 0
    }
    else if($('#paster').prop('checked')==true && $('#stacker').prop('checked')==false){
        pasterID = 1
        Stacker = 0
    }
    else if($('#paster').prop('checked')==false && $('#stacker').prop('checked')==true){
        pasterID = 0
        Stacker = 1
    }
    else{
        pasterID = 1
        Stacker = 1
    }

    const action = await $.ajax({
      type: "POST",
      dataType: "JSON",
      url: "php_repository/admin_repo.php",
      data: {
        action:'update',
        id:id,
        lname:lname,
        fname:fname,
        mname:mname,
        nname:nname,
        pasterID:pasterID,
        stackerID:Stacker
      },
      success: function (data) {
        var results = JSON.parse(data.result)


        if(results==1){
          $('#modalEdit').modal("hide");
          swal({
            title: "Success",
            text: "Employee Info has been updated!",
            icon: "success",
            buttons: false,
            dangerMode: true,
          })
        }
        else{
          swal({
            title: "Error!",
            text: "Something went wrong with the process",
            icon: "error",
            buttons: false,
            dangerMode: true,
          })
        }
        EmployeeTable()
      }
    });
}

function del(id){
  swal({
    title: "Are you sure?",
    text: "Delete employee information",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then (async (willDelete) => {
    if (willDelete) {
        const action = await $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "php_repository/admin_repo.php",
          data: {
              action:'delete',
              id:id
          },
          success: function (data) {
            var result = JSON.parse(data);

            if(result==1){
              swal({
                title: "Success",
                text: "Employee info has been deleted",
                icon: "success",
                buttons: false,
                dangerMode: true,
              })
            }
            else{
              swal({
                title: "Error!",
                text: "Something went wrong with the process",
                icon: "error",
                buttons: false,
                dangerMode: true,
              })
            }

            EmployeeTable()

          }
        });
    }
  });
  
}

function AddEmpData(){
  $('#modalAdd').modal('show')
}

async function submitAddData(){
    var lname = $('#LnameAdd').val()
    var fname = $('#FnameAdd').val()
    var mname = $('#MnameAdd').val()
    var nname = $('#NnameAdd').val()

    if(lname != "" && fname != ""){
      const action = await $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "php_repository/admin_repo.php",
          data: {
            action:'addEmpData',
            lname:lname,
            fname:fname,
            mname:mname,
            nname:nname
          },
          success: function (data) {
            var result = JSON.parse(data)

            if(result ==1){
              swal({
                title: "Success",
                text: "Employee data has been added",
                icon: "success",
                buttons: false,
                dangerMode: true,
              })
              $('#modalAdd').modal('hide')
              EmployeeTable()
            }
            else{
              swal({
                title: "Error!",
                text: "Something went wrong with the process",
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
        title: "Incomplete field",
        text: "Lastname and Firstname is required",
        icon: "warning",
        buttons: false,
        dangerMode: true,
      })
    }
    
}

function Logout(){
  swal({
        title: "Do you want to Log Out",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((logout) => {
        if (logout) {
            $.ajax({
              type: "POST",
              dataType: "JSON",
              url: "php_repository/admin_repo.php",
              data: {
                action:'logout'
              },
              success: function (data) {
                var result = JSON.parse(data)
                if(result==1){
                  setTimeout(() => {
                      location.reload(); 
                  }, 1000);
                }
              }
            });
        }

    })

    
}

//Manage employee end

//Manage Plate
async function viewPlate(id){
  
  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
      action:'viewPlate',
      id:id
    },
    success: function (data) {
      $('#modalViewPlate').modal("show");
      $('#ViewContainerPlate').html(data)
    }
  });

}

async function editPlate(id){

  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
      action:'editPlate',
      id:id
    },
    success: function (data) {
      $('#modalEditPlate').modal("show");
      $('#platetype').val(data.platetype)
      $('#linePlate').html(data.line)
      $('#idHolderPlate').val(data.id)
    }
  });
 
}

async function updatePlateData(){
  var plate = $('#platetype').val()
  var line = $('#linePlate').val()
  var id = $('#idHolderPlate').val()


  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
      action:'updatePlate',
      id:id,
      plate:plate,
      line:line
    },
    success: function (data) {
      var results = JSON.parse(data)


      if(results==1){
        $('#modalEditPlate').modal("hide");
        swal({
          title: "Success",
          text: "Plate Info has been updated!",
          icon: "success",
          buttons: false,
          dangerMode: true,
        })
      }
      else{
        swal({
          title: "Error!",
          text: "Something went wrong with the process",
          icon: "error",
          buttons: false,
          dangerMode: true,
        })
      }
      PlateTable()
    }
  });
}

function delPlate(id){
  swal({
    title: "Are you sure?",
    text: "Delete Plate Type information",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then (async (willDelete) => {
    if (willDelete) {
        const action = await $.ajax({
          type: "POST",
          dataType: "JSON",
          url: "php_repository/admin_repo.php",
          data: {
              action:'deletePlate',
              id:id
          },
          success: function (data) {
            var result = JSON.parse(data);

            if(result==1){
              swal({
                title: "Success",
                text: "Plate info has been deleted",
                icon: "success",
                buttons: false,
                dangerMode: true,
              })
            }
            else{
              swal({
                title: "Error!",
                text: "Something went wrong with the process",
                icon: "error",
                buttons: false,
                dangerMode: true,
              })
            }

            PlateTable()

          }
        });
    }
  });
  
}

function AddPlateData(){
  $('#modalAddPlate').modal('show')
}

async function submitAddPlateData(){
  var plateType = $('#platetypeAdd').val()
  var polarityID = $('#linePlateAdd').val()

  if(plateType!="" && polarityID !=0){
    const action = await $.ajax({
      type: "POST",
      dataType: "JSON",
      url: "php_repository/admin_repo.php",
      data: {
        action:'submitPlateData',
        plateType:plateType,
        polarityID:polarityID
      },
      success: function (data) {
        var result = JSON.parse(data)

        if(result==1){
            swal({
              title: "Success",
              text: "New Plate data has been added",
              icon: "success",
              buttons: false,
              dangerMode: true,
            })
            $('#modalAddPlate').modal('hide')
            PlateTable()

        }
        else{
          swal({
            title: "Error!",
            text: "Something went wrong with the process",
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
      title: "Incomplete",
      text: "",
      icon: "error",
      buttons: false,
      dangerMode: true,
    })
  }
}
//Manage Plate end

$('#nav-myacc-tab').on('click', function(e){
  e.preventDefault()
  var id = $('#empID').val()
  displayEmpCreds(id)
})

async function displayEmpCreds(id){
  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
      action:'adminCred',
      id:id
    },
    success: function (data) {
      $('#username').val(data.uname)
      $('#password').val(data.pass)
      $('#admin_name').text(data.admin_name)
    }
  });
}

$('#basic-addon3').on('click', function(){
    if ($('#password').attr('type') === 'password') {
      $('#password').attr('type', 'text');
        $('#icon').addClass('fa-eye-slash').removeClass('fa-eye');
    } else {
      $('#password').attr('type', 'password');
      $('#icon').addClass('fa-eye').removeClass('fa-eye-slash');
    }
})

async function updateCreds(){
  var id = $('#empID').val()
  var uname = $('#username').val()
  var pass = $('#password').val()

  const action = await $.ajax({
    type: "POST",
    dataType: "JSON",
    url: "php_repository/admin_repo.php",
    data: {
        action:'updateCred',
        id:id,
        uname:uname,
        pass:pass
    },
    success: function (data) {
      var result = JSON.parse(data)

      if(result==1){
        swal({
          title: "Success",
          text: "Admin credential has been updated!",
          icon: "success",
          buttons: false,
          dangerMode: true,
        })
        displayEmpCreds(id)
      }
      else{
        swal({
          title: "Error!",
          text: "Something went wrong with the process",
          icon: "error",
          buttons: false,
          dangerMode: true,
        })
      }
    }
  });
}

