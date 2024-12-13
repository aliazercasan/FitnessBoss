<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chart.js Stacked Bar Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@kurkle/color@0.1.9"></script>
</head>
<body>
  <div style="width: 80%; margin: auto;">
    <canvas id="myChart"></canvas>
  </div>
  
  <script>
    // <block:actions:2>
    const actions = [
      {
        name: 'Randomize',
        handler(chart) {
          chart.data.datasets.forEach(dataset => {
            dataset.data = Utils.numbers({ count: chart.data.labels.length, min: -100, max: 100 });
          });
          chart.update();
        }
      },
    ];
    // </block:actions>

    // Utility functions
    const Utils = {
      months(config) {
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const count = config?.count || 12;
        return months.slice(0, count);
      },
      numbers(config) {
        const min = config.min || 0;
        const max = config.max || 100;
        const count = config.count || 1;
        const decimalPlaces = config.decimalPlaces || 0;
        return Array.from({ length: count }, () => +(Math.random() * (max - min) + min).toFixed(decimalPlaces));
      },
      CHART_COLORS: {
        red: 'rgba(255, 99, 132, 0.5)',
        blue: 'rgba(54, 162, 235, 0.5)',
        green: 'rgba(75, 192, 192, 0.5)'
      }
    };

    // <block:setup:1>
    const DATA_COUNT = 7;
    const NUMBER_CFG = { count: DATA_COUNT, min: -100, max: 100 };

    const labels = Utils.months({ count: 7 });
    const data = {
      labels: labels,
      datasets: [
        {
          label: 'Dataset 1',
          data: Utils.numbers(NUMBER_CFG),
          backgroundColor: Utils.CHART_COLORS.red,
        },
        {
          label: 'Dataset 2',
          data: Utils.numbers(NUMBER_CFG),
          backgroundColor: Utils.CHART_COLORS.blue,
        },
        {
          label: 'Dataset 3',
          data: Utils.numbers(NUMBER_CFG),
          backgroundColor: Utils.CHART_COLORS.green,
        },
      ]
    };
    // </block:setup>

    // <block:config:0>
    const config = {
      type: 'bar',
      data: data,
      options: {
        plugins: {
          title: {
            display: true,
            text: 'Chart.js Bar Chart - Stacked'
          },
        },
        responsive: true,
        scales: {
          x: {
            stacked: true,
          },
          y: {
            stacked: true
          }
        }
      }
    };
    // </block:config>

    // Render chart
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, config);
  </script>
</body>
</html>
