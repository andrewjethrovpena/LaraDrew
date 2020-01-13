
<!DOCTYPE html>
<html>
  <!-- LAYOUT HEADER -->
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">

  <script src="{{asset('/js/axios.js')}}"></script>
  <script src="{{asset('/js/vue.js')}}"></script>
  <script src="{{asset('/js/vue-router.js')}}"></script>

<body class="hold-transition sidebar-mini" style="background-color:#95a5a6; ">
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:#95a5a6;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="color: #FFF;">Expense Management System</h1>
          </div>
        
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" style="width: 1200px;" >
      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header" style="background-color:#006266;">
              <div id="app">
                <h3 class="card-title">@{{ message }}</h3>
              </div>
            </div>

            <div id="login">
               <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" name="remarks" placeholder="Username" v-model="username">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" v-model="password">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" style="background-color:#006266; border-color:#006266;" @click="loginSubmit();">Submit</button>
                </div>
            </div>
           
          </div>  
        </div>
      </div>

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>
<!-- ./wrapper -->
<script>

  var app = new Vue({
    el: '#app',
    data: {
      message: 'Login Form'
    }
  });

  var login = new  Vue({
    el: '#login',
    data:{
      username: '',
      password: '', 
    },
    methods: {
        loginSubmit:function() {
            let currentObj = this;
            axios.post("{{ route('loginProcess') }}", {
                username: this.username,
                password: this.password
            })
            .then(function (response) {
              if (response.data == "1") {
                location.replace("{{ route('dashboard') }}");
              }else{
                alert("Password/Username mismatch. Please try again.");
                location.replace("{{ route('login') }}");
              }
              
              console.log(response.data);
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
