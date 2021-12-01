(function ($) {
    "use strict";

    /* 
    ------------------------------------------------
    Sidebar open close animated humberger icon
    ------------------------------------------------*/

    $(".hamburger").on('click', function () {
        $(this).toggleClass("is-active");
    });


    /*  
    -------------------
    List item active
    -------------------*/
    $('.header li, .sidebar li').on('click', function () {
        $(".header li.active, .sidebar li.active").removeClass("active");
        $(this).addClass('active');
    });

    $(".header li").on("click", function (event) {
        event.stopPropagation();
    });

    $(document).on("click", function () {
        $(".header li").removeClass("active");

    });



    /*  
    -----------------
    Chat Sidebar
    ---------------------*/


    var open = false;

    var openSidebar = function () {
        $('.chat-sidebar').addClass('is-active');
        $('.chat-sidebar-icon').addClass('is-active');
        open = true;
    }
    var closeSidebar = function () {
        $('.chat-sidebar').removeClass('is-active');
        $('.chat-sidebar-icon').removeClass('is-active');
        open = false;
    }

    $('.chat-sidebar-icon').on('click', function (event) {
        event.stopPropagation();
        var toggle = open ? closeSidebar : openSidebar;
        toggle();
    });




    




    /* TO DO LIST 
    --------------------*/
    $(".tdl-new").on('keypress', function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            var v = $(this).val();
            var s = v.replace(/ +?/g, '');
            if (s == "") {
                return false;
            } else {
                $(".tdl-content ul").append("<li><label><input type='checkbox'><i></i><span>" + v + "</span><a href='#' class='ti-close'></a></label></li>");
                $(this).val("");
            }
        }
    });


    $(".tdl-content a").on("click", function () {
        var _li = $(this).parent().parent("li");
        _li.addClass("remove").stop().delay(100).slideUp("fast", function () {
            _li.remove();
        });
        return false;
    });

    // for dynamically created a tags
    $(".tdl-content").on('click', "a", function () {
        var _li = $(this).parent().parent("li");
        _li.addClass("remove").stop().delay(100).slideUp("fast", function () {
            _li.remove();
        });
        return false;
    });



    /*  Chat Sidebar User custom Search
    ---------------------------------------*/

    $('[data-search]').on('keyup', function () {
        var searchVal = $(this).val();
        var filterItems = $('[data-filter-item]');

        if (searchVal != '') {
            filterItems.addClass('hidden');
            $('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
        } else {
            filterItems.removeClass('hidden');
        }
    });


    /*  Chackbox all
    ---------------------------------------*/

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });


    /*  Data Table
    -------------*/

    $(document).on('change', '.subcategory_status_change ', function() {
        if ($(this).is(":checked")) {
            var visibility = '1';

        } else {
            var visibility = '0';
        }
        var id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'id': id,
                'visibility': visibility
            },
            success: function(data) {
                data = JSON.parse(data);
                if(data && data.success){
                    $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "success");
                }else {
                    $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "error");
                }
                
            },
            error: function(xhr){
                $.NotificationApp.send(xhr.status, xhr.responseText, "top-right", "rgba(0,0,0,0.2)", "error");
            }
        });
    });

   

    $(document).on('change', '.restaurant_status_change ', function() {
        if ($(this).is(":checked")) {
            var visibility = '1';

        } else {
            var visibility = '0';
        }
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url:url,
            data: {
                'id': id,
                'visibility': visibility
            },
            success: function(data) {
                data = JSON.parse(data);
                if(data && data.success){
                    $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "success");
                }else {
                    $.NotificationApp.send("", data.message, "top-right", "rgba(0,0,0,0.2)", "error");
                }
                
            },
            error: function(xhr){
                $.NotificationApp.send(xhr.status, xhr.responseText, "top-right", "rgba(0,0,0,0.2)", "error");
            }
        });
    });



})(jQuery);