# Mikhmon Termux

Version compatible avec RouterOS 6 et RouterOS 7.

Fonctions ajoutées : gestion des comptes/profils PPPoE, connexions PPPoE actives,
connexion distante via une adresse WireGuard et import local d’un fichier WireGuard `.conf`.

Le tunnel WireGuard doit être activé séparément dans l’application WireGuard Android
ou dans Termux. Le fichier `.conf` contient une clé privée : il ne faut jamais le publier
sur GitHub.

## Installation Termux

```bash
pkg update
pkg install git
git clone https://github.com/cybercanvasservices-sys/mikhmon-termux.git
cd mikhmon-termux
bash install-termux.sh
```

Puis ouvrez `http://127.0.0.1:8080` dans le navigateur du téléphone.

Après l’installation, le serveur démarre automatiquement à chaque ouverture de Termux
et l’adresse locale s’ouvre dans le navigateur Android.

Le fichier de configuration contenant les routeurs et mots de passe n'est pas inclus dans ce dépôt. Une configuration vierge est créée automatiquement à partir de `include/config.example.php`.
