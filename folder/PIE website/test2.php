<?php
// test2.php - Modified to be compatible with index.php
session_start();
require_once 'connextion.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

// Get user ID based on session email
$email = $_SESSION['email'];
$user_id = '';
$user_type = '';

// Determine if user is stagiaire or formateur
try {
    // Check stagiaire table first
    $stmt = $conn->prepare("SELECT ID FROM user WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $user_id = $user['ID'];
        $user_type = 'stagiaire';
    } else {
        // Check formateur table if not found in stagiaire
        $stmt = $conn->prepare("SELECT ID FROM teacher WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            $user_id = $user['ID'];
            $user_type = 'formateur';
        } else {
            // No user found
            header('Location: index.php');
            exit();
        }
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

$error = '';
$success = '';

// Fetch user's existing answers (only for stagiaire)
if ($user_type === 'stagiaire') {
    $stmt = $conn->prepare("SELECT * FROM reponses1 WHERE ID = ?");
    $stmt->execute([$user_id]);
    $part1 = $stmt->fetch();

    $stmt = $conn->prepare("SELECT * FROM reponses2 WHERE ID = ?");
    $stmt->execute([$user_id]);
    $part2 = $stmt->fetch();
} else {
    // Formateur can't modify answers, redirect
    header('Location: formateur.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_type === 'stagiaire') {
    try {
        // Update Part 1 answers
        $stmt = $conn->prepare("UPDATE reponses1 SET 
            rpA1 = ?, rpA2 = ?, rpA3 = ?,
            rpB1 = ?, rpB2 = ?, rpB3 = ?,
            rpC1 = ?, rpD1 = ?, rpD2 = ?, rpD3 = ?,
            rpD4 = ?, rpD5 = ?, rpD6 = ?, rpD7 = ?,
            rpD8 = ?, rpD9 = ?, rpD10 = ?, rpD11 = ?,
            rpE1 = ?, rpF1 = ?, rpG1 = ?, rpH1 = ?,
            rpI1 = ?, rpJ1 = ?
            WHERE ID = ?");
        
        $stmt->execute([
            $_POST['A1'], $_POST['A2'], $_POST['A3'],
            $_POST['B1'], $_POST['B2'], $_POST['B3'],
            $_POST['C1'], $_POST['D1'], $_POST['D2'], $_POST['D3'],
            $_POST['D4'], $_POST['D5'], $_POST['D6'], $_POST['D7'],
            $_POST['D8'], $_POST['D9'], $_POST['D10'], $_POST['D11'],
            $_POST['E1'], $_POST['F1'], $_POST['G1'], $_POST['H1'],
            $_POST['I1'], $_POST['J1'],
            $user_id
        ]);

        // Update Part 2 answers
        $stmt = $conn->prepare("UPDATE reponses2 SET 
            rpM1 = ?, rpN1 = ?, rpO1 = ?,
            rpP1 = ?, rpP2 = ?, rpP3 = ?, rpP4 = ?, rpP5 = ?,
            rpQ1 = ?, rpQ2 = ?, rpQ3 = ?, rpQ4 = ?, rpQ5 = ?,
            rpR1 = ?, rpR2 = ?, rpR3 = ?, rpR4 = ?, rpR5 = ?,
            rpS1 = ?, rpS2 = ?, rpS3 = ?, rpS4 = ?, rpS5 = ?,
            rpT1 = ?, rpT2 = ?, rpT3 = ?, rpT4 = ?, rpT5 = ?,
            rpU1 = ?, rpV1 = ?
            WHERE ID = ?");
        
        $stmt->execute([
            $_POST['M1'], $_POST['N1'], $_POST['O1'],
            $_POST['P1'], $_POST['P2'], $_POST['P3'], $_POST['P4'], $_POST['P5'],
            $_POST['Q1'], $_POST['Q2'], $_POST['Q3'], $_POST['Q4'], $_POST['Q5'],
            $_POST['R1'], $_POST['R2'], $_POST['R3'], $_POST['R4'], $_POST['R5'],
            $_POST['S1'], $_POST['S2'], $_POST['S3'], $_POST['S4'], $_POST['S5'],
            $_POST['T1'], $_POST['T2'], $_POST['T3'], $_POST['T4'], $_POST['T5'],
            $_POST['U1'], $_POST['V1'],
            $user_id
        ]);

        $success = "Vos réponses ont été mises à jour avec succès!";
        
        // Refresh the data
        $stmt = $conn->prepare("SELECT * FROM reponses1 WHERE ID = ?");
        $stmt->execute([$user_id]);
        $part1 = $stmt->fetch();

        $stmt = $conn->prepare("SELECT * FROM reponses2 WHERE ID = ?");
        $stmt->execute([$user_id]);
        $part2 = $stmt->fetch();
        header("location: modification.html");
    } catch (PDOException $e) {
        $error = "Une erreur est survenue: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mes réponses</title>
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
            padding: 20px;
            color: var(--text-color);
        }

        .container {
            background: var(--light-bg);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 0 auto;
            max-width: 1000px;
            position: relative;
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
        }

        .alert {
            padding: 15px;
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

        .response-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(106, 17, 203, 0.2);
        }

        .question-group {
            margin-bottom: 20px;
        }

        .question {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        input[type="text"], 
        textarea, 
        select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 10px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: block;
            width: 200px;
            margin: 30px auto;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?php echo $user_type === 'stagiaire' ? 'welcome1.php' : 'formateur.php'; ?>" class="back-link">← Retour</a>
        <h1>Modifier mes réponses</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <?php if ($user_type === 'stagiaire'): ?>
            <form method="POST" action="test2.php">
                <!-- Part 1 -->
                <div class="response-section">
                    <h2 class="section-title">Première Partie</h2>
                    
                    <!-- Question 1 -->
                    <div class="question-group">
                        <div class="question">1. Les 3 mots que vous voulez que les gens retiennent de vous:</div>
                        <input type="text" name="A1" value="<?= htmlspecialchars($part1['rpA1'] ?? '') ?>" placeholder="Mot 1">
                        <input type="text" name="A2" value="<?= htmlspecialchars($part1['rpA2'] ?? '') ?>" placeholder="Mot 2">
                        <input type="text" name="A3" value="<?= htmlspecialchars($part1['rpA3'] ?? '') ?>" placeholder="Mot 3">
                    </div>
                    
                    <!-- Question 2 -->
                    <div class="question-group">
                        <div class="question">2. Actions quotidiennes justifiant ces mots:</div>
                        <textarea name="B1" placeholder="Actions pour le mot 1"><?= htmlspecialchars($part1['rpB1'] ?? '') ?></textarea>
                        <textarea name="B2" placeholder="Actions pour le mot 2"><?= htmlspecialchars($part1['rpB2'] ?? '') ?></textarea>
                        <textarea name="B3" placeholder="Actions pour le mot 3"><?= htmlspecialchars($part1['rpB3'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 3 -->
                    <div class="question-group">
                        <div class="question">3. Êtes-vous une personne de confiance?</div>
                        <textarea name="C1"><?= htmlspecialchars($part1['rpC1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 4 -->
                    <div class="question-group">
                        <div class="question">4. Mots écrits par vos collègues:</div>
                        <?php for ($i = 1; $i <= 11; $i++): ?>
                            <input type="text" name="D<?= $i ?>" value="<?= htmlspecialchars($part1['rpD'.$i] ?? '') ?>" placeholder="Mot <?= $i ?>">
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Question 5 -->
                    <div class="question-group">
                        <div class="question">5. Points communs:</div>
                        <textarea name="E1"><?= htmlspecialchars($part1['rpE1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 6 -->
                    <div class="question-group">
                        <div class="question">6. Différences:</div>
                        <textarea name="F1"><?= htmlspecialchars($part1['rpF1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 7 -->
                    <div class="question-group">
                        <div class="question">7. Comment construire votre réputation:</div>
                        <textarea name="G1"><?= htmlspecialchars($part1['rpG1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 8 -->
                    <div class="question-group">
                        <div class="question">8. Que signifie "être exemplaire":</div>
                        <textarea name="H1"><?= htmlspecialchars($part1['rpH1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 9 -->
                    <div class="question-group">
                        <div class="question">9. Comment devenir exemplaire:</div>
                        <textarea name="I1"><?= htmlspecialchars($part1['rpI1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 10 -->
                    <div class="question-group">
                        <div class="question">10. Ce que vous devez apprendre:</div>
                        <textarea name="J1"><?= htmlspecialchars($part1['rpJ1'] ?? '') ?></textarea>
                    </div>
                </div>
                
                <!-- Part 2 -->
                <div class="response-section">
                    <h2 class="section-title">Deuxième Partie</h2>
                    
                    <!-- Question 11 -->
                    <div class="question-group">
                        <div class="question">11. Vos 5 valeurs clés:</div>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="text" name="K<?= $i ?>" value="<?= htmlspecialchars($part2['rpK'.$i] ?? '') ?>" placeholder="Valeur <?= $i ?>">
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Question 12 -->
                    <div class="question-group">
                        <div class="question">12. Valeurs identifiées par vos collègues:</div>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="text" name="L<?= $i ?>" value="<?= htmlspecialchars($part2['rpL'.$i] ?? '') ?>" placeholder="Valeur <?= $i ?>">
                        <?php endfor; ?>
                    </div>
                    
                    <!-- Question 13 -->
                    <div class="question-group">
                        <div class="question">13. Réflexions sur les écarts/similarités:</div>
                        <textarea name="M1"><?= htmlspecialchars($part2['rpM1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 14 -->
                    <div class="question-group">
                        <div class="question">14. Expérience personnelle:</div>
                        <textarea name="N1"><?= htmlspecialchars($part2['rpN1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 15 -->
                    <div class="question-group">
                        <div class="question">15. Causes qui vous tiennent à cœur:</div>
                        <textarea name="O1"><?= htmlspecialchars($part2['rpO1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 16 -->
                    <div class="question-group">
                        <div class="question">16. Engagement dans des causes:</div>
                        <?php 
                        $prefixes = ['P', 'Q', 'R', 'S', 'T'];
                        foreach ($prefixes as $prefix): 
                            $cause = $part2['rp'.$prefix.'1'] ?? '';
                            $action = $part2['rp'.$prefix.'2'] ?? '';
                            $reads = $part2['rp'.$prefix.'3'] ?? 0;
                            $informed = $part2['rp'.$prefix.'4'] ?? 0;
                            $engaged = $part2['rp'.$prefix.'5'] ?? 0;
                        ?>
                        <div style="margin-bottom: 20px; border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                            <h4>Cause <?= $prefix ?></h4>
                            <input type="text" name="<?= $prefix ?>1" value="<?= htmlspecialchars($cause) ?>" placeholder="Cause">
                            <textarea name="<?= $prefix ?>2" placeholder="Actions"><?= htmlspecialchars($action) ?></textarea>
                            <div style="display: flex; gap: 20px; margin-top: 10px;">
                                <label>
                                    <input type="checkbox" name="<?= $prefix ?>3" value="1" <?= $reads ? 'checked' : '' ?>> Lit sur le sujet
                                </label>
                                <label>
                                    <input type="checkbox" name="<?= $prefix ?>4" value="1" <?= $informed ? 'checked' : '' ?>> Au courant
                                </label>
                                <label>
                                    <input type="checkbox" name="<?= $prefix ?>5" value="1" <?= $engaged ? 'checked' : '' ?>> Engagé
                                </label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Question 17 -->
                    <div class="question-group">
                        <div class="question">17. Engagement futur:</div>
                        <textarea name="U1"><?= htmlspecialchars($part2['rpU1'] ?? '') ?></textarea>
                    </div>
                    
                    <!-- Question 18 -->
                    <div class="question-group">
                        <div class="question">18. Plan d'action:</div>
                        <textarea name="V1"><?= htmlspecialchars($part2['rpV1'] ?? '') ?></textarea>
                    </div>
                </div>
                
                <button type="submit" class="btn">Enregistrer les modifications</button>
            </form>
        <?php else: ?>
            <div class="alert alert-error">Seuls les stagiaires peuvent modifier leurs réponses.</div>
        <?php endif; ?>
    </div>
</body>
</html>