# Mikhmon Termux

Version compatible avec RouterOS 6 et RouterOS 7.

## Installation Termux

```bash
pkg update
pkg install git
git clone https://github.com/cybercanvasservices-sys/mikhmon-termux.git
cd mikhmon-termux
bash install-termux.sh
```

Puis ouvrez `http://127.0.0.1:8080` dans le navigateur du téléphone.

Le fichier de configuration contenant les routeurs et mots de passe n'est pas inclus dans ce dépôt. Une configuration vierge est créée automatiquement à partir de `include/config.example.php`.
