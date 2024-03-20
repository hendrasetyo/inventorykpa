<?php
$birthDate = new DateTime($tanggal_lahir);
$today = new DateTime("today");
$umur = $today->diff($birthDate)->y;
?>

<td>{{$umur}}</td>