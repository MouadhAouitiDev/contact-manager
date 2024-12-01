<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    if ($stmt->execute([$id])) {
        header('Location: index.php');
        exit();
    } else {
        $error = "Erreur lors de la suppression du contact.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <title>Supprimer un Contact</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Supprimer un Contact</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php else: ?>
        <div class="alert alert-success">Contact supprimé avec succès.</div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary">Retour à la liste</a>
</div>
</body>
</html>
