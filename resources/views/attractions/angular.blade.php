<script type="text/javascript">
    angular.module('attractionModule', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
    }).controller('attractionModuleController', function($scope, $http) {
        $scope.attractions = {!! json_encode($attractions) !!};
        $scope.zones = {!! json_encode($zones) !!};
        $scope.attraction = {};
        $scope.showMap = false;

        $scope.attachFile = function(files, name) {
            if($scope.attraction.fd == undefined){
                var fd = new FormData();
                fd.append(name, files[0]);
                $scope.attraction.fd = fd;
            }
            else{
                $scope.attraction.fd.append(name, files[0]);
            }
        }

        $scope.toggleMap = (creation = false) => {
            if(map.getSource('location')){
                map.removeLayer('location');
                map.removeSource("location");
            }
            if(map.getSource('polygon')){
                map.removeLayer('polygon');
                map.removeSource("polygon");
            }
            $scope.showMap = !$scope.showMap;
            if($scope.attraction.zone !== undefined && creation) $scope.showPolygon($scope.attraction.zone.polygon);
        }

        $scope.store = () => {
            if($scope.attraction.fd === undefined){
                errorMessage("Añade la imagen!");
                return;
            }
            $scope.attraction.fd.append('name', $scope.attraction.name);
            $scope.attraction.fd.append('location', $scope.attraction.location);
            $scope.attraction.fd.append('description', $scope.attraction.description);
            $scope.attraction.fd.append('zone_id', $scope.attraction.zone.id);
            fd = $scope.attraction.fd;
            $http.post('/attractions', fd, {
                withCredentials: false,
                headers: {
                  'Content-Type': undefined
                },
                transformRequest: angular.identity
            }).then((data) => {
                successMessage(data.data.msg);
                $scope.attractions = data.data.attractions;
                document.getElementById("fileP").value = "";
                document.getElementById("fileA").value = "";
                document.getElementById("fileI").value = "";
                $scope.attraction = {};
            }, (err) => {
                errorMessage(err.msg);
            });
        }

        $scope.remove = (id) => {
            $http.delete('/attractions/'+id).then((data) => {
                successMessage(data.data.msg);
                $scope.attractions = data.data.attractions;
            }, (err) => {
                errorMessage(err.msg);
            });
        }

        $scope.showPoint = (coordinates, icon) => {
            if(map.hasImage('icon')){
                map.removeImage("icon");
            }
            if(map.getSource('location')){
                map.removeLayer('location');
                map.removeSource("location");
            }
            map.loadImage(icon, function(error, image) {
                if (error) throw error;
                map.addImage('icon', image);
                map.addLayer({
                    "id": "location",
                    "type": "symbol",
                    "source": {
                        "type": "geojson",
                        "data": {
                            "type": "FeatureCollection",
                            "features": [{
                                "type": "Feature",
                                "geometry": {
                                    "type": "Point",
                                    "coordinates": coordinates
                                }
                            }]
                        }
                    },
                    "layout": {
                        "icon-image": "icon",
                        "icon-size": 0.2
                    }
                });
            });

            map.easeTo({center: coordinates, zoom: 16});
            $scope.showMap = true;;
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
                point: true,
                trash: true
            }
        });
        map.addControl(draw);

        map.on('draw.create', updateArea);

        function updateArea(e){
            $scope.attraction.location = JSON.stringify(e.features[0].geometry.coordinates);
            $scope.toggleMap();
            $scope.$apply();
            draw.deleteAll();
        }
    });
</script>
