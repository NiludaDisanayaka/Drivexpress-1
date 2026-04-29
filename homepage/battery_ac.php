<?php

// DB Connection
$conn = new mysqli("localhost", "root", "");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB
$conn->query("CREATE DATABASE IF NOT EXISTS drivexpress");

// Select DB
$conn->select_db("drivexpress");

// Create Table
$conn->query("CREATE TABLE IF NOT EXISTS battery_ac_service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    issues TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// INSERT DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get selected issues
    $issues = isset($_POST['issues']) ? implode(", ", $_POST['issues']) : "";

    $stmt = $conn->prepare("INSERT INTO battery_ac_service (issues) VALUES (?)");
    $stmt->bind_param("s", $issues);

    if ($stmt->execute()) {
        echo "<script>alert('Service Request Submitted Successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>

<title>Battery & AC Service</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    font-family: 'Montserrat', sans-serif;
    background: linear-gradient(135deg, #f0f4ff 0%, #eaf0f7 60%, #f8fbff 100%);
    margin: 0;
}

.container {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

h1 { color: #0a2a52; }
p { color: #4a5a75; }

.issues {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.issue-card {
    flex: 1;
    background: #f5f8ff;
    padding: 18px;
    border-radius: 12px;
    text-align: center;
}

form { margin-top: 25px; }

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

button {
    margin-top: 20px;
    padding: 14px;
    width: 100%;
    background: #003366;
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
}
</style>

</head>

<body>

<div class="container">

<h1>Battery & AC Service</h1>
<p>Check battery health and keep your car air conditioning running smoothly.</p>

<h3>Common Issues</h3>

<div class="issues">
<div class="issue-card"><i class="fa-solid fa-car-battery"></i><p><b>Weak Battery</b></p></div>
<div class="issue-card"><i class="fa-solid fa-snowflake"></i><p><b>AC Not Cooling</b></p></div>
<div class="issue-card"><i class="fa-solid fa-wind"></i><p><b>Weak Air Flow</b></p></div>
</div>

<h3>Request Service</h3>

<form method="POST">

<div class="checkbox-group">
<label><input type="checkbox" name="issues[]" value="Battery drains quickly"> Battery drains quickly</label>
<label><input type="checkbox" name="issues[]" value="AC not cooling properly"> AC not cooling properly</label>
<label><input type="checkbox" name="issues[]" value="Weak air flow"> Weak air flow</label>
<label><input type="checkbox" name="issues[]" value="Strange noise"> Strange noise from AC</label>
<label><input type="checkbox" name="issues[]" value="Battery warning light"> Battery warning light</label>
</div>

<button type="submit">Book Battery & AC Service</button>

</form>

</div>

</body>
</html>
