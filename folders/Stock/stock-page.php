<?php
			// Load configuration as an array. Use the actual location of your configuration file
			$config = parse_ini_file('../../config.ini'); 
			$connection = mysqli_connect('mysql13.000webhost.com',$config['username'],$config['password'],$config['dbname']);
			if($connection === false) {
				// Handle error - notify administrator, log to a file, show an error screen, etc.
				echo "erro";
			}
?>

<div style="margin-top: 20px;" ng-controller="addStockController" >
	<h1 style="text-align: center;">Verificar stock</h1>
	
		<button id="addStockButton" type="button" class="btn btn-default" ng-click="showForm(true)">
			<i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
		</button>
		<form id="addStock" name="addStock" role="form" ng-submit="submit()" method="post" class="registration-form hide">
			<div class="col-sm-6 form-box" >
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
	            	<label class="sr-only" for="form-product-spent">Pago</label>
	            	<input type="number" min="0" step="0.01" name="spent" ng-model="spent" placeholder="Total pago" class="form-control" required>
	            </div>

	<!--             <div class="form-group">
	            	<label class="sr-only" for="form-product-received">Recebido</label>
	            	<input type="number" min="0" step="0.01" name="received" ng-model="received" placeholder="Total recebido" class="form-control" required>
	            </div> -->
				
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
			         	?>
			         	
				    </select>
	            </div>
	            <button type="submit" class="btn">Inserir encomenda</button>
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

			    <div class="form-group">
	            	<label class="sr-only" for="form-inStock">Em stock?</label>
	            	<select name="inStockSelect" ng-model="inStockSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Em stock?</option>
			         	<option value="0">Não</option>
			         	<option value="1">Sim</option>
				    </select>
			    </div>

			   <!--  <div class="form-group">
	            	<label class="sr-only" for="form-model">Selecionar o modelo do telemóvel</label>
	            	<select name="modelSelect" ng-model="modelSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Selecionar o modelo do telemóvel</option>
				    </select>
			    </div> -->
			     
            </div>
    	</form>

	<div>
		<form action="post">
			<table class="table">
				<thead>
	                <tr>
	                  <th>#</th>
	                  <th>Produto</th>
	                  <th>Telemóvel</th>
	                  <th>Pago</th>
	                  <th>Recebido</th>
	                  <th>Lucro</th>
	                  <th>Data</th>
	                  <th>Em stock</th>
	                </tr>
              </thead>
              <tbody>
              	<?php
              		$sql = "SELECT stock.id, stock.product_id, stock.color_id, stock.received, stock.spent, stock.date, stock.inStock, product.name, color.colorType, mobile.brand FROM stock 
              			LEFT JOIN color ON stock.color_id = color.id 
              			LEFT JOIN mobile ON stock.mobile_id = mobile.id 
              			LEFT JOIN product ON stock.product_id = product.id
              			ORDER BY mobile.brand ASC";
						$result = $connection->query($sql);
						while($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>".$row['id']."</td>";
							echo "<td>".$row['name'].": ".$row['colorType']."</td>";
							echo "<td>".$row['brand']."</td>";
							echo "<td>".$row['spent']."€</td>";
							echo "<td>".$row['received']."€</td>";
							echo "<td>".($row['received']- $row['spent'])."€</td>";
							echo "<td>".$row['date']."</td>";
							if($row['inStock'] == 1) echo "<td>Sim</td>"; else echo "<td>Não</td>";
							echo "</tr>";
						}
              	?>
              </tbody>
			</table>
		</form>
	</div>
</div>