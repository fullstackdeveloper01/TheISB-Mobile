@stack('top_scripts')
<script src="{{ asset('assets/vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/toastr/toastr.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset('assets/js/user/application.js') }}"></script>
<script src="{{ asset('assets/js/extra/extra.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_KEY') }}&libraries=places&callback=initialize" async defer></script>
<script type="text/javascript">
    $("#full_address").on('focus', function () {
        geolocate();
    });
     
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'street_number',
        route: 'route',
        locality: 'locality',
        administrative_area_level_1: 'administrative_area_level_1',
        country: 'country',
        postal_code: 'postal_code'
    };
     
    function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
        /** @type  {HTMLInputElement} */ (document.getElementById('full_address')), {
            types: ['geocode'],
            componentRestrictions: {country: "it"} // Restictions for country city
        });
     
      //autocomplete.setComponentRestrictions({'country': 'AE'});
     
        // populate the address fields in the form.
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            fillInAddress();
        });  
       
    }
     
    function fillInAddress() {
        var place = autocomplete.getPlace();
        $("#full_address").val(place.formatted_address);
        $("#latitude").val(place.geometry.location.lat());
        $("#longitude").val(place.geometry.location.lng());
         
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }
    }

    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = new google.maps.LatLng(
                position.coords.latitude, position.coords.longitude);

                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                document.getElementById("latitude").value = latitude;
                document.getElementById("longitude").value = longitude;

                autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
                //autocomplete.setComponentRestrictions({'country': 'UAE'});
            });
        }
    }

    $(document).ready(function () {
        initialize();
    });
</script> 
<script>
    let avatarInput = $('#contact_person_image'),
        targetedImagePreview = $('#contact_person_image_preview');
    avatarInput.on('change', function() {
        var file = true,
            readLogoURL;
        if (file) {
            readLogoURL = function(input_file) {
                if (input_file.files && input_file.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        targetedImagePreview.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input_file.files[0]);
                }
            }
        }
        readLogoURL(this);
    });
</script>
<script>
    function amenitiesStatus(checkboxElem, aid) {
        var status = 0;
        if (checkboxElem.checked) {
            status = 1;
        } else {
            status = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = {
            status: status,
            amenity_id: aid,
        };
        var ajaxurl = 'marinasAmenitiesUpdate';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                toastr.success(data, '', []);
            },
            error: function (data) {
                
            }
        });
    }

    function featuredAmenitiesStatus(checkboxElem, aid) {
        var status = 0;
        if (checkboxElem.checked) {
            status = 1;
        } else {
            status = 0;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = {
            status: status,
            amenity_id: aid,
        };
        var ajaxurl = 'marinasFeaturedAmenitiesUpdate';
        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                toastr.success(data, '', []);
            },
            error: function (data) {
                
            }
        });
    }
</script>
@toastr_render
@stack('scripts')
