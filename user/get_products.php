<?php

include_once("../config/constants.php");

$stmt = $conn->prepare("SELECT * FROM tbl_food"); // selectionner toutes les entrees dans la ta table products
$stmt->execute();

$products = $stmt->get_result(); // retourne tous les prdts dans [{}, {}, {}]

?>