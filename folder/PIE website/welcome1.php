<?php
// Get the email from the URL parameter
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';

// If email is empty, check the session (if you're using sessions)
if (empty($email)) {
    session_start();
    $email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIE-A1-P2-Séance 3 - Booklet - Les Leaders</title>
    <link rel="stylesheet" href="page1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Amiri&display=swap" rel="stylesheet">
</head>
<body>
    <style>
                :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --accent-color: #4a00e0;
            --text-color: #2c3e50;
            --light-bg: rgba(255, 255, 255, 0.9);
            --border-color: rgba(106, 17, 203, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            background-attachment: fixed;
            color: var(--text-color);
            line-height: 1.6;
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Decorative elements */
        body::before {
            content: "";
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: -1;
        }

        body::after {
            content: "";
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            z-index: -1;
        }

        header {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        h2 {
            font-size: 18px;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .workbook {
            background: var(--light-bg);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .workbook::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .page {
            padding: 30px;
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .page.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section-title {
            color: var(--primary-color);
            font-size: 22px;
            margin-bottom: 15px;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .section-subtitle {
            text-align: center;
            color: var(--secondary-color);
            margin-bottom: 20px;
            font-style: italic;
        }

        .image-container {
            text-align: center;
            margin: 20px 0;
        }

        .concept-image {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .info-box, .tip-box, .learning-box, .highlight-box {
            background: rgba(106, 17, 203, 0.05);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .tip-box {
            background: rgba(37, 117, 252, 0.05);
            border-left-color: var(--secondary-color);
        }

        .learning-box {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 20px;
        }

        .highlight-box {
            background: rgba(255, 255, 255, 0.8);
            border: 1px dashed var(--primary-color);
            text-align: center;
            padding: 20px;
            margin: 30px 0;
        }

        .ikigai-title {
            font-size: 28px;
            color: var(--primary-color);
            font-weight: 700;
            margin-top: 10px;
        }

        .question-block {
            margin-bottom: 30px;
            animation: fadeIn 0.6s ease;
        }

        .question-title {
            font-size: 18px;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .subtitle {
            font-size: 16px;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .input-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .input-label {
            margin-right: 10px;
            font-weight: 500;
            color: var(--primary-color);
            min-width: 30px;
        }

        input[type="text"], 
        input[type="email"] {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
        }

        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            min-height: 100px;
            font-family: 'Poppins', sans-serif;
            resize: vertical;
        }

        .full-textarea {
            min-height: 150px;
        }

        .table-container {
            overflow-x: auto;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: rgba(106, 17, 203, 0.1);
            color: var(--primary-color);
            font-weight: 600;
        }

        .center-cell {
            text-align: center;
        }

        .two-columns {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        .two-columns > div {
            flex: 1;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 24px;
            text-align: center;
            margin: 20px 0;
            color: var(--primary-color);
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding: 0 20px;
        }

        .nav-btn {
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-btn:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .nav-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .validate-btn {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .validate-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .validate-btn:hover {
            background: linear-gradient(135deg, #218838 0%, #1a6b2f 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }

        .validate-btn:hover::before {
            left: 100%;
        }

        .validate-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.4);
        }

        .validate-btn i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .validate-btn:hover i {
            transform: scale(1.1);
        }

        /* Pulse animation when appearing */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse-animation {
            animation: pulse 0.5s ease;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            margin-top: auto; /* This pushes footer to bottom */
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .bold-text {
            font-weight: 600;
        }

        .medium-text {
            font-size: 17px;
        }

        .italic-text {
            font-style: italic;
            color: #666;
            margin-bottom: 15px;
        }

        .text-center {
            text-align: center;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .slide-in {
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            from { transform: translateX(20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .page {
                padding: 20px;
            }

            .two-columns {
                flex-direction: column;
                gap: 15px;
            }

            .section-title {
                font-size: 20px;
            }

            .question-title {
                font-size: 16px;
            }

            .arabic-text {
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 15px 0;
            }

            h1 {
                font-size: 20px;
            }

            h2 {
                font-size: 16px;
            }

            .nav-btn {
                padding: 8px 15px;
                font-size: 14px;
            }

            .page-indicator {
                font-size: 14px;
                padding: 3px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Your existing HTML content remains exactly the same -->
    <!-- [Previous HTML content from welcome.html goes here] -->
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pages = document.querySelectorAll('.page');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const currentPageEl = document.getElementById('currentPage');
            const totalPagesEl = document.getElementById('totalPages');
            
            let currentPageIndex = 0;
            const totalPages = pages.length;
            
            totalPagesEl.textContent = totalPages;
            
            function showPage(index) {
                // Hide all pages
                pages.forEach(page => {
                    page.classList.remove('active');
                    page.classList.remove('slide-in');
                });
                
                // Show the current page
                pages[index].classList.add('active');
                pages[index].classList.add('slide-in');
                
                // Update page indicator
                currentPageEl.textContent = index + 1;
                
                // Update button states
                prevBtn.disabled = index === 0;
                
                // Change next button to validate on last page
                if (index === totalPages - 1) {
                    nextBtn.innerHTML = '<button name="valider" type="submite" class="fas fa-check-circle"> VALIDER</button>';
                    nextBtn.classList.add('validate-btn');
                    nextBtn.classList.remove('nav-btn');
                    nextBtn.classList.add('pulse-animation');
                    
                    // Remove animation after it plays
                    setTimeout(() => {
                        nextBtn.classList.remove('pulse-animation');
                    }, 500);
                } else {
                    nextBtn.innerHTML = 'Suivant <i class="fas fa-chevron-right"></i>';
                    nextBtn.classList.add('nav-btn');
                    nextBtn.classList.remove('validate-btn');
                }
                
                
                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            
            prevBtn.addEventListener('click', function() {
                if (currentPageIndex > 0) {
                    currentPageIndex--;
                    showPage(currentPageIndex);
                }
            });
            
            nextBtn.addEventListener('click', function() {
                if (currentPageIndex < totalPages - 1) {
                    currentPageIndex++;
                    showPage(currentPageIndex);
                } else {
                    // Handle form validation/submission here
                    alert('Formulaire validé!'); // Replace with actual form submission
                    document.querySelector('form').submit(); // Uncomment to actually submit the form
                }
            });
            
            // Initialize
            showPage(currentPageIndex);
            
            // Animation observer
            const animateElements = document.querySelectorAll('.question-block, .info-box, .tip-box, .learning-box, .highlight-box');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            animateElements.forEach(element => {
                observer.observe(element);
            });
        });
    </script>
    <header>
        <h1>Programme d'Innovation Entrepreneuriale (PIE)</h1>
        <h2>Booklet IKIGAI - Séance 3 : Cahier personnel du STAGIAIRE</h2>
    </header>
    <div class="container">
        <div class="workbook">
            <section id="page1" class="page active">
                <h3 class="section-title">PREMIÈRE ANNÉE, MODULE 1 : COMPRENDRE l'ENTREPRENEURIAT</h3>
                <p class="section-subtitle">Séance 2 sur 9</p>
                
                <div class="image-container">
                    <img src="https://via.placeholder.com/300" alt="IKIGAI Concept" class="concept-image">
                </div>
                
                <div class="info-box">
                    <p>
                        Bienvenue dans votre cahier personnel IKIGAI. Ce document vous accompagnera 
                        dans votre voyage de découverte personnelle et entrepreneuriale.
                    </p>
                </div>
            </section>
            <!-- Page 2 -->
            <section id="page2" class="page">
                <div class="text-center">
                    <h3 class="section-title">Prêt ? On démarre ?</h3>
                    
                    <p class="arabic-text">
                        باسم الله<br>على بركة الله
                    </p>
                    
                    <div class="highlight-box">
                        <h3>PREMIÈRE ANNÉE, PHASE 2 : A LA DÉCOUVERTE DE SOI</h3>
                        <p>CAHIER PERSONNEL DU STAGIAIRE</p>
                        <p class="ikigai-title">IKIGAI</p>
                    </div>
                </div>
            </section>

            <!-- Page 3 -->
            <form method="post" action="welcome.php">
            <section id="page3" class="page">
                <div class="question-block">
                    <h3 class="question-title">1. Chacun écrit sur son cahier les 3 mots (tags) que vous voulez que les gens retiennent de vous ?</h3>
                    <div class="answer-space">
                        <div class="input-row">
                            <span class="input-label">1.1.</span>
                            <input type="text" name="A1" placeholder="Votre réponse...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">1.2.</span>
                            <input type="text" name="A2" placeholder="Votre réponse...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">1.3.</span>
                            <input type="text" name="A3" placeholder="Votre réponse...">
                        </div>
                    </div>
                </div>

                <div class="question-block">
                    <h3 class="question-title">2. Quelles sont les actions du quotidien que vous faites aujourd'hui qui vous permettent de justifier cela ?</h3>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mon Tag</th>
                                    <th>Action quotidienne</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1-</td>
                                    <td>
                                        <textarea name="B1" placeholder="Décrivez vos actions..."></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2-</td>
                                    <td>
                                        <textarea name="B2" placeholder="Décrivez vos actions..."></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3-</td>
                                    <td>
                                        <textarea name="B3" placeholder="Décrivez vos actions..."></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="question-block">
                    <h3 class="question-title">3. Etes-vous une personne de confiance ? Si oui, pourquoi ? Si non, pourquoi ?</h3>
                    <textarea class="full-textarea" name="C1" placeholder="Votre réponse..."></textarea>
                </div>
            </section>
            <!-- Page 4 -->
            <section id="page4" class="page">
                <div class="question-block">
                    <h3 class="question-title">4. Quels sont les mots qu'ont écrit vos collègues</h3>
                    <div class="grid-inputs">
                        <div class="input-row">
                            <span class="input-label">4.1.</span>
                            <input type="text" name="D1" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.2.</span>
                            <input type="text" name="D2" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.3.</span>
                            <input type="text" name="D3" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.4.</span>
                            <input type="text" name="D4" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.5.</span>
                            <input type="text" name="D5" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.6.</span>
                            <input type="text" name="D6" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.7.</span>
                            <input type="text" name="D7" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.8.</span>
                            <input type="text" name="D8" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.9.</span>
                            <input type="text" name="D9" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.10.</span>
                            <input type="text" name="D10" placeholder="Mot écrit par un collègue...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.11.</span>
                            <input type="text" name="D11" placeholder="Mot écrit par un collègue...">
                        </div>
                    </div>
                </div>

                <div class="question-block">
                    <h3 class="question-title">Quels sont les points communs ? Les différences ?</h3>
                    <div class="two-columns">
                        <div>
                            <h4 class="subtitle">Points communs :</h4>
                            <textarea name="E1" placeholder="Listez les points communs..."></textarea>
                        </div>
                        <div>
                            <h4 class="subtitle">Différences :</h4>
                            <textarea name="F1" placeholder="Listez les différences..."></textarea>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Page 5 -->
            <section id="page5" class="page">
                <div class="question-block">
                    <h3 class="question-title">Comment construire votre réputation autour des mots clés que vous voulez ?</h3>
                    <p class="italic-text">
                        Même si vous n'êtes pas encore aujourd'hui ce que vous voulez devenir.
                    </p>
                    <textarea name="G1" class="full-textarea" placeholder="Votre réponse..."></textarea>
                </div>

                <div class="question-block">
                    <h3 class="question-title">Que signifie "être exemplaire" ?</h3>
                    <textarea name="H1" class="full-textarea" placeholder="Votre définition..."></textarea>
                </div>

                <div class="info-box">
                    <p>
                        Réfléchissez à des exemples concrets de personnes que vous considérez comme exemplaires 
                        et pourquoi elles le sont à vos yeux.
                    </p>
                </div>
            </section>
            <!-- Page 6 -->
            <section id="page6" class="page">
                <div class="question-block">
                    <h3 class="question-title">Comment pouvez-vous devenir exemplaire ?</h3>
                    <textarea name="I1" class="full-textarea" placeholder="Décrivez votre plan d'action..."></textarea>
                </div>

                <div class="question-block">
                    <h3 class="question-title">Que devez-vous apprendre pour devenir exemplaire ?</h3>
                    <div class="numbered-inputs">
                        <div class="input-row">
                            <span class="input-label">1.</span>
                            <textarea name="J1" placeholder="Compétence à acquérir..."></textarea>
                        </div>
                        </div>
                </div>

                <div class="tip-box">
                    <p>
                        Conseil : Pensez à des compétences techniques, mais aussi à des qualités humaines 
                        et des comportements qui vous aideront à devenir la personne que vous aspirez à être.
                    </p>
                </div>
            </section>
            <!-- Page 7 -->
            <section id="page7" class="page">
                <div class="question-block">
                    <h3 class="section-title text-center">LES VALEURS</h3>
                    <p>
                        Réflexion individuelle : Quelles sont vos 5 valeurs clés avec lesquelles vous vivez au quotidien ? 
                        Notez ces valeurs sur votre cahier
                    </p>
                    <div class="numbered-inputs">
                        <div class="input-row">
                            <span class="input-label">1.</span>
                            <input type="text" name="K1" placeholder="Votre valeur...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">2.</span>
                            <input type="text" name="K2" placeholder="Votre valeur...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">3.</span>
                            <input type="text" name="K3" placeholder="Votre valeur...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.</span>
                            <input type="text" name="K4" placeholder="Votre valeur...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">5.</span>
                            <input type="text" name="K5" placeholder="Votre valeur...">
                        </div>
                    </div>
                </div>

                <div class="question-block">
                    <h3 class="question-title">Demandez à vos collègues de faire une liste des 5 valeurs qui vous caractérisent</h3>
                    <div class="numbered-inputs">
                        <div class="input-row">
                            <span class="input-label">1.</span>
                            <input type="text" name="L1" placeholder="Valeur identifiée par vos collègues...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">2.</span>
                            <input type="text" name="L2" placeholder="Valeur identifiée par vos collègues...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">3.</span>
                            <input type="text" name="L3" placeholder="Valeur identifiée par vos collègues...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">4.</span>
                            <input type="text" name="L4" placeholder="Valeur identifiée par vos collègues...">
                        </div>
                        <div class="input-row">
                            <span class="input-label">5.</span>
                            <input type="text" name="L5" placeholder="Valeur identifiée par vos collègues...">
                        </div>
                    </div>
                </div>

                <div class="question-block">
                    <h3 class="question-title">Débrief collectif en groupe sur les écarts ou les similarités que vous avez trouvé</h3>
                    <p>
                        Écrivez vos réflexions personnelles sur les écarts constatés et les actions à faire dans les cas d'écart.
                    </p>
                    <textarea name="M1" class="full-textarea" placeholder="Vos réflexions..."></textarea>
                </div>
            </section>
            <!-- Page 8 -->
            <section id="page8" class="page">
                <div class="question-block">
                    <h3 class="section-title text-center">Ce que nous apprenons</h3>
                    
                    <div class="learning-box">
                        <p>
                            Nos valeurs nous bâtissent, nous construisent et déterminent qui nous sommes. 
                            Nos valeurs sont ce qui reste constant, quelles que soient les circonstances.
                        </p>
                        
                        <p>
                            Si je dis que ma valeur c'est l'honnêteté et que face à une situation compliquée et difficile, 
                            je donne un pourboire, je mens, je fais une mauvaise action car "je n'avais pas le choix", 
                            alors l'honnêteté n'est pas une de mes valeurs.
                        </p>
                        
                        <p>
                            Votre valeur c'est ce qui reste quand vous êtes face à des choix difficiles 
                            et que vous n'avez pas d'autres choix que d'assumer votre valeur ou d'y renoncer.
                        </p>
                        
                        <p class="bold-text">
                            C'est dans ces cas, que nous reconnaissons les leaders.
                        </p>
                    </div>
                </div>

                <div class="question-block">
                    <h4 class="subtitle">Réflexion personnelle :</h4>
                    <p>
                        Pensez à une situation difficile où vous avez dû choisir entre respecter une de vos valeurs 
                        ou prendre une décision plus facile. Comment avez-vous agi et qu'avez-vous appris ?
                    </p>
                    <textarea class="full-textarea" name="N1" placeholder="Partagez votre expérience..."></textarea>
                </div>
            </section>
            <!-- Page 9 -->
            <section id="page9" class="page">
                <div class="question-block">
                    <h3 class="section-title text-center">LES CAUSES</h3>
                    <p>
                        Y-a-t-il des causes qui te tiennent à cœur sur lesquelles tu veux contribuer ?
                    </p>
                    <div class="checkbox-inputs">
                        <div class="checkbox-row">
                            <textarea name="O1" placeholder="Cause qui vous tient à cœur..."></textarea>
                        </div>
                </div>

                <div class="question-block">
                    <h3 class="question-title">Quelles sont les actions concrètes que tu fais aujourd'hui qui prouvent que ces causes te tiennent à cœur ?</h3>
                    <div class="table-container">
                        <table class="causes-table">
                            <thead>
                                <tr>
                                    <th>La cause qui me tient à cœur</th>
                                    <th>Actions concrètes</th>
                                    <th>Est-ce que je lis des livres/articles sur le sujet ?</th>
                                    <th>Est-ce que je suis au courant de l'actualité ?</th>
                                    <th>Est-ce que je suis engagé dans des groupes/associations… sur la thématique ?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input name="P1" type="text" placeholder="Cause...">
                                    </td>
                                    <td>
                                        <textarea name="P2" placeholder="Actions..."></textarea>
                                    </td>
                                    <td class="center-cell">
                                        <input  name="P3" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="P4" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="P5" type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="Q1" type="text" placeholder="Cause...">
                                    </td>
                                    <td>
                                        <textarea name="Q2" placeholder="Actions..."></textarea>
                                    </td>
                                    <td class="center-cell">
                                        <input name="Q3" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="Q4" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="Q5" type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="R1" type="text" placeholder="Cause...">
                                    </td>
                                    <td>
                                        <textarea name="R2" placeholder="Actions..."></textarea>
                                    </td>
                                    <td class="center-cell">
                                        <input name="R3" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="R4" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="R5" type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="S1" type="text" placeholder="Cause...">
                                    </td>
                                    <td>
                                        <textarea name="S2" placeholder="Actions..."></textarea>
                                    </td>
                                    <td class="center-cell">
                                        <input name="S3" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="S4" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="S5" type="checkbox">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input name="T1" type="text" placeholder="Cause...">
                                    </td>
                                    <td>
                                        <textarea name="T2" placeholder="Actions..."></textarea>
                                    </td>
                                    <td class="center-cell">
                                        <input name="T3" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="T4" type="checkbox">
                                    </td>
                                    <td class="center-cell">
                                        <input name="T5" type="checkbox">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Page 10 -->
            <section id="page10" class="page">
                <div class="question-block">
                    <h3 class="question-title">Si tu ne fais pas d'actions aujourd'hui, souhaiterais-tu t'engager dans une cause pour le mois prochain ?</h3>
                    <textarea name="U1" class="full-textarea" placeholder="Décrivez votre engagement futur..."></textarea>
                </div>

                <div class="question-block">
                    <h3 class="section-title text-center">Ce que nous apprenons</h3>
                    
                    <div class="learning-box">
                        <p class="medium-text">
                            Etre engagé, ce ne sont pas des paroles, ce sont des actions concrètes sur le terrain.
                        </p>
                        
                        <p>Nous nous engageons quand :</p>
                        <ul>
                            <li>Nous quittons la zone de la parole (donner son point de vue) pour entrer dans l'action.</li>
                            <li>Nous commençons à lire, à nous documenter sur un sujet (pas une recherche unique sur Wikipedia ou une vidéo Youtube de 5 min mais plutôt des recherches constantes sur le sujet).</li>
                            <li>Nous nous engageons sur le terrain via des actions : changer son comportement personnel.</li>
                            <li>Nous nous engageons sur le terrain en rejoignant des collectifs qui construisent sur les questions (Exemple : Bonheur au travail, Artisanat, développement durable, entrepreneuriat social, …).</li>
                        </ul>
                        
                        <p>
                            Exemple : on peut dire : je souhaite m'engager en faveur de l'artisanat au Maroc. 
                            Mais je ne le lis pas sur l'artisanat, je n'achète pas de l'artisanat, 
                            je ne connais pas d'artisans alors cela ne s'appelle pas de l'engagement dans une cause.
                        </p>
                    </div>
                </div>

                <div class="question-block">
                    <h4 class="subtitle">Réflexion finale :</h4>
                    <p>
                        Identifiez une cause dans laquelle vous souhaitez vous engager concrètement et décrivez 
                        les actions spécifiques que vous allez entreprendre dans les prochaines semaines.
                    </p>
                    <textarea name="V1" class="full-textarea" placeholder="Votre plan d'action..."></textarea>
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </section>
            </form>
        </div>
        <div class="navigation">
            <button id="prevBtn" class="nav-btn" disabled>
                <i class="fas fa-chevron-left"></i> Précédent
            </button>
            
            <div class="page-indicator">
                <span id="currentPage">1</span> / <span id="totalPages">10</span>
            </div>
            
            <button id="nextBtn" class="nav-btn">
                Suivant <i class="fas fa-chevron-right"></i>
            </button>

        </div>
</div>
    <footer>
        <p class="font-semibold">PREMIÈRE ANNÉE, PHASE 2 : A LA DÉCOUVERTE DE SOI</p>
        <p>CAHIER PERSONNEL DU STAGIAIRE</p>
        <p class="font-bold">IKIGAI</p>
    </footer>
</body>
</html>
