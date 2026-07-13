#!/bin/bash

# Sekolah App Management Script
# Usage: ./sekolah.sh [start|stop|restart|status|url|tunnel]

APP_DIR="$HOME/sekolah-app"
LOG_FILE="$APP_DIR/storage/logs/server.log"

start() {
    if pgrep -f "php artisan serve.*8000" > /dev/null; then
        echo "✅ Sekolah App sudah running!"
        url
        return 0
    fi

    echo "📦 Starting aplikasi..."

    # Ensure MySQL is running
    if ! pgrep -x mysqld > /dev/null; then
        echo "📦 Starting MySQL..."
        sudo systemctl start mariadb 2>/dev/null || sudo systemctl start mysql 2>/dev/null || sudo mysqld_safe &
        sleep 2
    fi

    cd "$APP_DIR"

    # Remove hot file (prevents Vite dev mode)
    rm -f "$APP_DIR/public/hot"

    # Cache optimization
    php artisan config:cache > /dev/null 2>&1
    php artisan route:cache > /dev/null 2>&1
    php artisan view:cache > /dev/null 2>&1

    # Start server
    nohup php artisan serve --host=0.0.0.0 --port=8000 > "$LOG_FILE" 2>&1 &
    sleep 2

    echo "✅ Sekolah App started!"
    echo ""
    url
}

stop() {
    pkill -f "php artisan serve.*8000" 2>/dev/null
    pkill -f "serveo.net" 2>/dev/null
    echo "⛔ Sekolah App stopped."
}

restart() {
    stop
    sleep 1
    start
}

status() {
    if pgrep -f "php artisan serve.*8000" > /dev/null; then
        echo "✅ Server: RUNNING"
        echo "   PID: $(pgrep -f 'php artisan serve.*8000' | head -1)"
        echo "   Port: 8000"
        if pgrep -f "serveo.net" > /dev/null; then
            echo "🔗 Tunnel: ACTIVE"
        else
            echo "🔗 Tunnel: NOT RUNNING (./sekolah.sh tunnel)"
        fi
    else
        echo "⛔ Server: NOT RUNNING"
        echo "   Jalankan: ./sekolah.sh start"
    fi
}

url() {
    IP=$(ip -4 addr show scope global 2>/dev/null | grep -oP 'inet \K[0-9.]+' | head -1)
    echo "🌐 Local:   http://127.0.0.1:8000"
    echo "🌐 Network: http://$IP:8000"
    if pgrep -f "serveo.net" > /dev/null; then
        TUNNEL_URL=$(ps aux | grep serveo | grep -oP 'https://[a-z0-9.-]+\.serveousercontent\.com' | head -1)
        echo "🌍 Public:  $TUNNEL_URL (via Serveo)"
    fi
}

tunnel() {
    if pgrep -f "serveo.net" > /dev/null; then
        echo "🔗 Tunnel sudah running!"
        url
        return 0
    fi

    echo "🔗 Starting public tunnel (Serveo)..."
    nohup ssh -o StrictHostKeyChecking=no -R 80:localhost:8000 serveo.net > "$APP_DIR/tunnel.log" 2>&1 &
    sleep 5

    TUNNEL_URL=$(grep -oP 'https://[a-z0-9.-]+\.serveousercontent\.com' "$APP_DIR/tunnel.log" | head -1)
    if [ -n "$TUNNEL_URL" ]; then
        echo "✅ Tunnel aktif!"
        echo "🌍 Public URL: $TUNNEL_URL"
        echo ""
        echo "📝 Share ke teman:"
        echo "   URL: $TUNNEL_URL"
        echo "   Email: admin@sekolah.test"
        echo "   Password: password"
    else
        echo "⏳ Tunnel starting... cek nanti:"
        echo "   cat $APP_DIR/tunnel.log"
    fi
}

case "${1:-start}" in
    start)   start ;;
    stop)    stop ;;
    restart) restart ;;
    status)  status ;;
    url)     url ;;
    tunnel)  tunnel ;;
    *)
        echo "🚀 Sekolah App Manager"
        echo ""
        echo "Usage: ./sekolah.sh [command]"
        echo ""
        echo "Commands:"
        echo "  start    Start app + database (default)"
        echo "  stop     Stop app + tunnel"
        echo "  restart  Restart app"
        echo "  status   Cek status server & tunnel"
        echo "  url      Tampilkan URL akses"
        echo "  tunnel   Start public tunnel (Serveo)"
        echo ""
        echo "Quick start tiap boot:"
        echo "  ./sekolah.sh start   # Jalankan app"
        echo "  ./sekolah.sh tunnel  # Share ke teman"
        ;;
esac
