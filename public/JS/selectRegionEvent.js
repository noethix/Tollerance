//JAVASCRIPT NATIF
    function changerRegion(){
		
		var selectElem = document.getElementById('event_eventsRegion');
        var donnees = selectElem.selectedIndex;
        
        if (selectElem.options[donnees].value!='') {

        $.getJSON(
            "departments/"+selectElem.options[donnees].value, function( data ) {
                
                $('#event_eventsDepartement').empty();
                $("#event_eventsDepartement").append('<option value="">Département</option>');
                var obj = jQuery.parseJSON( data );  

                for (var i=0;i<obj.length;i++) {     
                    $("#event_eventsDepartement").append('<option value="'+obj[i].idDepartment+'">'+obj[i].nameDepartment+'</option>');

                }
            });
        } 
        else {
            $('#event_eventsDepartement').empty();
            $("#event_eventsDepartement").append('<option value="">Département</option>');
        }
    }
	
	    // JQUERY 
    $(document).ready(function() {
        
        $( "#event_eventsRegion" ).change(function() {
            changerRegion();
          });

    } );