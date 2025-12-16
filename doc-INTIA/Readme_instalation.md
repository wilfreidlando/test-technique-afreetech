# Procédure d'installation

Ce projet est déployé avec Docker.

Pour installer et lancer le projet, il suffit d'exécuter la commande suivante dans chacun des dossiers `intia_frontend` et `intia_backend` :

```bash
docker compose up --bluid -d
```
pour lancer le front sans docker utiliser 

```bash
npm start
```
pour le backend
```bash
php artisan serve

php artisan migrate --seed
```

Assurez-vous d'avoir Docker et Docker Compose installés sur votre machine.
