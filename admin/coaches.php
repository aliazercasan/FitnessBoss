<html>

<head>
    <title>
        Coaches
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    
    
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
    
    
    
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #000;
            color: #fff;
            font-family: 'Poppins',sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #111;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar .menu {
            display: flex;
            align-items: center;
        }

        .navbar .menu a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            display: flex;
            align-items: center;
        }

        .navbar .menu a i {
            margin-right: 5px;
        }

        .navbar .menu a:hover {
            color: #ff00ff;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
        }

        .navbar .user-info .total-users {
            background-color: #00ff00;
            color: #000;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 10px;
        }

        .navbar .user-info .user-icon {
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            display: flex;
            align-items: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .content h1 i {
            margin-right: 10px;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #004d40;
            color: #fff;
        }

        td {
            background-color: #4a235a;
        }

        td img {
            width: 100px;
            height: 100px;
            border-radius: 10px;
        }

        .status-active {
            color: #00ff00;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #111;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include 'header.php' ?>
    <div class="content tw-mt-20 container">
        <h1>
            <i class="fas fa-dumbbell">
            </i>
            Coaches
        </h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>
                            Profile
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Contact #
                        </th>
                        <th>
                            Gender
                        </th>
                        <th>
                            Age
                        </th>
                        <th>
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <img alt="Profile picture of a coach in a gym" height="100" src="https://storage.googleapis.com/a1aa/image/Ju2eAdXjZ3x6cqnM84vaGxTuTIEItxsfpZ8h5uMDbnDB3g2TA.jpg" width="100" />
                        </td>
                        <td>
                            asdasdsad
                        </td>
                        <td>
                            asdadssadas
                        </td>
                        <td>
                            09222215231
                        </td>
                        <td>
                            M
                        </td>
                        <td>
                            27
                        </td>
                        <td class="status-active">
                            Active
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img alt="Profile picture of a coach in a gym" height="100" src="https://storage.googleapis.com/a1aa/image/Ju2eAdXjZ3x6cqnM84vaGxTuTIEItxsfpZ8h5uMDbnDB3g2TA.jpg" width="100" />
                        </td>
                        <td>
                            asdasdsad
                        </td>
                        <td>
                            asdadssadas
                        </td>
                        <td>
                            09222215231
                        </td>
                        <td>
                            M
                        </td>
                        <td>
                            27
                        </td>
                        <td class="status-active">
                            Active
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img alt="Profile picture of a coach in a gym" height="100" src="https://storage.googleapis.com/a1aa/image/Ju2eAdXjZ3x6cqnM84vaGxTuTIEItxsfpZ8h5uMDbnDB3g2TA.jpg" width="100" />
                        </td>
                        <td>
                            asdasdsad
                        </td>
                        <td>
                            asdadssadas
                        </td>
                        <td>
                            09222215231
                        </td>
                        <td>
                            F
                        </td>
                        <td>
                            27
                        </td>
                        <td class="status-active">
                            Active
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <footer>
        @ 2024 by Visionary Creatives x FitnessBoss Gym
    </footer>
</body>

</html>