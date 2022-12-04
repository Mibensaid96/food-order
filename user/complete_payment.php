<?php
// Ce code change le payment status et envoie les infos du paiement a la BD

session_start();

include '../config/constants.php';

if (isset($_GET['transaction_id']) && isset($_SESSION['order_id'])) {
	
	$order_status = "paid";
	$order_id = $_SESSION['order_id'];
	$payment_date = date("Y-m-d h:i:s");
	$transaction_id = $_GET['transaction_id'];

	// change order status to paid
	$stmt = $conn->prepare("UPDATE tbl_order SET order_status = ? WHERE order_id = ?");
	$stmt->bind_param("si",$order_status,$order_id);
	$stmt->execute();


	// store payment info in the table
	$stmt1 = $conn->prepare("INSERT INTO payments (order_id,transaction_id,payment_date) VALUES (?,?,?) ");
	$stmt1->bind_param("iss",$order_id,$transaction_id, $payment_date); // order_id est de type int mais transaction_id sera string
	$stmt1->execute();

	header("location: thank_you.php?success_message=thanks for shopping witn us");
	exit;

} else {
	header("location: ../index.php");
	exit;
}



?>