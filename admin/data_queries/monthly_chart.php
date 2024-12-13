<?php
include 'data_queries/config.php';

// Fetch monthly income data for the last 12 months
$query = "
  SELECT DATE_FORMAT(payment_created, '%M') AS month, COUNT(*) AS income 
  FROM payment_history 
  WHERE DATE(payment_created) >= CURDATE() - INTERVAL 12 MONTH
  AND category = 'monthly'
  GROUP BY month
  ORDER BY MONTH(payment_created)";

$result = $conn->query($query);

$dates = [];
$incomes = [];
while ($row = $result->fetch_assoc()) {
  // Directly use the month value from the query result
  $dates[] = $row['month'];  // Month name (e.g., Dec)
  $incomes[] = $row['income']; // The number of people in that month
}

// Convert PHP arrays to JavaScript arrays for the chart
$dates_js = json_encode($dates);
$incomes_js = json_encode($incomes);
?>


  <!--JS CHART-->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <canvas id="monthlyChart" width="400" height="200"></canvas>

  <script>
    const ctx2 = document.getElementById('monthlyChart2').getContext('2d');

    new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: <?php echo $dates_js; ?>, // Use dynamically generated dates
        datasets: [{
          label: 'Monthly Count',
          data: <?php echo $incomes_js; ?>, // Use dynamically generated incomes
          backgroundColor: '#FF4500', // Blue
          borderColor: '#FF4500', // Blue border
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
            text: 'Yearly Statistics for Monthly Subscription',
            color: 'white',
            font: {
              size: 16
            }
          }
        }
      }
    });
  </script>
