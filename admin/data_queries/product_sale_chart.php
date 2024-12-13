<?php
include 'data_queries/config.php';

// Fetch monthly income data for the last 12 months
$query = "
  SELECT DATE_FORMAT(date_issued, '%M') AS month, 
         SUM(product_total) AS total_sales 
  FROM product_sales 
  WHERE DATE(date_issued) >= CURDATE() - INTERVAL 12 MONTH
  GROUP BY MONTH(date_issued)
  ORDER BY MONTH(date_issued)";

$result = $conn->query($query);

$months = [];
$total_sales = [];
while ($row = $result->fetch_assoc()) {
  $months[] = $row['month'];  // Month name (e.g., January, February)
  $total_sales[] = $row['total_sales']; // Total sales amount for the month
}

// Convert PHP arrays to JavaScript arrays for the chart
$months_js = json_encode($months);
$total_sales_js = json_encode($total_sales);
?>



  <!-- JS CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<script>
  const ctx4 = document.getElementById('monthlyChart4').getContext('2d');

  new Chart(ctx4, {
    type: 'line',
    data: {
      labels: <?php echo $months_js; ?>, // Dynamically generated month names
      datasets: [{
        label: 'Monthly Product Sales (Total Amount)',
        data: <?php echo $total_sales_js; ?>, // Dynamically generated total sales
        backgroundColor: '#F1C40F', // Blue
        borderColor: '#F1C40F', // Blue border
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
          },
          title: {
            display: true,
            text: 'Total Sales Amount',
            color: 'white',
            font: {
              size: 14
            }
          }
        },
        x: {
          ticks: {
            color: 'white'
          },
          title: {
            display: true,
            text: 'Month',
            color: 'white',
            font: {
              size: 14
            }
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
          text: 'Monthly Product Sales Statistics',
          color: 'white',
          font: {
            size: 16
          }
        }
      }
    }
  });
</script>
