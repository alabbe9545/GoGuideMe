<script type="text/javascript">
    angular.module('awardModule', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
    }).controller('awardModuleController', function($scope, $http) {
        $scope.awards = {!! json_encode($awards) !!};
        $scope.zones = {!! json_encode($zones) !!};
        $scope.countries = {!! json_encode($countries) !!};
        $scope.award = {};

        $scope.attachFile = function(files, name) {
            if($scope.award.fd == undefined){
                var fd = new FormData();
                fd.append(name, files[0]);
                $scope.award.fd = fd;
            }
            else{
                $scope.award.fd.append(name, files[0]);
            }
        }

        $scope.store = () => {
            if($scope.award.fd === undefined){
                errorMessage("Añade la imagen!");
                return;
            }
            let zone = $scope.award.zone_id === undefined ? null : $scope.award.zone_id;
            let country = $scope.award.country_id === undefined ? null : $scope.award.country_id;
            $scope.award.fd.append('name', $scope.award.name);
            if(zone)$scope.award.fd.append('zone_id', zone);
            if(country) $scope.award.fd.append('country_id', country);
            $scope.award.fd.append('unlock_criteria', $scope.award.unlock_criteria);
            fd = $scope.award.fd;
            $http.post('/awards', fd, {
                withCredentials: false,
                headers: {
                  'Content-Type': undefined
                },
                transformRequest: angular.identity
            }).then((data) => {
                successMessage(data.data.msg);
                $scope.awards = data.data.awards;
                document.getElementById("fileP").value = "";
                $scope.award = {};
            }, (err) => {
                errorMessage(err.msg);
            });
        }

        $scope.remove = (id) => {
            $http.delete('/awards/'+id).then((data) => {
                successMessage(data.data.msg);
                $scope.awards = data.data.awards;
            }, (err) => {
                errorMessage(err.msg);
            });
        }
    });
</script>

