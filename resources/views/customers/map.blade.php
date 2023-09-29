@extends('customers.layout')

@section('content')

    <header class="bg-white shadow">
        <div class="max-w-6xl max-auto py-6 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">
                        Customers
                    </h2>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="w-full p-2 bg-white rounded-md shadow">
            <div class="rounded" style="height: 600px" id="map"></div>
        </div>
    </main>

    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">

    <script>
        // TO MAKE THE MAP APPEAR YOU MUST
        // ADD YOUR ACCESS TOKEN FROM
        // https://account.mapbox.com
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [-96, 53.8], // starting position [lng, lat]
            zoom: 3.1 // starting zoom
        });

        let regions = @json($regions->map->only('id','color','geometry_as_json'));
        let customers = @json($customers->map->only('latitude','longitude'));
        map.on('load',function () {
            regions.forEach(function (region) {
                map.addSource(`region-${region.id}`, {
                    'type': 'geojson',
                    'data': JSON.parse(region.geometry_as_json)
                });
                map.addLayer({
                    'id': 'region-'+region.id,
                    'type': 'fill',
                    'source': 'region-'+region.id,
                    'layout': {},
                    'paint': {
                        'fill-color': region.color,
                        'fill-opacity': 0.5
                    }
                });
            });

            customers.forEach(function (customer) {
                let el = document.createElement('div');
                el.innerHTML = `<div class="rounded-full bg-white w-3 h-3 bg-white opacity-75"></div>`;
                new window.mapboxgl.Marker(el)
                    .setLngLat([customer.longitude, customer.latitude])
                    .addTo(map)
                ;
            });
        });
    </script>
@endsection
