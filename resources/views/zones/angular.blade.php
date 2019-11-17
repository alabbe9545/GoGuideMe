<script type="text/javascript">
    angular.module('zoneModule', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
    }).controller('zoneModuleController', function($scope, $http) {
        $scope.countries = {!! json_encode($countries) !!};
        $scope.zones = {!! json_encode($zones) !!};
        $scope.zone = {};
        $scope.showMap = false;

        $scope.attachFile = function(files) {
            var fd = new FormData();
            fd.append("file", files[0]);
            $scope.zone.fd = fd;
        }

        $scope.toggleMap = () => {
            if(map.getSource('polygon')){
                map.removeLayer('polygon');
                map.removeSource("polygon");
            }
            $scope.showMap = !$scope.showMap;
        }

        $scope.store = () => {
            if($scope.zone.fd === undefined){
                errorMessage("Añade la imagen!");
                return;
            }
            $scope.zone.fd.append('name', $scope.zone.name);
            $scope.zone.fd.append('polygon', $scope.zone.polygon);
            $scope.zone.fd.append('description', $scope.zone.description);
            $scope.zone.fd.append('country_id', $scope.zone.country);
            fd = $scope.zone.fd;
            $http.post('/zones', fd, {
                withCredentials: false,
                headers: {
                  'Content-Type': undefined
                },
                transformRequest: angular.identity
            }).then((data) => {
                successMessage(data.data.msg);
                $scope.zones = data.data.zones;
            }, (err) => {
                errorMessage(err.msg);
            });
            document.getElementById("file").value = "";
            $scope.zone = {};
        }

        $scope.remove = (id) => {
            $http.delete('/zones/'+id).then((data) => {
                successMessage(data.data.msg);
                $scope.zones = data.data.zones;
            }, (err) => {
                errorMessage(err.msg);
            });
        }

        $scope.showPolygon = (polygon) => {
            if(map.getSource('polygon')){
                map.removeLayer('polygon');
                map.removeSource("polygon");
            }

            pol = [];
            polObj = JSON.parse(polygon);
            pol.push(polObj);
            centroid = $scope.calculateCentroid(polObj);
            map.addLayer({
                'id': 'polygon',
                'type': 'fill',
                'source': {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Polygon',
                            'coordinates': pol
                        }
                    }
                },
                'layout': {},
                'paint': {
                    'fill-color': '#088',
                    'fill-opacity': 0.8
                }
            });
            map.easeTo({center: centroid, zoom: 7});
            $scope.showMap = true;;
        }

        $scope.calculateCentroid = (polygon) => {
            A = 0;
            cx = 0;
            cy = 0;
            //calculate Area
            for (var i = 0; i < polygon.length - 1; i++) {
                xi = polygon[i][0];
                xi1 = polygon[i+1][0];
                yi = polygon[i][1];
                yi1 = polygon[i+1][1];

                A += (xi * yi1) - (xi1 * yi);
                cx += (xi + xi1) * ((xi*yi1) - (xi1 * yi));
                cy += (yi + yi1) * ((xi*yi1) - (xi1 * yi));
            }
            A *= 0.5;
            cx *= 1/(6*A);
            cy *= 1/(6*A);
            return [cx,cy];
        }

        mapboxgl.accessToken = 'pk.eyJ1IjoiYWxhYmJlOTU0NSIsImEiOiJjazJnNXRzZXQwN3d4M2NwZmw1aGVkMjhyIn0.spxnZe5xKR3vSQ0VwSo1eA';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11'
        });

        var draw = new MapboxDraw({
            displayControlsDefault: false,
            controls: {
                polygon: true,
                trash: true
            }
        });
        map.addControl(draw);

        map.on('draw.create', updateArea);

        function updateArea(e){
            $scope.zone.polygon = JSON.stringify(e.features[0].geometry.coordinates[0]);
            $scope.toggleMap();
            $scope.$apply();
            draw.deleteAll();
        }
    });
</script>
