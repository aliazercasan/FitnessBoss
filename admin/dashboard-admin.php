<?php
session_start();
include('data_queries/config.php');
if (!isset($_SESSION['admin_id'])) {
  header("Location: ../login.php");
  exit();
}
// Fetch the total number of users
$total_users = 0;
$sql = "SELECT COUNT(*) as total FROM tbl_users_account WHERE role = 'user'"; // Replace 'users' with your actual table name
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
  $total_users = $row['total'];
}

// Determine greeting based on time in the Philippines
date_default_timezone_set('Asia/Manila');
$current_hour = date('H'); // Get the current hour (24-hour format)

if ($current_hour >= 6 && $current_hour < 12) {
  $greeting = "Good Morning";
} elseif ($current_hour >= 12 && $current_hour < 18) {
  $greeting = "Good Afternoon";
} else {
  $greeting = "Good Evening";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrator Dashboard</title>
  <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">

  <!--CSS SHEET-->
  <link rel="stylesheet" href="style.css" />
  <!--Google Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ultra&display=swap"
    rel="stylesheet" />

  <!--Bootstrap Icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!--Taiwind Framework-->
  <script src="https://cdn.tailwindcss.com"></script>

  <!--Taiwind config (to avoid conflict)-->
  <script>
    tailwind.config = {
      prefix: "tw-",
    };
  </script>
</head>

<body class="bg-black">
  <!--NAVIGATION-->
  <?php include 'header.php' ?>



  <!--DASHBOARD-->
  <div class="container tw-mt-40 tw-flex md:tw-justify-between md:tw-items-center tw-justify-center md:tw-items-center">
    <div class="d-flex justify-content-center align-items-center">
      <h1 class="tw-text-4xl tw-font-bold text-white"><?php echo $greeting; ?>, <?php echo $_SESSION['admin_name']; ?></h1> <!-- Dynamic Greeting -->
      <img src="../assets/wave.png" alt="">
    </div>

    <!-- Total Users -->
    <div class="lg:tw-flex md:tw-hidden tw-hidden">
      <li class="nav-item me-2 d-flex tw-bg-[#00FFAE] justify-content-center align-items-center tw-w-42 rounded-5 px-2">
        <span class="tw-text-[#EA3EF7] tw-text-2xl me-2"><i class="bi bi-person-fill"></i></span>
        <p class="me-1">Total Users:</p>
        <p><?php echo $total_users; ?></p>
      </li>
    </div>
  </div>

  <!--CARDS -->
  <div class="tw-grid lg:tw-grid-cols-3 md:tw-grid-cols-2 container mt-5 gap-4 tw-grid-cols-1 ">

    <!--DAILY LOGS -->
    <div class="card tw-bg-[#003323] text-white">
      <div class="header d-flex justify-content-start align-items-center">
        <img src="../assets/book.png" alt="" width="70">
        <div class="dropdown">
          <button class=" tw-bg-transparent tw-active:outline-none dropdown-toggle tw-text-xl ">
            Daily Logs
          </button>

        </div>
        <p class=" tw-font-bold"></p>
      </div>

      <!--TOTAL USERS QUERY-->
      <?php include 'data_queries/count_today_attendance.php' ?>

      <div class="tw-flex tw-justify-between tw-items-center">
        <div class="md:tw-ms-10 tw-mb-5 tw-ms-0 md:tw-text-start tw-text-center md:tw-mt-10 tw-mt-0 ">
          <p class="tw-text-6xl tw-font-bold"><?php echo htmlspecialchars($users_attendance) ?></p>
          <p class="tw-text-md">Today's Attendance</p>
        </div>
        <div class="md:tw-me-10 tw-ms-0 tw-bg-black tw-px-5 tw-py-2 tw-rounded-lg">
          <a href="attendance.php"><span><i class="bi bi-person"></i>Log</span></a>
        </div>
      </div>
      <div class=" tw-underline tw-text-sm tw-flex tw-justify-center tw-items-center">
        <img src="../assets/Edit Property.png" alt="">
        <a href="all_logs.php" class="ms-1">View all logs</a>
      </div>
    </div>

    <!--Product Sold -->
    <div class="card  tw-bg-[#003323] text-white p-2">
      <div class="header d-flex justify-content-around align-items-center">
        <img src="../assets/Best Seller.png" alt="" width="70">
        <h1 class="tw-text-xl">Products Sold</h1>
        <div class="dropdown">
          <button class=" px-2 py-1 tw-rounded-lg text-white tw-text-sm tw-active:outline-none dropdown-toggle tw-border-2 tw-border-[#00FFAE] tw-bg-transparent" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Daily
          </button>
          <ul class="dropdown-menu tw-bg-white">
            <li><a class="dropdown-item" href="#">Monthly</a></li>
            <li><a class="dropdown-item" href="#">Yearly</a></li>
          </ul>
        </div>
      </div>
      <div class="text-center mt-4">
        <div class="discription d-flex justify-content-around md:tw-text-xs tw-text-md">
          <p class="tw-text-md">Energy Drink</p>
          <p class="tw-text-md">Supplements</p>
          <p class="tw-text-md">Mineral Water</p>

        </div>
        <div class="pictures d-flex justify-content-around mt-3 align-items-center">
          <img src="../assets/energydrink.png" alt="" width="60" height="60">
          <img src="../assets/suplement.png" alt="" width="60" height="60">
          <img src="../assets/water.png" alt="" width="60" height="60">
        </div>
      </div>

      <div class="text-center mt-3 tw-text-sm tw-underline">
        <a href="products.php">View specific product sales</a>
      </div>
    </div>

    <!--ALERTS-->
    <div class="card  tw-bg-[#003323] text-white">
      <div class="header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
          <img src="../assets/Alarm.png" alt="" width="70">
          <p class="tw-text-xl ms-3">Alerts</p>
        </div>
      </div>
      <!--count_active-->
      <?php include 'data_queries/count_active.php' ?>
      <div class="tw-flex tw-justify-around tw-items-center mt-4">
        <div>
          <!--Active-->
          <div class="tw-flex  align-items-start mb-2">
            <img src="../assets/Toggle On.png" alt="">
            <p class="tw-text-[#08FFA0] mx-3"><?php echo $row['total'] ?></p>
            <p>Active</p>
          </div>

          <!--Inactive-->
          <div class="d-flex align-items-center mb-2">
            <img src="../assets/Toggle Off.png" alt="">
            <p class="tw-text-[#FFC508] mx-3"><?php echo $row2['total'] ?></p>
            <p>Inactive</p>
          </div>

          <!--View All-->
          <div class="tw-flex tw-items-center mb-2">
            <img src="../assets/Analyze.png" alt="" width="30" class="me-3">
            <a href="total_users.php">View All</a>
          </div>
        </div>

        <div class="">
          <div class="tw-flex tw-items-center container mt-3">
            <div class="tw-text-md tw-underline">
              <a href="products.php">Products</a><br>
              <a href="payment_history_admin.php">Payment History</a><br>
              <a href="sales_report.php">Overall Sales Report</a>

            </div>
            <div class="ms-4">
              <img src="../assets/Fast Moving Consumer Goods.png" alt="">
              <img src="../assets/Order History.png" alt="">
              <img src="../assets/Order History.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>








  
  <!-- SESSION CHART Responsive Graph CHART -->
  <div class="container tw-flex tw-flex-col md:tw-flex-row tw-justify-center tw-items-stretch tw-gap-6 tw-px-4 tw-py-5 tw-mx-auto">


    <!-- SESSION CHART -->
    <div class="tw-flex-1 tw-flex tw-flex-col tw-bg-[#003323] tw-rounded-lg">
      <div class="tw-rounded-t-lg tw-flex tw-items-center tw-justify-between tw-text-white px-4 py-3">
        <div class="tw-flex tw-items-center">
          <img src="../assets/Combo Chart.png" alt="Session Icon" width="50" class="tw-shrink-0">
          <h1 class="tw-text-lg tw-font-semibold tw-ml-3">Session</h1>
        </div>
      </div>
      <div class="tw-flex-1">
        <canvas class="tw-p-4 tw-bg-[#003323] tw-rounded-b-lg" id="monthlyChart"></canvas>
      </div>
      <div class="tw-text-white tw-bg-[#003323] py-2 tw-flex tw-justify-center tw-items-center tw-text-sm tw-underline">
      </div>
    </div>

    <!-- WALK IN CHART -->
    <div class="tw-flex-1 tw-flex tw-flex-col tw-bg-[#003323] tw-rounded-lg">
      <div class="tw-rounded-t-lg tw-flex tw-items-center tw-justify-between tw-text-white px-4 py-3">
        <div class="tw-flex tw-items-center">
          <img src="../assets/Combo Chart.png" alt="Monthly Icon" width="50" class="tw-shrink-0">
          <h1 class="tw-text-lg tw-font-semibold tw-ml-3">Walk In</h1>
        </div>
      </div>
      <div class="tw-flex-1">
        <canvas class="tw-p-4 tw-bg-[#003323] tw-rounded-b-lg" id="monthlyChart3"></canvas>
      </div>
      <div class="tw-text-white tw-bg-[#003323] py-2 tw-flex tw-justify-center tw-items-center tw-text-sm tw-underline">
      </div>
    </div>
  </div>

  <!-- MONTHLY CHART -->
  <div class="tw-flex-1 tw-flex tw-flex-col tw-bg-[#003323] tw-rounded-lg container">
    <div class="tw-rounded-t-lg tw-flex tw-items-center tw-justify-between tw-text-white px-4 py-3">
      <div class="tw-flex tw-items-center">
        <img src="../assets/Combo Chart.png" alt="Monthly Icon" width="50" class="tw-shrink-0">
        <h1 class="tw-text-lg tw-font-semibold tw-ml-3">Monthly Subscription</h1>
      </div>
    </div>
    <div class="tw-flex-1">
      <canvas id="monthlyChart2" width="400" height="200" class="tw-p-4 tw-bg-[#003323] tw-rounded-b-lg"></canvas>
    </div>
    <div class="tw-text-white tw-bg-[#003323] py-2 tw-flex tw-justify-center tw-items-center tw-text-sm tw-underline">
    </div>
  </div>






    <!-- Product Sales Statistics -->
    <div class="tw-flex-1 tw-flex tw-flex-col tw-bg-[#003323] tw-rounded-lg container">
    <div class="tw-rounded-t-lg tw-flex tw-items-center tw-justify-between tw-text-white px-4 py-3">
      <div class="tw-flex tw-items-center">
        <img src="../assets/Combo Chart.png" alt="Monthly Icon" width="50" class="tw-shrink-0">
        <h1 class="tw-text-lg tw-font-semibold tw-ml-3">Product Sales Statistics</h1>
      </div>
    </div>
    <div class="tw-flex-1">
      <canvas id="monthlyChart4" width="400" height="200" class="tw-p-4 tw-bg-[#003323] tw-rounded-b-lg"></canvas>
    </div>
    <div class="tw-text-white tw-bg-[#003323] py-2 tw-flex tw-justify-center tw-items-center tw-text-sm tw-underline">
    </div>
  </div>



  <!-- walk_in CHART  -->
  <?php include 'data_queries/walk_in_chart.php' ?>

  <!-- SESSION CHART  -->
  <?php include 'data_queries/session_chart.php' ?>

  <!-- MONTHLY CHART  -->
  <?php include 'data_queries/monthly_chart.php' ?>

  <!-- product_sale_chart  -->
  <?php include 'data_queries/product_sale_chart.php' ?>
















  <div class="footer tw-text-slate-500 text-center tw-mt-5 tw-mb-5">
    <div>
      <h1>&copy; Copyright 2024 by Visionary Creatives X Fitness Boss</h1>
    </div>
  </div>

  <!--Bootstrap JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>