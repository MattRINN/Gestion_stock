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

// Récupérer les produits et les fournisseurs pour les listes déroulantes
$produits = $pdo->query("SELECT id_produit, nom_produit FROM Produits")->fetchAll(PDO::FETCH_ASSOC);
$fournisseurs = $pdo->query("SELECT id_fournisseur, nom_fournisseur FROM Fournisseurs")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Facture</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Créer une Facture</h2>
        <form action="traiter_facture.php" method="POST">
            <!-- Produit -->
            <div class="mb-3">
                <label for="produit" class="form-label">Produit</label>
                <select class="form-select" id="produit" name="id_produit" required>
                    <option value="">Sélectionnez un produit</option>
                    <?php foreach ($produits as $produit) { ?>
                        <option value="<?php echo $produit['id_produit']; ?>"><?php echo $produit['nom_produit']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Fournisseur -->
            <div class="mb-3">
                <label for="fournisseur" class="form-label">Fournisseur</label>
                <select class="form-select" id="fournisseur" name="id_fournisseur" required>
                    <option value="">Sélectionnez un fournisseur</option>
                    <?php foreach ($fournisseurs as $fournisseur) { ?>
                        <option value="<?php echo $fournisseur['id_fournisseur']; ?>"><?php echo $fournisseur['nom_fournisseur']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Quantité -->
            <div class="mb-3">
                <label for="quantite" class="form-label">Quantité</label>
                <input type="number" class="form-control" id="quantite" name="quantité" required>
            </div>

            <!-- Coût unitaire -->
            <div class="mb-3">
                <label for="cout_unitaire" class="form-label">Coût unitaire</label>
                <input type="number" class="form-control" id="cout_unitaire" name="cout_unitaire" step="0.01" required>
            </div>

            <!-- Date de facture -->
            <div class="mb-3">
                <label for="date_facture" class="form-label">Date de facture</label>
                <input type="date" class="form-control" id="date_facture" name="date_facture" required>
            </div>

            <!-- Bouton Soumettre -->
            <button type="submit" class="btn btn-primary">Enregistrer la facture</button>
        </form>
    </div>
</body>
</html>
