<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déjà répondu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: white;
            text-align: center;
        }

        .message-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.18);
            position: relative;
            animation: fadeIn 0.5s ease;
        }

        .message-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #6a11cb, #2575fc);
        }

        .message-icon {
            font-size: 80px;
            color: #FFA726;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 15px;
            color: white;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.9);
            color: #2575fc;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .message-container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            p {
                font-size: 16px;
            }
            
            .btn {
                padding: 10px 25px;
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }
            
            .btn-secondary {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="message-container">
        <div class="message-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        <h1>Vous avez déjà répondu</h1>
        <p>Nous avons bien reçu vos réponses précédemment. Vous ne pouvez soumettre ce formulaire qu'une seule fois.</p>
        <p>Vous avez une erreur? <a href="test2.php?id=<?php echo urlencode($id); ?>">Cliquez ici</a></p>
        
        <div class="btn-group">
            <a href="index.html" class="btn">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>