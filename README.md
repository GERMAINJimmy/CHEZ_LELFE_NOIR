# chez_lelfe_noir
SELECT c.titre FROM `produit_categorie` pc INNER JOIN `categorie` c ON c.id = pc.categorie_id GROUP BY c.titre

reste a faire :

administrateur ne peut pas ce deco
modification du profil utilisateur
faire disparaitre la rubrique nouveauté et promotion si URL != de produit, et augmenter le nombre de produit afficher a 20
