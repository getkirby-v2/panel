<?php

return array(
  'title' => 'French',
  'author' => 'Philippe Gervaise <getkirby@malvese.org>',
  'version' => '1.0.0',
  'data' => array(

    // global
    'cancel' => 'Annuler',
    'add' => 'Ajouter',
    'save' => 'Enregistrer',
    'delete' => 'Supprimer',
    'ok' => 'Ok',

    // installation
    'installation.check.headline' => 'Installation de Kirby Panel',
    'installation.check.text' => 'Kirby a rencontré les problèmes suivants :',
    'installation.check.retry' => 'Réessayer',
    'installation.signup.headline' => 'Créer votre premier compte',
    'installation.signup.username' => 'Identifiant',
    'installation.signup.email' => 'Email',
    'installation.signup.email.placeholder' => 'mail@example.com',
    'installation.signup.password' => 'Mot de passe',
    'installation.signup.create' => 'Créer votre compte',
    'installation.signup.success' => 'Votre compte a été créé',

    // app
    'app.health.error' => 'Il y a quelques problèmes !',
    'app.health.error.accounts' => '<strong>site/accounts</strong> n\'est pas accessible en écriture',
    'app.health.error.avatars' => '<strong>/assets/avatars</strong> n\'est pas accessible en écriture',
    'app.health.error.blueprints' => 'Veuillez ajouter un répertoire <strong>site/blueprints</strong>',
    'app.health.error.content' => 'Le répertoire de contenu et tous ses fichiers doivent être accessibles en écriture.',
    'app.health.error.thumbs' => 'Le répertoire <strong>thumbs</strong> doit être accessible en écriture.',
    'app.health.success' => 'Tout est en ordre',

    // login
    'login.title' => 'Connexion',
    'login.username' => 'Identifiant',
    'login.password' => 'Mot de passe',
    'login.error' => 'Identifiant ou mot de passe invalide',
    'login.success' => 'Vous êtes maintenant connecté',
    'login.button' => 'Connexion',

    // site
    'site.title' => 'Site',
    'site.settings' => 'Paramètres du site',
    'site.publish' => 'Publier les modifications',
    'site.languages.error' => 'Ce site est monolingue',

    // subpages
    'subpages.title' => 'Sous-pages',
    'subpages.add' => 'Ajouter une nouvelle sous-page',
    'subpages.manage' => 'Gérer',
    'subpages.search.placeholder' => 'Rechercher une sous-page',
    'subpages.show' => 'Tout afficher',
    'subpages.empty' => 'Cette page n\'a aucune sous-page',

    // metatags
    'metatags.title' => 'Méta-tags',
    'metatags.edit' => 'Éditer les méta-tags',
    'metatags.cancel' => 'Aller au tableau de bord',

    // files
    'files.title' => 'Fichiers',
    'files.manage' => 'gérer',
    'files.upload' => 'Transférer un nouveau fichier',
    'files.empty' => 'Cette page n\'a aucun fichier',
    'files.show.error' => 'Le fichier n\'a pu être trouvé',
    'files.manager.headline' => 'Gérer les fichiers pour',
    'files.manager.back' => 'Retour à la page',
    'files.manager.upload' => 'Transférer un nouveau fichier',
    'files.manager.upload.first' => 'Transférer votre premier fichier',
    'files.manager.edit' => 'Éditer',
    'files.manager.delete' => 'Supprimer',
    'files.delete.headline' => 'Vouslez-vous vraiment supprimer ce fichier ?',
    'files.delete.error.missing' => 'Le fichier n\'a pu être trouvé',
    'files.delete.success' => 'Le fichier a été supprimé',
    'files.edit.filename' => 'Nom du fichier',
    'files.edit.replace' => 'Remplacer',
    'files.edit.delete' => 'Supprimer',
    'files.edit.typeAndSize' => 'Type / taille',
    'files.edit.link' => 'Lien public',
    'files.replace.headline' => 'Remplacer',
    'files.replace.drop' => 'Déposer un fichier ici…',
    'files.replace.click' => '… ou cliquer pour remplacer le fichier actuel',
    'files.replace.error.type' => 'Le fichier transféré doit être du même type',
    'files.replace.success' => 'Le fichier a été remplacé',
    'files.rename.error' => 'Le fichier n\'a pu être renommé',
    'files.rename.error.missing' => 'Le fichier n\'a pu être trouvé',
    'files.rename.success' => 'Le fichier a été renommé',
    'files.update.error.page' => 'La page n\'a pu être trouvée',
    'files.update.error.missing' => 'Le fichier n\'a pu être trouvé',
    'files.update.success' => 'Le fichier a été mis à jour',
    'files.upload.drop' => 'Déposer un fichier ici…',
    'files.upload.click' => '… ou cliquer pour en transférer un',
    'files.upload.success' => 'Le transfert de fichier a été effectué',

    // error page
    'errorpage.title' => 'Page d\'erreur',
    'errorpage.text'  => 'Ceci est la page d\'erreur de votre site. Vos visiteurs verront cette page lorsqu\'ils entreront une URL qui n\'est pas disponible.',

    // unwritable
    'unwritable.title' => 'Le fichier n\'est pas accessible en écriture',
    'unwritable.text'  => 'Veuillez vérifier les permissions du répertoire de contenu et de tous les fichiers.',

    // pages
    'pages.changeUrl' => 'Modifier l\'URL',
    'pages.settings' => 'Paramètres de la page',
    'pages.form.error.nocontent.headline' => 'Cette page ne comporte aucun contenu',
    'pages.form.error.nocontent.text' => 'Veuillez créer manuellement un fichier texte de contenu sur le serveur',
    'pages.show.error' => 'La page n\'a pu être trouvée',
    'pages.delete' => 'Supprimer la page',
    'pages.delete.headline' => 'Voulez-vous vraiment supprimer cette page ?',
    'pages.delete.error.missing' => 'La page n\'a pu être trouvée',
    'pages.delete.success' => 'La page a été supprimée',
    'pages.delete.url' => 'URL',
    'pages.template' => 'Modèle',
    'pages.add.headline' => 'Ajouter une nouvelle sous-page',
    'pages.add.title.placeholder' => 'Titre',
    'pages.add.url' => 'Segment d\'URL',
    'pages.add.url.enter' => '(Entrer votre titre)',
    'pages.add.url.close' => 'Fermer',
    'pages.add.url.help' => 'Format : a-z minuscule, 0-9 et trait d’union',
    'pages.add.template' => 'Modèle',
    'pages.add.template.select' => 'Sélectionner un modèle',
    'pages.add.error.title' => 'Le titre est manquant',
    'pages.add.error.template' => 'Ce modèle est manquant',
    'pages.add.success' => 'La page a été créée',
    'pages.update.error.missing' => 'La page n\'a pu être trouvée',
    'pages.update.success' => 'La page a été mise à jour',
    'pages.sort.success' => 'Les pages ont été ordonnées',
    'pages.hide.error.missing' => 'La page n\'a pu être trouvée',
    'pages.hide.success' => 'La page est maintenant invisible',
    'pages.templates.error.missing' => 'La page n\'a pu être trouvée',
    'pages.templates.error.nosubpages' => 'La page ne peut comporter de sous-pages',
    'pages.publish.headline' => 'Publication des modifications',
    'pages.publish.text' => 'Veuillez attendre quelques instants. Vos dernières modifications sont envoyées au serveur.',
    'pages.url.headline' => 'Segment d\'URL',
    'pages.url.createFromTitle' => 'Créer d\'après le titre',
    'pages.url.error.missing' => 'La page n\'a pu être trouvée',
    'pages.url.error.exists' => 'Une page avec un segment d\'URL existe déjà',
    'pages.url.error.move' => 'Le segment d\'URL n\'a pu être modifié',
    'pages.url.idle' => 'Le segment d\'URL n\'a pas été modifié',
    'pages.url.success' => 'Le segment d\'URL a été modifié',
    'pages.manager.headline' => 'Gérer les sous-pages pour',
    'pages.manager.back' => 'Retour à la page',
    'pages.manager.add' => 'Ajouter une nouvelle sous-page',
    'pages.manager.add.first' => 'Ajouter votre première sous-page',
    'pages.manager.visible' => 'Sous-pages visibles',
    'pages.manager.visible.help' => 'Glisser ici des pages depuis la droite pour les rendre visible et les ordonner.',
    'pages.manager.invisible' => 'Sous-pages invisibles',
    'pages.manager.invisible.help' => 'Glisser ici des pages depuis la gauche pour les rendre invisible.',

    // users
    'users.title' => 'Utilisateurs',
    'users.index.headline' => 'Gérer les utilisateurs',
    'users.index.add' => 'Ajouter un nouvel utilisateur',
    'users.index.edit' => 'modifier',
    'users.index.delete' => 'supprimer',
    'users.show.error.missing' => 'L\'utilisateur n\'a pu être trouvé',
    'users.add.username' => 'Identifiant',
    'users.add.username.placeholder' => 'Votre identifiant',
    'users.add.username.help' => 'Caractères autorisés : a-z minuscule, 0-9 et trait d’union',
    'users.add.email' => 'Email',
    'users.add.email.placeholder' => 'mail@example.com',
    'users.add.password' => 'Mot de passe',
    'users.add.language' => 'Langue',
    'users.edit.username' => 'Identifiant',
    'users.edit.email' => 'Email',
    'users.edit.email.placeholder' => 'mail@example.com',
    'users.edit.password' => 'Mot de passe',
    'users.edit.language' => 'Langue',
    'users.edit.error' => 'L\'utilisateur n\'a pu être mis à jour',
    'users.edit.error.missing' => 'L\'utilisateur n\'a pu être trouvé',
    'users.edit.success' => 'L\'utilisateur a été mis à jour',
    'users.delete.headline' => 'Voulez-vous vraiment supprimer cet utilisateur ?',
    'users.delete.error.missing' => 'L\'utilisateur n\'a pu être trouvé',
    'users.delete.success' => 'L\'utilisateur a été supprimé',
    'users.avatar.drop' => 'Glisser une image de profil ici…',
    'users.avatar.click' => '… ou cliquer pour en transférer une',
    'users.avatar.error.missing' => 'L\'utilisateur n\'a pu être trouvé',
    'users.avatar.error.type' => 'Vous ne pouvez transférer que des fichiers JPG, PNG et GIF',
    'users.avatar.error.folder.headline' => 'Le répertoire <strong>avatar</strong> n\'est pas accessible en écriture',
    'users.avatar.error.folder.text' => 'Veuillez créer le répertoire <strong>/assets/avatars</strong> et le rendre accessible en écriture pour transférer les images de profil.',
    'users.avatar.success' => 'L\'image de profil a été transférée',
    'users.avatar.delete.error' => 'L\'image de profil n\'a pu être supprimée',
    'users.avatar.delete.error.missing' => 'L\'utilisateur n\'a pu être trouvé',
    'users.avatar.delete.success' => 'L\'image de profil a été supprimée',

    // logout
    'logout' => 'Déconnexion'

  )
);
