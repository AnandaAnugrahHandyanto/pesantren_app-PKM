#!/bin/bash

# Sekolah App Management Script
# Usage: ./sekolah.sh [start|stop|restart|status|url]

APP_DIR="$HOME/sekolah-app"
LOG_FILE="$APP_DIR/storage/logs/server.log"

start() {
    # Check if already running
    if pgrep -f "php artisan serve.*8000" > /dev/null; then
        echo "✅ Sekolah App sudah running!"
        return 0
    fi

    # Ensure MySQL is running
    if ! pgrep -x mysqld > /dev/null; then
        echo "📦 Starting MySQL..."
        sudo systemctl start mariadb 2>/dev/null || sudo systemctl start mysql 2>/dev/null || sudo mysqld_safe &
        sleep 2
    fi

    # Remove hot file if exists (prevents Vite dev mode)
    rm -f "$APP_DIR/public/hot"

    # Clear caches
    cd "$APP_DIR"
    php artisan config:clear > /dev/null 2>&1
    php artisan cache:clear > /dev/null 2>&1
    php artisan view:clear > /dev/null 2>&1
    rm -rf storage/framework/cache/* storage/framework/views/* bootstrap/cache/*

    # Start server
    nohup php artisan serve --host=0.0.0.0 --port=8000 > "$LOG_FILE" 2>&1 &
    sleep 2

    echo "✅ Sekolah App started!"
    echo "🌐 Local:  http://127.0.0.1:8000"
    echo "🌐 Network: http://$(ip -4 addr show scope global | grep -oP 'inet \K[0-9.]+' | head -1):8000"
}

stop() {
    pkill -f "php artisan serve.*8000" 2>/dev/null
    echo "⛔ Sekolah App stopped."
}

status() {
    if pgrep -f "php artisan serve.*8000" > /dev/null; then
        echo "✅ Running"
        echo "   PID: $(pgrep -f 'php artisan serve.*8000' | head -1)"
    else
        echo "⛔ Not running"
    fi
}

url() {
    echo "🌐 Local:   http://127.0.0.1:8000"
    echo "🌐 Network: http://$(ip -4 addr show scope global | grep -oP 'inet \K[0-9.]+' | head -1):8000"
}

case "${1:-start}" in
    start)   start ;;
    stop)    stop ;;
    restart) stop; sleep 1; start ;;
    status)  status ;;
    url)     url ;;
    *)
        echo "Usage: ./sekolah.sh [start|stop|restart|status|url]"
        echo ""
        echo "Commands:"
        echo "  start    Start app & database (default)"
        echo "  stop     Stop app"
        echo "  restart  Restart app"
        echo "  status   Check if running"
        echo "  url      Show access URLs"
        ;;
esac
