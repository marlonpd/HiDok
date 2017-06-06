@extends('layout')

@section('content')

<div class="container">


        <div class="row">

        <div class="panel panel-default">
        <div class="panel-heading">Clinics</div>

        <div class="panel-body">



        <button class="btn btn-primary btn-default" @click="newClinic()" data-title="Create" data-toggle="modal" data-target="#create-clinic-form" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i>Create</button>


        <div class="table-responsive">

                
        <table id="mytable" class="table table-bordred table-striped">             
                <thead>
                    <th>Name</th>
                    <th>Days</th>
                    <th>Time</th>
                    <th>Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                    <template v-for="clinic in clinics">
                            <tr class="green-row">
                                <td>@{{ clinic.name }}</td>
                                <td>
                                    <ul class="no-bullet">
                                        <li v-if="clinic.open_sunday == 1">Sunday</li>
                                        <li v-if="clinic.open_monday == 1">Monday</li>
                                        <li v-if="clinic.open_tuesday == 1">Tuesday</li>
                                        <li v-if="clinic.open_wednesday == 1">Wednesday</li>
                                        <li v-if="clinic.open_thursday == 1">Thursday</li>
                                        <li v-if="clinic.open_friday == 1">Friday</li>
                                        <li v-if="clinic.open_saturday == 1">Saturday</li>
                                    </ul>

                                </td>
                                <td>@{{ clinic.from_time }} - @{{ clinic.to_time }}</td>
                                <td>@{{ clinic.address }}</td>
                                <td><p data-placement="top" data-toggle="tooltip" title="Edit" ><button @click="editClinic(clinic)" class="btn btn-primary btn-xs" data-title="Edit clinic" data-toggle="modal" data-target="#edit-clinic-form" ><i class="fa fa-pencil-square-o fa-1" aria-hidden="true"></i></button></p></td>
                                <td><p data-placement="top" data-toggle="tooltip" title="Delete"><button @click="deleteClinic(clinic)" class="btn btn-danger btn-xs" ><i class="fa fa-trash fa-1" aria-hidden="true"></i></button></p></td>
                            </tr>
                    </template>
                </tbody>
                
        </table>

        <div class="clearfix"></div>

                
            </div> <!-- end table-responsive --> 

    </div>
    </div>
    </div>
</div>

<create-clinic-form :clinics="clinics" :doctor_id="'{{ Auth::user()->id }}'" ></create-clinic-form>
<edit-clinic-form :clinic="editableClinic"  :doctor_id="'{{ Auth::user()->id }}'"></edit-clinic-form>


@endsection




