$ErrorActionPreference = 'Stop'
$AppDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$Port = 8080

$listener = Get-NetTCPConnection -LocalPort $Port -State Listen -ErrorAction SilentlyContinue
if (-not $listener) {
    Start-Process -FilePath 'php' -ArgumentList @('-S', "127.0.0.1:$Port", '-t', $AppDir) -WorkingDirectory $AppDir -WindowStyle Minimized
    Start-Sleep -Seconds 2
}
Start-Process "http://127.0.0.1:$Port"
