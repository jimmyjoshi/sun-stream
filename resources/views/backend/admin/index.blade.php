@extends ('backend.layouts.app')

@section ('title',  'Users Signup Google Map')

@section('after-styles')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
    <script src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyCHVayzYk_zm8j7yz1GuZMQH10a-a-bR5A"
          type="text/javascript"></script>
@endsection

@section('page-header')
    <h1>Users Signup Google Map</h1>
@endsection

@section('content')
    <center>
         <div id="map" style="width: 900px; height: 600px;"></div>
    </center>

    @php
        $locations = [];
    @endphp
    @foreach($repository->getAll() as $user)
        @if($user->user_meta)

            @php
            
            $locations[] = [
                'name'          => $user->name,
                'lat'           => $user->user_meta->lat,
                'long'          => $user->user_meta->long,
                'description'   => $user->email,
            ];

            @endphp
        @endif
    @endforeach

    <script type="text/javascript">

    var locations =  JSON.parse('{!! json_encode($locations) !!}');

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: new google.maps.LatLng(23.02, 72.57),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++)
    {
        console.log(locations[i].lat)
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i].lat, locations[i].long),
          map: map,
          icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|FFFF00',
        });

        google.maps.event.addListener(marker, 'click', (function(marker, i)
        {
          return function() {
            infowindow.setContent("<strong>" + locations[i].name + "</strong>" + '<br>' + locations[i].description );
            infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
@endsection

@section('after-scripts')

@endsection