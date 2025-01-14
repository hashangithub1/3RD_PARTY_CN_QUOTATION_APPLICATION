<!-- Pie Chart -->
<div class="panel-body">
  <canvas id="myDoughnutChart" width="300" height="300"></canvas>
  </div>

  <?php include'product_count.php'?>

  <?php
    $P_count = [$num_rows_motorcar, $num_rows_motorcycle, $num_rows_HandTractor, $num_rows_Tractor, $num_rows_ThreeWheeler, $num_rows_DualPurpose, $num_rows_Lorry];
  //print_r ($L_count);
  ?>
  <!-- End Get lead count  -->

  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  document.addEventListener('DOMContentLoaded', function () {
  // Get the canvas element
  var ctx = document.getElementById('myDoughnutChart').getContext('2d');

  // Define the data for the chart
  var data = {
      labels: ['Motor Car' , 'Motor Cycle', 'Hand Tractor','Tractor', 'Three Wheeler', 'Dual Purpose', 'Lorry'],
      datasets: [{
          data: <?php echo json_encode($P_count); ?>, // Example data, you can replace it with your own
          backgroundColor: [
              'rgba(21, 179, 168)',
              'rgba(21, 92, 179)',
              'rgba(219, 144, 24)',
              'rgba(183, 24, 219)',
              'rgba(219, 24, 118)',
              'rgba(255, 102, 102)',
              'rgba(24, 219, 76)'
              
              
          ],
          borderColor: [
              'rgba(21, 179, 168)',
              'rgba(21, 92, 179)',
              'rgba(219, 144, 24)',
              'rgba(183, 24, 219)',
              'rgba(219, 24, 118)',
              'rgba(255, 102, 102)',
              'rgba(24, 219, 76)'
          ],
          borderWidth: 1
      }]
  };

  
  // Configure the options for the chart
  var options = {
      responsive: true,
      maintainAspectRatio: false,
      cutout: 50, // Adjust the cutout to make it a doughnut chart
  };

  // Create the doughnut chart
  var myDoughnutChart = new Chart(ctx, {
      type: 'doughnut',
      data: data,
      options: options
  });
  });
  </script>

  <!-- End Pie Chart -->