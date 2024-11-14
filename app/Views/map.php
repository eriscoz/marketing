<section class="container my-5">
    <div class="row">
        <div class="col-md-6 order-1 order-md-1">
            <div class="container-fluid">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Lokasi Asal</label>
                    <input id="source" type="text" class="form-control auto-text" value="<?= $asal ?>">
                    <input type="hidden" id="sourceLatitude">
                    <input type="hidden" id="sourceLongitude">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Lokasi Tujuan</label>
                    <input id="destination" type="text" class="form-control auto-text" value="<?= $tujuan ?>">
                    <input type="hidden" id="destinationLatitude">
                    <input type="hidden" id="destinationLongitude">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Jenis Kendaraan</label>
                    <select name="map_kendaraan" class="form-control" id="kendaraan">
                        <?php foreach ($jenis_kendaraan as $key) {
                            ?>
                            <option value="<?= $key['ID'] ?>" <?= $key['ID'] == $kendaraan ? "selected" : "" ?>>
                                <?= $key['Deskripsi'] ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <input type="hidden" id="distance">
                <input type="hidden" id="price">
                <div class="mb-3" style="float: right;">
                    <button class="btn btn-outline-success" type="submit" onclick="generateMap()">Reroute</button>
                    <button class="btn btn-outline-info" type="submit" onclick="calculatePrice()">Tampilkan
                        Harga</button>
                </div>

            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center order-2 order-md-2">
            <div class="card" style="width: 100%;">
                <div class="image-container">
                    <div id="maplocation" style="width: 100%; height: 100%;">
                        <div id="loading-spinner"
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                            Loading...
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <p class="card-text">Jarak. <span id="distanceLbl"></span></p>
                    <p class="card-text">Harga. <span id="priceLbl"></span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="//maps.googleapis.com/maps/api/js?key=<?= $api_key ?>&sensor=false&libraries=places"
    type="text/javascript"></script>
<script>
    function generateMap() {
        $('#loading-spinner').show();
        var source = $('#source').val();
        var destination = $('#destination').val();

        const geocoder = new google.maps.Geocoder();

        if (source && destination) {
            geocoder.geocode({
                'address': source
            }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    const sourceLat = results[0].geometry.location.lat();
                    const sourceLon = results[0].geometry.location.lng();

                    $('#sourceLatitude').val(sourceLat);
                    $('#sourceLongitude').val(sourceLon);

                    geocoder.geocode({
                        'address': destination
                    }, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            const destLat = results[0].geometry.location.lat();
                            const destLon = results[0].geometry.location.lng();

                            $('#destinationLatitude').val(destLat);
                            $('#destinationLongitude').val(destLon);

                            const checkForFerry = (travelMode) => {
                                const directionsService = new google.maps.DirectionsService();
                                const request = {
                                    origin: new google.maps.LatLng(sourceLat, sourceLon),
                                    destination: new google.maps.LatLng(destLat, destLon),
                                    travelMode: travelMode
                                };

                                directionsService.route(request, function (response, status) {
                                    if (status === google.maps.DirectionsStatus.OK) {
                                        const directionsLegs = response.routes[0].legs;
                                        let hasFerry = false;

                                        for (const leg of directionsLegs) {
                                            const travelModes = leg.via_waypoint || [];
                                            if (travelModes.some(mode => mode.travel_mode === 'ferry')) {
                                                hasFerry = true;
                                                break;
                                            }
                                        }

                                        if (!hasFerry) {
                                            calculateDistanceAndShowRoute(travelMode);
                                        } else {
                                            checkForFerry('driving" - ferry');
                                        }
                                    } else {
                                        console.error('Error fetching directions for', travelMode, ':', status);
                                        alert(status);
                                    }
                                });
                            };

                            // Initial route check (driving by default)
                            checkForFerry('DRIVING');

                            let ferry = false;

                            const calculateDistanceAndShowRoute = (travelMode) => {
                                const directionsService = new google.maps.DirectionsService();
                                const request = {
                                    origin: new google.maps.LatLng(sourceLat, sourceLon),
                                    destination: new google.maps.LatLng(destLat, destLon),
                                    travelMode: travelMode
                                };

                                directionsService.route(request, function (response, status) {
                                    if (status === google.maps.DirectionsStatus.OK) {
                                        let steps = response.routes[0].legs[0].steps;

                                        for (const mv of steps) {
                                            if (mv.maneuver.toLowerCase() === "ferry") ferry = true;
                                        }

                                        let distance = response.routes[0].legs[0].distance;
                                        console.log(distance);
                                        $("#distanceLbl").text(distance.text);
                                        $('#distance').val(Math.round(distance.value / 1000));

                                        if (ferry) {
                                            distance = 0;
                                            $("#distanceLbl").text(distance);
                                            $('#distance').val(distance);
                                            showToastError("Error Route Includes Shipping!");
                                            return false;
                                        }


                                        //saveSearchHistory(response.routes[0].legs[0].start_address, response.routes[0].legs[0].end_address, sourceLat, sourceLon, destLat, destLon, distance);

                                        const map = new google.maps.Map(document.getElementById('maplocation'), {
                                            zoom: 10,
                                            center: {
                                                lat: (sourceLat + destLat) / 2,
                                                lng: (sourceLon + destLon) / 2
                                            }
                                        });

                                        const original_directions = response;

                                        const directionsRenderer = new google.maps.DirectionsRenderer({
                                            draggable: true,
                                            map: map,
                                            directions: response
                                        });



                                        directionsRenderer.addListener("directions_changed", () => {
                                            const directions = directionsRenderer.getDirections();
                                            let steps = directions.routes[0].legs[0].steps;

                                            for (const mv of steps) {
                                                if (mv.maneuver.toLowerCase() === "ferry") ferry = true;
                                            }

                                            if (ferry) {
                                                showToast("Error Route Includes Shipping!");
                                                $('#source').val('<?= $asal ?>');
                                                $('#destination').val('<?= $tujuan ?>');
                                                generateMap();
                                                return false;
                                            }
                                            if (directions) {
                                                let direct = directions.routes[0].legs[0];
                                                let distance = direct.distance;
                                                //saveSearchHistory(direct.start_address, direct.end_address, direct.start_location.lat(), direct.start_location.lng(), direct.end_location.lat(), direct.end_location.lng(), distance);

                                                $("#distanceLbl").text(distance.text);
                                                $('#distance').val(Math.round(distance.value / 1000));

                                                $('#source').val(direct.start_address);
                                                $('#destination').val(direct.end_address);

                                                $('#sourceLatitude').val(direct.start_location.lat());
                                                $('#sourceLongitude').val(direct.start_location.lng());

                                                $('#destinationLatitude').val(direct.end_location.lat());
                                                $('#destinationLongitude').val(direct.end_location.lng());

                                                calculatePrice();
                                            }
                                        })

                                        calculatePrice();

                                        directionsRenderer.setMap(map);

                                        $('#loading-spinner').hide();
                                    } else {
                                        console.error('Error fetching directions for', travelMode, ':', status);
                                        alert(status);
                                    }
                                });
                            };
                        } else {
                            console.error("Error geocoding destination:", status);
                            alert(status);
                        }
                    });
                } else {
                    console.error("Error geocoding source:", status);
                    alert(status);
                }
            });
        }
    }

    function calculatePrice() {
        let isLogin = '<?= json_encode(session()->has('user')) ?>';
        if (isLogin !== 'true') {
            showToastError("Silahkan Login Terlebih Dahulu Untuk Mendaptakan Harga!");
            return false;
        } else {
            let idKendaraan = $('#kendaraanh').val();
            let distance = $('#distance').val();

            $.ajax({
                url: "<?= base_url() ?>/getPrice", 
                type: 'POST',
                data: {
                    distance: distance,
                    vehicleId: idKendaraan 
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    $('#priceLbl').text(formatRupiah(data.value));
                    $('#price').val(data.value);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(errorThrown);
                    console.log(jqXHR.responseText);
                    showToastError('Error while Calculating the cost');
                }
            });
        }
    }

    $(document).ready(function () {
        generateMap();
        //calculatePrice();
    });
</script>