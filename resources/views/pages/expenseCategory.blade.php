
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
              <li class="breadcrumb-item"><a href="#">Expense Category Management</a></li>
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
            
              <div id="categoryForm" style="margin-top: 20px;">
                  <table width="100%">
                    <input type="hidden" name="_token" id="csrfAdd" v-model="csrfAdd" value="{{Session::token()}}">
                   
                    <tr>
                      <td>Name: <input type="text" name="name" v-model="name"></td>
                    </tr>
                    <tr>
                      <td>Category: <input type="text" name="category" v-model="category"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" @click="addCategory();">Submit</button>
                      </td>
                    </tr>
                  </table>
              </div>
            
          </div>
        </div>
      </div>
    </div>

    <div class="w3-container">
      <div id="updateCateg" class="w3-modal">
        <div class="w3-modal-content" style="height: 390px; width: 280px;">
          <div class="w3-container">
            
            <span onclick="document.getElementById('updateCateg').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            
              <div id="updatecategoryForm" style="margin-top: 10px;">
                 <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                 <input type="hidden" v-model="updateCategoryID" id="updateCategoryID">
                  <table width="100%">
                    
                    <tr>
                      <td>Name: <input type="text" name="updateName" v-model="updateName" id="updateName"></td>
                    </tr>
                    <tr>
                      <td>Username: <input type="text" name="updateCategname" v-model="updateCategname" id="updateCategname"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" onclick="updateCateg();">Submit</button>
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
                  <table id="categoryTable" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Category</th>
                          <th>Date Created</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                  </table>
              </div>
              <button class="btn btn-primary" onclick="document.getElementById('id01').style.display='block'" style="float: right; margin-top: 10px;">Add Category</button>
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

      $('#categoryTable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": "{{ route('expenseCategories.getCategoryList') }}",
          "dataType" :"json",
          "columns": [
              { "data": null,"sortable": false, 
                render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }  
              },

              { data: "name", name: "name"},
              { data: "category", name: "category"},
              { data : "dateCreated", name: "dateCreated"},
              { data: "action", name:"action"}
          ]
      });
  });

  function viewCategory(categId){

    var updateCategoryID = $("#updateCategoryID").val("");
    var updateCategoryID = $("#updateCategoryID").val(categId);

    document.getElementById('updateCateg').style.display='block'

    $.ajax({
      type: 'GET',
      url: "/expenseCategories/"+categId,
      success: function(data){
        $("#updateName").val(data.name);
        $("#updateCategname").val(data.category);

      }

    });

  }

  function updateCateg(){

    var updateName = $("#updateName").val();
    var updateCategname = $("#updateCategname").val();
    var updateCategoryID = $("#updateCategoryID").val();

   $.ajax({
    type: 'POST',
    url: "{{ route('updateCategory') }}",
    data: {
        _token: $("#csrf").val(),
        updateName: updateName,
        updateCategname: updateCategname,
        updateCategoryID:updateCategoryID
    },
    success: function(data){
        
         if (data == 1) {
          alert("Successfully Updated");
          location.href = "/expenseCategories";
         }

    }

   });

  }

  function deleteCategory(categId){

    var txt = confirm("Do you want to delete this category?");

    if (txt == true) {
      $.ajax({
        type: 'POST',
        url: "{{ route('deleteCategory') }}",
        data: {
            _token: $("#csrf").val(),
            categId: categId,
        },
        success: function(data){
             if (data == 1) {
              alert("Successfully Deleted");
              location.href = "/expenseCategories";
             }
        }

      });
    }

  }


  // vue scripts
  var categoryForm = new  Vue({
    el: '#categoryForm',
    data:{
      name: '',
      category: ''
    },
    methods: {
        addCategory:function() {
            let currentObj = this;
            axios.post("{{ route('addNewCategory') }}", {
                name: this.name,
                category: this.category,
            })
            .then(function (response) {
              location.replace("{{ route('expenseCategories') }}");
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
