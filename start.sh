#!/bin/bash

set -e

echo "Iniciando setup"

if ! command -v docker &> /dev/null; then
  echo "Docker não está instalado"
  exit 1
fi

if ! command -v docker-compose &> /dev/null; then
  echo "Docker Compose não está instalado"
  exit 1
fi

if [ ! -f .env ]; then
  cp .env.example .env
fi
echo "Arquivo .env criado"

echo "Subindo containers..."
docker-compose up -d --build

echo "Instalando dependências..."
docker-compose exec app composer install

echo "Gerando APP_KEY..."
docker-compose exec app php artisan key:generate --force

echo "Rodando migrations..."
docker-compose exec app php artisan migrate --force

echo "Ajustando permissões..."
docker-compose exec app chmod -R 775 storage bootstrap/cache

echo ""
echo "Concluído!"
echo "Acesse: http://localhost:8000"
echo ""
