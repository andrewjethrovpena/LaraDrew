
<!DOCTYPE html>
<html>
  <!-- LAYOUT HEADER -->
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('/css/w3.css') }}">
  <script src="{{asset('/js/axios.js')}}"></script>
  <script src="{{asset('/js/vue.js')}}"></script>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- SIDEBAR CONTENT -->
    @extends('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Expense Management System</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Role Management</a></li>
              <li class="breadcrumb-item active">List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="w3-container">
      <div id="id01" class="w3-modal">
        <div class="w3-modal-content" style="height: 180px; width: 320px;">
          <div class="w3-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            
              <div id="roleForm">
                  <table width="100%">
                    <tr>
                      <td>Role Name: <input type="text" name="roleName" v-model="roleName"></td>
                     
                    </tr>
                    <tr>
                       <td>Role Description: <input type="text" name="roleName" v-model="roleDesc"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" @click="addRoleSubmit();">Submit</button>
                      </td>
                    </tr>
                  </table>
              </div>
            
          </div>
        </div>
      </div>
    </div>

    <div class="w3-container">
      <div id="updateRole" class="w3-modal">
        <div class="w3-modal-content" style="height: 180px; width: 320px;">
          <div class="w3-container">
            
            <span onclick="document.getElementById('updateRole').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            
              <div id="updateRoleForm">
                 <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                 <input type="hidden" v-model="updateRoleID" id="updateRoleID">
                  <table width="100%">
                    <tr>
                      <td>Role Name: <input type="text" name="roleName" id="roleNameInfo" v-model="roleNameInfo"></td>
                     
                    </tr>
                    <tr>
                       <td>Role Description: <input type="text" name="roleName" id="roleDescInfo" v-model="roleDescInfo"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" onclick="updateRole();">Submit</button>
                      </td>
                    </tr>
                  </table>
              </div>
            
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
    
      <div class="row">

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Expense Management System</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                  <table id="roleTable" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Role Name</th>
                          <th>Role Description</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Role Name</th>
                          <th>Role Description</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                  </table>
              </div>
              <button class="btn btn-primary" onclick="document.getElementById('id01').style.display='block'" style="float: right; margin-top: 10px;">Add Role</button>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

         
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- LAYOUT FOOTER -->
  @extends('layouts.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<script src="{{asset('/js/jquery.min.js')}}"></script>
<!-- ./wrapper -->
<script>

   $(document).ready( function () {
        $('#roleTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('roleManage.getRoleList') }}",
            "dataType" :"json",
            "columns": [
                { "data": null,"sortable": false, 
                  render: function (data, type, row, meta) {
                   return meta.row + meta.settings._iDisplayStart + 1;
                  }  
                },
                { data: "role_name", name: "role_name"},
                { data: "role_description", name: "role_description"},
                { data: "created_at", name: "created_at"},
                { data: "action", name: "action"}
            ]
        });
    });

  function viewRole(roleID){

    var updateRoleID = $("#updateRoleID").val("");
    var updateRoleID = $("#updateRoleID").val(roleID);

    document.getElementById('updateRole').style.display='block'

    $.ajax({
      type: 'GET',
      url: "/roleManage/"+roleID,
      success: function(data){
       $("#roleNameInfo").val(data.roleName);
       $("#roleDescInfo").val(data.roleDesp);
      }

    });

  }

  function updateRole(){

   var updateRoleID = $("#updateRoleID").val();
   var roleNameInfo = $("#roleNameInfo").val();
   var roleDescInfo = $("#roleDescInfo").val();


   $.ajax({
    type: 'POST',
    url: "{{ route('updateRoleProcess') }}",
    data: {
        _token: $("#csrf").val(),
        updateRoleID: updateRoleID,
        roleNameInfo: roleNameInfo,
        roleDescInfo: roleDescInfo,
    },
    success: function(data){
        
         if (data == 1) {
          alert("Successfully Updated");
          location.href = "/roleManage";
         }

    }

   });

  }

  function deleteRole(roleId){

    var txt = confirm("Do you want to delete this role?");

    if (txt == true) {
      $.ajax({
        type: 'POST',
        url: "{{ route('deleteRole') }}",
        data: {
            _token: $("#csrf").val(),
            roleId: roleId,
        },
        success: function(data){
             if (data == 1) {
              alert("Successfully Deleted");
              location.href = "/roleManage";
             }
        }

      });
    }

  }

   // vue scripts
  var roleForm = new  Vue({
    el: '#roleForm',
    data:{
      roleName: '',
      roleDesc: '', 
    },
    methods: {
        addRoleSubmit:function() {
            let currentObj = this;
            axios.post("{{ route('addRoleProcess') }}", {
                roleName: this.roleName,
                roleDesc: this.roleDesc
            })
            .then(function (response) {
              location.replace("{{ route('roleManage') }}");
              console.log(response);
            })
            .catch(function (error) { 
                currentObj.output = error;
            });
        }
    }

  });

</script>
</body>
</html>
