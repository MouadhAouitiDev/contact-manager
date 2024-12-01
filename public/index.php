<?php
include 'db.php';
$query = $pdo->query("SELECT * FROM contacts");
$contacts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/datatables/dataTables.bootstrap5.min.css">
    <title>Liste des Contacts</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Liste des Contacts</h1>
    <a href="add_contact.php" class="btn btn-success mb-3">Ajouter un Contact</a>
    <table id="contactsTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Âge</th>
                <th>Pays</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['first_name']) ?></td>
                    <td><?= htmlspecialchars($contact['last_name']) ?></td>
                    <td><?= htmlspecialchars($contact['age']) ?></td>
                    <td><?= htmlspecialchars($contact['country']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['phone_number']) ?></td>
                    <td>
                        <a href="edit_contact.php?id=<?= $contact['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="delete_contact.php?id=<?= $contact['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce contact ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="assets/js/search.js"></script>
<script src="assets/js/jquery-3.7.0.min.js"></script>
<script src="assets/js/datatables/js/jquery.dataTables.min.js"></script>
<script src="assets/js/datatables/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#contactsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json"
            }
        });
    });
</script>
</body>
</html>