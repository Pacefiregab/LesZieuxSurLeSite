# LesZieuxSurLeSite

## Ressources Dev

[Figma](https://www.figma.com/file/IeNhL3uRymq7BhU46ioI6x/LesZieuxSurLeSite?type=design&node-id=4%3A53&mode=design&t=eFrSl7poUwrLj7Hz-1)
[Trello](https://trello.com/b/NIHLeh30/lesyeuxdusite)
[Github](https://github.com/Pacefiregab/LesZieuxSurLeSite)

## Eye Tracker install

- 1 - Installer le logiciel [Tobii Eye Tracking Core Software](https://files.update.tech.tobii.com/Tobii_Eye_Tracking_Core_v2.13.1.7294_x86.exe)
- 2 - Telecharger le [Serveur](https://github.com/rezreal/Tobii-EyeX-Web-Socket-Server/releases/tag/v1.0.1)
- 3 - Lancer le serveur

## Commandes a run a chaque update du docker (en attendant une maj du dockerfile)

```bash
composer install
php bin/console d:s:u
```
