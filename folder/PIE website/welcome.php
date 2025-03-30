<?php
session_start();
require_once 'connextion.php';

// Get email from POST data
$email = isset($_POST['email']) ? $_POST['email'] : (isset($_SESSION['email']) ? $_SESSION['email'] : '');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect all POST variables
    $A1 = $_POST['A1'];
    $A2 = $_POST['A2'];
    $A3 = $_POST['A3'];
    $B1 = $_POST['B1'];
    $B2 = $_POST['B2'];
    $B3 = $_POST['B3'];
    $C1 = $_POST['C1'];
    $D1 = $_POST['D1'];
    $D2 = $_POST['D2'];
    $D3 = $_POST['D3'];
    $D4 = $_POST['D4'];
    $D5 = $_POST['D5'];
    $D6 = $_POST['D6'];
    $D7 = $_POST['D7'];
    $D8 = $_POST['D8'];
    $D9 = $_POST['D9'];
    $D10 = $_POST['D10'];
    $D11 = $_POST['D11'];
    $E1 = $_POST['E1'];
    $F1 = $_POST['F1'];
    $G1 = $_POST['G1'];
    $H1 = $_POST['H1'];
    $I1 = $_POST['I1'];
    $J1 = $_POST['J1'];
    $K1 = $_POST['K1'];
    $K2 = $_POST['K2'];
    $K3 = $_POST['K3'];
    $K4 = $_POST['K4'];
    $K5 = $_POST['K5'];
    $L1 = $_POST['L1'];
    $L2 = $_POST['L2'];
    $L3 = $_POST['L3'];
    $L4 = $_POST['L4'];
    $L5 = $_POST['L5'];
    $M1 = $_POST['M1'];
    $N1 = $_POST['N1'];
    $O1 = $_POST['O1'];
    $P1 = $_POST['P1'];
    $P2 = $_POST['P2'];
    $P3 = isset($_POST['P3']) ? 1 : 0;
    $P4 = isset($_POST['P4']) ? 1 : 0;
    $P5 = isset($_POST['P5']) ? 1 : 0;
    $Q1 = $_POST['Q1'];
    $Q2 = $_POST['Q2'];
    $Q3 = isset($_POST['Q3']) ? 1 : 0;
    $Q4 = isset($_POST['Q4']) ? 1 : 0;
    $Q5 = isset($_POST['Q5']) ? 1 : 0;
    $R1 = $_POST['R1'];
    $R2 = $_POST['R2'];
    $R3 = isset($_POST['R3']) ? 1 : 0;
    $R4 = isset($_POST['R4']) ? 1 : 0;
    $R5 = isset($_POST['R5']) ? 1 : 0;
    $T1 = $_POST['T1'];
    $T2 = $_POST['T2'];
    $T3 = isset($_POST['T3']) ? 1 : 0;
    $T4 = isset($_POST['T4']) ? 1 : 0;
    $T5 = isset($_POST['T5']) ? 1 : 0;
    $S1 = $_POST['S1'];
    $S2 = $_POST['S2'];
    $S3 = isset($_POST['S3']) ? 1 : 0;
    $S4 = isset($_POST['S4']) ? 1 : 0;
    $S5 = isset($_POST['S5']) ? 1 : 0;
    $U1 = $_POST['U1'];
    $V1 = $_POST['V1'];

    try {
        // Get user ID
        $sql = "SELECT * FROM user WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $row = $stmt->fetch();
            $ID = $row['ID'];
        } else {
            echo "No user found with this email.";
            exit();
        }
        $try="SELECT * FROM reponses1 WHERE ID = :ID";
        $stmt = $conn->prepare($try);
        $stmt->bindParam(':ID', $ID);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $existingID = $ID; // Store the ID in a variable
            header("Location: false.php?ID=" . urlencode($existingID));
            exit();
        }
        else{
        // Prepare SQL statements with PDO
        $sql1 = "INSERT INTO reponses1 (ID, rpA1, rpA2, rpA3, rpB1, rpB2, rpB3, rpC1, rpD1, rpD2, rpD3, rpD4, rpD5, rpD6, rpD7, rpD8, rpD9, rpD10, rpD11, rpE1, rpF1, rpG1, rpH1, rpI1, rpJ1, rpK1, rpK2, rpK3, rpK4, rpK5, rpL1, rpL2, rpL3, rpL4, rpL5) 
                VALUES (:ID, :A1, :A2, :A3, :B1, :B2, :B3, :C1, :D1, :D2, :D3, :D4, :D5, :D6, :D7, :D8, :D9, :D10, :D11, :E1, :F1, :G1, :H1, :I1, :J1, :K1, :K2, :K3, :K4, :K5, :L1, :L2, :L3, :L4, :L5)";
        
        $sql2 = "INSERT INTO reponses2 (ID, rpM1, rpN1, rpO1, rpP1, rpP2, rpP3, rpP4, rpP5, rpQ1, rpQ2, rpQ3, rpQ4, rpQ5, rpR1, rpR2, rpR3, rpR4, rpR5, rpT1, rpT2, rpT3, rpT4, rpT5, rpS1, rpS2, rpS3, rpS4, rpS5, rpU1, rpV1)
                VALUES (:ID, :M1, :N1, :O1, :P1, :P2, :P3, :P4, :P5, :Q1, :Q2, :Q3, :Q4, :Q5, :R1, :R2, :R3, :R4, :R5, :T1, :T2, :T3, :T4, :T5, :S1, :S2, :S3, :S4, :S5, :U1, :V1)";
        
        // Execute first statement
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(':ID', $ID);
        $stmt1->bindParam(':A1', $A1);
        $stmt1->bindParam(':A2', $A2);
        $stmt1->bindParam(':A3', $A3);
        $stmt1->bindParam(':B1', $B1);
        $stmt1->bindParam(':B2', $B2);
        $stmt1->bindParam(':B3', $B3);
        $stmt1->bindParam(':C1', $C1);
        $stmt1->bindParam(':D1', $D1);
        $stmt1->bindParam(':D2', $D2);
        $stmt1->bindParam(':D3', $D3);
        $stmt1->bindParam(':D4', $D4);
        $stmt1->bindParam(':D5', $D5);
        $stmt1->bindParam(':D6', $D6);
        $stmt1->bindParam(':D7', $D7);
        $stmt1->bindParam(':D8', $D8);
        $stmt1->bindParam(':D9', $D9);
        $stmt1->bindParam(':D10', $D10);
        $stmt1->bindParam(':D11', $D11);
        $stmt1->bindParam(':E1', $E1);
        $stmt1->bindParam(':F1', $F1);
        $stmt1->bindParam(':G1', $G1);
        $stmt1->bindParam(':H1', $H1);
        $stmt1->bindParam(':I1', $I1);
        $stmt1->bindParam(':J1', $J1);
        $stmt1->bindParam(':K1', $K1);
        $stmt1->bindParam(':K2', $K2);
        $stmt1->bindParam(':K3', $K3);
        $stmt1->bindParam(':K4', $K4);
        $stmt1->bindParam(':K5', $K5);
        $stmt1->bindParam(':L1', $L1);
        $stmt1->bindParam(':L2', $L2);
        $stmt1->bindParam(':L3', $L3);
        $stmt1->bindParam(':L4', $L4);
        $stmt1->bindParam(':L5', $L5);
        
        // Execute second statement
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(':ID', $ID);
        $stmt2->bindParam(':M1', $M1);
        $stmt2->bindParam(':N1', $N1);
        $stmt2->bindParam(':O1', $O1);
        $stmt2->bindParam(':P1', $P1);
        $stmt2->bindParam(':P2', $P2);
        $stmt2->bindParam(':P3', $P3);
        $stmt2->bindParam(':P4', $P4);
        $stmt2->bindParam(':P5', $P5);
        $stmt2->bindParam(':Q1', $Q1);
        $stmt2->bindParam(':Q2', $Q2);
        $stmt2->bindParam(':Q3', $Q3);
        $stmt2->bindParam(':Q4', $Q4);
        $stmt2->bindParam(':Q5', $Q5);
        $stmt2->bindParam(':R1', $R1);
        $stmt2->bindParam(':R2', $R2);
        $stmt2->bindParam(':R3', $R3);
        $stmt2->bindParam(':R4', $R4);
        $stmt2->bindParam(':R5', $R5);
        $stmt2->bindParam(':T1', $T1);
        $stmt2->bindParam(':T2', $T2);
        $stmt2->bindParam(':T3', $T3);
        $stmt2->bindParam(':T4', $T4);
        $stmt2->bindParam(':T5', $T5);
        $stmt2->bindParam(':S1', $S1);
        $stmt2->bindParam(':S2', $S2);
        $stmt2->bindParam(':S3', $S3);
        $stmt2->bindParam(':S4', $S4);
        $stmt2->bindParam(':S5', $S5);
        $stmt2->bindParam(':U1', $U1);
        $stmt2->bindParam(':V1', $V1);
        
        // Execute both statements in a transaction
        $conn->beginTransaction();
        try {
            $stmt1->execute();
            $stmt2->execute();
            $conn->commit();
            error_log("Data inserted successfully. Redirecting...");
            header("Location: success.html"); // Redirect to the desired page
            // Redirect to the desired page
            // Replace 'success.php' with your target page
            exit();
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Error: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }}
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        echo "Database error: " . $e->getMessage();
    }
    
}
?>