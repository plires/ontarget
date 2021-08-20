const nav = document.getElementById('nav');

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

function headerScroll() {
    if ($(document).scrollTop() > nav.offsetHeight) {
      $("#nav").addClass("fixed");
    } else {
      $("#nav").removeClass("fixed");
    }
}

/* Scroll header */
$(window).scroll(function() {
    headerScroll()
});

headerScroll()

AOS.init();