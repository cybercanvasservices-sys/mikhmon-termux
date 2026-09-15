<?php
/*
 *  Copyright (C) 2018 Laksamadi Guko.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
// hide all error
error_reporting(0);
if (substr($_SERVER["REQUEST_URI"], -11) == "readcfg.php") {
    header("Location:./");
};
// read config

$iphost = explode('!', $data[$session][1])[1];
$userhost = explode('@|@', $data[$session][2])[1];
$passwdhost = explode('#|#', $data[$session][3])[1];
$hotspotname = explode('%', $data[$session][4])[1];
$dnsname = explode('^', $data[$session][5])[1];
$currency = explode('&', $data[$session][6])[1];
$areload = explode('*', $data[$session][7])[1];
$iface = explode('(', $data[$session][8])[1];
$infolp = explode(')', $data[$session][9])[1];
$idleto = explode('=', $data[$session][10])[1];
$sesname = explode('+', $data[$session][10])[1];
$useradm = explode('<|<', $data['mikhmon'][1])[1];
$passadm = explode('>|>', $data['mikhmon'][2])[1];
$livereport = explode('@!@', $data[$session][11])[1];

$cekindo['indo'] = array(
    'RP', 'Rp', 'rp', 'IDR', 'idr', 'RP.', 'Rp.', 'rp.', 'IDR.', 'idr.',
);

// Match Mikhmon sales records written by RouterOS 6 (mmm/dd/yyyy)
// and RouterOS 7.10+ (yyyy-mm-dd).
function mikhmon_script_matches_period($row, $idhr = '', $idbl = '') {
    if ($idhr == '' && $idbl == '') {
        return true;
    }
    $recordDate = isset($row['source']) ? trim($row['source']) : '';
    if ($recordDate == '' && isset($row['name'])) {
        $recordDate = explode('-|-', $row['name'])[0];
    }
    $recordDate = strtolower($recordDate);
    if ($idhr != '') {
        $targetLegacy = strtolower($idhr);
        $targetIso = date('Y-m-d', strtotime(str_replace('/', ' ', $idhr)));
        return $recordDate == $targetLegacy || $recordDate == $targetIso;
    }
    $targetMonth = strtolower($idbl);
    $targetIsoMonth = date('Y-m', strtotime('01 ' . substr($idbl, 0, 3) . ' ' . substr($idbl, 3, 4)));
    return $recordDate == $targetMonth || substr($recordDate, 0, 7) == $targetIsoMonth;
}

function mikhmon_filter_scripts($rows, $idhr = '', $idbl = '') {
    $filtered = array();
    foreach ((array)$rows as $row) {
        if (mikhmon_script_matches_period($row, $idhr, $idbl)) {
            $filtered[] = $row;
        }
    }
    return $filtered;
}

