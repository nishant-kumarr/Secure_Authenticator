<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit(); // Add exit() after header redirect to prevent further execution
}

// Connect to your database (replace these with your actual database credentials)
$hostName = "sql312.infinityfree.com";
$dbUser = "if0_36313219";
$dbPassword = "zZZhkwieZwJhE0";
$dbName = "if0_36313219_loginform";

// Create connection
$conn = new mysqli($hostName, $dbUser, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch student data for section D from the database
$sql_d = "SELECT name, roll_number FROM students WHERE section = 'D'";
$result_d = $conn->query($sql_d);

$students_d = [];
if ($result_d->num_rows > 0) {
    // Fetching student data row by row
    while ($row_d = $result_d->fetch_assoc()) {
        $students_d[] = $row_d;
    }
}

// Fetch student data for section C from the database
$sql_c = "SELECT name, roll_number FROM students WHERE section = 'C'";
$result_c = $conn->query($sql_c);

$students_c = [];
if ($result_c->num_rows > 0) {
    // Fetching student data row by row
    while ($row_c = $result_c->fetch_assoc()) {
        $students_c[] = $row_c;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="icon" type="image/png" sizes="128x128" href="https://img.icons8.com/stickers/100/test-account.png">

    <style>
        .container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
        }
        .left-half {
            width: 80%;
            overflow-y: auto;
            background-color: #ffffff;
            padding: 45px;
        }
        .right-half {
            width: 20%;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding: 20px;
            background-color: #ffffff;
            border-right: 1px solid #ccc; /* Change to right border */
        }
        
        .btn-menu {
            margin-bottom: 20px;
            background-color: #8095f5; /* Blue color */
            border: none;
            border-radius: 20px; /* Curved edges */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Black shadow */
            padding: 10px 20px;
            cursor: pointer;
            color: #fff; /* White text color */
            transition: background-color 0.3s ease;
            width: 100%; /* Set button width to 100% */
            text-align: center; /* Center button text */
        }

        .btn-menu:hover {
            background-color: rgb(201, 37, 160);
        }

        .btn-logout {
            margin-top: auto;
            background-color: lightsalmon; /* Blue color */
            border: none;
            border-radius: 20px; /* Curved edges */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Black shadow */
            padding: 10px 20px;
            cursor: pointer;
            color: #fff; /* White text color */
            transition: background-color 0.3s ease;
            width: 100%; /* Set button width to 100% */
            text-align: center; /* Center button text */
            text-decoration: none;
        }
        
        
    </style>
    <title>User Dashboard</title>
</head>
<body>
    <div class="container">
        <div class="right-half">
            <button class="btn-menu" onclick="closeSectionD()">Home</button>
            <button class="btn-menu" onclick="showSection('sectionC')">Section C</button>
            <button class="btn-menu" onclick="saveAttendance('C')">Save Attendance C</button>
            <button class="btn-menu" onclick="showSection('sectionD')">Section D</button>
            <button class="btn-menu" onclick="saveAttendance('D')">Save Attendance D</button>

            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
        <div class="left-half">
            <h1 style="font-family: 'Brush Script MT', cursive;">Welcome to Dashboard</h1>
            <br><br><h2 style="font-family: 'Trebuchet MS', sans-serif;">Attendance System</h2>
            <div class="attendance-details" id="sectionD" style="display:none;">
                <h3>Section D</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Roll Number</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceBody">
                        <!-- Student details -->
                        <?php foreach ($students_d as $student_d): ?>
                            <tr>
                                <td><?php echo $student_d['name']; ?></td>
                                <td><?php echo $student_d['roll_number']; ?></td>
                                <td onclick="toggleAttendance(this)">A</td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- End of student details -->
                    </tbody>
                </table>
            </div>
            <div class="attendance-details" id="sectionC" style="display:none;">
                <h3>Section C</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Roll Number</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody id="attendanceBodyC">
                        <!-- Student details -->
                        <?php foreach ($students_c as $student_c): ?>
                            <tr>
                                <td><?php echo $student_c['name']; ?></td>
                                <td><?php echo $student_c['roll_number']; ?></td>
                                <td onclick="toggleAttendance(this)">A</td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- End of student details -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>

        function toggleAttendance(cell) {
            cell.textContent = cell.textContent === "A" ? "P" : "A";
        }

        function saveAttendance(section) {
            const attendanceText = generateAttendanceText(section);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_attendance.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // downloadAttendance(attendanceText, section);
                    alert("Attendance saved successfully!");
                }
            };
            xhr.send("attendance_text=" + encodeURIComponent(attendanceText));
        }

        function generateAttendanceText(section) {
            let attendanceText = ""; // Header for the attendance data

            let rows;
            if (section === 'D') {
                rows = document.querySelectorAll("#attendanceBody tr");
            } else if (section === 'C') {
                rows = document.querySelectorAll("#attendanceBodyC tr");
            } else {
                console.error("Invalid section provided.");
                return; // Exit function if section is neither 'D' nor 'C'
            }

            rows.forEach(row => {
                const rollNumber = row.cells[1].textContent.trim(); // Get the roll number
                const attendance = row.cells[2].textContent.trim(); // Get the attendance

                // Check if roll number is empty, if so, skip this record
                if (rollNumber === '') {
                    return;
                }

                // Add roll number and attendance to the attendance text
                attendanceText += `${rollNumber},${attendance}\n`;
            });

            return attendanceText;
        }


        // function generateAttendanceText(section) {
        //     let attendanceText = "     Name           Roll Number          Attendance\n\n";

        //     let rows;
        //     if (section === 'D') {
        //         rows = document.querySelectorAll("#attendanceBody tr");
        //     } else if (section === 'C') {
        //         rows = document.querySelectorAll("#attendanceBodyC tr");
        //     } else {
        //         console.error("Invalid section provided.");
        //         return; // Exit function if section is neither 'D' nor 'C'
        //     }

        //     rows.forEach(row => {
        //         const name = row.cells[0].textContent.padEnd(34);
        //         const rollNumber = row.cells[1].textContent.padEnd(20);
        //         const attendance = row.cells[2].textContent.padEnd(20);
        //         attendanceText += `${name}${rollNumber}${attendance}\n`;
        //     });

        //     return attendanceText;
        // }

        // function downloadAttendance(attendanceText, section) {
        //     const currentDate = new Date().toISOString().slice(0, 10); // Get current date in YYYY-MM-DD format
        //     const fileName = `attendance_${section}_${currentDate}.txt`;

        //     const blob = new Blob([attendanceText], { type: "text/plain" });
        //     const link = document.createElement("a");
        //     link.download = fileName;
        //     link.href = URL.createObjectURL(blob);
        //     link.click();
        //     URL.revokeObjectURL(link.href);
        // }

        function closeSectionD() {
            document.getElementById("sectionD").style.display = "none";
            document.getElementById("sectionC").style.display = "none";
        }

        function showSection(section) {
            closeSectionD();
            document.getElementById(section).style.display = "block";
        }
    </script>
</body>
</html>