CREATE TABLE `projet`.`Clients` (
  `email` VARCHAR(255) NOT NULL,
  `motDePasse` VARCHAR(255) NOT NULL,
  `nom` VARCHAR(255) NOT NULL,
  `prenom` VARCHAR(255) NOT NULL,
  `ville` VARCHAR(255) NOT NULL,
  `adresse` TEXT NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE = InnoDB;
CREATE TABLE `projet`.`Produits` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  `categorie` VARCHAR(255) NOT NULL,
  `descriptif` TEXT NOT NULL,
  `photo` TEXT NOT NULL,
  `prix` DOUBLE NOT NULL,
  `stock` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
CREATE TABLE `projet`.`Commandes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `emailClient` VARCHAR(255) NOT NULL,
  `etat` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
ALTER TABLE `Commandes`
ADD FOREIGN KEY (`emailClient`) REFERENCES `Clients`(`email`) ON DELETE RESTRICT ON UPDATE RESTRICT;
CREATE TABLE `projet`.`Lignescommandes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idCommande` INT NOT NULL,
  `idProduit` INT NOT NULL,
  `quantite` INT NOT NULL,
  `montant` DOUBLE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
ALTER TABLE `Lignescommandes`
ADD FOREIGN KEY (`idCommande`) REFERENCES `Commandes`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Lignescommandes`
ADD FOREIGN KEY (`idProduit`) REFERENCES `Produits`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
INSERT INTO `Produits` (
    `id`,
    `nom`,
    `categorie`,
    `descriptif`,
    `photo`,
    `prix`,
    `stock`
  )
VALUES (
    1,
    'Visit Night City',
    't shirt',
    'Visitez Night City avec cette belle édition de t-shirt CYBERPUNK !',
    '/assets/images/1.jpg',
    999,
    5
  ),
  (
    2,
    'XAXO',
    't shirt',
    'XAXO pour les fans originaux ! On se souvient de Frank !',
    '/assets/images/2.jpg',
    1399,
    5
  ),
  (
    3,
    'I need you.',
    't shirt',
    '\"I need you.\" est notre meilleure t shirt!',
    '/assets/images/3.jpg',
    1799,
    5
  );
INSERT INTO `Clients` (
    `email`,
    `motDePasse`,
    `nom`,
    `prenom`,
    `ville`,
    `adresse`
  )
VALUES (
    'example@example.example',
    'pwned',
    'DAYIOGLU',
    'GURGUN',
    'MONTPELLIER',
    'Université de Montpellier'
  );