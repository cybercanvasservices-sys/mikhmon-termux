<?php
error_reporting(0);
if (!isset($_SESSION['mikhmon'])) { header('Location:../admin.php?id=login'); exit; }
function wg_h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$wgdir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'wireguard-configs';
if (!is_dir($wgdir)) { @mkdir($wgdir, 0700, true); }
$wgname = preg_replace('/[^A-Za-z0-9_-]/', '_', $session) . '.conf';
$wgfile = $wgdir . DIRECTORY_SEPARATOR . $wgname;
$wgmessage = '';
if (isset($_POST['upload_wireguard']) && isset($_FILES['wireguard_file'])) {
  $upload = $_FILES['wireguard_file'];
  $extension = strtolower(pathinfo($upload['name'], PATHINFO_EXTENSION));
  if ($upload['error'] !== UPLOAD_ERR_OK) {
    $wgmessage = '<div class="bg-danger pd-10 radius-3">Échec de l’importation du fichier.</div>';
  } elseif ($extension !== 'conf' || $upload['size'] > 65536) {
    $wgmessage = '<div class="bg-danger pd-10 radius-3">Sélectionnez un fichier .conf de 64 Ko maximum.</div>';
  } elseif (@move_uploaded_file($upload['tmp_name'], $wgfile)) {
    @chmod($wgfile, 0600);
    $wgmessage = '<div class="bg-success pd-10 radius-3">Fichier WireGuard importé pour cette session.</div>';
  } else {
    $wgmessage = '<div class="bg-danger pd-10 radius-3">Impossible d’enregistrer le fichier WireGuard.</div>';
  }
}
?>
<div class="row"><div class="col-12"><div class="card">
<div class="card-header"><h3><i class="fa fa-shield"></i> Connexion distante avec WireGuard</h3></div>
<div class="card-body">
<?= $wgmessage; ?>
<div class="bg-warning pd-10 radius-3"><b>Important :</b> activez le tunnel WireGuard dans Termux ou l’application WireGuard avant de cliquer sur Connect.</div>
<h4>Importer le fichier WireGuard</h4>
<p>Importez le fichier <code>.conf</code> exporté depuis Back to Home ou MikroTik sur Android.</p>
<form method="post" enctype="multipart/form-data">
  <input type="file" name="wireguard_file" accept=".conf" required>
  <button class="btn bg-primary" type="submit" name="upload_wireguard"><i class="fa fa-upload"></i> Importer</button>
</form>
<?php if (is_file($wgfile)) { ?><p class="text-green"><i class="fa fa-check"></i> Fichier importé : <?= wg_h($wgname); ?></p><?php } ?>
<div class="bg-warning pd-10 radius-3"><b>Sécurité :</b> ce fichier contient une clé privée. Il est conservé localement et ne doit pas être publié sur GitHub.</div>
<h4>Dans Mikhmon</h4>
<ol><li>Ouvrez les paramètres de la session.</li><li>Dans <b>IP MikroTik / WireGuard</b>, mettez l’adresse VPN du MikroTik, par exemple <code>10.10.10.1</code>.</li><li>Gardez l’utilisateur et le mot de passe API du MikroTik.</li><li>Activez le tunnel WireGuard, puis cliquez sur <b>Connect</b>.</li></ol>
<h4>À vérifier sur le MikroTik</h4>
<p>L’interface WireGuard doit avoir une adresse VPN et une règle pare-feu autorisant l’API depuis le réseau WireGuard. L’API doit être active sur le port 8728.</p>
<h4>Test dans Termux</h4>
<pre>ping 10.10.10.1</pre>
<p>Si le ping répond, utilisez cette même adresse dans le champ IP de Mikhmon.</p>
<h4>Activation dans Termux</h4>
<p>Après l’importation, activez le fichier avec WireGuard :</p>
<pre>wg-quick up ../wireguard-configs/<?= wg_h($wgname); ?></pre>
<p>Ensuite, mettez l’adresse WireGuard du MikroTik dans le champ IP et cliquez sur <b>Connect</b>.</p>
<a class="btn bg-warning" href="./admin.php?id=settings&session=<?= wg_h($session); ?>"><i class="fa fa-arrow-left"></i> Retour</a>
</div></div></div></div>
