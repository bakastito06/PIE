<?php
session_start();
require_once 'connextion.php';

// Get all students (since your schema doesn't link students to teachers)
$stmt = $conn->query("SELECT * FROM user");
$students = $stmt->fetchAll();

// Function to get student responses
function getStudentResponses($pdo, $student_id) {
    $responses = [];
    
    // Get responses from reponses1
    $stmt = $pdo->prepare("SELECT * FROM reponses1 WHERE ID = ?");
    $stmt->execute([$student_id]);
    $responses['part1'] = $stmt->fetch();
    
    // Get responses from reponses2
    $stmt = $pdo->prepare("SELECT * FROM reponses2 WHERE ID = ?");
    $stmt->execute([$student_id]);
    $responses['part2'] = $stmt->fetch();
    
    return $responses;
}

// Handle AJAX request for student responses
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    if ($_GET['action'] == 'get_responses' && isset($_GET['student_id'])) {
        $responses = getStudentResponses($pdo, $_GET['student_id']);
        echo json_encode($responses);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Formateur</title>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1200px;
            border: 1px solid rgba(255, 255, 255, 0.18);
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

        h1 {
            color: white;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            margin-bottom: 30px;
            display: flex;
            gap: 10px;
        }

        .search-bar input {
            flex: 1;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-size: 15px;
            color: #333;
        }

        .search-bar button {
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.9);
            color: #2575fc;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .search-bar button:hover {
            background: white;
            transform: translateY(-2px);
        }

        .student-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .student-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: #2c3e50;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .student-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #6a11cb;
        }

        .student-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .view-btn {
            display: inline-block;
            padding: 10px 15px;
            background: #2575fc;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            text-align: center;
            width: 100%;
            border: none;
            cursor: pointer;
        }

        .view-btn:hover {
            background: #1a5fd6;
            transform: translateY(-2px);
        }

        /* Modal styles */
        #responsesModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            color: #2c3e50;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #6a11cb;
        }

        .response-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(106, 17, 203, 0.2);
        }

        .response-title {
            font-size: 18px;
            color: #6a11cb;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .response-item {
            margin-bottom: 10px;
        }

        .response-item strong {
            color: #2575fc;
        }

        @media (max-width: 768px) {
            .student-list {
                grid-template-columns: 1fr;
            }
            
            .search-bar {
                flex-direction: column;
            }
            
            .modal-content {
                width: 95%;
                margin: 20px auto;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Stagiaires</h1>
        
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Rechercher un stagiaire..." onkeyup="searchStudents()">
        </div>
        
        <div class="student-list" id="studentList">
            <?php foreach ($students as $student): ?>
                <div class="student-card">
                    <div class="student-name"><?= htmlspecialchars($student['name']) ?> <?= htmlspecialchars($student['last_name']) ?></div>
                    <div class="student-group"><?= htmlspecialchars($student['filier']) ?> - Groupe <?= htmlspecialchars($student['groupe']) ?></div>
                    <form id="studentResponseForm" method="post" action="test.php"">
                    <input type="hidden" id="hiddenStudentId" name="student_id" value="<?= $student['ID'] ?>">
                    <button class="view-btn" type="submit" name="submit">Voir les réponses</button>

                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal for displaying responses -->
    <div id="responsesModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Réponses du Stagiaire</h2>
            <div id="responsesContainer"></div>
        </div>
    </div>

    <script>
        // Search function
        function searchStudents() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const studentList = document.getElementById('studentList');
            const cards = studentList.getElementsByClassName('student-card');

            for (let i = 0; i < cards.length; i++) {
            const nameElement = cards[i].getElementsByClassName('student-name')[0];
            const name = nameElement.textContent.toUpperCase();
            const nameParts = name.split(' ');
            const reversedName = nameParts.reverse().join(' ');

            if (name.includes(filter) || reversedName.includes(filter)) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
            }
        }

        // View responses
        function viewResponses(studentId, studentName) {
            document.getElementById('hiddenStudentId').value = studentId;
            document.getElementById('studentResponseForm').submit();
            fetch(`teacher_dashboard.php?action=get_responses&student_id=${studentId}`)
                .then(response => response.json())
                .then(data => {
                    displayResponses(data);
                })
                .catch(error => console.error('Error:', error));
        }

        // Display responses in modal
        function displayResponses(responses) {
            const container = document.getElementById('responsesContainer');
            container.innerHTML = '';
            
            // Part 1 responses
            if (responses.part1) {
                let part1HTML = '<div class="response-section"><h3 class="response-title">Première Partie</h3>';
                
                // Add each response field with question mapping
                const questionsPart1 = {
                    'rpA1': 'Mot-clé 1', 'rpA2': 'Mot-clé 2', 'rpA3': 'Mot-clé 3',
                    'rpB1': 'Action pour mot-clé 1', 'rpB2': 'Action pour mot-clé 2', 'rpB3': 'Action pour mot-clé 3',
                    'rpC1': 'Personne de confiance',
                    'rpD1': 'Mot collègue 1', 'rpD2': 'Mot collègue 2', 'rpD3': 'Mot collègue 3',
                    'rpD4': 'Mot collègue 4', 'rpD5': 'Mot collègue 5', 'rpD6': 'Mot collègue 6',
                    'rpD7': 'Mot collègue 7', 'rpD8': 'Mot collègue 8', 'rpD9': 'Mot collègue 9',
                    'rpD10': 'Mot collègue 10', 'rpD11': 'Mot collègue 11',
                    'rpE1': 'Points communs', 'rpF1': 'Différences',
                    'rpG1': 'Construire réputation', 'rpH1': 'Être exemplaire',
                    'rpI1': 'Devenir exemplaire', 'rpJ1': 'Apprendre pour être exemplaire',
                    'rpK1': 'Valeur 1', 'rpK2': 'Valeur 2', 'rpK3': 'Valeur 3',
                    'rpK4': 'Valeur 4', 'rpK5': 'Valeur 5',
                    'rpL1': 'Valeur collègue 1', 'rpL2': 'Valeur collègue 2',
                    'rpL3': 'Valeur collègue 3', 'rpL4': 'Valeur collègue 4',
                    'rpL5': 'Valeur collègue 5'
                };
                
                for (const [key, value] of Object.entries(responses.part1)) {
                    if (key !== 'ID' && value) {
                        part1HTML += `
                            <div class="response-item">
                                <strong>${questionsPart1[key] || key}:</strong>
                                <div>${value}</div>
                            </div>
                        `;
                    }
                }
                
                part1HTML += '</div>';
                container.innerHTML += part1HTML;
            }
            
            // Part 2 responses
            if (responses.part2) {
                let part2HTML = '<div class="response-section"><h3 class="response-title">Deuxième Partie</h3>';
                
                const questionsPart2 = {
                    'rpM1': 'Débrief valeurs',
                    'rpN1': 'Situation difficile',
                    'rpO1': 'Cause importante',
                    'rpP1': 'Cause 1', 'rpP2': 'Action 1', 'rpP3': 'Lit sur sujet 1', 'rpP4': 'Actualité 1', 'rpP5': 'Engagé 1',
                    'rpQ1': 'Cause 2', 'rpQ2': 'Action 2', 'rpQ3': 'Lit sur sujet 2', 'rpQ4': 'Actualité 2', 'rpQ5': 'Engagé 2',
                    'rpR1': 'Cause 3', 'rpR2': 'Action 3', 'rpR3': 'Lit sur sujet 3', 'rpR4': 'Actualité 3', 'rpR5': 'Engagé 3',
                    'rpS1': 'Cause 4', 'rpS2': 'Action 4', 'rpS3': 'Lit sur sujet 4', 'rpS4': 'Actualité 4', 'rpS5': 'Engagé 4',
                    'rpT1': 'Cause 5', 'rpT2': 'Action 5', 'rpT3': 'Lit sur sujet 5', 'rpT4': 'Actualité 5', 'rpT5': 'Engagé 5',
                    'rpU1': 'S\'engager pour une cause',
                    'rpV1': 'Plan d\'action engagement'
                };
                
                for (const [key, value] of Object.entries(responses.part2)) {
                    if (key !== 'ID' && value) {
                        part2HTML += `
                            <div class="response-item">
                                <strong>${questionsPart2[key] || key}:</strong>
                                <div>${value}</div>
                            </div>
                        `;
                    }
                }
                
                part2HTML += '</div>';
                container.innerHTML += part2HTML;
            }
            
            // Show modal
            document.getElementById('responsesModal').style.display = 'block';
        }

        // Close modal
        function closeModal() {
            document.getElementById('responsesModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('responsesModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>