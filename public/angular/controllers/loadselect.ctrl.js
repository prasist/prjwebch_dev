(function(){

    'use strict;'

    angular
        .module('appSigma3')
        .controller('loadselect', loadselect);

    function loadselect($scope, $http)     {

        $scope.selectedCarregar = null;

        /*
            Forma de Carregar estaticamente

            $scope.Locais = [{
                Id: 1,
                Name: 'Endereço do Líder'
            }, {
                Id: 2,
                Name: 'Endereço do Vice Líder'
            }, {
                Id: 3,
                Name: 'Endereço do Anfitrião'
            }
            , {
                Id: 4,
                Name: 'Endereço do Líder Suplente'
            }
            , {
                Id: 5,
                Name: 'Endereço da Igreja Sede'
            }
            , {
                Id: 6,
                Name: 'Outro'
            }];


        */


        /*
            Carregar Dinamicamente
        */
        $scope.Locais = [];

        $http({
                method: 'GET',
                url: "{!! url('/celulas/select1') !!}"
            }).success(function (result) {

                $scope.Locais = result;
                //console.log('ok');
                //console.log(result);
        });


    }


})();