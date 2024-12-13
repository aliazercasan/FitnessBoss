  <!--WALK IN CHART-->
  <?php
  include 'data_queries/config.php';

  // Fetch daily income for the last month
  $query = "
    SELECT DATE(payment_created) AS date, COUNT(*) AS income 
    FROM walk_in_users 
    WHERE DATE(payment_created) >= CURDATE() - INTERVAL 1 MONTH 
    GROUP BY DATE(payment_created)
    ORDER BY DATE(payment_created)";
  $result = $conn->query($query);

  $dates = [];
  $incomes = [];
  while ($row = $result->fetch_assoc()) {
    $dates[] = date('M d, Y', strtotime($row['date'])); 
    $incomes[] = $row['income']; 
  }

  // Convert PHP arrays to JavaScript arrays
  $dates_js = json_encode($dates);
  $incomes_js = json_encode($incomes);
  ?>

  <!--JS CHART-->
  <script src="https://cdn.jsdelivr.net/npm/@kurkle/color@0.1.9"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <script>
    const ctx3 = document.getElementById('monthlyChart3').getContext('2d');

    new Chart(ctx3, {
      type: 'bar',
      data: {
        labels: <?php echo $dates_js; ?>, // Use dynamically generated dates
        datasets: [{
          label: 'Walk In Count',
          data: <?php echo $incomes_js; ?>, // Use dynamically generated incomes
          backgroundColor: '#8E44AD', // Blue
          borderColor: '#8E44AD', // Blue border
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              color: 'white'
            }
          },
          x: {
            ticks: {
              color: 'white'
            }
          }
        },
        plugins: {
          legend: {
            labels: {
              color: 'white',
              font: {
                size: 14
              }
            }
          },
          title: {
            display: true,
            text: 'Daily Walk In Statistics',
            color: 'white',
            font: {
              size: 16
            }
          }
        }
      }
    });
  </script>
