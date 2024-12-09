<?php

$colored_day = ''; // Variable to store the colored day (if attendance exists)

// Check if the user is logged in
if (isset($_SESSION['users_account_id'])) {
    // Query to check if the user has attendance for today
    $colored_calendar_days = "SELECT * FROM attendance_users WHERE users_account_id = ? AND DATE(attendance_date) = CURDATE()";
    $stmt_colored = $conn->prepare($colored_calendar_days);
    $stmt_colored->bind_param("i", $_SESSION['users_account_id']);
    $stmt_colored->execute();
    $result_colored = $stmt_colored->get_result();

    // If the user has attendance today, store this information
    if ($result_colored->num_rows > 0) {
        $colored_day = 'today'; // Mark the day as attended
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
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        #calendar {
            max-width: 600px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }
       
        .attended-day {
            background-color: #32CD32; /* Green color for attended day */
            color: white;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
       
        .navigation button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div id="calendar">
    <div class="navigation mt-3">
        <button id="prev-month" class="tw-text-black tw-font-bold py-2 px-4 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d] hover:tw-bg-[#00FFAE]">Previous</button>
        <h2 id="month-year" class="text-danger"></h2>
        <button id="next-month" class="tw-text-black tw-font-bold py-2 px-4 tw-rounded tw-transition tw-duration-300 ease-in-out tw-bg-[#00e69d] hover:tw-bg-[#00FFAE]">Next</button>
    </div>
    <table class="mb-3">
        <thead>
            <tr id="weekdays"></tr>
        </thead>
        <tbody id="calendar-body"></tbody>
    </table>
</div>

<script>
    const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    const calendarBody = document.getElementById('calendar-body');
    const monthYear = document.getElementById('month-year');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const weekdaysRow = document.getElementById('weekdays');
    
    let currentDate = new Date();
    const coloredDay = "<?php echo $colored_day; ?>";  // Get PHP value into JS

    // Populate weekday headers
    weekdays.forEach(day => {
        const th = document.createElement('th');
        th.textContent = day;
        weekdaysRow.appendChild(th);
    });

    function renderCalendar(date) {
        // Clear the calendar body
        calendarBody.innerHTML = '';

        // Get month and year
        const year = date.getFullYear();
        const month = date.getMonth();

        // Set the header
        monthYear.textContent = `${date.toLocaleString('default', { month: 'long' })} ${year}`;

        // Get the first day and number of days in the month
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Create empty cells for days before the first of the month
        let row = document.createElement('tr');
        for (let i = 0; i < firstDay; i++) {
            const cell = document.createElement('td');
            cell.classList.add('empty-cell');
            row.appendChild(cell);
        }

        // Create cells for each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const cell = document.createElement('td');
            cell.textContent = day;

            // Highlight the current day
            const today = new Date();
            if (
                day === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                cell.classList.add('current-day');
            }

            // If the user has attendance today, color it green
            if (coloredDay === 'today' && day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                cell.classList.add('attended-day');
            }

            row.appendChild(cell);

            // Start a new row after Saturday
            if ((firstDay + day) % 7 === 0) {
                calendarBody.appendChild(row);
                row = document.createElement('tr');
            }
        }

        // Fill the remaining cells of the last row
        if (row.children.length > 0) {
            for (let i = row.children.length; i < 7; i++) {
                const cell = document.createElement('td');
                cell.classList.add('empty-cell');
                row.appendChild(cell);
            }
            calendarBody.appendChild(row);
        }
    }

    // Event listeners for navigation buttons
    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    // Initial render
    renderCalendar(currentDate);
</script>

</body>
</html>
