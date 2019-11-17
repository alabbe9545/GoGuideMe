<script type="text/javascript">
    angular.module('countryModule', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
    }).controller('countryModuleController', function($scope, $http) {
    	$scope.countries = {!! json_encode($countries) !!};
    	$scope.country = {};

    	$scope.store = () => {
    		if($scope.country.fd === undefined){
    			errorMessage("Añade la imagen!");
    			return;
    		}
    		$scope.country.fd.append('name', $scope.country.name);
    		$scope.country.fd.append('description', $scope.country.description);
    		fd = $scope.country.fd;
    		$http.post('/countries', fd, {
		        withCredentials: false,
	            headers: {
	              'Content-Type': undefined
	            },
	            transformRequest: angular.identity
		    }).then((data) => {
                successMessage(data.data.msg);
                $scope.countries = data.data.countries;
            }, (err) => {
                errorMessage(err.msg);
            });
            document.getElementById("file").value = "";
            $scope.country = {};
    	}

    	$scope.remove = (id) => {
    		$http.delete('/countries/'+id).then((data) => {
                successMessage(data.data.msg);
                $scope.countries = data.data.countries;
            }, (err) => {
                errorMessage(err.msg);
            });
    	}

    	$scope.attachFile = function(files) {
		    var fd = new FormData();
		    fd.append("file", files[0]);
		    $scope.country.fd = fd;
		}
    });
</script>
