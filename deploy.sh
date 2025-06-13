#!/bin/bash

set -e

echo "🚀 Mulai proses deploy Laravel di Docker..."

# Step 0: Copy env
if [ -f laravel.env ]; then
  cp laravel.env .env
  echo "✅ File .env disiapkan dari laravel.env"
else
  echo "❌ File laravel.env tidak ditemukan!"
  exit 1
fi

# Step 1: Build semua image (app, nginx, db)
echo "🔧 Build semua image Docker..."
docker-compose build

# Step 2: Jalankan container secara detached
echo "📦 Menjalankan container..."
docker-compose up -d

# Step 3: Tunggu db ready
echo "⏳ Menunggu database MySQL siap..."
until docker exec mysql-db mysqladmin ping -h "127.0.0.1" --silent; do
  printf "."
  sleep 2
done
echo "✅ Database siap!"

# Step 4: Jalankan migrasi & seeding Laravel di container app
echo "🛠️ Setup Laravel..."

docker exec laravel-app composer install --optimize-autoloader --no-dev

docker exec laravel-app php artisan key:generate

docker exec laravel-app php artisan storage:link

docker exec laravel-app php artisan migrate --force

docker exec laravel-app php artisan db:seed --force

docker exec laravel-app php artisan config:clear

docker exec laravel-app php artisan config:cache

docker exec laravel-app php artisan route:cache

echo "✅ Deploy selesai! Laravel siap diakses melalui nginx pada port 80 🚀"
