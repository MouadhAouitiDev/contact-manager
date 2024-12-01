<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $age = (int)$_POST['age'];
    $country = htmlspecialchars($_POST['country']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    // Validation et insertion
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif (!is_numeric($age) || $age <= 0) {
        $error = "Âge invalide.";
    } else {
        // Vérification si l'email existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM contacts WHERE email = ?");
        $stmt->execute([$email]);
        $email_exists = $stmt->fetchColumn();

        // Vérification si le numéro de téléphone existe déjà
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM contacts WHERE phone_number = ?");
        $stmt->execute([$phone_number]);
        $phone_exists = $stmt->fetchColumn();

        if ($email_exists > 0) {
            $error = "L'adresse email est déjà utilisée.";
        } elseif ($phone_exists > 0) {
            $error = "Le numéro de téléphone est déjà utilisé.";
        } else {
            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO contacts (first_name, last_name, age, country, email, phone_number) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$first_name, $last_name, $age, $country, $email, $phone_number]);
            header('Location: index.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/style.css" rel="stylesheet" >
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <title>Ajouter un Contact</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Ajouter un Contact</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Âge</label>
            <input type="number" name="age" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Pays</label>
            <input type="text" name="country" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
    </form>
</div>
</body>
</html>
