<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../../login.php");
    exit();
}

include 'data_queries/config.php'; // Ensure this file contains the DB connection

// Prepare the search query safely
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT 
    ua.users_account_id, 
    ui.fullname, 
    ua.status, 
    ua.expiration_membership, 
    ua.type_member, 
    ua.account_created
FROM 
    tbl_users_account ua
INNER JOIN 
    tbl_users_info ui ON ua.user_info_id = ui.user_info_id
WHERE 
    ua.role = 'user'";


// Add search functionality if search parameter exists
if (!empty($search)) {
    $sql .= " AND (ua.users_account_id LIKE ? OR ui.fullname LIKE ? OR ui.address LIKE ?)";
}

// Prepare the statement
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Error preparing the query: ' . $conn->error);
}

// Bind the parameters for search if necessary
if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm); // Bind three times for three search fields
}

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Dashboard</title>
    <link rel="icon" href="../assets/logo.jpg" type="image/x-icon">

    <!-- CSS Sheet -->
    <link rel="stylesheet" href="style.css" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Tailwind Framework -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind config -->
    <script>
        tailwind.config = {
            prefix: "tw-",
        };
    </script>
</head>

<body class="bg-black lg:tw-p-5 md:tw-p-3 tw-p-0">

    <div class="container-fluid tw-min-h-screen tw-flex tw-flex-col">
        <div class="d-flex align-items-center justify-content-start">
            <a href="dashboard-admin.php" class="tw-text-[#EA3EF7] tw-text-3xl tw-mb-3 me-3">
                <i class="bi bi-arrow-90deg-left"></i>
            </a>
            <h1 class="tw-text-3xl tw-font-bold tw-text-white tw-mb-3">User List</h1>
        </div>

        <div class="row tw-mx-auto tw-max-w-7xl tw-w-full">
            <div class="col-12 col-md-6 col-lg-4 tw-mx-auto tw-my-5">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="tw-flex tw-flex-col sm:tw-flex-row tw-items-center tw-justify-center tw-gap-3">
                    <div class="tw-flex tw-gap-3">
                        <input type="text" name="search" class="form-control tw-w-full sm:tw-w-96" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search for Account ID">
                        <button type="submit" class="tw-border-2 tw-rounded-lg px-3 tw-text-white ms-3 hover:tw-bg-[#00FFAE] hover:tw-border-[#00FFAE] tw-duration-300 tw-ease-in-out hover:tw-text-black">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-md-12 col-lg-12 tw-mx-auto tw-my-5">
                <div class="table-responsive">
                    <table class="table table-dark table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Account ID</th>
                                <th scope="col">Fullname</th>
                                <th scope="col">Membership Expired</th>
                                <th scope="col">
                                    <div class="btn-group">
                                        <button type="button" class=" dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Status
                                        </button>
                                        <ul class="dropdown-menu bg-black ">
                                            <li><a class="dropdown-item hover:tw-bg-[#00FFAE] tw-text-[#00FFAE] tw-transition-ease-in-out tw-duration-200" href="#">Active</a></li>
                                            <li><a class="dropdown-item dropdown-item hover:tw-bg-yellow-500 tw-text-yellow-500 tw-transition-ease-in-out tw-duration-200" href="#">Inactive</a></li>
                                        </ul>
                                    </div>
                                </th>
                                <th scope="col">Type of Membership</th>
                                <th scope="col">Account Created</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['users_account_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['expiration_membership']); ?></td>
                                    <td><?php
                                        if ($row['status'] == 'active') {
                                            echo '<span class="tw-text-[#00FFAE]">active</span>';
                                        } else {
                                            echo '<span class="tw-text-[#EA3EF7]">inactive</span>';
                                        }
                                    ?></td>
                                    <td><?php echo htmlspecialchars($row['type_member']); ?></td>
                                    <td><?php echo htmlspecialchars($row['account_created']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="footer tw-text-slate-500 text-center tw-mt-5 tw-mb-5">
        <div>
            <h1>&copy; Copyright 2024 by Visionary Creatives X Fitness Boss</h1>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>