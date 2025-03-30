<?php
require_once 'connextion.php';
session_start();
if(isset($_POST['stagiaire'])){
    $email = $_POST['email1'];
    $password = $_POST['password1'];
    
    try {
        $sql = "SELECT * FROM user WHERE email = :email AND pass = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $_SESSION['email'] = $email;
            header("Location: welcome1.php?email=" . urlencode($email));
            exit();
        } else {
            header("Location: errorpage.html");
        }
    } catch (PDOException $e) {
        // Handle error appropriately
        die("Database error: " . $e->getMessage());
    }
}

if(isset($_POST['formateur'])){
    $email = $_POST['email2'];
    $password = $_POST['password2'];
    
    try {
        $sql = "SELECT * FROM teacher WHERE email = :email AND pass = :password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $_SESSION['email'] = $email;
            header("Location: studentslist.php?email=" . urlencode($email));
            exit();
        } else {
            header("Location: errorpage.html");
        }
    } catch (PDOException $e) {
        // Handle error appropriately
        die("Database error: " . $e->getMessage());
    }
}