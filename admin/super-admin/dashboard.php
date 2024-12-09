<?php
session_start();
if (!isset($_SESSION['super_admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Dashboard</title>
    <link rel="icon" href="../../assets/logo.jpg" type="image/x-icon">

    <!--CSS SHEET-->
    <link rel="stylesheet" href="../style.css" />
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
            <h1 class="tw-text-4xl tw-font-bold text-white">GN,Super Admin</h1>
            <img src="../../assets/wave.png" alt="">

        </div>

        <div class="lg:tw-flex md:tw-hidden tw-hidden">
            <li class="nav-item me-2 d-flex tw-bg-[#00FFAE] justify-content-center align-items-center tw-w-42 rounded-5 px-2">
                <span class="tw-text-[#EA3EF7] tw-text-2xl me-2"><i class="bi bi-person-fill"></i></span>
                <p class="me-1">total user:</p>
            </li>
        </div>
    </div>
    <!--CARDS -->
    <div class="tw-grid lg:tw-grid-cols-3 md:tw-grid-cols-2 container mt-5 gap-4 tw-grid-cols-1 ">

        <!--DAILY LOGS -->
        <div class="card tw-bg-[#003323] text-white">
            <div class="header d-flex justify-content-start align-items-center">
                <img src="../../assets/book.png" alt="" width="70">
                <div class="dropdown">
                    <button class=" tw-bg-transparent tw-active:outline-none dropdown-toggle tw-text-xl " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Daily Logs
                    </button>
                    <ul class="dropdown-menu tw-bg-white">
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                        <li><a class="dropdown-item" href="#">Yearly</a></li>
                    </ul>
                </div>
                <p class=" tw-font-bold"></p>
            </div>
            <div class="md:tw-ms-10 tw-mb-5 tw-ms-0 md:tw-text-start tw-text-center md:tw-mt-10 tw-mt-0 ">
                <p class="tw-text-6xl tw-font-bold">120</p>
                <p class="tw-text-2xl">Attendance</p>
            </div>
        </div>

        <!--Product Sold -->
        <div class="card  tw-bg-[#003323] text-white p-2">
            <div class="header d-flex justify-content-around align-items-center">
                <img src="../../assets/Best Seller.png" alt="" width="70">
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
                    <img src="../../assets/energydrink.png" alt="" width="60" height="60">
                    <img src="../../assets/suplement.png" alt="" width="60" height="60">
                    <img src="../../assets/water.png" alt="" width="60" height="60">
                </div>
            </div>

        </div>

        <!--Monthly Revenue -->
        <div class="card  tw-bg-[#003323] text-white text-center">
            <div class="header d-flex justify-content-start align-items-center">
                <img src="../../assets/Profit.png" alt="" width="70">
                <div class="dropdown">
                    <button class=" tw-bg-transparent tw-active:outline-none dropdown-toggle tw-text-xl " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Monthly Revenue
                    </button>
                    <ul class="dropdown-menu tw-bg-white">
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                        <li><a class="dropdown-item" href="#">Yearly</a></li>
                    </ul>
                </div>
                <p class=" tw-font-bold"></p>
            </div>
            <div class=" mt-3 mb-3">
                <p class="tw-text-6xl tw-font-bold"><span class="tw-text-sm">₱</span>120</p>
                <p class="tw-text-2xl">Monthly Growth</p>
            </div>
        </div>
    </div>


    <!--Responsive Graph CHART-->
    <div class="d-flex flex-column flex-md-row justify-content-evenly align-items-center tw-mt-5 container tw-gap-10">
        <div class="monthly tw-w-full md:tw-w-1/2 lg:tw-w-1/2 tw-h-auto md:tw-h-1/2 lg:tw-h-1/2 tw-mb-4 md:tw-mb-0">
            <div class="tw-rounded-t-lg tw-flex tw-items-center tw-text-white tw-bg-[#003323] px-3 py-1">
                <img src="../../assets/Combo Chart.png" alt="" width="70">
                <h1 class="tw-text-xl ms-3">Monthly</h1>
            </div>
            <canvas class="p-4 tw-bg-[#003323] tw-rounded-b-lg" id="monthlyChart"></canvas>
        </div>

        <!--Growth Rate-->
        <div class="card tw-bg-[#003323] text-white tw-w-full md:tw-w-1/2 tw-h-auto md:tw-h-80">
            <div class="header d-flex justify-content-start align-items-center">
                <img src="../../assets/Increase.png" alt="" class="tw-w-16 tw-h-16">
                <div class="dropdown">
                    <button class="tw-bg-transparent tw-active:outline-none dropdown-toggle tw-text-2xl" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Growth Rate
                    </button>
                    <ul class="dropdown-menu tw-bg-white">
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                        <li><a class="dropdown-item" href="#">Yearly</a></li>
                    </ul>
                </div>
                <p class="tw-font-bold"></p>
            </div>
            <div class="tw-text-center mt-4 mb-3">
            <p class="tw-text-5xl tw-font-bold">UNDER DEVELOPMENT</p>
                <p class="tw-text-5xl tw-font-bold">120</p>
                <p class="tw-text-xl">30 days growth</p>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('monthlyChart');
        const ctx2 = document.getElementById('yearlyChart');


        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Month Sales',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: '#FF6384'
                        }
                    },
                    title: {
                        color: '#FF6384'
                    }
                }
            }
        });
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Month Sales',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


    <div class="footer tw-text-slate-500 text-center md:tw-text-xl bg-black p-3 tw-text-md">
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