(function(angular) {
  'use strict';
angular.module('app', [])
  .controller('ctrl', ['$scope', function($scope) {
    $scope.data = {
     repeatSelect: null,
     availableOptions: [
       {id: '', name: '(Selecionar)'},
       {id: 'M', name: 'Masculino'},
       {id: 'F', name: 'Feminino'}
     ],
    };
 }]);
})(window.angular);