    //JAVASCRIPT NATIF
    function changerRegion(){
        var selectElem = document.getElementById('registration_usersRegion');
        var donnees = selectElem.selectedIndex;
        
        if (selectElem.options[donnees].value!='') {

        $.getJSON(
            "departments/"+selectElem.options[donnees].value, function( data ) {
                
                $('#registration_usersDepartment').empty();
                $("#registration_usersDepartment").append('<option value="">Département</option>');
                var obj = jQuery.parseJSON( data );  

                for (var i=0;i<obj.length;i++) {     
                    $("#registration_usersDepartment").append('<option value="'+obj[i].idDepartment+'">'+obj[i].nameDepartment+'</option>');

                }
            });
        } 
        else {
            $('#registration_usersDepartment').empty();
            $("#registration_usersDepartment").append('<option value="">Département</option>');
        }
    }
    
    function changerDepartement(){
        var selectElem = document.getElementById('registration_usersRegion');
        var selectElem2 = document.getElementById('registration_usersDepartment');
        var donnees = selectElem.selectedIndex;
        var donnees2 = selectElem2.selectedIndex;
        
        parent.location.href = 'user/inscription/new?region='+selectElem.options[donnees].value+'&department='+selectElem2.options[donnees2].value;
    }
        // JQUERY 
    $(document).ready(function() {
        
        $( "#registration_usersRegion" ).change(function() {
            changerRegion();
          });

    } );