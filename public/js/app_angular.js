angular.module('staticSelect', [])
 .controller('limpar_dropdown', ['$scope', function($scope) {
   $scope.data = {
    singleSelect: null,
   };

   $scope.forceUnknownOption = function() {
     $scope.data.singleSelect = '';
   };
}]);

