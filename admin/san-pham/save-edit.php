<?php 
require_once '../../commons/utils.php';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('location: '. $adminUrl .'san-pham');
	die;
}

$id = $_POST['id'];
$product_name = trim($_POST['product_name']);

$cate_id = $_POST['cate_id'];
$list_price = $_POST['list_price'];
$sell_price = $_POST['sell_price'];
$detail = $_POST['detail'];
$status = $_POST['status'];



$sql = "update products 
		set product_name = :product_name,
			cate_id = :cate_id,
			list_price = :list_price,
			sell_price = :sell_price,
			detail = :detail,
			status = :status
		";
$file = $_FILES['image'];
if($file['size'] > 0){
	$path = $file['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);

	// 2. tao filename moi
	$filename = "img/san-pham/" . uniqid() . "." . $ext;
	// 3. luu file vao thu muc
	move_uploaded_file($file['tmp_name'], '../../' . $filename);
	$sql .= ", image = :image";
}

$sql .= " where id = :id";


$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_name', $product_name);
$stmt->bindParam(':detail', $detail);
$stmt->bindParam(':sell_price', $sell_price);
$stmt->bindParam(':list_price', $list_price);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':cate_id', $cate_id);
$stmt->bindParam(':id', $id);
if($file['size']!=0){

	$stmt->bindParam(':image', $filename);
}

$stmt->execute();
header('location: '. $adminUrl . 'san-pham');
die;


 ?>