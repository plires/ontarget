// Nav
$(function() {
    $(".toggle").on("click", function() {

        if ($(".navigation").hasClass("active")) {
            $(".navigation").removeClass("active")
            $(this).addClass("fa-bars")
            $(this).removeClass("fa-times")
        } else {
            $(".navigation").addClass("active")
            $(this).removeClass("fa-bars")
            $(this).addClass("fa-times")
            // $(this).html("<i class='fas fa-times'></i>")
        }

    })
})
// Nav end