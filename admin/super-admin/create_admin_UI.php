<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>
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
    <?php
    include 'header.php';
    ?>

    <!--Queries from database-->

    <?php
    include 'data_queries/create_admin.php';
    ?>

    <!--CREATE USER ACCOUNT BOX-->
    <div
        class="d-flex align-items-center justify-content-center tw-min-h-screen  tw-flex-col lg:tw-flex-row md:tw-flex-row-reverse tw-p-20 tw-px-1 tw-py-3 tw-rounded-lg md:tw-px-0 mt-4 tw-w-full tw-max-w-md tw-mx-auto ">
        <div class="login-box bg-white tw-w-full tw-px-4 tw-py-3 tw-rounded-lg md:tw-px-0 tw-mt-20">
            <h1 class="tw-text-2xl md:tw-text-3xl tw-text-center fw-bold tw-text-[#EA3EF7] mb-3 mb-md-0">
                Create Account <br>
            </h1>

            <div class="form-box tw-w-full d-flex tw-flex-col">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="tw-px-5 lg:tw-py-3 tw-w-full">
                    <!--Fullname-->
                    <div class="tw-mb-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="fullname" required>
                            <label for="floatingInput">Fullname</label>
                        </div>
                    </div>

                    <!--Age-->
                    <div class="tw-mb-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="age" required>
                            <label for="floatingInput">Age</label>
                        </div>

                        <!--Gender-->
                        <h1 class="mt-2 mb-1">Gender</h1>
                        <div class="gender mx-1 fs-6 fw-light">
                            <label>
                                <input type="radio" name="gender" value="Male"> Male
                            </label>
                            <label class="mx-1">
                                <input type="radio" name="gender" value="Female"> Female
                            </label>
                            <label>
                                <input type="radio" name="gender" value="other"> LGBTQ+
                            </label>
                        </div>
                    </div>

                    <!--ADDRESS-->
                    <div class="address">

                        <div class="form-floating ">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="street" required>
                            <label for="floatingInput">Street and Barangay</label>
                        </div>

                        <select id="province" name="province" onchange="populateCities()" class="mt-1">
                            <option value="">Select a Province</option>
                            <option value="Davao Del Sur">Davao Del Sur</option>
                        </select>

                        <select id="city" name="city">
                            <option value="">Select a City</option>
                            <option value="Digos City">Digos City</option>
                            <option value="Mantanao">Mantanao</option>
                            <option value="Gensan">Gensan</option>
                            <option value="Hagonoy">Hagonoy</option>
                            <option value="Padada">Padada</option>
                            <option value="Sulop">Sulop</option>
                            <option value="Malalag">Malalag</option>
                            <option value="Magsaysay">Magsaysay</option>
                            <option value="Bansalan">Bansalan</option>
                            <option value="Santa Cruz">Santa Cruz</option>
                        </select>
                    </div>

                    <!--Birthdate-->
                    <div class="tw-mb-3 mt-3">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="floatingInput" placeholder="name@example.com" name="birthdate" required>
                            <label for="floatingInput">Birthdate</label>
                        </div>
                    </div>
                    <!--PHONENUMBER-->
                    <div class="tw-mb-3 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="phonenumber" required>
                            <label for="floatingInput">Phone Number</label>
                        </div>
                    </div>
                    <!--Email or Username-->
                    <div class="username-email tw-mb-3 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="email_username" required>
                            <label for="floatingInput">Email or Username</label>
                        </div>
                    </div>

                    <!--Passsword-->
                    <div class="password tw-mb-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" name="password" required>
                            <label for="floatingInput">Password</label>
                        </div>

                        <p class="tw-text-xs tw-text-red-500">*Atleast have one uppercase and special characters more than 6 letters</p>

                    </div>
                    <button type="submit" class="tw-bg-[#00e69d] hover:tw-bg-[#00FFAE] tw-duration-100 tw-transition-ease-in tw-w-full tw-py-3 tw-rounded-lg tw-font-bold" name="create_account">
                        Create Account
                    </button>
                </form>
            </div>
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