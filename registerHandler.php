<?php include("./partials/db.php"); ?>
<?php

if (isset($_POST["email"]) && isset($_POST["motDePasse"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["ville"]) && isset($_POST["adresse"])) {
  try {
    // check if account exists
    $sqlGetAccountInfo = $db->prepare('SELECT * FROM Clients WHERE email = "' . $_POST["email"] . '"');
    $sqlGetAccountInfo->execute();
    $sqlGetAccountInfoResults = $sqlGetAccountInfo->fetchAll();
    if (!empty($sqlGetAccountInfoResults)) {
      header('Location: /register.php?error=Vous avez déjà un compte');
      exit;
    }

    $sqlCreateNewAccount = $db->prepare('INSERT INTO Clients VALUES ("' . $_POST["email"] . '", "' . $_POST["motDePasse"] . '", "' . $_POST["nom"] . '", "' . $_POST["prenom"] . '", "' . $_POST["ville"] . '", "' . $_POST["adresse"] . '")');
    $sqlCreateNewAccount->execute();
    header('Location: /account.php?error=Vous avez créé un compte avec succès, veuillez vous connecter');
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
} else {
  header('Location: /register.php?error=Remplissez le formulaire correctement');
}

exit;
?>
