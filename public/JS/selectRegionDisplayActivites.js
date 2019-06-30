//JAVASCRIPT NATIF
function changerRegion(){
		
    var selectElem = document.getElementById('display_activites_region');
    var donnees = selectElem.selectedIndex;
    
    if (selectElem.options[donnees].value!='') {

    $.getJSON(
        "departments/"+selectElem.options[donnees].value, function( data ) {
            
            $('#display_activites_departement').empty();
            $("#display_activites_departement").append('<option value="">Département</option>');
            var obj = jQuery.parseJSON( data );  

            for (var i=0;i<obj.length;i++) {     
                $("#display_activites_departement").append('<option value="'+obj[i].idDepartment+'">'+obj[i].nameDepartment+'</option>');

            }
        });
    } 
    else {
        $('#display_activites_departement').empty();
        $("#display_activites_departement").append('<option value="">Département</option>');
    }
}

    // JQUERY 
$(document).ready(function() {
    
    $( "#display_activites_region" ).change(function() {
        changerRegion();
        $("form[name='display_activites']").submit();
      });
      $( "#display_activites_departement" ).change(function() {
        
        $("form[name='display_activites']").submit();
      });
} );