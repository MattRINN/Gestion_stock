<?php
// Inclure le code pour récupérer les options des produits et fournisseurs
include 'enregistrer_facture.php';
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une facture d'achat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Créer une facture d'achat</h2>
        <form action="traiter_facture.php" method="POST">


            <!-- Liste déroulante pour les produits -->
            <div class="mb-3">
                <label for="produit" class="form-label">Produit</label>
                <select class="form-select" id="produit" name="id_produit" required>
                    <option value="">Sélectionnez un produit</option>
                    <!-- Insertion des options pour les produits -->
                    <?php echo $optionsProduits; ?>
                </select>
            </div>

            <!-- Liste déroulante pour les fournisseurs -->
            <div class="mb-3">
                <label for="fournisseur" class="form-label">Fournisseur</label>
                <select class="form-select" id="fournisseur" name="id_fournisseur" required>
                    <option value="">Sélectionnez un fournisseur</option>
                    <!-- Insertion des options pour les fournisseurs -->
                    <?php echo $optionsFournisseurs; ?>
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