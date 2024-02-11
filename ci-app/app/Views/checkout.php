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
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        label {
            margin-left: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            border-radius: 4px;
            border: none;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .total-amount {
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pizza Ordering System</h1>
        <table>
            <thead>
                <tr>
                    <th>Pizza Name</th>
                    <th>Size</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
			<?php $onlyPizzaAmount = 0;
			foreach($pizzaOrder as $data){
				$onlyPizzaAmount += $data['total_amount'];
				?>
                <tr>
                    <td><?= $data['name'];?></td>
                    <td><?= $data['size'];?></td>
                    <td><?= $data['total_amount'];?></td>
                </tr>
			<?php }?>
            </tbody>
        </table>
        <h3>Selected Toppings:</h3>
        <ul>
			<?php $onlyToppingAmount= 0; if (!empty($topping)): //print_r($topping);exit;?>
			<?php foreach($topping as $topping){ 
			$onlyToppingAmount += $topping['price'];
			?>
            <li><?= $topping['name']?> (<?= $topping['price']?>)</li>
			<?php }?>
			<?php endif;?>
        </ul>
        
        <div class="total-amount">Total Amount: <?php echo $onlyPizzaAmount + $onlyToppingAmount?></div>
    </div>
</body>
</html>
