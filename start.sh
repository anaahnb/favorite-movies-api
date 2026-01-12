#!/bin/bash

set -e

RESET_DB=false

if [[ "$1" == "--reset" ]]; then
  RESET_DB=true
fi

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
  echo "Arquivo .env criado"
fi

echo "Subindo containers..."
docker-compose up -d --build

echo "Instalando dependências..."
docker-compose exec app composer install

# Gera a APP_KEY apenas se não existir
if ! docker-compose exec app php artisan key:generate --show &> /dev/null; then
  echo "Gerando APP_KEY..."
  docker-compose exec app php artisan key:generate --force
fi

if [ "$RESET_DB" = true ]; then
  echo "Resetando banco de dados..."
  docker-compose exec app php artisan migrate:fresh --seed --force
else
  echo "Rodando migrations..."
  docker-compose exec app php artisan migrate --force
fi

echo "Ajustando permissões..."
docker-compose exec app chmod -R 775 storage bootstrap/cache

echo ""
echo "Concluído!"
echo "Acesse: http://localhost:8000"
echo ""

if [ "$RESET_DB" = true ]; then
  echo "Banco de dados foi resetado e populado com seeds."
fi
