<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
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


    <?php
    include 'data_queries/config.php';
    $sql = "SELECT 
    tbl_users_account.users_account_id,
    tbl_users_info.fullname,
    tbl_users_info.address,
    tbl_users_info.gender,
    tbl_users_info.age,
    tbl_users_account.type_member,
    tbl_users_account.status,
    tbl_users_account.expiration_membership

    FROM 
        tbl_users_account
    INNER JOIN 
        tbl_users_info 
    ON 
        tbl_users_info.user_info_id = tbl_users_account.user_info_id 
    WHERE 
        tbl_users_account.type_member IN ('vip', 'regular');
    ";

    $result = $conn->query($sql);
    ?>


    <div class="d-flex align-items-center justify-content-start tw-mt-40 mx-4 container">
        <img src="../assets/People.png" alt="">
        <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3">Members</h1>
    </div>

    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center  tw-px-4 container md:tw-mt-0  tw-mt-40">
        <!-- Search Bar -->
        <div class="tw-w-full tw-mb-4 tw-flex tw-justify-center">
            <input type="text" id="searchBar" class="form-control tw-w-full md:tw-w-1/2 tw-p-2 tw-border tw-border-gray-300 tw-rounded-lg" placeholder="Search by Account ID or Name">
        </div>

        <!-- Table Container -->
        <div class="tw-overflow-x-auto tw-w-full">
            <div class="tw-overflow-x-auto tw-max-h-96 tw-scrollbar-thin tw-scrollbar-thumb-gray-400 tw-scrollbar-track-gray-200">
                <table class="table table-dark tw-w-full" id="dataTable">
                    <thead>
                        <tr>
                            <th scope="col">Account ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Age</th>
                            <th scope="col">Membership Expire</th>
                            <th scope="col">Type of Membership</th>
                            <th scope="col">
                                <div class="dropdown">
                                    <button class=" dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="active_member.php">Active</a></li>
                                        <li><a class="dropdown-item" href="inactive_member.php">Inactive </a></li>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td class="tw-text-[#1a8cff]"><?php echo $row['users_account_id']; ?></td>
                                <td class="tw-text-[#1a8cff]"><?php echo $row['fullname']; ?></td>
                                <td class="tw-text-[#1a8cff]"><?php echo $row['address']; ?></td>
                                <td>
                                    <?php if ($row['gender'] == 'male') {
                                        echo '<span class="tw-text-[#1a8cff]">Male</span>';
                                    } else if ($row['gender'] == 'female') {
                                        echo '<span class="tw-text-[#ff33ff]">Female</span>';
                                    } else {
                                        echo '<span class="tw-text-[#A020F0]">Other</span>';
                                    } ?>
                                </td>
                                <td class="tw-text-[#1a8cff]"><?php echo $row['age']; ?></td>
                                <td class="tw-text-[#1a8cff]"><?php echo $row['expiration_membership']; ?></td>
                                <td class="tw-text-[#1a8cff]">
                                    <?php if ($row['type_member'] == 'regular') {
                                        echo '<span class="tw-text-[#00FFAE]">Regular</span>';
                                    } else {
                                        echo '<span class="tw-text-[#EA3EF7]">VIP</span>';
                                    } ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'active') {
                                        echo '<span class="tw-text-[#00FFAE]">Active</span>';
                                    } else if ($row['status'] == 'expired') {
                                        echo '<span class="tw-text-[#FFC508]">Expired</span>';
                                    } else {
                                        echo '<span class="tw-text-red-500">Inactive</span>';
                                    } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="footer tw-text-center tw-text-slate-500 tw-mt-5 tw-mb-5 tw-fixed tw-bottom-0 tw-w-full">
        <div>
            <h1>&copy; 2024 Visionary Creatives X Fitness Boss. All Rights Reserved.</h1>
        </div>
    </footer>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- Search Functionality -->
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
</body>

</html>