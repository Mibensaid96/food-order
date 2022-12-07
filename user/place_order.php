<?php
include_once 'partials-user/header.php';

if(isset($_POST['checkout_btn'])) {
	$user_id = $_POST['user_id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$order_cost = $_SESSION['total'];
	$order_status = "not paid";
	$order_date = date("Y-m-d h:i:s");

	// logins de l'utilisateur
	$user_username = $_SESSION['auth']['username'];
	$user_email = $_SESSION['auth']['email'];

	if ($name != $user_username || $email != $user_email) { // si les identifiants sont differents de ceux de l'user
		$_SESSION['flash']['error'] = "<div class='col-3 error'>Votre pseudo ou votre email n'est pas valide.</div>";
        header("location: user-checkout.php"); // 
        exit();
	} else { // sinon enregistrer les datas dans la db et aller a la page de paiement
		
		// req pour enregistrer des datas user dans tbl_order
		$stmt = $conn->prepare("INSERT INTO tbl_order (order_cost, order_status, user_id, user_name, user_email, user_phone, user_city,  order_date)
								VALUES (?,?,?,?,?,?,?,?)");

		$stmt->bind_param("isississ", $order_cost,$order_status,$user_id,$name,$email,$phone,$city,$order_date); // i : int , s : string
		$stmt->execute();
    
    
		// checker si les infos saisies sont identiques a ceux de $_SESSION['auth']
		// eEnregistrer les datas complementaires de user dans tbl_user
		$stmt2 = $conn->prepare("UPDATE tbl_users SET phone = ?, user_city = ?, user_address = ? WHERE id = ?");
    
		$stmt2->bind_param("issi",$phone, $city, $address, $user_id); // 
		$stmt2->execute();
    
    
		/*VALUES (:phone,:user_city,:user_address)
								WHERE id=':id'*/
    
		/*$stmt2->bindParam(":phone", $phone); // 
		$stmt2->bindParam(":user_city", $city); // 
		$stmt2->bindParam(":user_address", $address); // */
    
		if (!$stmt->execute() || !$stmt2->execute()) { // si la req echoue
			// rediriger l'utilisateur a la page d'accueil
			header("location: index.php");
			// Envoyer msg flash a l'user : order fail
			exit();
		}

		$order_id = $stmt->insert_id; // derniere valeur enregistree

		//recuperer tous les produits de la carte et les inserer dans la BD

		foreach($_SESSION['order'] as $id=>$product) {
			$product = $_SESSION['order'][$id];
			$product_id = $product['product_id'];
			$product_name = $product['product_name'];
			$product_image = $product['product_image'];
			$product_price = $product['product_price'];
			$product_quantity = $product['product_quantity'];

			$stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id,product_name,product_image,product_price,product_quantity,user_name,order_date)
									VALUES (?,?,?,?,?,?,?,?)");
			$stmt1->bind_param("iissiiss",$order_id,$product_id,$product_name,$product_image,$product_price,$product_quantity,$name,$order_date);
			$stmt1->execute();
		} 

		// enregistrement de order_id dans la session
		$_SESSION['order_id'] = $order_id;

		// rediriger l'utilisateur a la page de paiement
		header("location: payment.php");
	}

}
?>
