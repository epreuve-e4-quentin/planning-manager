# Planning manager épreuve E4 - BTS SIO
Planning manager, school project. Application intranet sécurisé pour pouvoir gérer le personnel et leurs plannings associés via une interface simplifié.

# Installation / Utilisation 

1) Téléchargez la  [dernière version](https://github.com/epreuve-e4-quentin/planning-manager/releases/latest) testé du projet , et glissez les fichiers du dossier dans la racine du serveur apache (où le php est actif). Exemple de racine de serveur apache : 'htdocs' ou 'www'.
    
2) Pour finir, importez la base de données (MySQL) : 
[databases.sql](https://raw.githubusercontent.com/epreuve-e4-quentin/planning-manager/main/private/database/database.sql)
_(N'oubliez pas de configurer les identifiants de connexion à la base de données par [ici](https://github.com/epreuve-e4-quentin/planning-manager/blob/main/.env#L31))_

3) Vous pouvez supprimer les dossiers/fichiers, innutiles pour le fonctionnement du site : 
    - ".gitattributes"
    - "gitignore"
    - ".github"
4) VOUS POUVEZ MAINTENANT COMMENCER A NAVIGUER SUR LE SITE!
    
# A savoir
- Il est important que les fichiers/dossier du site se trouvent à la racine de votre serveur (Ex: https://localhost/) pour le bon fonctionnement des ressources (scripts, styles...) et non pas dans un sous dossier de votre serveur (Ex: https://localhost/mon_dossier_perso)

- Identifiants de connexion (/login)
  -  Utilisateur : Quentin
  -  Mot de passe : admin
