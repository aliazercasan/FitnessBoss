<?php
include '../data_queries/login_query.php';

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    $stmt = $conn->prepare("SELECT 
        ua.users_account_id,
        ua.username_email,
        ui.fullname,
        ui.gender,
        ui.age,
        ua.account_created
    FROM 
        tbl_users_account ua
    INNER JOIN 
        tbl_users_info ui 
    ON 
        ui.user_info_id = ua.user_info_id
    WHERE 
        ua.users_account_id = ?");

    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
    } else {
        echo "<p>No user found with the specified email/username.</p>";
    }

    $stmt->close();
} else {
    echo "<p>You must be logged in as an admin to view this information.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Management</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

    <!-- Tailwind Framework -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: "tw-",
        };
    </script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: black;
            color: #333;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<?php include 'header.php' ?>
<body>
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container border rounded shadow p-4 bg-light" style="max-width: 500px;">
            <h1 class="text-center mb-4 tw-text-2xl tw-font-semibold">Account Management</h1>

            <form>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" id="fullname" class="form-control" value="<?php echo htmlspecialchars($user_data['fullname']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <input type="text" id="gender" class="form-control" value="<?php echo htmlspecialchars($user_data['gender']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="text" id="age" class="form-control" value="<?php echo htmlspecialchars($user_data['age']); ?>" disabled>
                </div>

                <div class="mb-3">
                    <label for="accountCreated" class="form-label">Account Created</label>
                    <input type="text" id="accountCreated" class="form-control" value="<?php echo htmlspecialchars($user_data['account_created']); ?>" disabled>
                </div>

                <div class="text-center">
                    <button type="button" class="tw-bg-[#00e69d] hover:tw-bg-[#00FFAE] tw-duration-100 tw-transition-ease-in fw-bold tw-w-full tw-py-3 tw-rounded-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">Change Password</button>
                </div>
            </form>
        </div>
    </div>
<?php include 'data_queries/change_admin_password.php'; ?>
    <!-- CHANGE PASSWORD Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($error_mess)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_mess); ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="mb-3">
                            <label for="username_email" class="form-label">Username</label>
                            <input type="text" id="username_email" name="username_email" class="form-control" value="<?php echo htmlspecialchars($user_data['username_email']); ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="newpassword" class="form-label">New Password</label>
                            <input type="password" id="newpassword" name="newpassword" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="tw-bg-[#00e69d] hover:tw-bg-[#00FFAE] tw-duration-100 tw-transition-ease-in fw-bold tw-w-full tw-py-3 tw-rounded-lg" name="btn-changepassword">Save Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
