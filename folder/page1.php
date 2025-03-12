<?php
// Start the session
session_start();

// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'PIE'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Create a connection to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data based on the page
    if (isset($_POST['A1'])) { // Page 3 - Question 1
        $stmt = $conn->prepare("INSERT INTO q1 (rp1, rp2, rp3) VALUES (:rp1, :rp2, :rp3)");
        $stmt->execute([
            ':rp1' => $_POST['A1'],
            ':rp2' => $_POST['A2'],
            ':rp3' => $_POST['A3']
        ]);
    }

    if (isset($_POST['B1'])) { // Page 3 - Question 2
        $stmt = $conn->prepare("INSERT INTO q2 (rp1, rp2, rp3) VALUES (:rp1, :rp2, :rp3)");
        $stmt->execute([
            ':rp1' => $_POST['B1'],
            ':rp2' => $_POST['B2'],
            ':rp3' => $_POST['B3']
        ]);
    }

    if (isset($_POST['C1'])) { // Page 3 - Question 3
        $stmt = $conn->prepare("INSERT INTO q3 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['C1']]);
    }

    if (isset($_POST['D1'])) { // Page 4 - Question 4
        $stmt = $conn->prepare("INSERT INTO q4 (rp1, rp2, rp3, rp4, rp5, rp6, rp7, rp8, rp9, rp10, rp11) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5, :rp6, :rp7, :rp8, :rp9, :rp10, :rp11)");
        $stmt->execute([
            ':rp1' => $_POST['D1'],
            ':rp2' => $_POST['D2'],
            ':rp3' => $_POST['D3'],
            ':rp4' => $_POST['D4'],
            ':rp5' => $_POST['D5'],
            ':rp6' => $_POST['D6'],
            ':rp7' => $_POST['D7'],
            ':rp8' => $_POST['D8'],
            ':rp9' => $_POST['D9'],
            ':rp10' => $_POST['D10'],
            ':rp11' => $_POST['D11']
        ]);
    }

    if (isset($_POST['E1'])) { // Page 4 - Question 5 (Points communs)
        $stmt = $conn->prepare("INSERT INTO q5 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['E1']]);
    }

    if (isset($_POST['F1'])) { // Page 4 - Question 5 (Différences)
        $stmt = $conn->prepare("INSERT INTO q15 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['F1']]);
    }

    if (isset($_POST['G1'])) { // Page 5 - Question 6
        $stmt = $conn->prepare("INSERT INTO q6 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['G1']]);
    }

    if (isset($_POST['H1'])) { // Page 5 - Question 7
        $stmt = $conn->prepare("INSERT INTO q7 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['H1']]);
    }

    if (isset($_POST['I1'])) { // Page 6 - Question 8
        $stmt = $conn->prepare("INSERT INTO q8 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['I1']]);
    }

    if (isset($_POST['J1'])) { // Page 6 - Question 9
        $stmt = $conn->prepare("INSERT INTO q10 (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['J1'],
            ':rp2' => $_POST['J2'],
            ':rp3' => $_POST['J3'],
            ':rp4' => $_POST['J4'],
            ':rp5' => $_POST['J5']
        ]);
    }

    if (isset($_POST['K1'])) { // Page 7 - Question 10
        $stmt = $conn->prepare("INSERT INTO q11 (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['K1'],
            ':rp2' => $_POST['K2'],
            ':rp3' => $_POST['K3'],
            ':rp4' => $_POST['K4'],
            ':rp5' => $_POST['K5']
        ]);
    }

    if (isset($_POST['L1'])) { // Page 7 - Question 11
        $stmt = $conn->prepare("INSERT INTO q12 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['L1']]);
    }

    if (isset($_POST['M1'])) { // Page 8 - Question 12
        $stmt = $conn->prepare("INSERT INTO q13 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['M1']]);
    }

    if (isset($_POST['N1'])) { // Page 9 - Question 13
        $stmt = $conn->prepare("INSERT INTO q14a (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['N1'],
            ':rp2' => $_POST['N2'],
            ':rp3' => $_POST['N3'],
            ':rp4' => $_POST['N4'],
            ':rp5' => $_POST['N5']
        ]);
    }

    if (isset($_POST['O1'])) { // Page 9 - Question 14
        $stmt = $conn->prepare("INSERT INTO q14b (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['O1'],
            ':rp2' => $_POST['O2'],
            ':rp3' => $_POST['O3'],
            ':rp4' => $_POST['O4'],
            ':rp5' => $_POST['O5']
        ]);
    }

    if (isset($_POST['P1'])) { // Page 9 - Question 14
        $stmt = $conn->prepare("INSERT INTO q14c (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['P1'],
            ':rp2' => $_POST['P2'],
            ':rp3' => $_POST['P3'],
            ':rp4' => $_POST['P4'],
            ':rp5' => $_POST['P5']
        ]);
    }

    if (isset($_POST['Q1'])) { // Page 9 - Question 14
        $stmt = $conn->prepare("INSERT INTO q14d (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['Q1'],
            ':rp2' => $_POST['Q2'],
            ':rp3' => $_POST['Q3'],
            ':rp4' => $_POST['Q4'],
            ':rp5' => $_POST['Q5']
        ]);
    }

    if (isset($_POST['S1'])) { // Page 9 - Question 14
        $stmt = $conn->prepare("INSERT INTO q14e (rp1, rp2, rp3, rp4, rp5) VALUES (:rp1, :rp2, :rp3, :rp4, :rp5)");
        $stmt->execute([
            ':rp1' => $_POST['S1'],
            ':rp2' => $_POST['S2'],
            ':rp3' => $_POST['S3'],
            ':rp4' => $_POST['S4'],
            ':rp5' => $_POST['S5']
        ]);
    }

    if (isset($_POST['T1'])) { // Page 10 - Question 15
        $stmt = $conn->prepare("INSERT INTO q15 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['T1']]);
    }

    if (isset($_POST['U1'])) { // Page 10 - Question 16
        $stmt = $conn->prepare("INSERT INTO q17 (rp1) VALUES (:rp1)");
        $stmt->execute([':rp1' => $_POST['U1']]);
    }

    // Redirect back to the form or another page
    header('Location: page1.html'); // Redirect to the form or a success page
    exit();
}

// If not a POST request, redirect to the form
header('Location: page1.html');
exit();
?>