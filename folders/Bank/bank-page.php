<?php
	// Load configuration as an array. Use the actual location of your configuration file
	$config = parse_ini_file('../../config.ini'); 
	$connection = mysqli_connect('mysql13.000webhost.com',$config['username'],$config['password'],$config['dbname']);
	if($connection === false) {
		// Handle error - notify administrator, log to a file, show an error screen, etc.
		echo "erro";
	}
?>
<div style="margin-top: 20px;">
	<h1 style="text-align: center;">Vamos verificar o saldo!</h1>
	<div class="col-sm-4 form-box">
		<label class="sr-only" for="form-wallet">Selecionar a caixa</label>
    	<select name="walletSelect" ng-model="walletSelect" class="form-control empty" required>
    		<option value="" selected disabled>Selecionar a caixa</option>
         	<?php
         		$sql = "SELECT id, name, balance FROM wallet";
				$result = $connection->query($sql);
				while($row = $result->fetch_assoc()) {
					echo "<option value=".$row['balance'].">".$row['name']."</option>"; 
				}
         	?>
	    </select>
	    Valor bancário: {{walletSelect}}€
	</div>

	<div ng-controller="addStatementController">
		<h1 style="text-align: center; margin-top: 2em;">Últimas movimentações</h1>
		<button id="addStatementButton" type="button" class="btn btn-default" ng-click="showForm(true)" >
			<i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
		</button>
		<form id="addStatement" name="addStatement" role="form" ng-submit="submit()" method="post" class="registration-form hide">
			<div class="col-sm-6 form-box" >
	        	<div class="form-group">
	        		<label class="sr-only" for="form-statement-type">Selecionar o tipo de transação</label>
	            	<select name="typeSelect" ng-model="typeSelect" class="form-control empty" required>
	            		<option value="" selected disabled>Selecionar o tipo de transação</option>
	            		<option>Despesa</option>
	            		<option>Lucro</option>
				    </select>
	            </div>

	            <div class="form-group">
	            	<label class="sr-only" for="form-statement-amount">Inserir o valor</label>
	            	<input type="number" min="0" step="0.01" name="amount" ng-model="amount" placeholder="Inserir o valor" class="form-control" required>
	            </div>

	            <div class="form-group">
	            	<label class="sr-only" for="form-statement-information">Adicionar informação adicional</label>
	            	<textarea name="information" ng-model="information" placeholder="Adicionar informação adicional" class="form-control" required></textarea>
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
			         	?>
			         	
				    </select>
	            </div>
	            <button type="submit" class="btn">Inserir</button>
    		</div>
    	</form>


		<form action="post">
			<table class="table">
				<thead>
	                <tr>
	                  <th>#</th>
	                  <th>Informação</th>
	                  <th>Valor</th>
	                  <th>Tipo</th>
	                  <th>Data</th>
	                </tr>
              </thead>
              <tbody>
              	<?php
              		$sql = "SELECT statement.id, statement.amount, statement.type, statement.information, statement.date
              			FROM statement
              			ORDER BY statement.date DESC";
						$result = $connection->query($sql);
						while($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>".$row['id']."</td>";
							echo "<td>".$row['information']."</td>";
							echo "<td>".$row['amount']."&euro;</td>";
							echo "<td>".$row['type']."</td>";
							echo "<td>".$row['date']."</td>";
							echo "</tr>";
						}
              	?>
              </tbody>
			</table>
		</form>
	</div>

</div>