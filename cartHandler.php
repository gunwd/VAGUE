<?php include("./partials/db.php"); ?>
<?php

if (!isset($_SESSION['account']) || empty($_SESSION['account'])) {
  header("Location: /account.php?error=Connectez-vous avant d'acheter");
} else {
  if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: /cart.php?error=Panier vide");
    exit;
  }
  try {
    $sqlAccount = $db->prepare('SELECT * FROM Clients WHERE email = "' . $_SESSION["account"]["email"] . '" AND motDePasse = "' . $_SESSION["account"]["motDePasse"] . '"');
    $sqlAccount->execute();
    $sqlAccountResults = $sqlAccount->fetchAll();
    // check if account still valid
    if (empty($sqlAccountResults)) {
      unset($_SESSION["account"]);
      header('Location: /account.php?error=Identifiants incorrects');
      exit;
    }

    // get product info to check their stock
    $sqlGetOrderedProducts = $db->prepare("SELECT * FROM Produits WHERE id IN (" . implode(',', $_SESSION['cart']) . ")");
    $sqlGetOrderedProducts->execute();
    $sqlGetOrderedProducts = $sqlGetOrderedProducts->fetchAll();

    foreach ($sqlGetOrderedProducts as $result) {
      if ($result["stock"] <= 0) {
        header('Location: /cart.php?error=Votre panier contient des produits en rupture de stock');
        exit;
      }
    }

    // create order
    $sqlCreateOrder = $db->prepare('INSERT INTO Commandes (date, emailClient, etat) VALUES (now(), "' . $_SESSION["account"]["email"] . '", "nouvelle")');
    $sqlCreateOrder->execute();
    $sqlGetLastOrder = $db->prepare('SELECT * FROM Commandes WHERE id=(SELECT MAX(id) FROM Commandes)');
    $sqlGetLastOrder->execute();
    $sqlGetLastOrderResults = $sqlGetLastOrder->fetchAll();

    foreach ($_SESSION['cart'] as $cartItemID) {
      foreach ($sqlGetOrderedProducts as $result) {
        if ($result["id"] == $cartItemID) {
          $sql = $db->prepare('INSERT INTO Lignescommandes (idCommande, idProduit, quantite, montant) VALUES (' . $sqlGetLastOrderResults[0]["id"] . ', ' . $result["id"] . ', 1, ' . $result["prix"] . ')');
          $sql->execute();
          $sql = $db->prepare('UPDATE Produits SET stock = ' . $result["stock"] - 1 . ' WHERE id = ' . $result["id"]);
          $sql->execute();
        }
      }
    }
    unset($_SESSION["cart"]);
    header('Location: /account.php?error=Commande Passée');
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
}

exit;
?>