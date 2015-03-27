/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// /public/js/custom.js

jQuery(function($) {
    $("#create").on('click', function(event){
        event.preventDefault();
        var $stickynote = $(this);
        $.post("stickynotes/add", null,
            function(data){
                if(data.response == true){
                    $stickynote.before("<div class=\"sticky-note\"><textarea id=\"stickynote-"+data.new_note_id+"\"></textarea><a href=\"#\" id=\"remove-"+data.new_note_id+"\"class=\"delete-sticky\">X</a></div>");
                // print success message
                } else {
                    // print error message
                    console.log('could not add');
                }
            }, 'json');
    });

    $('#sticky-notes').on('click', 'a.delete-sticky',function(event){
        event.preventDefault();
        var $stickynote = $(this);
        var remove_id = $(this).attr('id');
        remove_id = remove_id.replace("remove-","");

        $.post("stickynotes/remove", {
            id: remove_id
        },
        function(data){
            if(data.response == true)
                $stickynote.parent().remove();
            else{
                // print error message
                console.log('could not remove ');
            }
        }, 'json');
    });
    
    $('#sticky-notes').on('keyup', 'textarea', function(event){
        var $stickynote = $(this);
        var update_id = $stickynote.attr('id'),
        update_content = $stickynote.val();
        update_id = update_id.replace("stickynote-","");

        $.post("stickynotes/update", {
            id: update_id,
            content: update_content
        },function(data){
            if(data.response == false){
                // print error message
                console.log('could not update');
            }
        }, 'json');

    });
    $('.datepicker').datepicker({
        /*dateFormat: "yy-mm-dd",*/
        dateFormat: "dd.mm.yy",
        addSliderAccess: true,
        firstDay: 1,
        changeMonth: true, 
        changeYear: true, 
        yearRange: '1900:2015',
	sliderAccessArgs: { touchonly: false },
        /*beforeShow: function(input, inst) {
            if($(input).val() == '') {
                $(input).val('15.04.1978');
            }
        }*/
    });
    $('.datetimepicker').datetimepicker({
        timeFormat: "HH:mm:ss",
        dateFormat: "yy-mm-dd",
        addSliderAccess: true,
	sliderAccessArgs: { touchonly: false }
    });
    
    /*$('#TnC').on('click', 'a.TnC-show', function(event) {
        event.preventDefault();
        $.get("/info/terms", function(data) {
            $("#TnC-container").html(data);
            $("#TnC-container").show();
            alert( "Load was performed.");
        });
    });*/
    /*$('#participant').change(function() {
        location.reload();
    });*/
    $.cookieCuttr({
        cookieAnalytics: false,
        cookieMessage: 'We use cookies on this website, you can <a href="{{cookiePolicyLink}}" title="read about our cookies" target="_blank">read about them here</a>. To use the website as intended please...',
        cookiePolicyLink: '/info/cookie'
    });
    
    $( "#person-detail" ).tabs({
        create: function( event, ui ) {
            $( "#person-detail" ).find('input').prop('disabled', true);
            $( "#person-detail" ).find('select').prop('disabled', true);
            ui.panel.find('input').prop('disabled', false);
            ui.panel.find('select').prop('disabled', false);
        },
        /*activate: function( event, ui ) {},*/
        beforeActivate: function( event, ui ) {
            $( "#person-detail" ).find('input').prop('disabled', true);
            $( "#person-detail" ).find('select').prop('disabled', true);
            ui.newPanel.find('input').prop('disabled', false);
            ui.newPanel.find('select').prop('disabled', false);
        }
    });
});