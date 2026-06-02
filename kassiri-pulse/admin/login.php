<?php
/**
 * Kassiri Pulse - Connexion Administrative
 * Fichier : admin/login.php
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Démo sécurisée - identifiants de test culturels
    if ($username === 'admin' && $password === 'burkina226') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Identifiants administratifs incorrects. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration | Kassiri Pulse</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #FAF5E9;
            font-family: 'Source Sans Pro', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #ffffff;
            border-style: solid;
            border-width: 6px;
            border-image: repeating-linear-gradient(45deg, #1A6B3C, #1A6B3C 10px, #D4A017 10px, #D4A017 20px, #C0392B 20px, #C0392B 30px, #1A1A1A 30px, #1A1A1A 40px) 20;
            width: 100%;
            max-width: 440px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        .btn-kassiri {
            background-color: #C0392B;
            color: #FAF5E9;
            border-radius: 0;
            font-weight: 600;
            border: 2px solid #C0392B;
        }
        .btn-kassiri:hover {
            background-color: transparent;
            color: #C0392B;
            border-color: #C0392B;
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <div class="bg-danger d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 50px; height: 50px; border: 3px solid #D4A017;">
        <span class="font-serif fw-bold" style="font-size: 24px;">K</span>
    </div>
    
    <h3 class="font-serif fw-bold text-dark mb-1">KASSIRI ADMIN</h3>
    <span class="text-xs text-muted block font-mono text-uppercase tracking-wider d-block mb-4" style="font-size: 11px;">Espace de Gestion Culturelle</span>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger rounded-0 text-start py-2 text-xs" style="font-size: 13px;">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3 text-start">
            <label class="form-label font-serif text-dark fw-bold" style="font-size:14px;"><i class="fa-solid fa-user me-1 text-danger"></i> Nom d'utilisateur :</label>
            <input type="text" name="username" class="form-control rounded-0 font-sans" placeholder="Ex: admin" required autocomplete="off">
        </div>
        <div class="mb-4 text-start">
            <label class="form-label font-serif text-dark fw-bold" style="font-size:14px;"><i class="fa-solid fa-lock me-1 text-danger"></i> Mot de passe :</label>
            <input type="password" name="password" class="form-control rounded-0 font-sans" placeholder="Ex: burkina226" required>
        </div>
        
        <div class="p-3 bg-light border border-warning text-xs text-start mb-4 text-dark" style="font-size: 11px; line-height:1.5;">
            <i class="fa-solid fa-circle-info text-warning me-1"></i> <strong>Mode Démonstration :</strong> Pour accéder à l'interface administrative, saisissez les identifiants nationaux suivants : <strong>username: admin</strong> / <strong>password: burkina226</strong>.
        </div>

        <button type="submit" class="btn btn-kassiri w-100 font-serif text-uppercase py-2"><i class="fa-solid fa-right-to-bracket me-1"></i> Se Connecter</button>
    </form>
    
    <div class="mt-4">
        <a href="../accueil" class="text-sm text-decoration-none text-muted font-mono" style="font-size:12px;"><i class="fa-solid fa-arrow-left me-1"></i> Retourner vers le portail</a>
    </div>
</div>

</body>
</html>
