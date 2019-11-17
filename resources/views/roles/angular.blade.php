<script type="text/javascript">
    angular.module('roleModule', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
    }).controller('roleModuleController', function($scope, $http) {
        $scope.roles = {!! json_encode($roles) !!};
        $scope.role = {};

        $scope.create = () => {
            if($scope.role.name === undefined || $scope.role.name === ""){
                errorMessage("Enter a role name");
                return;
            }
            $http.post('/roles', $scope.role).then((data) =>{
                successMessage(data.data.msg);
                $scope.roles = data.data.roles;
            }, (err) => {
                errorMessage(err.msg);
            });
        }

        $scope.remove = (id) => {
            $http.delete('/roles/'+id).then((data) =>{
                successMessage(data.data.msg);
                $scope.roles = data.data.roles;
            }, (err) => {
                errorMessage(err.msg);
            });
        }
    });
</script>
