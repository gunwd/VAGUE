<?php include("./partials/db.php"); ?>
<?php

try {
  // DATA
  $sqlQueryGetProducts = "SELECT * FROM Produits";

  if (count(array_filter($_GET))) { // not empty
    if ((isset($_GET['categorie']) && !empty($_GET['categorie'])) && !(isset($_GET['nom']) && !empty($_GET['nom']))) {
      $sqlQueryGetProducts .= ' WHERE categorie = "' . $_GET['categorie'] . '"';
    } elseif (!(isset($_GET['categorie']) && !empty($_GET['categorie'])) && (isset($_GET['nom']) && !empty($_GET['nom']))) {
      $sqlQueryGetProducts .= ' WHERE nom LIKE "%' . $_GET['nom'] . '%"';
    } elseif ((isset($_GET['categorie']) && !empty($_GET['categorie'])) && (isset($_GET['nom']) && !empty($_GET['nom']))) {
      $sqlQueryGetProducts .= ' WHERE categorie = "' . $_GET['categorie'] . '" AND nom LIKE "%' . $_GET['nom'] . '%"';
    }

    if ((isset($_GET['prix']) && !empty($_GET['prix'])) && ($_GET['prix'] == "ASC" || $_GET['prix'] == "DESC")) {
      $sqlQueryGetProducts .= ' ORDER BY prix ' . $_GET['prix'];
    }
  }

  $sqlGetProducts = $db->prepare($sqlQueryGetProducts);
  $sqlGetProducts->execute();
  $sqlGetProductsResults = $sqlGetProducts->fetchAll();

  // set the PDO error mode to exception
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

?>

<?php include("./partials/navbar.php"); ?>
<section>
  <canvas class="my-2" id="myCanvas"></canvas>

  <div class="container">
    <form action="index.php" method="GET" class="d-flex flex-row bd-highlight justify-content-center">
      <div class="mx-3 my-5 text-center">
        <select class="form-select" aria-label="Default select example" name="prix">
          <option disabled selected>Prix</option>
          <option value="ASC">Ascendant</option>
          <option value="DESC">Descendant</option>
        </select>
      </div>

      <div class="mx-3 my-5 text-center">
        <select class="form-select" aria-label="Default select example" name="categorie">
          <option disabled selected>Categorie</option>
          <option value="t shirt">t shirt</option>
          <option value="hoodie">hoodie</option>
        </select>
      </div>

      <div class="mx-3 my-5 text-center">
        <input type="text" class="form-control outline-dark border border-dark" id="nom" name="nom" placeholder="Nom de Produit">
      </div>


      <div class="mx-3 my-5 text-center">
        <button type="submit" class="btn btn-dark">Recherche</button>
      </div>


    </form>
  </div>

  <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php foreach ($sqlGetProductsResults as $result) {
        if ($result["stock"] > 0) { ?>
          <div class="col">
            <div class="card card-item shadow-sm border border-dark">
              <img src="<?php echo htmlspecialchars($result["photo"]); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($result["nom"]) ?>">
              <div class="card-body">
                <p class="card-text"><?php echo htmlspecialchars($result["descriptif"]); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="/cart.php?addCartID=<?php echo htmlspecialchars($result["id"]) ?>" class="btn btn-sm btn-outline-dark me-1">Ajouter au panier</a>
                  </div>
                  <small class="text-muted">$<?php echo htmlspecialchars($result["prix"]); ?></small>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php }; ?>
</section>

<script src="/assets/js/edition.js"></script>
<?php include("./partials/footer.php"); ?>