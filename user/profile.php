<?php
session_start();
include 'data_queries/config.php';

if (isset($_SESSION['username_email'])) {
  $username_email = $_SESSION['username_email'];

  // SQL query
  $sql = "
        SELECT 
            ua.username_email,
            ua.password,
            ua.role,
            ua.account_created,
            ui.fullname,
            ui.gender,
            ui.age
        FROM 
            tbl_users_account ua
        INNER JOIN 
            tbl_users_info ui 
        ON 
            ui.user_info_id = ua.user_info_id
        WHERE 
            ua.username_email = ?
        LIMIT 1
    ";

  $stmt = $conn->prepare($sql);
  if ($stmt) {
    // Bind the parameter
    $stmt->bind_param("s", $username_email);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      // Fetch the row as an associative array
      $row = $result->fetch_assoc();
      $_SESSION['fullname'] = $row['fullname'];
      $_SESSION['gender'] = $row['gender'];
      $_SESSION['age'] = $row['age'];
      $_SESSION['account_created'] = $row['account_created'];
    } else {
      echo "<p>No user data found.</p>";
    }

    $stmt->close();
  } else {
    echo "Error preparing the query: " . $conn->error;
  }
} else {
  echo "<p>User is not logged in.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Management</title>

  <!--Google Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ultra&display=swap" rel="stylesheet">

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
<!-- navigation  -->
<?php include 'navigation.php' ?>

<body>
  <div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container border rounded shadow p-4 bg-light" style="max-width: 500px;">
      <h1 class="text-center mb-4">Account Management</h1>

      <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="mb-3">
          <label for="fullname" class="form-label">Username</label>
          <input type="text" id="fullname" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username_email']); ?>" disabled>
        </div>

        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <input type="text" id="gender" class="form-control" value="<?php echo htmlspecialchars($_SESSION['gender']); ?>" disabled>
        </div>

        <div class="mb-3">
          <label for="age" class="form-label">Age</label>
          <input type="text" id="age" class="form-control" value="<?php echo htmlspecialchars($_SESSION['age']); ?>" disabled>
        </div>

        <div class="mb-3">
          <label for="accountCreated" class="form-label">Account Created</label>
          <input type="text" id="accountCreated" class="form-control" value="<?php echo htmlspecialchars($_SESSION['account_created']); ?>" disabled>
        </div>

        <div class="text-center">
          <button type="button" class="tw-bg-[#00e69d] hover:tw-bg-[#00FFAE] tw-duration-100 tw-transition-ease-in fw-bold tw-w-full tw-py-3 tw-rounded-lg" data-bs-toggle="modal" data-bs-target="#exampleModal">Change Password</button>
        </div>
      </form>
    </div>
  </div>

  <!--forgot_user_password query -->
  <?php include 'data_queries/forgot_user_password.php' ?>


  <!-- CHANGE PASSWORD Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Display error message -->
          <?php if (!empty($error_mess)): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo htmlspecialchars($error_mess); ?>
            </div>
          <?php endif; ?>
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-3">
              <label for="username_email" class="form-label">Username</label>
              <input type="text" id="username_email" name="username_email" class="form-control"
                value="<?php echo htmlspecialchars($_SESSION['username_email']); ?>" readonly>
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