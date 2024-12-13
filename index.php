<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="fontstyle.css" />
    <link rel="icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Fitness Boss</title>
    <!--CSS SHEET-->
    <link rel="stylesheet" href="style.css">
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
</head>

<body>
    <!--NAVIGATION BAR-->
    <nav class="navbar navbar-expand-lg bg-black fixed-top">
        <div class="container">
            <img src="assets/minilogo.png" alt="" width="70">
            <a class="navbar-brand tw-text-xl fw-bold text-white" href="#"><span class="tw-text-[#00FFAE]">Fitness</span><span
                    class="tw-text-[#EA3EF7]">Boss</span></a>
            <button class="navbar-toggler tw-bg-[#00FFAE]" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="nav navbar-nav ms-auto lg:tw-text-start md:tw-text-center md:tw-mt-0 tw-mt-10 tw-text-center tw-text-sm">
                    <li class="nav-item active me-2">
                        <a class="nav-link tw-text-slate-200 hover:tw-text-slate-200"
                            href="#">HOME</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="#about-us">WHO WE
                            ARE</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="#coaches">MEET THE COACHES</a>
                    </li>

                    <li class="nav-item md:tw-my-0 tw-my-5 tw-text-end">
                        <a href="login.php"><button data-bs-toggle="modal" data-bs-target="#signinModal"
                                class="tw-text-black tw-font-bold py-2 px-4 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d] hover:tw-bg-[#00FFAE]">SIGN IN
                            </button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--HERO PAGE CONTENT-->
    <div class="tw-relative lg:tw-h-[750px] tw-h-[750px] tw-bg-black">
        <div id="carouselExampleSlidesOnly" class="carousel slide tw-h-full tw-opacity-80" data-bs-ride="carousel">
            <div class="carousel-inner tw-h-full tw-mt-10">
                <div class="carousel-item active tw-h-full">
                    <img src="assets/gym1.jpg" class="tw-object-cover tw-w-full tw-h-full tw-opacity-80" alt="Coach 1" />
                </div>
                <div class="carousel-item tw-h-full">
                    <img src="assets/gym12jpg.jpg" class="tw-object-cover tw-w-full tw-h-full" alt="Coach 2" />
                </div>
                <div class="carousel-item tw-h-full">
                    <img src="assets/gym2.jpg" class="tw-object-cover tw-w-full tw-h-full" alt="Coach 3" />
                </div>
            </div>
        </div>
        <div class="tw-absolute tw-inset-0 tw-flex tw-items-center tw-justify-center">
            <div class="tw-text-center">
                <h1 class="lg:tw-text-9xl tw-tracking-widest md:tw-text-7xl tw-text-5xl tw-font-bold tw-text-red-600">
                    <span class="tw-text-[#00FFAE]">FITNESS</span><span class="tw-text-[#EA3EF7]">BOSS</span>
                </h1>
                <h1 class="md:tw-text-6xl tw-text-4xl tw-font-bold tw-text-white">
                    GYM TRAINER
                </h1>
                <h1 class="md:tw-text-xl tw-text-sm tw-font-bold tw-text-white mt-2">"Create the Best Version of Yourself"</h1>
            </div>
        </div>
    </div>


    <!--MIDDLE PAGE COTENT-->
    <div class="tw-mt-20">
        <div class="div d-flex flex-column flex-lg-row justify-content-around align-items-center mt-">
            <div class="picture bg-black p-4 rounded-circle d-flex justify-content-center align-items-center">
                <img src="assets/coach4.png" alt="" class="img-fluid lg:tw-w-full tw-w-60" />
            </div>

            <div class="d-flex flex-column justify-content-center align-items-center lg:tw-mt-0 tw-mt-10">
                <h1 class="text-center tw-text-4xl md:tw-text-5xl fw-bold tw-text-[#EA3EF7] mb-2">
                    WHY CHOOSE US?
                </h1>
                <h1 class="text-center tw-text-base tw-text-lg md:tw-text-xl fw-bold tw-mb-10">
                    PUSH YOUR LIMITS FORWARD
                </h1>
                <div class="parent-container d-flex flex-wrap justify-content-center">
                    <div class="content-for-iconstext-center tw-mb-4 ">
                        <img src="assets/Treadmill.png" alt="" width="100" class="tw-mx-auto" />
                        <p class="tw-text-base sm:tw-text-lg md:tw-text-md">
                            Quality Machine
                        </p>
                    </div>
                    <div class="content-for-icons tw-mb-4 tw-mx-20">
                        <img src="assets/Barbell.png" alt="" width="100" class="tw-mx-auto" />
                        <p class="tw-text-base sm:tw-text-lg md:tw-text-md">
                            Quality Training
                        </p>
                    </div>

                    <div class="content-for-icons tw-mb-4 tw-mx-2">
                        <img src="assets/Heart with Pulse.png" alt="" width="100" class="tw-mx-auto" />
                        <p class="tw-text-base sm:tw-text-lg md:tw-text-md">
                            Quality Health
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--ABOUT US PAGE CONTENT-->
    <div class="bg-black text-white p-5 mt-5" id="about-us">
        <div class="container">
            <h1 class="tw-text-5xl md:tw-text-6xl tw-font-bold tw-text-[#EA3EF7] text-start mb-1">
                ABOUT US
            </h1>
         
        </div>
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="about-fitnessGym tw-w-full md:tw-w-1/2 tw-mb-10 md:tw-mb-0">
                <p class="tw-text-base tw-text-lg md:tw-text-xl lg:tw-text-start tw-text-center md:tw-mt-0 tw-mt-5 tw-text-justify">
                    Welcome to FitnessBoss, where fitness meets community. Our mission is to inspire individuals to reach their full potential through personalized training, a supportive environment, and state-of-the-art equipment. Whether you're just starting your fitness journey or are a seasoned athlete, our expert trainers are here to guide you every step of the way. We believe that fitness is more than just a workout—it's about building confidence, improving health, and achieving personal goals. At FitnessBoss, we foster a positive and motivating atmosphere where every member feels empowered to succeed. Join us today and experience the difference in your fitness journey!
                </p>
            </div>
            <div class="img-coach tw-w- md:tw-w-1/2 tw-bg-white rounded-circle z-0">
                <img src="assets/logo.jpg" alt="" class="tw-w-full tw-h-full md:tw-p-10 tw-p-5" />
            </div>
        </div>
    </div>


    <!--COACHES PAGE CONTENT-->
    <div class="bg-black tw-py-20" id="coaches">
        <h1 class="text-center tw-text-5xl md:tw-text-6xl mb-5 tw-text-[#EA3EF7] tw-font-bold">
            MEET THE COACHES
        </h1>
        <!--(COACHES CONTAINER)-->
        <div class="teams d-flex flex-wrap justify-content-center container">
            <!--CEO FOUNDER(TEAM)-->
            <div class="tw-px-5 tw-mb-5 tw-w-full md:tw-w-1/2 lg:tw-w-1/4">
                <!--PARENT-->
                <div
                    class="card position-relative hover:tw-scale-105 tw-transition tw-duration-300 tw-h-full tw-mx-auto">
                    <img src="assets/coach3.png" class="card-img-top tw-h-[250px]" alt="..." />
                    <!--CHILD-->
                    <div
                        class="card-body position-absolute tw-bottom-0 text-center w-100 tw-text-transparent hover:tw-text-black hover:tw-bg-[#00FFAE] hover:tw-bg-opacity-100 tw-h-full tw-transition tw-duration-300 ease-in-out">
                        <h1 class="tw-mt-20">BRIAN HUNDER</h1>
                        <hr />
                        <p>Coach</p>
                    </div>
                </div>
            </div>
           
            <!--COACH ALIHANDRO-->
            <div class="tw-px-5 tw-mb-5 tw-w-full md:tw-w-1/2 lg:tw-w-1/4">
                <!--PARENT-->
                <div
                    class="card position-relative hover:tw-scale-105 tw-transition tw-duration-300 tw-h-full tw-mx-auto">
                    <img src="assets/coach5.png" class="card-img-top tw-h-[250px]" alt="..." />
                    <!--CHILD-->
                    <div
                        class="card-body position-absolute tw-bottom-0 text-center w-100 tw-text-transparent hover:tw-text-black hover:tw-bg-[#00FFAE] hover:tw-bg-opacity-100 tw-h-full tw-transition tw-duration-300 ease-in-out">
                        <h1 class="tw-mt-20">Jay-Ar Calibay</h1>
                        <hr />
                        <p>COACH</p>
                    </div>
                </div>
            </div>

            <!--COACH ZALSALAH-->
            <div class="tw-px-5 tw-mb-5 tw-w-full md:tw-w-1/2 lg:tw-w-1/4">
                <!--PARENT-->
                <div
                    class="card position-relative hover:tw-scale-105 tw-transition tw-duration-300 tw-h-full tw-mx-auto">
                    <img src="assets/coach6.png" class="card-img-top tw-h-[250px]" alt="..." />
                    <!--CHILD-->
                    <div
                        class="card-body position-absolute tw-bottom-0 text-center w-100 tw-text-transparent hover:tw-text-black hover:tw-bg-[#00FFAE] hover:tw-bg-opacity-100 tw-h-full tw-transition tw-duration-300 ease-in-out">
                        <h1 class="tw-mt-20">Jelo Bacalso</h1>
                        <hr />
                        <p>COACH</p>
                    </div>
                </div>
            </div>

           

           
        </div>
    </div>
    <div class="footer tw-text-slate-500 text-center md:tw-text-sm bg-black p-3 tw-text-md">
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