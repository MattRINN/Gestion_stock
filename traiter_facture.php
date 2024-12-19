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

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id_produit = $_POST['id_produit'];
    $id_fournisseur = $_POST['id_fournisseur'];
    $quantité = $_POST['quantité'];
    $cout_unitaire = $_POST['cout_unitaire'];
    $date_facture = $_POST['date_facture'];

    // Calculer le montant total
    $montant_total = $quantité * $cout_unitaire;

    // Valider les données
    if (empty($id_produit) || empty($id_fournisseur) || empty($quantité) || empty($cout_unitaire) || empty($date_facture)) {
        die("Tous les champs sont obligatoires.");
    }

    try {
        // Insérer la nouvelle facture dans la table
        $sql = "INSERT INTO Factures (id_produit, id_fournisseur, quantité, cout_unitaire, montant_total, date_facture)
                VALUES (:id_produit, :id_fournisseur, :quantité, :cout_unitaire, :montant_total, :date_facture)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_produit' => $id_produit,
            ':id_fournisseur' => $id_fournisseur,
            ':quantité' => $quantité,
            ':cout_unitaire' => $cout_unitaire,
            ':montant_total' => $montant_total,
            ':date_facture' => $date_facture
        ]);

        echo "La facture a été enregistrée avec succès !";
    } catch (PDOException $e) {
        die("Erreur lors de l'enregistrement : " . $e->getMessage());
    }
} else {
    die("Méthode de requête invalide.");
}
