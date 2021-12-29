<?php include("./partials/db.php"); ?>
<?php

if (isset($_GET["logout"])) {
  unset($_SESSION["account"]);
  header('Location: /account.php?error=Vous vous êtes déconnecté');
  exit;
}

if (!empty($_POST["email"]) && !empty($_POST["motDePasse"])) {
  try {
    // verify account
    $sqlGetAccountData = $db->prepare('SELECT * FROM Clients WHERE email = "' . $_POST['email'] . '" AND motDePasse = "' . $_POST['motDePasse'] . '"');
    $sqlGetAccountData->execute();
    $sqlGetAccountDataResults = $sqlGetAccountData->fetchAll();

    // if no account found delete account session and send back to account page with error
    if (empty($sqlGetAccountDataResults)) {
      // just to be safe, remove account session anyway!
      unset($_SESSION["account"]);
      header('Location: /account.php?error=Identifiants incorrects');
      exit;
    }

    $_SESSION['account'] = array("email" => $sqlGetAccountDataResults[0]["email"], "motDePasse" => $sqlGetAccountDataResults[0]["motDePasse"], "nom" => $sqlGetAccountDataResults[0]["nom"], "prenom" => $sqlGetAccountDataResults[0]["prenom"], "ville" => $sqlGetAccountDataResults[0]["ville"], "adresse" => $sqlGetAccountDataResults[0]["adresse"]);
    header('Location: /account.php');
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {
  header('Location: /account.php?error=Remplissez le formulaire correctement');
}

exit;
?>