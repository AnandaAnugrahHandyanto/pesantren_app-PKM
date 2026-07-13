# 🚀 Quick Start - Sekolah App Docker

## 1️⃣ Generate APP_KEY

```bash
docker run --rm php:8.3-cli php -r "require 'vendor/autoload.php'; echo 'base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

Copy hasilnya ke `.env` untuk `APP_KEY=`

## 2️⃣ Start Docker

```bash
./docker-setup.sh
```

Atau manual:
```bash
docker-compose build
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed
```

## 3️⃣ Access

- **URL**: http://localhost
- **Email**: admin@sekolah.test
- **Password**: password

## 4️⃣ Database Access

```bash
# From terminal
docker-compose exec mysql mysql -u sekolah_user -psekolah_password sekolah_db

# Or GUI client (TablePlus, Sequel Pro, etc)
# Host: localhost:3306
# User: sekolah_user
# Password: sekolah_password
# Database: sekolah_db
```

## 5️⃣ View Logs

```bash
# App logs
docker-compose logs -f app

# Nginx logs
docker-compose logs -f nginx

# MySQL logs
docker-compose logs -f mysql
```

## 6️⃣ Stop Everything

```bash
docker-compose down
```

---

## Troubleshooting

**Port 80 already in use?**
```bash
# Change port in docker-compose.yml
# ports:
#   - "8080:80"  # Change to any available port
```

**Database migration failed?**
```bash
docker-compose down -v  # Remove volumes
./docker-setup.sh       # Start fresh
```

**Permission denied?**
```bash
sudo chmod +x docker-setup.sh
sudo ./docker-setup.sh
```

---

Lihat `DOCKER.md` untuk dokumentasi lengkap.
