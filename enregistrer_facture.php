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

// Récupération des produits
$produits = $pdo->query("SELECT id_produit, nom_produit FROM Produits")->fetchAll(PDO::FETCH_ASSOC);

// Récupération des fournisseurs
$fournisseurs = $pdo->query("SELECT id_fournisseur, nom_fournisseur FROM Fournisseurs")->fetchAll(PDO::FETCH_ASSOC);

// Génération des listes déroulantes
function genererOptions($data, $idKey, $valueKey)
{
    $options = "";
    foreach ($data as $item) {
        $options .= "<option value='{$item[$idKey]}'>{$item[$valueKey]}</option>";
    }
    return $options;
}

// Génération des options produits et fournisseurs
$optionsProduits = genererOptions($produits, 'id_produit', 'nom_produit');
$optionsFournisseurs = genererOptions($fournisseurs, 'id_fournisseur', 'nom_fournisseur');
