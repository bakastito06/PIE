<?php
// registre.php
session_start();
require_once 'connextion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $filier = trim($_POST['filier']);
    $group = trim($_POST['group']);

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($filier) || empty($group)) {
        $error = 'Tous les champs sont obligatoires';
    } elseif ($password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères';
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? OR (name = ? AND last_name = ?)");
        $stmt->execute([$email , $firstName, $lastName]);
        
        if ($stmt->rowCount() > 0) {
            header("Location: errorpage2.html");
        } else {
            // Hash password
    
            
            // Insert new student
            $stmt = $conn->prepare("INSERT INTO user (name,last_name,filier,groupe,email,pass) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$firstName, $lastName, $filier, $group, $email, $password]);
            
            if ($result) {
                $success = 'Inscription réussie! Vous pouvez maintenant vous connecter.';
                $_POST = array(); // Clear form
            } else {
                $error = 'Une erreur est survenue. Veuillez réessayer.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Stagiaire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --text-color: #2c3e50;
            --light-bg: rgba(255, 255, 255, 0.9);
            --error-color: #e74c3c;
            --success-color: #2ecc71;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            margin: 0;
            padding: 0;
            min-height: 100vh;
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: var(--light-bg);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            margin: 20px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-error {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }

        .alert-success {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Créer votre compte stagiaire</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="