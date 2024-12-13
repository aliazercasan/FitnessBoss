<?php

$attendance_days = []; // Array to store attendance days

// Check if the user is logged in
if (isset($_SESSION['users_account_id'])) {
    // Query to get all attendance dates for the user
    $attendance_query = "SELECT DATE(attendance_date) as date FROM attendance_users WHERE users_account_id = ?";
    $stmt = $conn->prepare($attendance_query);
    $stmt->bind_param("i", $_SESSION['users_account_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the attendance dates in an array
    while ($row = $result->fetch_assoc()) {
        $attendance_days[] = $row['date'];
    }
}
?>

<?php
$attendance_days = []; // Array to store attendance days

// Check if the user is logged in
if (isset($_SESSION['users_account_id'])) {
    // Query to get all attendance dates for the user
    $attendance_query = "SELECT DATE(attendance_date) as date FROM attendance_users WHERE users_account_id = ?";
    $stmt = $conn->prepare($attendance_query);
    $stmt->bind_param("i", $_SESSION['users_account_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the attendance dates in an array
    while ($row = $result->fetch_assoc()) {
        $attendance_days[] = $row['date'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaScript Calendar</title>
    <style>
        /* Responsive Calendar Styles */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
        }

        .attended-day {
            background-color: #32CD32;
            color: white;
            border-radius: 5px;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .navigation button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #32CD32;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .navigation button:hover {
            background-color: #28a745;
        }

        @media (max-width: 768px) {

            th,
            td {
                padding: 5px;
                font-size: 12px;
            }

            .navigation button {
                font-size: 12px;
                padding: 5px 8px;
            }
        }

        @media (max-width: 480px) {
            #calendar {
                font-size: 12px;
            }

            .navigation {
                flex-direction: column;
                align-items: center;
            }

            .navigation button {
                width: 100%;
                margin-bottom: 5px;
            }

            th,
            td {
                font-size: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div id="calendar">
            <div class="navigation mt-3">
                <button id="prev-month">Previous</button>
                <h2 id="month-year"></h2>
                <button id="next-month">Next</button>
            </div>
            <table>
                <thead>
                    <tr id="weekdays"></tr>
                </thead>
                <tbody id="calendar-body"></tbody>
            </table>
        </div>
    </div>


    <script>
        // Get attendance days from PHP
        const attendanceDays = <?php echo json_encode($attendance_days); ?>;

        const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const calendarBody = document.getElementById('calendar-body');
        const monthYear = document.getElementById('month-year');
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        const weekdaysRow = document.getElementById('weekdays');

        let currentDate = new Date();

        // Populate weekday headers
        weekdays.forEach(day => {
            const th = document.createElement('th');
            th.textContent = day;
            weekdaysRow.appendChild(th);
        });

        function renderCalendar(date) {
            calendarBody.innerHTML = ''; // Clear previous calendar

            const year = date.getFullYear();
            const month = date.getMonth();
            monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            let row = document.createElement('tr');

            // Empty cells before the first day
            for (let i = 0; i < firstDay; i++) {
                row.appendChild(document.createElement('td'));
            }

            // Calendar days
            for (let day = 1; day <= daysInMonth; day++) {
                const cell = document.createElement('td');
                cell.textContent = day;

                // Highlight attended days
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                if (attendanceDays.includes(dateString)) {
                    cell.classList.add('attended-day');
                }

                row.appendChild(cell);

                // Start a new row on Sunday
                if ((firstDay + day) % 7 === 0) {
                    calendarBody.appendChild(row);
                    row = document.createElement('tr');
                }
            }

            // Add remaining empty cells
            while (row.children.length < 7) {
                row.appendChild(document.createElement('td'));
            }
            calendarBody.appendChild(row);
        }

        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });

        renderCalendar(currentDate);
    </script>

</body>

</html>