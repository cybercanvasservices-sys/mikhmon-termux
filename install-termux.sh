#!/data/data/com.termux/files/usr/bin/bash
set -e
pkg update -y
pkg install -y php
if [ ! -f include/config.php ] && [ -f include/config.example.php ]; then
  cp include/config.example.php include/config.php
fi
echo "Mikhmon est installé. Ouvrez http://127.0.0.1:8080"
php -S 0.0.0.0:8080
