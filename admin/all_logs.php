<?php
session_start();
// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

include 'data_queries/config.php';
$sql = "SELECT 
    users_account_id,
    fullname,
    category,
    expiration_date,
    attendance_date
    FROM 
        attendance_users";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>All Logs</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
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

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: black;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>
    <div class="container">
        <div class="content">
            <h1><i class="fas fa-clipboard-list"></i> Attendance</h1>
            <div class="table-container tw-mt-40">
                <div class="tw-flex tw-flex-col md:tw-flex-row tw-justify-between tw-items-center">
                    <div class="tw-w-full tw-mb-4 tw-flex tw-justify-center">
                        <input type="text" id="searchBar" class="form-control tw-w-full md:tw-w-1/2 tw-p-2 tw-border tw-border-gray-300 tw-rounded-lg" placeholder="Search by Account ID or Name">
                    </div>
                    <div class="dropdown tw-w-full tw-mb-4 md:tw-mb-0 md:tw-w-auto">
                        <button class="tw-bg-[#00FFAE] px-3 py-1 tw-rounded-lg text-black dropdown-toggle mb-3 w-full md:w-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Over All
                        </button>
                        <ul class="dropdown-menu tw-w-full md:tw-w-auto">
                            <li><a class="dropdown-item" href="#">Monthly</a></li>
                            <li><a class="dropdown-item" href="#">Session</a></li>
                            <li><a class="dropdown-item" href="#">Walk In</a></li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark tw-w-full" id="dataTable">
                        <div class="tw-overflow-x-auto tw-max-h-96 tw-scrollbar-thin tw-scrollbar-thumb-gray-400 tw-scrollbar-track-gray-200">
                            <thead>
                                <tr>
                                    <th>Account ID</th>
                                    <th>Name</th>
                                    <th>Monthly or Session</th>
                                    <th>Expiration Date</th>
                                    <th>Attendace Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="tw-text-[#1a8cff]"><?php echo $row['users_account_id']; ?></td>
                                        <td class="tw-text-[#]"><?php echo $row['fullname']; ?></td>
                                        <td class="tw-text-[#1a8cff]">
                                            <?php if ($row['category'] == 'session') {
                                                echo '<span class="tw-text-[#00FFAE]">session</span>';
                                            } else {
                                                echo '<span class="tw-text-[#EA3EF7]">monthly</span>';
                                            } ?>
                                        </td>
                                        <td class="tw-text-[#1a8cff]"><?php echo $row['expiration_date']; ?></td>
                                        <td class="tw-text-[#1a8cff]"><?php echo $row['attendance_date']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <footer class="footer tw-text-center tw-text-slate-500 tw-mt-5 tw-mb-5 tw-fixed tw-bottom-0 tw-w-full">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
        </div>
    </footer>


    <script>
        document.getElementById('searchBar').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('#dataTable tbody tr');

            rows.forEach(row => {
                const accountId = row.cells[0].textContent.toLowerCase();
                const name = row.cells[1].textContent.toLowerCase();

                if (accountId.includes(filter) || name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>