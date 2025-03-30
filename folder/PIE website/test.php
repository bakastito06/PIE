<?php
session_start();

require_once 'connextion.php';
$student_id = $_POST['student_id'] ?? null;
// Get student info
$stmt = $conn->prepare("SELECT * FROM user WHERE ID = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();

// Get responses
$responses = [];
$stmt = $conn->prepare("SELECT * FROM reponses1 WHERE ID = ?");
$stmt->execute([$student_id]);
$responses['part1'] = $stmt->fetch();

$stmt = $conn->prepare("SELECT * FROM reponses2 WHERE ID = ?");
$stmt->execute([$student_id]);
$responses['part2'] = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponses du Stagiaire</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            color: white;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin: 0 auto;
            max-width: 1000px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            position: relative;
        }

        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.9);
            color: #2575fc;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: white;
            transform: translateY(-2px);
        }

        .student-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .student-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .student-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
        }

        .response-section {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .section-title {
            color: #6a11cb;
            font-size: 20px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid rgba(106, 17, 203, 0.3);
        }

        .question-group {
            margin-bottom: 15px;
        }

        .question {
            font-weight: 600;
            color: #2575fc;
            margin-bottom: 5px;
        }

        .answer {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            border-left: 3px solid #6a11cb;
        }

        .table-response {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .table-response th {
            background-color: rgba(106, 17, 203, 0.1);
            color: #6a11cb;
            padding: 10px;
            text-align: left;
        }

        .table-response td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .student-info {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            
            .response-section {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="studentslist.php" class="back-btn">
            &larr; Retour à la liste
        </a>
        
        <div class="student-header">
            <h2 class="student-name"><?= htmlspecialchars($student['name']) ?> <?= htmlspecialchars($student['last_name']) ?></h2>
            <div class="student-info">
                <span class="info-item">Filière: <?= htmlspecialchars($student['filier']) ?></span>
                <span class="info-item">Groupe: <?= htmlspecialchars($student['groupe']) ?></span>
                <span class="info-item">Email: <?= htmlspecialchars($student['email']) ?></span>
            </div>
        </div>
        
        <!-- Part 1 Responses -->
        <div class="response-section">
            <h3 class="section-title">Première Partie</h3>
            
            <?php if ($responses['part1']): ?>
                <!-- Question 1 -->
                <div class="question-group">
                    <div class="question">1. Les 3 mots que vous voulez que les gens retiennent de vous:</div>
                    <div class="answer">
                        <p>1. <?= htmlspecialchars($responses['part1']['rpA1']) ?></p>
                        <p>2. <?= htmlspecialchars($responses['part1']['rpA2']) ?></p>
                        <p>3. <?= htmlspecialchars($responses['part1']['rpA3']) ?></p>
                    </div>
                </div>
                
                <!-- Question 2 -->
                <div class="question-group">
                    <div class="question">2. Actions quotidiennes justifiant ces mots:</div>
                    <table class="table-response">
                        <thead>
                            <tr>
                                <th>Mot-clé</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= htmlspecialchars($responses['part1']['rpA1']) ?></td>
                                <td><?= htmlspecialchars($responses['part1']['rpB1']) ?></td>
                            </tr>
                            <tr>
                                <td><?= htmlspecialchars($responses['part1']['rpA2']) ?></td>
                                <td><?= htmlspecialchars($responses['part1']['rpB2']) ?></td>
                            </tr>
                            <tr>
                                <td><?= htmlspecialchars($responses['part1']['rpA3']) ?></td>
                                <td><?= htmlspecialchars($responses['part1']['rpB3']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Question 3 -->
                <div class="question-group">
                    <div class="question">3. Êtes-vous une personne de confiance?</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpC1']) ?></div>
                </div>
                
                <!-- Question 4 -->
                <div class="question-group">
                    <div class="question">4. Mots écrits par vos collègues:</div>
                    <div class="answer" style="columns: 3; column-gap: 20px;">
                        <?php for ($i = 1; $i <= 11; $i++): ?>
                            <?php if (!empty($responses['part1']["rpD$i"])): ?>
                                <p><?= $i ?>. <?= htmlspecialchars($responses['part1']["rpD$i"]) ?></p>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <!-- Question 5 -->
                <div class="question-group">
                    <div class="question">5. Points communs entre les mots que vous avez choisis et ceux de vos collègues:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpE1']) ?></div>
                </div>
                
                <!-- Question 6 -->
                <div class="question-group">
                    <div class="question">6. Différences entre les mots que vous avez choisis et ceux de vos collègues:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpF1']) ?></div>
                </div>
                
                <!-- Question 7 -->
                <div class="question-group">
                    <div class="question">7. Comment construire votre réputation autour des mots clés que vous voulez:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpG1']) ?></div>
                </div>
                
                <!-- Question 8 -->
                <div class="question-group">
                    <div class="question">8. Que signifie "être exemplaire" ?</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpH1']) ?></div>
                </div>
                
                <!-- Question 9 -->
                <div class="question-group">
                    <div class="question">9. Comment pouvez-vous devenir exemplaire ?</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpI1']) ?></div>
                </div>
                
                <!-- Question 10 -->
                <div class="question-group">
                    <div class="question">10. Que devez-vous apprendre pour devenir exemplaire ?</div>
                    <div class="answer"><?= htmlspecialchars($responses['part1']['rpJ1']) ?></div>
                </div>
                
            <?php else: ?>
                <p>Aucune réponse trouvée pour la première partie.</p>
            <?php endif; ?>
        </div>
        
        <!-- Part 2 Responses -->
        <div class="response-section">
            <h3 class="section-title">Deuxième Partie</h3>
            
            <?php if ($responses['part2']): ?>
                <!-- Question 11 -->
                <div class="question-group">
                    <div class="question">11. Vos 5 valeurs clés:</div>
                    <div class="answer">
                        <ol style="columns: 2; column-gap: 20px; margin: 0; padding-left: 20px;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if (!empty($responses['part1']["rpK$i"])): ?>
                                    <li><?= htmlspecialchars($responses['part1']["rpK$i"]) ?></li>
                                <?php else: ?>
                                    <li>(Non renseigné)</li>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </ol>
                    </div>
                </div>
                
                <!-- Question 12 -->
                <div class="question-group">
                    <div class="question">12. Valeurs identifiées par vos collègues:</div>
                    <div class="answer">
                        <ol style="columns: 2; column-gap: 20px; margin: 0; padding-left: 20px;">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if (!empty($responses['part1']["rpL$i"])): ?>
                                    <li><?= htmlspecialchars($responses['part1']["rpL$i"]) ?></li>
                                <?php else: ?>
                                    <li>(Non renseigné)</li>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </ol>
                    </div>
                </div>
                <!-- Question 13 -->
                <div class="question-group">
                    <div class="question">13. Réflexions sur les écarts/similarités entre vos valeurs et celles identifiées par vos collègues:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part2']['rpM1']) ?></div>
                </div>
                
                <!-- Question 14 -->
                <div class="question-group">
                    <div class="question">14. Expérience personnelle sur une situation difficile où vous avez dû choisir entre respecter une valeur ou prendre une décision plus facile:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part2']['rpN1']) ?></div>
                </div>
                
                <!-- Question 15 -->
                <div class="question-group">
                    <div class="question">15. Causes qui vous tiennent à cœur:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part2']['rpO1']) ?></div>
                </div>
                
<!-- Question 16 -->
<!-- Question 16 - Engagement dans des causes -->
<div class="question-group">
    <div class="question">16. Engagement dans des causes:</div>
    <div class="table-container">
        <table class="table-response">
            <thead>
                <tr>
                    <th>La cause qui me tient à cœur</th>
                    <th>Actions concrètes</th>
                    <th>Lit sur le sujet</th>
                    <th>Au courant</th>
                    <th>Engagé</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Define all possible cause prefixes from the form
                $cause_prefixes = ['rpP', 'rpQ', 'rpR', 'rpS', 'rpT'];
                $has_causes = false;
                
                foreach ($cause_prefixes as $prefix): 
                    $cause = $responses['part2'][$prefix.'1'] ?? '';
                    $action = $responses['part2'][$prefix.'2'] ?? '';
                    $reads = isset($responses['part2'][$prefix.'3']) && $responses['part2'][$prefix.'3'] ? '✓' : '✗';
                    $informed = isset($responses['part2'][$prefix.'4']) && $responses['part2'][$prefix.'4'] ? '✓' : '✗';
                    $engaged = isset($responses['part2'][$prefix.'5']) && $responses['part2'][$prefix.'5'] ? '✓' : '✗';
                    
                    // Only show row if there's at least a cause or action
                    if (!empty($cause) || !empty($action)):
                        $has_causes = true;
                ?>
                <tr>
                    <td><?= !empty($cause) ? htmlspecialchars($cause) : '(Non spécifié)' ?></td>
                    <td><?= !empty($action) ? htmlspecialchars($action) : '(Non spécifié)' ?></td>
                    <td class="center-cell"><?= $reads ?></td>
                    <td class="center-cell"><?= $informed ?></td>
                    <td class="center-cell"><?= $engaged ?></td>
                </tr>
                <?php endif; endforeach; ?>
                
                <?php if (!$has_causes): ?>
                <tr>
                    <td colspan="5" class="center-cell">(Aucune cause renseignée)</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
                
                <!-- Question 17 -->
                <div class="question-group">
                    <div class="question">17. Engagement futur dans une cause:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part2']['rpU1']) ?></div>
                </div>
                
                <!-- Question 18 -->
                <div class="question-group">
                    <div class="question">18. Plan d'action pour s'engager concrètement dans une cause:</div>
                    <div class="answer"><?= htmlspecialchars($responses['part2']['rpV1']) ?></div>
                </div>
                
            <?php else: ?>
                <p>Aucune réponse trouvée pour la deuxième partie.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>