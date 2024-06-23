<x-app-layout>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>

    <script>
        (g => {
            var h, a, k, p = "The Google Maps JavaScript API",
                c = "google",
                l = "importLibrary",
                q = "__ib__",
                m = document,
                b = window;
            b = b[c] || (b[c] = {});
            var d = b.maps || (b.maps = {}),
                r = new Set,
                e = new URLSearchParams,
                u = () => h || (h = new Promise(async (f, n) => {
                    await (a = m.createElement("script"));
                    e.set("libraries", [...r] + "");
                    for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                    e.set("callback", c + ".maps." + q);
                    a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                    d[q] = f;
                    a.onerror = () => h = n(Error(p + " could not load."));
                    a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                    m.head.append(a)
                }));
            d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                d[l](f, ...n))
        })({
            key: "AIzaSyCrR7RmCs0UkChkfbOJSoOUQ7kf9i-gcsk",
            v: "weekly",
            // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
            // Add other bootstrap parameters as needed, using camel case.
        });
    </script>

    <!-- CONTEUDO -->
    <div class="container">

        <!-- HEADER -->
        <h2 class="my-3 fw-bolder fs-1">Áreas de entrega</h2>
        <!-- FIM HEADER -->

        <!-- BODY -->

        <!-- SE HOUVER RESTAURANTE -->
        @if($restaurante != null)

        <!-- CARD AREA EM METROS -->
        <div class="card text-bg-light mb-3" style="max-width: 18rem;">
            <div class="card-header">Área de entrega</div>
            <div class="card-body">
                <h5 class="card-title fw-bold fs-2 m-0 p-0">{{$restaurante->area_entrega_metros}}</h5>
                <p class="mb-1 p-0">
                    metros
                </p>
                <p class="card-text text-secondary">
                    Raio da área de entrega definida em metros.
                </p>
            </div>
        </div>
        <!-- BTN ACAO -->
        <form action="{{ route('restaurante.area_entrega_metros', ['id' => $restaurante->id]) }}" method="POST"
            class="my-2">
            @csrf
            <div class="form-floating mt-1">
                <input type="text" class="form-control @error('area_entrega_metros') is-invalid @enderror"
                    id="inputArea" name="area_entrega_metros" autocomplete="off">
                <label for="inputArea">Área de entrega (metros)</label>
            </div>
            
            <button type="submit" class="btn btn-primary px-5 mt-2">
                Escolher
            </button>
        </form>

        <!-- FIM BTN -->
        @endif
        <!-- FIM SE HOUVER RESTAURANTE -->

        <div id="map" class="m-3"></div>

        <!-- FIM BODY -->

    </div>
    <!-- FIM CONTEUDO -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
       
        // Initialize and add the map
        let map;

        async function initMap() {
            // The location of Restaurante
            const position = {
                lat: {{$data_maps['latitude']}},
                lng: {{$data_maps['longitude']}}
            };
            // Request needed libraries.
            //@ts-ignore
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            // The map, centered at Restaurante
            map = new Map(document.getElementById("map"), {
                zoom: 12,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Restaurante",
            });

            // The circle
            const cityCircle = new google.maps.Circle({
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
                map: map,
                center: position,
                radius: {{$restaurante->area_entrega_metros}},
            });
        }

        initMap();
    </script>
</x-app-layout>
