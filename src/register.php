<?php include("./partials/db.php"); ?>
<?php if (isset($_SESSION['account']) && !empty($_SESSION['account'])) {
  header('Location: /account.php');
  exit;
} else { ?>

  <?php include("./partials/navbar.php"); ?>
  <?php if (isset($_GET["error"])) { ?>
    <div class="alert-box"><?php echo htmlspecialchars($_GET["error"]) ?></div>
  <?php } ?>
  <section>
    <div class="container mt-2">
      <h1 class="display-1 text-center">S'INSCRIRE</h1>
      <div class="d-flex justify-content-center">

        <form action="/registerHandler.php" method="POST" class=" w-50 p-3">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control outline-dark border border-dark" id="email" name="email">
            <div id="emailHelp" class="form-text">Nous ne partagerons jamais votre adresse email.</div>
          </div>
          <div class="mb-3">
            <label for="motDePasse" class="form-label">Mot de passe</label>
            <input type="password" class="form-control border border-dark" id="motDePasse" name="motDePasse">
          </div>
          <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control outline-dark border border-dark" id="prenom" name="prenom">
          </div>
          <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control border border-dark" id="nom" name="nom">
          </div>
          <div class="mb-3">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control outline-dark border border-dark" id="ville" name="ville">
          </div>
          <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control border border-dark" id="adresse" name="adresse">
          </div>
          <button type="submit" class="btn btn-outline-dark">S'inscrire</button>
        </form>
      </div>
    </div>
  </section>
<?php } ?>

<script src="/assets/js/error.js"></script>
<?php include("./partials/footer.php"); ?>