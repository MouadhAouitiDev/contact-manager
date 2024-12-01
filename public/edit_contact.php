<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Récupération des informations du contact
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$contact) {
        header('Location: index.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $age = (int)$_POST['age'];
    $country = htmlspecialchars($_POST['country']);
    $email = htmlspecialchars($_POST['email']);
    $phone_number = htmlspecialchars($_POST['phone_number']);

    // Validation et mise à jour
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Adresse email invalide.";
    } elseif (!is_numeric($age) || $age <= 0) {
        $error = "Âge invalide.";
    } else {
        // Vérification si l'email existe déjà (exclure le contact actuel de la vérification)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM contacts WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        $email_exists = $stmt->fetchColumn();

        // Vérification si le numéro de téléphone existe déjà (exclure le contact actuel de la vérification)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM contacts WHERE phone_number = ? AND id != ?");
        $stmt->execute([$phone_number, $id]);
        $phone_exists = $stmt->fetchColumn();

        if ($email_exists > 0) {
            $error = "L'adresse email est déjà utilisée.";
        } elseif ($phone_exists > 0) {
            $error = "Le numéro de téléphone est déjà utilisé.";
        } else {
            // Mise à jour dans la base de données
            $stmt = $pdo->prepare("UPDATE contacts SET first_name = ?, last_name = ?, age = ?, country = ?, email = ?, phone_number = ? WHERE id = ?");
            if ($stmt->execute([$first_name, $last_name, $age, $country, $email, $phone_number, $id])) {
                header('Location: index.php');
                exit();
            } else {
                $error = "Erreur lors de la mise à jour.";
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
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Modifier un Contact</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Modifier un Contact</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($contact['first_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($contact['last_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Âge</label>
            <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($contact['age']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Pays</label>
            <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($contact['country']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contact['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="phone_number" class="form-control" value="<?= htmlspecialchars($contact['phone_number']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
