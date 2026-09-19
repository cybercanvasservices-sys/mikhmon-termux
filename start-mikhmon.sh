#!/data/data/com.termux/files/usr/bin/bash
set -e

APP_DIR="$HOME/mikhmon-termux"
LOG_FILE="$HOME/.mikhmon.log"

if [ ! -d "$APP_DIR" ]; then
  exit 0
fi

if pgrep -f "php -S 127.0.0.1:8080" >/dev/null 2>&1; then
  exit 0
fi

cd "$APP_DIR"
nohup php -S 127.0.0.1:8080 >"$LOG_FILE" 2>&1 &
sleep 1

if command -v termux-open-url >/dev/null 2>&1; then
  termux-open-url "http://127.0.0.1:8080" >/dev/null 2>&1 &
fi
