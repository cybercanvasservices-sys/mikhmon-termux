#!/data/data/com.termux/files/usr/bin/bash
set -e
pkg update -y
pkg install -y php termux-tools procps
if [ ! -f include/config.php ] && [ -f include/config.example.php ]; then
  cp include/config.example.php include/config.php
fi

cp start-mikhmon.sh "$HOME/.start-mikhmon.sh"
chmod 700 "$HOME/.start-mikhmon.sh"

if ! grep -q 'start-mikhmon.sh' "$HOME/.bashrc" 2>/dev/null; then
  printf '\n# Démarrage automatique de Mikhmon\n[ -x "$HOME/.start-mikhmon.sh" ] && "$HOME/.start-mikhmon.sh"\n' >> "$HOME/.bashrc"
fi

echo "Mikhmon est installé. Il démarrera automatiquement à l'ouverture de Termux."
"$HOME/.start-mikhmon.sh"
