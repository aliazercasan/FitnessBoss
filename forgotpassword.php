<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="./assets/logo.jpg" type="image/x-icon">
    <title>Forgot Password</title>
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

<body>
    <?php include 'data_queries/forgotpassword_query.php' ?>

    <!--Change Password Container-->
    <div class="d-flex align-items-center justify-content-center tw-min-h-screen tw-bg-black">
        <div class="login-box d-flex flex-column flex-md-row align-items-center justify-content-between tw-w-full md:tw-w-3/4 lg:tw-w-1/2 tw-px-5 tw-py-3 tw-rounded-lg tw-shadow-lg bg-white">

            <div class="tw-w-full md:tw-w-1/2 tw-flex tw-items-center tw-justify-center mb-3 mb-md-0">
                <img src="assets/logo.jpg" alt="" class="tw-h-[150px] md:tw-h-[250px]" />
            </div>
            <div class="form-box tw-w-full md:tw-w-1/2 tw-flex tw-items-center tw-justify-center">
                <div class="tw-w-full tw-max-w-md">
                    <h1 class="tw-text-2xl md:tw-text-3xl tw-text-center fw-bold tw-text-[#EA3EF7] mb-3 mt-3">
                        CHANGE PASSWORD
                    </h1>
    <!--Change Password FORM-->
                    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="tw-px-5 tw-py-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="email_username">
                            <label for="floatingInput">Email or Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="newpassword">
                            <label for="floatingPassword">New Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingPassword" placeholder="Password" name="confirmpassword">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                        

                        <button type="submit" class="tw-bg-[#00e69d] hover:tw-bg-[#00FFAE] tw-duration-100 tw-transition-ease-in fw-bold tw-w-full tw-py-3 tw-rounded-lg" name="btn-changepassword">
                            Submit
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>