-- phpMyAdmin SQL Dump
-- version 4.9.1deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  Dim 26 avr. 2020 à 19:11
-- Version du serveur :  10.3.22-MariaDB-1:10.3.22+maria~bionic-log
-- Version de PHP :  7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `p1920022`
--

-- --------------------------------------------------------

--
-- Structure de la table `Categorie`
--

CREATE TABLE `Categorie` (
  `catId` int(11) NOT NULL,
  `nomCat` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Categorie`
--

INSERT INTO `Categorie` (`catId`, `nomCat`) VALUES
(0, 'Animaux'),
(1, 'Voyage'),
(2, 'Cuisine');

-- --------------------------------------------------------

--
-- Structure de la table `Photo`
--

CREATE TABLE `Photo` (
  `photoId` int(11) NOT NULL,
  `nomFich` varchar(250) CHARACTER SET utf8 NOT NULL,
  `Description` varchar(250) CHARACTER SET utf8 NOT NULL,
  `catId` int(11) NOT NULL,
  `auteur` varchar(25) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Photo`
--

INSERT INTO `Photo` (`photoId`, `nomFich`, `Description`, `catId`, `auteur`) VALUES
(1, 'bali.jpg', 'Bali est une île indonésienne célèbre pour ses montagnes volcaniques boisées', 1, 'p1908800'),
(2, 'chien.jpg', 'Le Chien est la sous-espèce domestique de Canis lupus, un mammifère de la famille des Canidés.', 0, 'p1920022'),
(3, 'chat.jpg', 'Le Chat domestique est la sous-espèce issue de la domestication du Chat sauvage, mammifère carnivore de la famille des Félidés.', 0, 'p1908800'),
(4, 'crocodile.jpeg', 'Les Crocodiles constituent une sous-famille de crocodiliens de la famille des crocodilidés.', 0, 'p1920022'),
(5, 'budapest.jpg', 'Capitale de la Hongrie, Budapest est coupée en deux par le Danube.', 1, 'p1908800'),
(6, 'burger.jpg', 'Un hamburger est un sandwich d\'origine allemande, composé de deux pains de forme ronde généralement garnis de steak haché et de crudités, salade, tomate, oignon, cornichon, et de sauce…', 2, 'p1920022'),
(7, 'carthagene.jpg', 'Carthagène des Indes est une ville portuaire située sur la côte caribéenne de la Colombie.', 1, 'p1908800'),
(8, 'croqueMonsieur.jpg', 'Un croque-monsieur est un sandwich chaud, originaire de France, à base de pain de mie, de jambon blanc et de fromage, grillé à la poêle, au four ou dans un appareil spécialisé.', 2, 'p1920022'),
(9, 'elephant.jpg', 'Les éléphants sont des mammifères proboscidiens de la famille des Éléphantidés. Ils correspondent aujourd\'hui à trois espèces réparties en deux genres distincts.', 0, 'p1908800'),
(10, 'harbourIsland.jpg', 'Harbour Island est une île des Bahamas située au nord de l\'île d\'Eleuthera. L\'île est de taille assez réduite, puisqu\'elle mesure à peu près 5 km de long pour une largeur d\'environ 800 m.', 1, 'p1920022'),
(11, 'irlande.jpg', 'La République d\'Irlande occupe la majeure partie de l\'île au large des côtes de l\'Angleterre et du Pays de Galles. Sa capitale, Dublin, est la ville natale d\'écrivains comme Oscar Wilde, et de la Guinness.', 1, 'p1908800'),
(12, 'lasagne.jpg', 'Les lasagnes sont des pâtes alimentaires en forme de larges plaques. Il s\'agit également de la préparation utilisant ces mêmes pâtes et généralement faite de couches alternées de pâtes, de fromage et d\'une sauce tomate avec de la viande.', 2, 'p1920022'),
(13, 'macarons.jpg', 'Le macaron est un petit gâteau à l\'amande, granuleux et moelleux, à la forme arrondie, d\'environ 3 à 5 cm de diamètre, dérivé de la meringue. Il est fabriqué à partir d\'amandes concassées, de sucre glace, de sucre et de blancs d\'œufs.', 2, 'p1908800'),
(14, 'manchot.jpg', 'Les Sphénisciformes sont un ordre d\'oiseaux de mer inaptes au vol vivant dans l\'hémisphère austral et dont les membres sont appelés manchots. Les manchots à aigrettes sont également nommés gorfous.', 0, 'p1920022'),
(15, 'paris.jpg', 'Paris, capitale de la France, est une grande ville européenne et un centre mondial de l\'art, de la mode, de la gastronomie et de la culture. Son paysage urbain du XIXe siècle est traversé par de larges boulevards et la Seine.', 1, 'p1908800'),
(16, 'patagonie.jpg', 'La Patagonie est une région englobant la pointe méridionale de l\'Amérique du Sud et séparée entre l\'Argentine et le Chili par la cordillère des Andes.', 1, 'p1920022'),
(17, 'perroquet.jpg', 'Le terme perroquet est un terme du vocabulaire courant qui désigne plusieurs espèces d\'oiseaux psittaciformes ayant généralement un gros bec crochu, une taille importante et des couleurs vives.', 0, 'p1908800'),
(18, 'phillipines.jpeg', 'Les Philippines sont un pays d\'Asie du Sud-Est, à l\'ouest du Pacifique, comptant plus de 7 000 îles. Manille, sa capitale, est célèbre pour ses promenades au bord de l\'océan et son quartier chinois datant de plusieurs siècles, Binondo.', 1, 'p1920022'),
(19, 'pizza.jpg', 'La pizza est une recette de cuisine traditionnelle de la cuisine italienne, originaire de Naples en Italie à base de galette de pâte à pain, garnie de divers mélanges d’ingrédients', 2, 'p1908800'),
(20, 'pouletBasquaise.jpg', 'Le poulet basquaise ou poulet à la basquaise est une spécialité culinaire de cuisine traditionnelle emblématique de la cuisine basque, étendue avec le temps à la cuisine française, à base de morceaux de poulet mijotés dans une piperade.', 2, 'p1920022'),
(21, 'raieManta.jpg', 'La raie manta, diable de mer ou raie manta géante est une espèce de poissons de la famille des Mobulidae. C\'est la plus grande des raies, elle peut atteindre jusqu\'à sept mètres d\'envergure et deux tonnes.', 0, 'p1908800'),
(22, 'renard.jpg', 'Renard est un terme ambigu qui désigne le plus souvent en français les canidés du genre Vulpes, le plus commun étant le Renard roux.', 0, 'p1920022'),
(23, 'russie.jpg', 'La Russie, la plus grande nation au monde, est frontalière de pays européens et asiatiques, ainsi que des océans Pacifique et Arctique. Ses paysages varient de la toundra aux plages subtropicales en passant par la forêt.', 1, 'testUser'),
(24, 'saladeLyonnaise.jpg', 'La salade lyonnaise est une recette de cuisine de salade composée traditionnelle de la cuisine lyonnaise à Lyon, variante de la salade de pissenlit.', 2, 'testUser'),
(25, 'suricate.jpg', 'Le suricate, parfois surnommé « sentinelle du désert », est une espèce de mammifères diurnes de la famille des Herpestidae et la seule du genre Suricata. Ce petit carnivore vit dans le sud-ouest de l\'Afrique.', 0, 'testUser'),
(26, 'sushis.jpg', 'Le sushi est un plat traditionnel japonais, composé d\'un riz vinaigré appelé shari combiné avec un autre ingrédient appelé neta qui est habituellement du poisson cru ou des fruits de mer.', 2, 'p1908800'),
(27, 'tacos.jpg', 'Un taco est un plat de la cuisine mexicaine qui se compose d\'une tortilla de maïs repliée ou enroulée sur elle-même contenant presque toujours une garniture le plus souvent à base de viande, de sauce, d\'oignon et de coriandre fraiche hachée.', 2, 'p1920022'),
(28, 'tartiflette.jpg', 'La tartiflette est une recette de cuisine inspirée de recettes traditionnelles de cuisine savoyarde, de gratin de pommes de terre, oignons, lardons, le tout gratiné au reblochon.', 2, 'p1908800'),
(29, 'tigre.jpg', 'Le Tigre est une espèce de mammifère carnivore de la famille des félidés du genre Panthera. Aisément reconnaissable à sa fourrure rousse rayée de noir, il est le plus grand félin sauvage et l\'un des plus grands carnivores terrestres.', 0, 'p1920022'),
(30, 'vatican.jpg', 'Le Vatican, ville-État située au cœur de Rome (Italie), est le siège de l\'Église catholique romaine et la résidence du pape. Il abrite de nombreuses œuvres d\'art et d\'architecture emblématiques.', 1, 'testUser');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `login` varchar(25) CHARACTER SET utf8 NOT NULL,
  `mdp` varchar(40) CHARACTER SET utf8 NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`login`, `mdp`, `admin`) VALUES
('p1908800', '55249c', 1),
('p1920022', '0beb2b', 1),
('testUser', 'mdp123', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Categorie`
--
ALTER TABLE `Categorie`
  ADD PRIMARY KEY (`catId`);

--
-- Index pour la table `Photo`
--
ALTER TABLE `Photo`
  ADD PRIMARY KEY (`photoId`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Categorie`
--
ALTER TABLE `Categorie`
  MODIFY `catId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `Photo`
--
ALTER TABLE `Photo`
  MODIFY `photoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