@section('javascripts')
    
    <script>

      var LATITUDE_ELEMENT_ID2 = "gmap_lat2";
      var LONGITUDE_ELEMENT_ID2 = "gmap_lng2";
      var MAP_DIV_ELEMENT_ID2 = "google_map2";

      var LATITUDE_ELEMENT_ID = "gmap_lat";
      var LONGITUDE_ELEMENT_ID = "gmap_lng";
      var MAP_DIV_ELEMENT_ID = "google_map";

      var DEFAULT_ZOOM_WHEN_NO_COORDINATE_EXISTS = 15;
      var DEFAULT_CENTER_LATITUDE = 7.4253268;
      var DEFAULT_CENTER_LONGITUDE = 124.5085753;
      var DEFAULT_ZOOM_WHEN_COORDINATE_EXISTS = 15;

      // This is the zoom level required to position the marker
      var REQUIRED_ZOOM = 15;

      google.load("maps", "2.x");

      // The google map variable
      var map = null;

      // The marker variable, when it is null no marker has been added
      var marker = null;

      function googleMapClickHandler(overlay, latlng, overlaylatlng) {

            if(map.getZoom() < REQUIRED_ZOOM) {
                alert("You need to zoom in more to set the location accurately." );
                return;
            }
            if(marker == null) {
                marker = new GMarker(latlng, {draggable:false});
                map.addOverlay(marker);
            }
            else {
                marker.setLatLng(latlng);
            }

            if($('#create-clinic-form').css('display') == 'block'){
                document.getElementById(LATITUDE_ELEMENT_ID).value = latlng.lat();
                document.getElementById(LONGITUDE_ELEMENT_ID).value = latlng.lng();
            }
            if($('#edit-clinic-form').css('display') == 'block'){
                document.getElementById(LATITUDE_ELEMENT_ID2).value = latlng.lat();
                document.getElementById(LONGITUDE_ELEMENT_ID2).value = latlng.lng();
            }
        }


        var childMixin = {

            mounted(){              
            },

            created: function() {
                this.fetchClinics('{!! Auth::user()->id !!}');
            },

            data: function(){
                return {
                    editableClinic : {}
                }
            },

            methods:{

                newClinic : function(){
                    map = new google.maps.Map2(document.getElementById(MAP_DIV_ELEMENT_ID));
                    map.addControl(new GLargeMapControl());
                    map.addControl(new GMapTypeControl());

                    map.setMapType(G_NORMAL_MAP);

                    var latitude = +document.getElementById(LATITUDE_ELEMENT_ID).value;
                    var longitude = +document.getElementById(LONGITUDE_ELEMENT_ID).value;

                    if(latitude != 0 && longitude != 0) {
                    //We have some sort of starting position, set map center and marker
                    map.setCenter(new google.maps.LatLng(latitude, longitude), DEFAULT_ZOOM_WHEN_COORDINATE_EXISTS);
                    var point = new GLatLng(latitude, longitude);
                    marker = new GMarker(point, {draggable:false});
                    map.addOverlay(marker);
                    } else {
                    // Just set the default center, do not add a marker
                    map.setCenter(new google.maps.LatLng(DEFAULT_CENTER_LATITUDE, DEFAULT_CENTER_LONGITUDE), DEFAULT_ZOOM_WHEN_NO_COORDINATE_EXISTS);
                    }

                    GEvent.addListener(map, "click", googleMapClickHandler);

                },

                editClinic : function(clinic){
                    this.editableClinic = clinic;

                    map = new google.maps.Map2(document.getElementById(MAP_DIV_ELEMENT_ID2));
                    map.addControl(new GLargeMapControl());
                    map.addControl(new GMapTypeControl());

                    map.setMapType(G_NORMAL_MAP);

                    var latitude = clinic.gmap_lat;// +document.getElementById(LATITUDE_ELEMENT_ID2).value;
                    var longitude = clinic.gmap_lng;// +document.getElementById(LONGITUDE_ELEMENT_ID2).value;
                
                    if(latitude != 0 && longitude != 0) {
                    //We have some sort of starting position, set map center and marker
                    map.setCenter(new google.maps.LatLng(latitude, longitude), DEFAULT_ZOOM_WHEN_COORDINATE_EXISTS);
                    var point = new GLatLng(latitude, longitude);
                    marker = new GMarker(point, {draggable:false});
                    map.addOverlay(marker);
                    } else {
                    // Just set the default center, do not add a marker
                    map.setCenter(new google.maps.LatLng(DEFAULT_CENTER_LATITUDE, DEFAULT_CENTER_LONGITUDE), DEFAULT_ZOOM_WHEN_NO_COORDINATE_EXISTS);
                    }

                    GEvent.addListener(map, "click", googleMapClickHandler);
                },


                deleteClinic : function(clinic){
                   var self = this; 
                   var editClinic = clinic;

                    swal({
                      title: 'Are you sure?',
                      text: "You won't be able to revert this!",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes, delete it!'
                    }).then(function (isConfirm) {

                      if(isConfirm){
                
                        self.$http.post('/api/clinic/delete/post', editClinic.id, function(data){
                          if(data == "success"){
                            
                                swal({
                                  title: 'Success!',
                                  text: 'Successfully deleted! ',
                                  showConfirmButton : false,
                                  timer: 1000,
                                  type : 'success',
                                }).then(
                                  function () {},
                                  function (dismiss) {
                                    if (dismiss === 'timer') {
                                      console.log('I was closed by the timer')
                                    }
                                  }
                                );

                            self.fetchClinics('{!! Auth::user()->id !!}');
                          }
                        });
             

                      }
                      else
                      {
                          swal("cancelled","Your categories are safe", "error");
                      }

                      
                    });

                },


            }
        };


      
    </script>
@endsection