<?php include("./partials/db.php"); ?>
<?php

if (isset($_GET["addCartID"])) {
  if (isset($_SESSION['cart'])) {
    array_push($_SESSION['cart'], $_GET["addCartID"]);
  } else {
    $_SESSION['cart'] = array();
    array_push($_SESSION['cart'], $_GET["addCartID"]);
  }
}

if (isset($_GET["removeCartID"]) && isset($_SESSION['cart'])) {
  if (($key = array_search($_GET["removeCartID"], $_SESSION['cart'])) !== false) {
    unset($_SESSION['cart'][$key]);
  }
}

?>

<?php include("./partials/navbar.php"); ?>
<?php if (isset($_GET["error"])) { ?>
  <div class="alert-box"><?php echo htmlspecialchars($_GET["error"]) ?></div>
<?php } ?>
<section>
  <div class="container mt-2">
    <h1 class="display-1 text-center">PANIER</h1>
    <div class="d-flex justify-content-center">
      <div class="card w-50 p-3 border border-dark">
        <ul class="list-group list-group-flush">
          <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            try {
              $sqlGetProductsInCart = $db->prepare("SELECT * FROM Produits WHERE id IN (" . implode(',', $_SESSION['cart']) . ")");
              $sqlGetProductsInCart->execute();
              $sqlGetProductsInCartResults = $sqlGetProductsInCart->fetchAll();
            } catch (PDOException $e) {
              echo "Connection failed: " . $e->getMessage();
            }
            foreach ($_SESSION['cart'] as $cartItemID) {
              foreach ($sqlGetProductsInCartResults as $result) {
                if ($result["id"] == $cartItemID) { ?>
                  <li class="list-group-item">
                    <div class="card mb-3">
                      <div class="row g-0">
                        <div class="col-md-4">
                          <img src="<?php echo htmlspecialchars($result["photo"]); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($result["nom"]) ?>">
                        </div>
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($result["nom"]) ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($result["descriptif"]); ?></p>
                            <small class="text-muted">$<?php echo htmlspecialchars($result["prix"]); ?></small>
                            <a href="/cart.php?removeCartID=<?php echo htmlspecialchars($result["id"]) ?>" class="btn btn-sm btn-outline-danger position-absolute end-0 me-3">Supprimer</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } ?>
              <?php  } ?>
            <?php } ?>
          <?php } else { ?>
            <li class="list-group-item">
              <p class="d-flex justify-content-center card-text">Panier est vide.</p>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
        <a href="/cartHandler.php" class="btn btn-dark my-5">Acheter</a>
      <?php } else { ?>
        <button type="button" class="btn btn-dark my-5" disabled>Acheter</button>
      <?php } ?>
    </div>
  </div>
</section>

<script src="/assets/js/error.js"></script>
<?php include("./partials/footer.php"); ?>