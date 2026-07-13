#!/bin/bash

set -e

echo "🐳 Setting up Sekolah App with Docker..."

# Build and start containers
echo "📦 Building Docker images..."
docker-compose build --no-cache

echo "🚀 Starting containers..."
docker-compose up -d

# Wait for services to be ready
echo "⏳ Waiting for services to be ready..."
sleep 10

# Run migrations
echo "🗄️ Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Seed database with admin user
echo "👤 Seeding database with admin user..."
docker-compose exec -T app php artisan db:seed

# Create storage symlink
echo "🔗 Creating storage symlink..."
docker-compose exec -T app php artisan storage:link

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec -T app chown -R www-data:www-data /app/storage
docker-compose exec -T app chmod -R 775 /app/storage
docker-compose exec -T app chmod -R 755 /app/bootstrap/cache

# Optimize application
echo "⚡ Optimizing application..."
docker-compose exec -T app php artisan config:cache
docker-compose exec -T app php artisan route:cache
docker-compose exec -T app php artisan view:cache

echo ""
echo "✅ Setup complete!"
echo ""
echo "🌐 Access application at: http://localhost"
echo ""
echo "📝 Login credentials:"
echo "   Email: admin@sekolah.test"
echo "   Password: password"
echo ""
echo "📊 Database access:"
echo "   Host: localhost:3306"
echo "   Database: sekolah_db"
echo "   User: sekolah_user"
echo "   Password: sekolah_password"
echo ""
echo "📋 Useful commands:"
echo "   docker-compose logs -f app        # View app logs"
echo "   docker-compose exec app bash      # Access app container"
echo "   docker-compose down               # Stop all containers"
echo ""
