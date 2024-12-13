<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestion_stock';
$username = 'root';
$password = 'L@nDry2000##';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer les paramètres de filtre
$produit_filter = isset($_GET['produit']) ? $_GET['produit'] : '';
$fournisseur_filter = isset($_GET['fournisseur']) ? $_GET['fournisseur'] : '';
$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : '';
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : '';

// Construire la requête SQL avec filtres
$sql = "SELECT f.id_facture, p.nom_produit, fo.nom_fournisseur, f.quantité, f.cout_unitaire, f.montant_total, f.date_facture
        FROM Factures f
        JOIN Produits p ON f.id_produit = p.id_produit
        JOIN Fournisseurs fo ON f.id_fournisseur = fo.id_fournisseur
        WHERE 1";

if ($produit_filter) {
    $sql .= " AND p.nom_produit LIKE :produit";
}

if ($fournisseur_filter) {
    $sql .= " AND fo.nom_fournisseur LIKE :fournisseur";
}

if ($date_start && $date_end) {
    $sql .= " AND f.date_facture BETWEEN :date_start AND :date_end";
}

$sql .= " ORDER BY f.date_facture DESC"; // Tri par date décroissante

$stmt = $pdo->prepare($sql);

// Lier les paramètres si les filtres sont définis
if ($produit_filter) {
    $stmt->bindValue(':produit', "%$produit_filter%");
}

if ($fournisseur_filter) {
    $stmt->bindValue(':fournisseur', "%$fournisseur_filter%");
}

if ($date_start && $date_end) {
    $stmt->bindValue(':date_start', $date_start);
    $stmt->bindValue(':date_end', $date_end);
}

$stmt->execute();
$factures = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Factures</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Liste des Factures d'Achat</h2>

        <a href="facture.php" class="btn btn-success mb-4">Ajouter une facture</a>


        <!-- Formulaire de filtre -->
        <form method="GET" class="mb-4">
            <div class="row">
                <!-- Filtre Produit -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="produit" placeholder="Filtrer par produit" value="<?php echo htmlspecialchars($produit_filter); ?>">
                </div>

                <!-- Filtre Fournisseur -->
                <div class="col-md-3">
                    <input type="text" class="form-control" name="fournisseur" placeholder="Filtrer par fournisseur" value="<?php echo htmlspecialchars($fournisseur_filter); ?>">
                </div>

                <!-- Filtre par Date -->
                <div class="col-md-3">
                    <input type="date" class="form-control" name="date_start" placeholder="Date de début" value="<?php echo htmlspecialchars($date_start); ?>">
                </div>

                <div class="col-md-3">
                    <input type="date" class="form-control" name="date_end" placeholder="Date de fin" value="<?php echo htmlspecialchars($date_end); ?>">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Filtrer</button>
        </form>

        <!-- Tableau des factures -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Fournisseur</th>
                    <th>Quantité</th>
                    <th>Coût Unitaire</th>
                    <th>Montant Total</th>
                    <th>Date de Facture</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($factures)) { ?>
                    <tr><td colspan="6">Aucune facture trouvée.</td></tr>
                <?php } else { ?>
                    <?php foreach ($factures as $facture) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($facture['nom_produit']); ?></td>
                            <td><?php echo htmlspecialchars($facture['nom_fournisseur']); ?></td>
                            <td><?php echo htmlspecialchars($facture['quantité']); ?></td>
                            <td><?php echo htmlspecialchars($facture['cout_unitaire']); ?>€</td>
                            <td><?php echo htmlspecialchars($facture['montant_total']); ?>€</td>
                            <td><?php echo htmlspecialchars($facture['date_facture']); ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
