<?php
	include_once('config.php');

	if (isset($_REQUEST['id']))
	{
		if (ctype_digit($_REQUEST['id']) &&
			!isset($_REQUEST['qty']))
		{
			$productID = $_REQUEST['id'];

			addToCart($con, $productID, 1);
		}
		else if  (ctype_digit($_REQUEST['id']) &&
			isset($_REQUEST['qty']))
		{
			$productID = $_REQUEST['id'];
			$quantity = $_REQUEST['qty'];
			addToCart($con, $productID, $quantity);
		}
		else
		{
			header('location: products.php');
		}
	}
	else
	{
		header('location: products.php');
	}

	function getPrice($con, $pid)
	{
		$sql_price = "SELECT price FROM products
			WHERE productID=$pid";
		$result_price = $con->query($sql_price)
			or die(mysqli_error($con));
		return mysqli_fetch_object($result_price)->price;
	}

	function isExisting($con, $pid)
	{
		$sql_existing = "SELECT productID FROM orders_details
			WHERE orderNo=0 AND userID=1 AND productID=$pid";
		$result_existing = $con->query($sql_existing)
			or die(mysqli_error($con));
		return mysqli_num_rows($result_existing) > 0 ? true : false;
	}

	function addToCart($con, $pid, $qty)
	{
		$price = getPrice($con, $pid);
		$amount = $price * $qty;

		$sql_cart = isExisting($con, $pid) ? 
			"UPDATE orders_details SET quantity = quantity + $qty,
			amount = amount + $amount
			WHERE orderNo=0 AND userID=1 AND productID=$pid" :
			"INSERT INTO orders_details VALUES ('', 0,
			1, $pid, $price, $qty, $amount)";
		$result_cart = $con->query($sql_cart) 
			or die(mysqli_error($con));
	}
?>