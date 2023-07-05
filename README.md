# LesZieuxSurLeSite

## Ressources Dev
[Figma](https://www.figma.com/file/IeNhL3uRymq7BhU46ioI6x/LesZieuxSurLeSite?type=design&node-id=4%3A53&mode=design&t=eFrSl7poUwrLj7Hz-1)
[Trello](https://trello.com/b/NIHLeh30/lesyeuxdusite)
[Github](https://github.com/Pacefiregab/LesZieuxSurLeSite)

## Installation du projet
1. Si ce n'est pas déjà fait, [installez Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Exécutez `docker compose build --pull --no-cache` pour créer les images
3. Exécutez `docker compose up
4. Ouvrez `https://localhost` dans votre navigateur Web préféré et [acceptez le certificat TLS généré automatiquement](https://stackoverflow.com/a/15076602/1352334)
5. Entrez dans le container php : `docker exec -it lesZieuxSurLeSite-php bash`
6. Exécutez Doctrine Shema Update : `php bin/console d:s:u`
7. Peupler la base de données : `php bin/console doctrine:fixtures:load`

Pour arrerter le docker éxécutez : `docker compose down --remove-orphans`

## Eye Tracker installation
1. Installer le logiciel [Tobii Eye Tracking Core Software](https://files.update.tech.tobii.com/Tobii_Eye_Tracking_Core_v2.13.1.7294_x86.exe)
2. Telecharger le [Serveur](https://github.com/rezreal/Tobii-EyeX-Web-Socket-Server/releases/tag/v1.0.1)
3. Lancer le serveur

### Credits

- Eye tracker websocket server : [rezreal](https://github.com/rezreal/Tobii-EyeX-Web-Socket-Server) 
- Symfony Docker : [Kévin Dunglas](https://dunglas.fr), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
