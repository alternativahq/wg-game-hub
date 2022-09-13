#!/bin/sh
cd /data/apps/game-hub || exit
sudo docker compose down
git stash
git pull
sudo docker compose up -d
