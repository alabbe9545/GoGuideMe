<script type="text/javascript">
    angular.module('userModule', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
    }).controller('userModuleController', function($scope, $http) {
        $scope.users = {!! json_encode($users) !!}.data;
        $scope.roles = {!! json_encode($roles) !!};
        console.log($scope.users);

        $scope.rolChecked = (role, user) => {
            var found = false;
            user.roles.forEach((rol) => {if(role.id == rol.id) found = true;});

            return found;
        }

        $scope.handleRolBox = (user, role) => {
            if(!$scope.rolChecked(role, user)) user.roles.push(role);
            else {
                var j = 0;
                for (var i = user.roles.length - 1; i >= 0; i--) {
                    if(user.roles[i].id == role.id) {
                        j = i;
                        break;
                    }
                }
                user.roles.splice(j, 1);
            }
        }

        $scope.editUser = (user) => {
            $http.post("/users", user).then((data) => {
                successMessage(data.data.msg);
                $scope.users = data.data.users.data;
            }, (err) => {
                errorMessage(err.msg);
            });
        }

        $scope.remove = (user) => {
            $http.delete("/users/"+user.id).then((data) => {
                successMessage(data.data.msg);
                $scope.users = data.data.users.data;
            }, (err) => {
                errorMessage(err.msg);
            });
        }
    });
</script>
