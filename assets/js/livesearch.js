 jQuery(document).ready(function(){

    function liveSearch() {

                var input_data = $('#search_data').val();
                if (input_data.length === 0) {
                    $('#suggestions').hide();
                } else {


                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>index.php/livesearch/search",
                        data: {search_data: input_data},
                        success: function (data) {
                            // return success
                            if (data.length > 0) {
                                $('#suggestions').show();
                                $('#autoSuggestionsList').addClass('auto_list');
                                $('#autoSuggestionsList').html(data);
                            }
                        }
                    });
                }
            }
            
            
            $('#boton_cargar').click(function(){
                cargar("Pepe");
            });
            
            
            function cargar(param1) {  
                $('#div_dinamico_anim').html("Hola " + param1);  
            }
            
            $('body').on('click', '.solTitle', function() {
                cargar( "Otro." + $(this).attr('rel') );
            });

});