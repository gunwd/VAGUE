<?php include("./partials/db.php"); ?>
<?php if (!isset($_SESSION['account']) || empty($_SESSION['account'])) { ?>

  <?php include("./partials/navbar.php"); ?>
  <?php if (isset($_GET["error"])) { ?>
    <div class="alert-box"><?php echo htmlspecialchars($_GET["error"]) ?></div>
  <?php } ?>
  <section>
    <div class="container mt-2">
      <h1 class="display-1 text-center">COMPTE</h1>
      <div class="d-flex justify-content-center">
        <form action="/accountHandler.php" method="POST" class=" w-50 p-3">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control outline-dark border border-dark" id="email" name="email">
          </div>
          <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot de passe</label>
            <input type="password" class="form-control border border-dark" id="motDePasse" name="motDePasse">
          </div>
          <div class="mb-3">
            <button type="submit" class="btn btn-outline-dark">Connexion</button>
            <a href="/register.php" class="btn btn-outline-dark">S'inscrire</a>
          </div>
        </form>
      </div>
    </div>
  </section>
<?php } else {
  try {
    $sqlGetAccountInfo = $db->prepare('SELECT * FROM Clients WHERE email = "' . $_SESSION["account"]["email"] . '" AND motDePasse = "' . $_SESSION["account"]["motDePasse"] . '"');
    $sqlGetAccountInfo->execute();
    $sqlGetAccountInfoResults = $sqlGetAccountInfo->fetchAll();
    // check if account still valid
    if (empty($sqlGetAccountInfoResults)) {
      unset($_SESSION["account"]);
      header('Location: /account.php?error=Identifiants incorrects');
      exit;
    }

    // to display previous account orders under the panel - if they exist
    $sqlGetClientOrders = $db->prepare('SELECT * FROM Clients INNER JOIN Commandes ON Clients.email = Commandes.emailClient INNER JOIN Lignescommandes ON Commandes.id = Lignescommandes.idCommande INNER JOIN Produits ON Lignescommandes.idProduit = Produits.id WHERE email = "' . $_SESSION["account"]["email"] . '"');
    $sqlGetClientOrders->execute();
    $sqlGetClientOrdersResults = $sqlGetClientOrders->fetchAll();
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  } ?>

  <?php include("./partials/navbar.php"); ?>
  <?php if (isset($_GET["error"])) { ?>
    <div class="alert-box"><?php echo htmlspecialchars($_GET["error"]) ?></div>
  <?php } ?>
  <section>
    <div class="container mt-2">
      <h1 class="display-1 text-center">COMPTE</h1>
      <div class="d-flex justify-content-center text-center">

        <div class="w-50 p-3">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class=""><?php echo htmlspecialchars($_SESSION["account"]["email"]) ?></div>
          </div>
          <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot De Passe</label>
            <div class=""><?php echo htmlspecialchars($_SESSION["account"]["motDePasse"]) ?></div>
          </div>
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <div class=""><?php echo htmlspecialchars($_SESSION["account"]["nom"]) ?></div>
          </div>
          <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <div class=""><?php echo htmlspecialchars($_SESSION["account"]["prenom"]) ?></div>
          </div>
          <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>
            <div class=""><?php echo htmlspecialchars($_SESSION["account"]["ville"]) ?></div>
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <div class=""><?php echo htmlspecialchars($_SESSION["account"]["adresse"]) ?></div>
          </div>
          <div class="mb-3">
            <a href="/accountHandler.php?logout=true" class="btn btn-dark my-2">Déconnexion</a>
          </div>
        </div>
      </div>
    </div>
    <?php if (!empty($sqlGetClientOrdersResults)) { ?>
      <?php foreach ($sqlGetClientOrdersResults as $order) { ?>
        <div class="d-flex justify-content-center">
          <div class="card card-item shadow-sm border border-dark my-2">
            <img src="<?php echo htmlspecialchars($order["photo"]); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($order["nom"]) ?>">
            <div class="card-body">
              <p class="card-text"><?php echo htmlspecialchars($order["descriptif"]); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">$<?php echo htmlspecialchars($order["prix"]); ?> - Acheté</small>
              </div>
            </div>
          </div>
        </div>
      <?php }; ?>
    <?php } ?>
  </section>
<?php } ?>

<script src="/assets/js/error.js"></script>
<?php include("./partials/footer.php"); ?>