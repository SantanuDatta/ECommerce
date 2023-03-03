<script>
    //Showing Saved locations From Database
    var savedCountryId = "{{ $savedCountryId }}";
    var savedDivisionId = "{{ $savedDivisionId }}";
    var savedDistrictId = "{{ $savedDistrictId }}";

    //Trggering and Changing
    $("#country_id").val(savedCountryId);
    $("#country_id").trigger("change");
    $("#divisions").val(savedDivisionId);
    $("#divisions").trigger("change");
    $("#districts").val(savedDistrictId);

    //Ajax for trigger change
    $('#country_id').on('change', function() {
        var country = $('#country_id').val();
        // Make All The Division As Null
        $('#divisions').html("");
        var option = "";
        $.get("/divisions/" + country, function(data) {
            data = JSON.parse(data);
            data.forEach(function(value) {
                option += "<option value='" + value.id + "'>" + value.name + "</option>";
            });
            $('#divisions').html(option);
            $('#divisions').trigger('change');
        });
    });

    $('#divisions').on('change', function() {
        var division = $('#divisions').val();
        // Make All The District As Null
        $('#districts').html("");
        var option = "";
        $.get("/districts/" + division, function(data) {
            data = JSON.parse(data);
            data.forEach(function(value) {
                option += "<option value='" + value.id + "'>" + value.name + "</option>";
            });
            $('#districts').html(option);
        });
    });
    $('#country_id').trigger('change');
</script>
