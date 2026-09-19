<?php error_reporting(0);if($removepprofile!='')$API->comm('/ppp/profile/remove',array('.id'=>$removepprofile));echo "<script>window.location='./?ppp=profiles&session=".$session."'</script>";
