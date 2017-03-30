<?php
	$page_title = "My Cart";
	include_once('../includes/header.php');

	$sql_cart = "SELECT od.detailID, p.name, 
		p.image, od.price, od.quantity, 
		od.amount FROM orders_details od 
		INNER JOIN products p ON 
		od.productID = p.productID
		WHERE od.orderNo=0
		AND od.userID=1";
	$result_cart = $con->query($sql_cart) or 
		die(mysqli_error($con));
?>

<form class="form-horizontal" method="POST">
	<div class="col-lg-9">
		<table class="table table-hover">
			<thead>
				<th colspan="2">Product</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Amount</th>
				<th>Actions</th>
			</thead>
			
			<tbody>
				<?php
					if(mysqli_num_rows($result_cart) > 0)
					{
						while ($row = mysqli_fetch_array($result_cart))
						{
							$detailID = $row['detailID'];
							$name = $row['name'];
							$image = $row['image'];
							$price = $row['price'];
							$qty = $row['quantity'];
							$amount = $row['amount'];

							echo "
								<tr>
									<td><img src='../images/products/$image' 
										width='200' alt='$name'
									</td>
									<td>$name</td>
									<td>PHP$price</td>
									<td>
										<input type='number' min=1 max=99 
											class='cart form-control' data-qty='$qty'
											value='$qty' required />
									</td>
									<td>PHP$amount</td>
									<td>
										<button class='update btn btn-xs btn-success'>
											<i class='fa fa-refresh'></i>
										</button>
										<button class='delete btn btn-xs btn-danger'>
											<i class='fa fa-trash-o'></i>
										</button>
									</td>
								</tr>
							";
						}
					}

					else
					{
						echo "
							<tr>
								<td colspan='6'>
									<h2 class='text-center'>No records found.</h2>
								</td>
							</tr>
						";
					}
				?>
			</tbody>
			
			<tfoot>

			</tfoot>
		</table>
	</div>

	<div class="col-lg-3">
		<div class="well">
			<table>
				<tbody>
					<tr>
						<td>Gross Amount</td>
						<td><?php echo $gross; ?></td>
					</tr>

					<tr>
						<td>VAT (12%)</td>
						<td><?php echo $vat; ?></td>
					</tr>

					<tr>
						<td>Delivery Fee</td>
						<td><?php echo $delivery; ?></td>
					</tr>

					<tr>
						<td>Total Amount</td>
						<td><?php echo $total; ?></td>
					</tr>
				</tbody>
			</table>
			<a href='checkout.php' class='btn btn-success btn-block btn-lg'>
				<i class='fa fa-money'></i> Checkout
			</a>
		</div>
	</div>
</form>

<?php
	include_once('../includes/footer.php');
?>