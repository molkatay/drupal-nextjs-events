# Events app using Drupal 10, Next JS, TailwindCss


## Initialisation du projet

Première installation



#### Installer Docker Desktop:
[Docker desktop](https://desktop.docker.com/win/stable/Docker%20Desktop%20Installer.exe) soit installé.

## Environnement de développement
- Lancer Ubuntu 20.04
Pour la premiere fois Ubuntu demande

- ```cd /home/username/```

- ```mkdir projects```

- ```cd projects```

### Initialisation projet
`git clone git@10.1.1.70:root/DrupalDistribution.git
cd DrupalDistribution
docker-compose up -d --build
composer install`

### Modification de fichier hosts

C:\Windows\System32\drivers\etc

`127.0.0.1 drupaldistribution.test`
- Visiter:
`http://drupaldistribution.test:8000/`

## Synchronisation de fichiers dans Windows
- Install mutagen.io on Windows to sync the files on a Windows drive.
- Go to [the mutagen.io download page](https://github.com/mutagen-io/mutagen/releases/latest) and download the Windows x64 binary.

- Copiez le binaire dans un dossier tel que C:\Program Files\Mutagen et ajoutez ce dossier à votre variable PATH.
- Tapez Windows Key + Break, à partir de là, sélectionnez "Paramètres système avancés" → "Variables d'environnement".

- Démarrer un nouveau projet avec Mutagen est très simple:
- **Exemple:**
`mutagen project start`

Vous pouvez voir l'état / les erreurs de la progression de la synchronisation en exécutant dans un PowerShell distinct:
```mutagen sync list``` ou ```mutagen sync monitor```

- Administrateur
```admin/admin```

## Import Base de données
- `docker-compose exec php /bin/sh`

- `drush sql-cli < data/drupal.sql`

## Export Base de données
- `docker-compose exec php /bin/sh`

- `sudo drush sql-dump --result-file=/var/www/html/data/drupal.sql `
## NPm
- `docker-compose run --rm node /bin/bash`
- `cd web/themes/custom/web_ui`
- `npm install`
- `npm run watch`

# Best Practices

## Avant de push

- vérifier que vous êtes sur une branche autre que develop
- faire un ```drush cex``` pour exporter la configuration actuelle
- commiter les modifications
- pusher les modifications et faire une PR

## Avant de pull

- faire un checkout sur develop
- vérifier qu'il n'y a pas de fichiers non commités
- faire un pull de la branche develop

## Après le pull
- docker-compose exec php /bin/sh
- composer install
- drush updatedb
- drush cr
- drush cim
- drush cr


Premiere installation:
docker-compose exec php /bin/bash
composer install
 drush si --account-name=admin --account-mail=tayahi.molka@gmail.com --account-pass=admin --site-name="Drupal Distribution"

./vendor/bin/phpstan analyze web/modules/custom


 Solr copy config
 docker cp c:/solr_8.x_config.zip my_drupal9_decoupled_solr:/opt/solr/server/solr/distro_solr/conf
