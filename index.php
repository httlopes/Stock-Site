<!DOCTYPE html>
<html lang="en" ng-app='stock'>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Stock</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	   <!-- Stock -->
	   <link rel="stylesheet" type="text/css" href="css/stock.css">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90142512-1', 'auto');
  ga('send', 'pageview');

</script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/angular.min.js"></script>
    <script src="js/main.js"></script>
    <!-- <script src="folders/Order/order.js"></script> -->
    <div class="container">
      <div class="masthead">
        <h3 class="text-muted">Stock dos artigos</h3>
        <nav>
          <section ng-controller="TabController as tab">
            <ul class="nav nav-justified nav-pills">
              <li ng-class="{ active:tab.isSet(1) }"><a ng-click="tab.setTab(1)">Inicio</a></li>
                <li ng-class="{ active:tab.isSet(2) }"><a ng-click="tab.setTab(2)">Encomendas</a></li>
                <li ng-class="{ active:tab.isSet(3) }"><a ng-click="tab.setTab(3)">Stock produtos</a></li>
                <li ng-class="{ active:tab.isSet(4) }"><a ng-click="tab.setTab(4)">Saldo bancário</a></li>
                <!-- <li ng-class="{ active:tab.isSet(5) }"><a ng-click="tab.setTab(5)" href="#">Export</a></li> -->
            </ul>
            <div ng-show="tab.isSet(1)">
              <home-page>
              </home-page>
            </div>
            <div ng-show="tab.isSet(2)">
              <order-page>
              </order-page>
            </div>
            <div ng-show="tab.isSet(3)">
              <stock-page>
              </stock-page>
            </div>
            <div ng-show="tab.isSet(4)">
              <bank-page>
              </bank-page>
            </div>
          </section>
        </nav>
      </div>
    </div>

  </body>
</html>		