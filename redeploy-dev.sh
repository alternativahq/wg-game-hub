#!/bin/sh
cd /data/apps/game-hub || exit
sudo docker compose down
git stash
git pull
sudo docker compose up -d
sudo docker compose run --rm composer install
sudo docker compose run --rm npm install
npm run prod
sudo docker compose run --rm artisan wodo:gamehub-demo-seed
