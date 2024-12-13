<nav class="navbar navbar-expand-lg bg-black fixed-top">
    <div class="container">
        <img src="../assets/minilogo.png" alt="" width="80">
        <a class="navbar-brand tw-text-3xl fw-bold text-white" href="index.php"><span class="tw-text-[#00FFAE]">Fitness</span><span
                class="tw-text-[#EA3EF7]">Boss</span></a>
        <div class="tw-bg-[#00FFAE] rounded">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-white"><span class="navbar-toggler-icon"></span></span>
            </button>
        </div>

        <div class="collapse navbar-collapse md:tw-justify-end tw-justify-center lg:tw-mt-0 tw-mt-10"
            id="navbarSupportedContent">
            <ul class="nav lg:tw-flex md:tw-block tw-block text-center">
                <li class="nav-item active me-2">
                    <div class="d-flex align-items-center">
                        <img src="../assets/Dashboard Layout.png" alt="">
                        <a class="nav-link tw-text-slate-200 hover:tw-text-slate-200"
                            href="index.php">Dashboard</a>
                    </div>
                </li>
                <li class="nav-item me-2">
                    <div class="d-flex align-items-center">
                        <img src="../assets/Activity History wan.png" alt="">
                        <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="payment_history.php">Payment History
                        </a>
                    </div>
                </li>
                

                <div class="dropdown mt-3 mb-2 tw-block text-end lg:tw-hidden">
                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="tw-text-[#EA3EF7] tw-text-3xl"><i class="bi bi-person-circle"></i></span>
                    </button>
                    <ul class="dropdown-menu tw-bg-black">
                        <li class=""><a class="dropdown-item hover:tw-bg-[#00FFAE] tw-text-[#00FFAE] tw-transition-ease-in-out tw-duration-200" href="profile.php">Profile</a></li>

                        <li><a class="dropdown-item hover:tw-bg-red-500 tw-text-red-500 tw-transition-ease-in-out tw-duration-200 hover:tw-text-black" href="data_queries/destroy_logout.php">Logout</a></li>
                    </ul>
                </div>
            </ul>
        </div>


        <div class="dropdown ms-2 md:tw-hidden tw-hidden lg:tw-block tw-text-white">
            <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="tw-text-[#EA3EF7] tw-text-3xl"><i class="bi bi-person-circle"></i></span>
            </button>
            <ul class="dropdown-menu tw-bg-black">
                <li class=""><a class="dropdown-item hover:tw-bg-[#00FFAE] tw-text-white tw-transition-ease-in-out tw-duration-200" href="profile.php">Profile</a></li>
                
                <li><a class="dropdown-item hover:tw-bg-red-500 tw-text-white tw-transition-ease-in-out tw-duration-200 hover:tw-text-black" href="data_queries/destroy_logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>