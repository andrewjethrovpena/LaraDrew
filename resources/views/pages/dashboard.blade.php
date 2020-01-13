
<!DOCTYPE html>
<html>
  <!-- LAYOUT HEADER -->
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('/css/w3.css') }}">
  <script src="{{asset('/js/axios.js')}}"></script>
  <script src="{{asset('/js/vue.js')}}"></script>
  <script src="{{asset('/js/chart.js')}}"></script>

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
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
              <!-- <li class="breadcrumb-item active"></li> -->&nbsp;
              
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    
      <div class="row">

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Dashboard</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                 <div id="graphPresentation" >
                    <canvas id="myChart" width="100" height="30"></canvas>
                  </div>

              </div>
              
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

$(function(){

  ajaxGraph();
});

function ajaxGraph(){

    $.ajax({
      type: "GET",
      url:  "{{ route('pieGraph') }}",
      dataType: "json",
      success: function(data){
        // alert(data.points);
        pieChart(data.labels, data.points);
      }

    });

}

function pieChart(labels, points){ 

    var revLabel = labels.reverse(); 
    var revPoint = points.reverse();  

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: '# of New Orders',
                data: points,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    }
                }]
            }
        }
    });

  }

</script>
</body>
</html>
