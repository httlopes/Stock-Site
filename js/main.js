(function() {
  var app = angular.module('stock', []);

  // app.controller('StoreController', function(){
  //   this.products= gem;
  // });

  // var gem = "hello";
  app.directive('homePage', function(){
    return {
      restrict: 'E',
      templateUrl: 'folders/Home/home-page.php',
    };
  });

  app.directive('orderPage', function(){
    return {
      restrict: 'E',
      templateUrl: 'folders/Order/order-page.php',
    };
  });

  app.directive('stockPage', function(){
    return {
      restrict: 'E',
      templateUrl: 'folders/Stock/stock-page.php',
    };
  });

  app.directive('bankPage', function(){
    return {
      restrict: 'E',
      templateUrl: 'folders/Bank/bank-page.php',
    };
  });

  app.controller('TabController', function(){
    this.tab = 1;

    this.setTab = function(newValue){
      this.tab = newValue;
    };

    this.isSet = function(tabName){
      return this.tab === tabName;
    };
  });

/**
Order JS
*/
  app.controller('addProductController', function($scope, $http){
    $scope.isShowForm = false;
    $scope.isAnotherProduct = function(productSelect) {
      if(productSelect==="Outro"){
        return false;
      }
      return true;
    };

    $scope.isAnotherColor = function(colorSelect) {
      if(colorSelect==="Outro"){
        return false;
      }
      return true;
    };

    $scope.showForm = function(select){
      var element = angular.element('#addProduct');
      if($("#addProductButton i").hasClass("glyphicon-plus")){
        element.removeClass('hide');
        $("#addProductButton i").removeClass("glyphicon-plus").addClass("glyphicon-minus");
      }else{
        $("#addProductButton i").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        element.addClass('hide');
      }
    };

    $scope.isAnotherBrand = function(brandSelect) {
        if(brandSelect==="Outro"){
          return false;
        }
        return true;
      };

    $scope.submit = function() {
      var product = "";
      var color = "";
      var received = $scope.received;
      var spent= $scope.spent;
      var mobile= $scope.brandSelect;
      var wallet = $scope.walletSelect;

      if($scope.productSelect==="Outro"){
        product=$scope.productOther;
      }else{
        product=$scope.productSelect;
      }

      if($scope.colorSelect === "Outro"){
        color= $scope.colorOther;
      }else{
        color=$scope.colorSelect;
      }

      if($scope.brandSelect === "Outro"){
          mobile= $scope.brandOther;
        }
      
      $http.post("folders/Order/insertOrder.php",{'p': product, 'c': color, 'r': received, 's': spent, 'w': wallet, 'm':mobile})
        .success(function(data, status, headers, config){
            $scope.productSelect = "";
            $scope.colorSelect = "";
            $scope.spent = "";
            $scope.walletSelect.selectedVariant = 0;
            $scope.brandSelect = "";
            $scope.showForm(false);
            location.reload();
        });
      };
  });


/**
* Stock JS
*/
  app.controller('addStockController', function($scope, $http){
      $scope.isShowForm = false;

      $scope.showForm = function(select){
        var element = angular.element('#addStock');
        if($("#addStockButton i").hasClass("glyphicon-plus")){
          element.removeClass('hide');
          $("#addStockButton i").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }else{
          $("#addStockButton i").removeClass("glyphicon-minus").addClass("glyphicon-plus");
          element.addClass('hide');
        }
      };

      $scope.isAnotherProduct = function(productSelect) {
        if(productSelect==="Outro"){
          return false;
        }
        return true;
      };

      $scope.isAnotherColor = function(colorSelect) {
        if(colorSelect==="Outro"){
          return false;
        }
        return true;
      };

      $scope.isAnotherBrand = function(brandSelect) {
        if(brandSelect==="Outro"){
          return false;
        }
        return true;
      };

      $scope.submit = function() {
        var product = $scope.productSelect;
        var color = $scope.colorSelect;
        var spent= $scope.spent;
        var wallet = $scope.walletSelect;
        var mobile = $scope.brandSelect;
        var inStock = $scope.inStockSelect;
        // alert(product+ " "+ color + " " + spent+ " "+ wallet+ " "+ mobile+ " "+ inStock);
        if($scope.productSelect==="Outro"){
          product=$scope.productOther;
        }

        if($scope.colorSelect === "Outro"){
          color= $scope.colorOther;
        }

       if($scope.brandSelect === "Outro"){
          mobile= $scope.brandOther;
        }
        
        $http.post("folders/Stock/insertStock.php",{'p': product, 'c': color, 's': spent, 'w': wallet, 'm': mobile, 'it': inStock})
          .success(function(data, status, headers, config){
              $scope.productSelect = "";
              $scope.colorSelect = "";
              $scope.received = "";
              $scope.spent = "";
              $scope.walletSelect.selectedVariant = 0;
              $scope.brandSelect = "";
              $scope.inStock = "";
              $scope.showForm(false);
              location.reload();
        });
      };

  });

/**
  Bank JS
*/

app.controller('addStatementController', function($scope, $http){
      $scope.isShowForm = false;

      $scope.showForm = function(select){
        var element = angular.element('#addStatement');
        if($("#addStatementButton i").hasClass("glyphicon-plus")){
          element.removeClass('hide');
          $("#addStatementButton i").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }else{
          $("#addStatementButton i").removeClass("glyphicon-minus").addClass("glyphicon-plus");
          element.addClass('hide');
        }
      };

      $scope.submit = function() {
        var type = $scope.typeSelect;
        var amount = $scope.amount;
        var information= $scope.information;
        var wallet = $scope.walletSelect;

        $http.post("folders/Bank/insertStatement.php",{'t': type, 'a': amount, 'i': information, 'w': wallet})
          .success(function(data, status, headers, config){
              $scope.typeSelect = "";
              $scope.amount="";
              $scope.information="";
              $scope.walletSelect.selectedVariant = 0;
              $scope.showForm(false);
              location.reload();
        });
      };
  });
  

})();
		