<?php
function formatPrice($price) {
    $newprice = number_format($price, 0, ',', '.');
    return $newprice. '₫';
}       
?>

