
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
              <li class="breadcrumb-item"><a href="#">User Management</a></li>
              <li class="breadcrumb-item active">List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="w3-container">
      <div id="id01" class="w3-modal">
        <div class="w3-modal-content" style="height: 390px; width: 280px;">
          <div class="w3-container">
            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            
              <div id="userForm" style="margin-top: 20px;">
                  <table width="100%">
                    <input type="hidden" name="_token" id="csrfAdd" v-model="csrfAdd" value="{{Session::token()}}">
                    <tr>
                      <td>
                        Role: 
                        <select v-model="roleSelect">
                          @foreach ($roleList as $roleInfo)
                            <option value="{{ $roleInfo->role_id }}"> {{ $roleInfo->role_name }} </option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Name: <input type="text" name="name" v-model="name"></td>
                    </tr>
                    <tr>
                      <td>Username: <input type="text" name="username" v-model="username"></td>
                    </tr>
                    <tr>
                      <td>Email: <input type="text" name="email" v-model="email"></td>
                    </tr>
                    <tr>
                       <td>User Description: <input type="text" name="userDesc" v-model="userDesc"></td>
                    </tr>
                    <tr>
                       <td>Password: <input type="password" name="password" v-model="password"></td>
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
      <div id="updateUser" class="w3-modal">
        <div class="w3-modal-content" style="height: 390px; width: 280px;">
          <div class="w3-container">
            
            <span onclick="document.getElementById('updateUser').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            
              <div id="updateUserForm" style="margin-top: 10px;">
                 <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                 <input type="hidden" v-model="updateUserID" id="updateUserID">
                  <table width="100%">
                    <tr>
                      <td>
                        Role: 
                        <select v-model="roleSelectUpdate" id="roleSelectUpdate">
                          <option value="">--Select Role--</option>
                          @foreach ($roleList as $roleInfo)
                            <option value="{{ $roleInfo->role_id }}"> {{ $roleInfo->role_name }} </option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Name: <input type="text" name="updateName" v-model="updateName" id="updateName"></td>
                    </tr>
                    <tr>
                      <td>Username: <input type="text" name="updateUsername" v-model="updateUsername" id="updateUsername"></td>
                    </tr>
                    <tr>
                      <td>Email: <input type="text" name="updateEmail" v-model="updateEmail" id="updateEmail"></td>
                    </tr>
                    <tr>
                       <td>User Description: <input type="text" name="updateDesc" v-model="updateDesc" id="updateDesc"></td>
                    </tr>
                    <tr>
                       <td>Password: <input type="password" name="updatePassword" v-model="updatePassword" id="updatePassword"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" onclick="updateUser();">Submit</button>
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
                  <table id="usersTable" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Email</th>
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
                          <th>Email</th>
                          <th>Role Description</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                  </table>
              </div>
              <button class="btn btn-primary" onclick="document.getElementById('id01').style.display='block'" style="float: right; margin-top: 10px;">Add User</button>
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

      $('#usersTable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": "{{ route('userManage.getUserList') }}",
          "dataType" :"json",
          "columns": [
              { "data": null,"sortable": false, 
                render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }  
              },
              { data: "name", name: "name"},
              { data: "email", name: "email"},
              { data: "role", name: "role"},
              {data : "dateCreated", name: "dateCreated"},
              {data: "action", name:"action"}
          ]
      });
  });

  function viewUser(userID){

    var updateUserID = $("#updateUserID").val("");
    var updateUserID = $("#updateUserID").val(userID);

    document.getElementById('updateUser').style.display='block'

    $.ajax({
      type: 'GET',
      url: "/userManage/"+userID,
      success: function(data){
        $("#updateName").val(data.name);
        $("#updateUsername").val(data.username);
        $("#updateEmail").val(data.email);
        $("#updateDesc").val(data.description);
        $("#updatePassword").val();

      }

    });

  }

  function updateUser(){

    var updateName = $("#updateName").val();
    var updateUsername = $("#updateUsername").val();
    var updateEmail = $("#updateEmail").val();
    var updateDesc = $("#updateDesc").val();
    var updatePassword = $("#updatePassword").val();
    var updateUserID = $("#updateUserID").val();
    var roleSelectUpdate = $("#roleSelectUpdate").val();

   $.ajax({
    type: 'POST',
    url: "{{ route('updateUser') }}",
    data: {
        _token: $("#csrf").val(),
        updateName: updateName,
        updateUsername: updateUsername,
        updateEmail: updateEmail,
        updateDesc: updateDesc,
        updatePassword: updatePassword,
        updateUserID: updateUserID,
        roleSelectUpdate:roleSelectUpdate
    },
    success: function(data){
        
         if (data == 1) {
          alert("Successfully Updated");
          location.href = "/userManage";
         }

    }

   });

  }

  function deleteUser(userId){

    var txt = confirm("Do you want to delete this user?");

    if (txt == true) {
      $.ajax({
        type: 'POST',
        url: "{{ route('deleteUser') }}",
        data: {
            _token: $("#csrf").val(),
            userId: userId,
        },
        success: function(data){
             if (data == 1) {
              alert("Successfully Deleted");
              location.href = "/userManage";
             }
        }

      });
    }

  }

  // vue scripts
  var userForm = new  Vue({
    el: '#userForm',
    data:{
      roleSelect: '',
      name: '', 
      username: '',
      email: '',
      userDesc: '',
      password: '',
      csrfAdd: ''
    },
    methods: {
        addRoleSubmit:function() {
            let currentObj = this;
            axios.post("{{ route('addNewUser') }}", {
                roleSelect: this.roleSelect,
                name: this.name,
                username: this.username,
                email: this.email,
                userDesc: this.userDesc,
                password: this.password,
                csrfAdd: this.csrfAdd
            })
            .then(function (response) {
              location.replace("{{ route('userManage') }}");
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
