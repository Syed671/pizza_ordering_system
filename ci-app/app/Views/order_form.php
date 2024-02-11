<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Ordering System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
        }
        select, input[type="submit"] {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
		
		table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pizza Ordering System</h1>
        <?php if (!empty($validation = session()->getFlashdata('error'))): ?>
            <div class="error"><?= $validation->listErrors() ?></div>
        <?php endif; ?>
        <form action="<?= base_url('submitData') ?>" method="post">
		
		<input type="hidden" name="randm" value="<?= $randomNumber;?>">

		
            <label for="pizza">Select Pizza:</label>
            <select name="pizzaName" id="pizzaName" required>
				<option value="">Select Pizza</option>
                <?php foreach ($pizzas as $pizza): ?>
				<option value="<?= $pizza['id'] ?>"><?= $pizza['name'] ?></option>
                <?php endforeach; ?>
            </select>
			
			<label for="pizza">Select Size:</label>
            <select name="pizzaSize" id="pizzaSize" required>	
					<option value="">Select Size</option>
            </select>
			
			<input type="submit" value="Add Pizza">
        </form>
		
		<?php if (isset($onePizza)): ?>
            <h2>Added Pizza</h2>
			<table>
				<thead>
					<tr>
						<th>Pizza Name</th>
						<th>Pizza Size</th>
						<th>Amount</th>
					</tr>
				</thead>
				
				<tbody>
				<?php foreach($onePizza as $onePizza){?>
					<tr>
						<td><?= $onePizza['name'];?></td>
						<td><?= $onePizza['size'];?></td>
						<td><?= $onePizza['price'];?></td>
					</tr>
				<?php }?>
				</tbody>
			</table>
			
        <?php endif; ?><br>
			
			
		<form action="<?= base_url('finalSubmit') ?>" method="post">
			<label for="toppings">Select Toppings (Optional):</label><br>
			<?php foreach ($toppings as $topping): ?>
				<div class="topping-option">
					<input type="checkbox" id="topping<?= $topping['id'] ?>" name="toppings[]" value="<?= $topping['id'] ?>">
					<label for="topping<?= $topping['id'] ?>"> <?= $topping['name'] ?> ($<?= $topping['price'] ?>)</label><br>
				</div>
			<?php endforeach; ?><br>
		<input type="submit" value="Place Order" <?php echo empty($onePizza) ? 'disabled' : "";?>>
        </form>

				
			<br>	

        <?php if (isset($total_amount)): ?>
            <h2>Total Amount: $<?= $total_amount ?></h2>
        <?php endif; ?>
    </div>
</body>
</html>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#pizzaName').change(function() {
        var pizzaName = $(this).val();
		
		$('#pizzaSize').empty().append('<option value="">Select Size</option>');
        
        if (pizzaName) {
            
            $.ajax({
                url: '<?php echo base_url("getPizzaSize"); ?>',
                type: 'POST',
                data: { pizza_name: pizzaName },
                dataType: 'json',
                success: function(response) {
                    $.each(response, function(index, size) {
                        $('#pizzaSize').append('<option value="' + size.id + '">' + size.size + ' ($' + size.price + ')</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching pizza sizes: ' + error);
                }
            });
        }
    });
});
</script>



