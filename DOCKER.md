# 🐳 Docker Setup for Sekolah App

Panduan lengkap untuk menjalankan Sekolah App menggunakan Docker di environment lokal atau production.

## Prerequisites

- Docker (v20.10+)
- Docker Compose (v2.0+)
- Git

## Quick Start

### 1. Clone Repository
```bash
cd ~/sekolah-app
git checkout feature/sekolah-app
```

### 2. Setup Environment
```bash
# Copy environment file
cp .env.docker .env

# Generate app key
docker run --rm -v $(pwd):/app php:8.3-cli php artisan key:generate --show
# Update APP_KEY in .env dengan output di atas
```

### 3. Run Setup Script
```bash
chmod +x docker-setup.sh
./docker-setup.sh
```

Atau manual:
```bash
docker-compose build
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan storage:link
```

### 4. Access Application
- **Web**: http://localhost
- **Email**: admin@sekolah.test
- **Password**: password

---

## Services

### 1. **PHP-FPM (App Container)**
- Image: `php:8.3-fpm-alpine`
- Port: 9000 (internal)
- Runs Laravel application

### 2. **Nginx**
- Image: `nginx:alpine`
- Port: 80 (HTTP), 443 (HTTPS - setup sendiri)
- Reverse proxy & static file serving

### 3. **MySQL 8.0**
- Image: `mysql:8.0`
- Port: 3306
- Database: `sekolah_db`
- User: `sekolah_user`
- Password: `sekolah_password`

### 4. **Redis**
- Image: `redis:7-alpine`
- Port: 6379
- Used for cache & sessions
- Password: `redis_password`

---

## Common Commands

### Container Management
```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f app

# Access app container
docker-compose exec app bash

# Access MySQL
docker-compose exec mysql mysql -u sekolah_user -psekolah_password sekolah_db
```

### Laravel Commands
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Clear cache
docker-compose exec app php artisan cache:clear

# View logs
docker-compose exec app tail -f storage/logs/laravel.log

# Tinker (Laravel REPL)
docker-compose exec app php artisan tinker
```

### Database
```bash
# Backup database
docker-compose exec mysql mysqldump -u sekolah_user -psekolah_password sekolah_db > backup.sql

# Restore database
docker-compose exec -T mysql mysql -u sekolah_user -psekolah_password sekolah_db < backup.sql
```

---

## Production Deployment

### Environment Variables (.env)
```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_GENERATED_KEY

# Database
DB_HOST=mysql  # atau hostname/IP actual MySQL server
DB_PASSWORD=STRONG_PASSWORD_HERE

# Redis
REDIS_PASSWORD=STRONG_PASSWORD_HERE

# SSL Certificate (jika menggunakan HTTPS)
NGINX_SSL_CERT=/etc/nginx/ssl/cert.pem
NGINX_SSL_KEY=/etc/nginx/ssl/key.pem
```

### SSL Setup (Optional)
```bash
# Generate self-signed certificate (development)
mkdir -p docker/nginx/ssl
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout docker/nginx/ssl/key.pem \
  -out docker/nginx/ssl/cert.pem

# Update nginx config untuk enable HTTPS
# Edit docker/nginx/conf.d/app.conf
```

### Scale with Docker Swarm or Kubernetes
```bash
# Initialize swarm
docker swarm init

# Deploy stack
docker stack deploy -c docker-compose.yml sekolah_app

# View services
docker service ls
```

---

## Troubleshooting

### Container tidak start
```bash
# Check logs
docker-compose logs app

# Rebuild
docker-compose build --no-cache
docker-compose up -d
```

### Database connection error
```bash
# Wait untuk MySQL siap
docker-compose exec app php artisan migrate --force

# Check MySQL status
docker-compose exec mysql mysqladmin ping -u sekolah_user -psekolah_password
```

### Permission issues
```bash
# Fix permissions
docker-compose exec app chown -R www-data:www-data /app/storage
docker-compose exec app chmod -R 775 /app/storage
```

### Memory issues
Edit `docker-compose.yml` dan tambahkan:
```yaml
services:
  app:
    deploy:
      resources:
        limits:
          memory: 512M
```

---

## Performance Optimization

### 1. Cache Configuration
```bash
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 2. Enable OPCache
```dockerfile
# Add to Dockerfile setelah install PHP extensions
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini
```

### 3. Database Indexes
Ensure semua frequently-queried fields memiliki index:
```bash
docker-compose exec mysql mysql -u sekolah_user -psekolah_password sekolah_db
mysql> SHOW INDEXES FROM siswas;
```

---

## Backup & Restore

### Backup Everything
```bash
#!/bin/bash
BACKUP_DIR="./backups"
mkdir -p $BACKUP_DIR
DATE=$(date +%Y%m%d_%H%M%S)

# Database backup
docker-compose exec -T mysql mysqldump -u sekolah_user -psekolah_password sekolah_db \
  > $BACKUP_DIR/sekolah_db_$DATE.sql

# Volume backup
docker run --rm -v sekolah-app_sekolah_mysql_data:/data -v $(pwd)/$BACKUP_DIR:/backup \
  alpine tar czf /backup/mysql_data_$DATE.tar.gz -C /data .

echo "✅ Backup complete: $BACKUP_DIR"
```

---

## Security Best Practices

1. **Change default passwords** di `.env`
2. **Use strong APP_KEY** - generate dengan `php artisan key:generate`
3. **Enable HTTPS** dengan valid SSL certificate
4. **Limit exposed ports** - hanya expose 80/443
5. **Regular updates** - update base images regularly
6. **Monitor logs** - review Docker logs secara berkala
7. **Set resource limits** - prevent runaway containers

---

## Support & Issues

Untuk issues atau questions:
1. Check Docker logs: `docker-compose logs`
2. Check Laravel logs: `docker-compose exec app tail -f storage/logs/laravel.log`
3. Review `.env` configuration
4. Verify all services running: `docker-compose ps`

---

**Last Updated**: 2026-07-06

Selamat hosting! 🚀
