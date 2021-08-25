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

// Validacion del Formulario
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();