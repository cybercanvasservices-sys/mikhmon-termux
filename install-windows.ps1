$ErrorActionPreference = 'Stop'
$RepoUrl = 'https://github.com/cybercanvasservices-sys/mikhmon-termux.git'
$BaseDir = Join-Path $env:USERPROFILE 'Mikhmon'
$AppDir = Join-Path $BaseDir 'mikhmon-termux'
$Desktop = [Environment]::GetFolderPath('Desktop')
$ShortcutPath = Join-Path $Desktop 'Mikhmon.lnk'

New-Item -ItemType Directory -Force -Path $BaseDir | Out-Null
if (Test-Path (Join-Path $AppDir '.git')) {
    git -C $AppDir pull
} else {
    git clone $RepoUrl $AppDir
}

if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host "PHP n'est pas installe." -ForegroundColor Yellow
    Write-Host 'Installez PHP avec : winget install PHP.PHP' -ForegroundColor Yellow
    exit 1
}

$Config = Join-Path $AppDir 'include\config.php'
$Example = Join-Path $AppDir 'include\config.example.php'
if ((-not (Test-Path $Config)) -and (Test-Path $Example)) {
    Copy-Item $Example $Config
}

$StartScript = Join-Path $AppDir 'start-mikhmon-windows.ps1'
$Shell = New-Object -ComObject WScript.Shell
$Shortcut = $Shell.CreateShortcut($ShortcutPath)
$Shortcut.TargetPath = 'powershell.exe'
$Shortcut.Arguments = "-NoProfile -ExecutionPolicy Bypass -File `"$StartScript`""
$Shortcut.WorkingDirectory = $AppDir
$Shortcut.Description = 'Démarrer Mikhmon'
$Shortcut.Save()

Write-Host "Raccourci créé : $ShortcutPath" -ForegroundColor Green
& $StartScript
