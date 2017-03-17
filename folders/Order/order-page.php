<?php
			// Load configuration as an array. Use the actual location of your configuration file
			$config = parse_ini_file('../../config.ini'); 
			$connection = mysqli_connect('mysql13.000webhost.com',$config['username'],$config['password'],$config['dbname']);
			if($connection === false) {
				// Handle error - notify administrator, log to a file, show an error screen, etc.
				echo "erro";
			}
?>

<div style="margin-top: 20px;" ng-controller="addProductController" >
	<h1 style="text-align: center;">Encomendas Realizadas</h1>

	<button id="addProductButton" type="button" class="btn btn-default" ng-click="showForm(true)">
			<i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
	</button>
		<form id="addProduct" name="addProduct" role="form" ng-submit="submit()" method="post" class="registration-form hide">
			<div class="col-sm-6 form-box">
	        	<div class="form-group">
	        		<label class="sr-only" for="form-product-name">Selecionar o produto</label>
	            	<select name="productSelect" ng-model="productSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Selecionar o produto</option>
			         	<?php
			         		$sql = "SELECT id, name FROM product";
							$result = $connection->query($sql);
							while($row = $result->fetch_assoc()) {
								echo "<option value=".$row['id'].">".$row['name']."</option>";
							}
							echo "<option>Outro</option>";
			         	?>
				    </select>
				    <input name="productOther" ng-model="productOther" class="form-control" type="text" placeholder="Especifique o produto!" ng-hide="isAnotherProduct(productSelect)" ng-required="productSelect == 'Outro'" />
	            </div>

	            <div class="form-group">
	            	<label class="sr-only" for="form-product-color">Selecionar a cor</label>
	            	<select name="colorSelect" ng-model="colorSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Selecionar a cor</option>
			         	<?php
			         		$sql = "SELECT id, colorType FROM color";
							$result = $connection->query($sql);
							while($row = $result->fetch_assoc()) {
								echo "<option value=".$row['id'].">".$row['colorType']."</option>";
							}
							echo "<option>Outro</option>";
			         	?>
			         	
				    </select>
				    <input name="colorOther" ng-model="colorOther" class="form-control" type="text" placeholder="Especifique a cor!" ng-hide="isAnotherColor(colorSelect)" ng-required="colorSelect == 'Outro'"/>
	            </div>

	            <div class="form-group">
	            	<label class="sr-only" for="form-product-received">Recebido</label>
	            	<input type="number" min="0" step="0.01" name="received" ng-model="received" placeholder="Total recebido" class="form-control" required>
	            </div>

	            <div class="form-group">
	            	<label class="sr-only" for="form-product-spent">Pago</label>
	            	<input type="number" min="0" step="0.01" name="spent" ng-model="spent" placeholder="Total pago" class="form-control">
	            </div>
				
				<div class="form-group">
	            	<label class="sr-only" for="form-wallet">Selecionar a caixa</label>
	            	<select name="walletSelect" ng-model="walletSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Selecionar a caixa</option>
			         	<?php
			         		$sql = "SELECT id, name FROM wallet";
							$result = $connection->query($sql);
							while($row = $result->fetch_assoc()) {
								echo "<option value=".$row['id'].">".$row['name']."</option>";
							}
							// echo "<option>Outro</option>";
			         	?>
			         	
				    </select>
	            </div>
	            <button type="submit" class="btn">Inserir produto</button>
            </div>

            <div class="col-sm-6 form-box">

	         	<div class="form-group">
	            	<label class="sr-only" for="form-brand">Selecionar a marca do telemóvel</label>
	            	<select name="brandSelect" ng-model="brandSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Selecionar a marca do telemóvel</option>
			         	<?php
			         		$sql = "SELECT id, brand FROM mobile ORDER BY brand ASC";
							$result = $connection->query($sql);
							while($row = $result->fetch_assoc()) {
								echo "<option value=".$row['id'].">".$row['brand']."</option>"; 
							}
							echo "<option>Outro</option>";
			         	?>
				    </select>
				    <input name="brandOther" ng-model="brandOther" class="form-control" type="text" placeholder="Especifique o telemóvel!" ng-hide="isAnotherBrand(brandSelect)" ng-required="brandSelect == 'Outro'"/>
			    </div>
            </div>
        </form>

	<div>
		<form action="post">
			<table class="table">
				<thead>
	                <tr>
	                  <th>#</th>
	                  <th>Telemóvel</th>
	                  <th>Produto</th>
	                  <th>Recebido</th>
	                  <th>Pago</th>
	                  <th>Lucro</th>
	                  <th>Data</th>
	                </tr>
              </thead>
              <tbody>
              	<?php
              		$sql = "SELECT orders.id, orders.product_id, orders.color_id, orders.received, orders.spent, orders.date, product.name, color.colorType, mobile.brand FROM orders 
              			LEFT JOIN color ON orders.color_id = color.id 
              			LEFT JOIN product ON orders.product_id = product.id
              			LEFT JOIN mobile ON orders.mobile_id = mobile.id
              			ORDER BY orders.date DESC";
						$result = $connection->query($sql);
						while($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>".$row['id']."</td>";
							echo "<td>".$row['brand']."</td>";
							echo "<td>".$row['name'].": ".$row['colorType']."</td>";
							echo "<td>".$row['received']."€</td>";
							echo "<td>".$row['spent']."€</td>";
							echo "<td>".($row['received']- $row['spent'])."€</td>";
							echo "<td>".$row['date']."</td>";
							echo "</tr>";
						}
              	?>
              </tbody>
			</table>
		</form>
	</div>
</div>