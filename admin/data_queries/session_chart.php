  <!--SESSION CHART-->
  <?php
  include 'data_queries/config.php';

  // Fetch daily income for the last month
  $query = "
    SELECT DATE(payment_created) AS date, COUNT(*) AS income 
    FROM payment_history 
    WHERE DATE(payment_created) >= CURDATE() - INTERVAL 1 MONTH 
    AND category = 'session'
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <canvas id="monthlyChart" width="400" height="200"></canvas>

  <script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo $dates_js; ?>, // Use dynamically generated dates
        datasets: [{
          label: 'Session Count',
          data: <?php echo $incomes_js; ?>, // Use dynamically generated incomes
          backgroundColor: '#FFA500', // Blue
          borderColor: '#FFA500', // Blue border
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
            text: 'Daily Session Statistics',
            color: 'white',
            font: {
              size: 16
            }
          }
        }
      }
    });
  </script>
