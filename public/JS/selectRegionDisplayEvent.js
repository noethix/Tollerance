//JAVASCRIPT NATIF
    function changerRegion(){
		
		var selectElem = document.getElementById('display_event_eventsRegion');
        var donnees = selectElem.selectedIndex;
        
        if (selectElem.options[donnees].value!='') {

        $.getJSON(
            "departments/"+selectElem.options[donnees].value, function( data ) {
                
                $('#display_event_eventsDepartement').empty();
                $("#display_event_eventsDepartement").append('<option value="">Département</option>');
                var obj = jQuery.parseJSON( data );  

                for (var i=0;i<obj.length;i++) {     
                    $("#display_event_eventsDepartement").append('<option value="'+obj[i].idDepartment+'">'+obj[i].nameDepartment+'</option>');

                }
            });
        } 
        else {
            $('#display_event_eventsDepartement').empty();
            $("#display_event_eventsDepartement").append('<option value="">Département</option>');
        }
    }
	
	    // JQUERY 
    $(document).ready(function() {
        
        $( "#display_event_eventsRegion" ).change(function() {
            changerRegion();
            $("form[name='display_event']").submit();
          });
          $( "#display_event_eventsDepartement" ).change(function() {
            
            $("form[name='display_event']").submit();
          });
    } );