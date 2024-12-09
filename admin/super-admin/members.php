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
    tbl_users_account.date_membership

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
    <div class="tw-h-screen tw-mt-40">
        <div>
            <div class="d-flex align-items-center mx-5 mb-3">
                <img src="../../assets/People.png" alt="">
                <h1 class="ms-3 tw-text-2xl tw-text-white">Members</h1>
            </div>
        </div>

        <div class=" tw-flex tw-items-center tw-justify-center table-responsive">
            <table class="table mx-5 table-dark table-striped align-middle">
                <thead>
                    <tr class="">
                        <!--ID-->
                        <th scope="col ">Id</th>

                        <!--Name-->
                        <th scope="col ">Name</th>


                        <!--Address-->
                        <th scope="col">Address</th>

                        <!--Gender-->
                        <th scope="col bg-black">
                            <div class="dropdown">
                                <a class="fw-bold btn btn-secondary dropdown-toggle tw-bg-transparent text-white tw-border-none hover:tw-bg-transparent p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="this.style.backgroundColor='transparent'">
                                    Gender
                                </a>

                                <ul class="dropdown-menu bg-black">
                                    <li><a class="dropdown-item tw-text-[#1a8cff] hover:tw-bg-[#1a8cff] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">Male</a></li>

                                    <li><a class="dropdown-item tw-text-[#ff33ff] hover:tw-bg-[#ff33ff] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">Female</a></li>

                                    <li><a class="dropdown-item tw-text-[#A020F0] hover:tw-bg-[#A020F0] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">Other</a></li>
                                </ul>
                            </div>
                        </th>

                        <!--Age-->
                        <th scope="col">Age</th>

                        <!--Date of Membership-->
                        <th scope="col">Date of Membership</th>

                        <!--Type of Membership-->
                        <th scope="col">
                            <div class="dropdown">
                                <a class="fw-bold btn btn-secondary dropdown-toggle tw-bg-transparent text-white tw-border-none hover:tw-bg-transparent p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="this.style.backgroundColor='transparent'">
                                    Type of Membership
                                </a>

                                <ul class="dropdown-menu bg-black">
                                    <li><a class="dropdown-item tw-text-[#EA3EF7] hover:tw-bg-[#EA3EF7] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">VIP</a></li>

                                    <li><a class="dropdown-item tw-text-[#00FFAE] hover:tw-bg-[#00FFAE] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">Regular</a></li>


                                </ul>
                            </div>
                        </th>

                        <!-- Status-->
                        <th scope="col">
                            <div class="dropdown">
                                <a class="fw-bold btn btn-secondary dropdown-toggle tw-bg-transparent text-white tw-border-none hover:tw-bg-transparent p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="this.style.backgroundColor='transparent'">
                                    Status
                                </a>

                                <ul class="dropdown-menu bg-black">
                                    <li><a class="dropdown-item tw-text-[#00FFAE] hover:tw-bg-[#00FFAE] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">Active</a></li>

                                    <li><a class="dropdown-item tw-text-[#FFC508] hover:tw-bg-[#FFC508] hover:tw-text-black tw-transition-ease-in-out tw-duration-200" href="#" onclick="this.parentElement.parentElement.previousElementSibling.style.backgroundColor='transparent'">Inactive</a></li>
                                </ul>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="mt-4">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['users_account_id']; ?></td>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['fullname']; ?></td>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['address']; ?></td>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['gender']; ?></td>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['age']; ?></td>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['date_membership']; ?></td>
                            <td class=" tw-text-[#1a8cff]"><?php echo $row['type_member']; ?></td>
                            <td class=" tw-text-[#1a8cff] tw-text-[#]"><?php echo $row['status']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="footer tw-text-slate-500 text-center md:tw-text-md bg-black p-3 tw-text-md">
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