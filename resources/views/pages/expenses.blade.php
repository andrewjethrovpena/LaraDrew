
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
            
              <div id="ExpensesForm" style="margin-top: 20px;">
                  <table width="100%">
                    <input type="hidden" name="_token" id="csrfAdd" v-model="csrfAdd" value="{{Session::token()}}">
                    
                    <tr>
                      <td>
                        <select v-model="category">
                            <option value="">--Select Category--</option>
                            @foreach($categoryList as $getInfo)
                              <option value="{{ $getInfo->category_id }}"> {{ $getInfo->expense_name }} </option>
                            @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Amount: <input type="text" name="amount" v-model="amount"></td>
                    </tr>
                    <tr>
                      <td>Entry Date: <input type="date" name="entryDate" v-model="entryDate"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" @click="addExpenses();">Submit</button>
                      </td>
                    </tr>
                  </table>
              </div>
            
          </div>
        </div>
      </div>
    </div>

    <div class="w3-container">
      <div id="updateExpense" class="w3-modal">
        <div class="w3-modal-content" style="height: 390px; width: 280px;">
          <div class="w3-container">
            
            <span onclick="document.getElementById('updateExpense').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            
              <div id="updateExpensesForm" style="margin-top: 10px;">
                 <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                 <input type="hidden" v-model="updateExpenseId" id="updateExpenseId">
                  <table width="100%">
                    <tr>
                      <td>
                        <select v-model="category" id="updateCategory">
                            <option value="">--Select Category--</option>
                            @foreach($categoryList as $getInfo)
                              <option value="{{ $getInfo->category_id }}"> {{ $getInfo->expense_name }} </option>
                            @endforeach
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Amount: <input type="text" name="updateAmount" v-model="updateAmount" id="updateAmount"></td>
                    </tr>
                    <tr>
                      <td>Entry Date: <input type="date" name="updateTransDate" v-model="updateTransDate" id="updateTransDate"></td>
                    </tr>
                    <tr>
                      <td>
                        <button class="btn btn-primary" style="float: right; margin-top: 10px;" onclick="updateExpense();">Submit</button>
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
                  <table id="expensesTable" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Category</th>
                          <th>Amount</th>
                          <th>Transaction Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Category</th>
                          <th>Amount</th>
                          <th>Transaction Date</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                  </table>
              </div>
              <button class="btn btn-primary" onclick="document.getElementById('id01').style.display='block'" style="float: right; margin-top: 10px;">Add Expense</button>
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

      $('#expensesTable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": "{{ route('expenses.getExpensesList') }}",
          "dataType" :"json",
          "columns": [
              { "data": null,"sortable": false, 
                render: function (data, type, row, meta) {
                 return meta.row + meta.settings._iDisplayStart + 1;
                }  
              },
              { data: "category", name: "category"},
              { data: "amount", name: "amount"},
              { data : "transDate", name: "transDate"},
              { data: "action", name:"action"}
          ]
      });
  });

  function viewExpenses(expenseId){

    var updateExpenseId = $("#updateExpenseId").val("");
    var updateExpenseId = $("#updateExpenseId").val(expenseId);

    document.getElementById('updateExpense').style.display='block'

    $.ajax({
      type: 'GET',
      url: "/expenses/"+expenseId,
      success: function(data){
        $("#updateAmount").val(data);

      }

    });

  }

  function updateExpense(){

   var updateCategory = $("#updateCategory").val();
   var updateAmount = $("#updateAmount").val();
   var updateTransDate = $("#updateTransDate").val();
   var updateExpenseId = $("#updateExpenseId").val();

   $.ajax({
    type: 'POST',
    url: "{{ route('updateExpenses') }}",
    data: {
        _token: $("#csrf").val(),
        updateCategory: updateCategory,
        updateAmount: updateAmount,
        updateTransDate:updateTransDate,
        updateExpenseId:updateExpenseId
    },
    success: function(data){
        
         if (data == 1) {
          alert("Successfully Updated");
          location.href = "/expenses";
         }

    }

   });

  }

  function deleteExpenses(transId){

    var txt = confirm("Do you want to delete this category?");

    if (txt == true) {
      $.ajax({
        type: 'POST',
        url: "{{ route('deleteExpenses') }}",
        data: {
            _token: $("#csrf").val(),
            transId: transId,
        },
        success: function(data){
             if (data == 1) {
              alert("Successfully Deleted");
              location.href = "/expenses";
             }
        }

      });
    }

  }

  // vue scripts
  var ExpensesForm = new  Vue({
    el: '#ExpensesForm',
    data:{
      category: '',
      amount: '',
      entryDate: ''
    },
    methods: {
        addExpenses:function() {
            let currentObj = this;
            axios.post("{{ route('addNewExpenses') }}", {
                category: this.category,
                amount: this.amount,
                entryDate: this.entryDate
            })
            .then(function (response) {
              location.replace("{{ route('expenses') }}");
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
