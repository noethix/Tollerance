//JAVASCRIPT NATIF
    function changerRegion(){
		
		var selectElem = document.getElementById('activite_Region');
        var donnees = selectElem.selectedIndex;
        
        if (selectElem.options[donnees].value!='') {

        $.getJSON(
            "departments/"+selectElem.options[donnees].value, function( data ) {
                
                $('#activite_Departement').empty();
                $("#activite_Departement").append('<option value="">Département</option>');
                var obj = jQuery.parseJSON( data );  

                for (var i=0;i<obj.length;i++) {     
                    $("#activite_Departement").append('<option value="'+obj[i].idDepartment+'">'+obj[i].nameDepartment+'</option>');

                }
            });
        } 
        else {
            $('#activite_Departement').empty();
            $("#activite_Departement").append('<option value="">Département</option>');
        }
    }
	
	    // JQUERY 
    $(document).ready(function() {
        
        $( "#activite_Region" ).change(function() {
            changerRegion();
          });

    } );