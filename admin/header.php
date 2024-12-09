<nav class="navbar navbar-expand-lg bg-black fixed-top">
  <div class="container">
    <img src="../assets/minilogo.png" alt="" width="80">
    <a class="navbar-brand tw-text-3xl fw-bold text-white" href="dashboard-admin.php"><span class="tw-text-[#00FFAE]">Fitness</span><span
        class="tw-text-[#EA3EF7]">Boss</span></a>
    <div class="tw-bg-[#00FFAE] rounded">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="text-white"><span class="navbar-toggler-icon"></span></span>
      </button>
    </div>

    <div class="collapse navbar-collapse justify-content-center lg:tw-mt-0 tw-mt-10"
      id="navbarSupportedContent">
      <ul class="nav lg:tw-flex md:tw-block tw-block text-center">
        <li class="nav-item me-2">

          <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="dashboard-admin.php"><span class="tw-text-[#EA3EF7] tw-text-xl me-2"><i class="bi bi-calendar-range"></i></span>Overview</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="coaches.php"><span class="tw-text-[#EA3EF7] tw-text-xl me-2"><i class="bi bi-person-raised-hand"></i></span>Coaches</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="create-user.php"><span class="tw-text-[#EA3EF7] tw-text-xl me-2"><i class="bi bi-person-add"></i></span>Account Creation</a>
        </li>
        <li class="nav-item me-2">
          <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="members.php"><span class="tw-text-[#EA3EF7] tw-text-xl me-2"><i class="bi bi-people"></i></span>Members</a>
        </li>

        <li class="nav-item me-2">
          <a class="nav-link tw-text-slate-400 hover:tw-text-slate-200" href="payment_method_admin.php"><span class="tw-text-[#EA3EF7] tw-text-xl me-2"><i class="bi bi-people"></i></span>Payment</a>
        </li>

        <div class="dropdown mt-3 mb-2 tw-block text-end lg:tw-hidden">
          <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="tw-text-[#EA3EF7] tw-text-3xl"><i class="bi bi-person-circle"></i></span>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="renew_user_membership.php">Renew Membership</a></li>
            <li><a class="dropdown-item" href="data_queries/destroy_logout.php">Logout</a></li>
          </ul>
        </div>
      </ul>
    </div>


    <div class="dropdown ms-2 md:tw-hidden tw-hidden lg:tw-block">
      <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="tw-text-[#EA3EF7] tw-text-3xl"><i class="bi bi-person-circle"></i></span>
      </button>
      <ul class="dropdown-menu tw-bg-black">
        <li><a class="dropdown-item hover:tw-bg-[#00FFAE] tw-text-[#00FFAE] tw-transition-ease-in-out tw-duration-200" href="#">Profile</a></li>
        <li><a class="dropdown-item hover:tw-bg-[#EA3EF7] tw-text-[#EA3EF7] tw-transition-ease-in-out tw-duration-200" href="renew_user_membership.php">Renew Membership</a></li>

        <li><a class="dropdown-item hover:tw-bg-[#EA3EF7] tw-text-white tw-transition-ease-in-out tw-duration-200" href="add_products.php">Add Product</a></li>

        <li><a class="dropdown-item hover:tw-bg-red-500 tw-text-red-500 tw-transition-ease-in-out tw-duration-200 hover:tw-text-black" href="data_queries/destroy_logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>