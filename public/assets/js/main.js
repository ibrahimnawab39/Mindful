$(document).ready(function () {
    // Theme function
    let cuurentTheme = localStorage.getItem('theme');
    if (cuurentTheme != null) {
        $('html').attr('theme', cuurentTheme);
    }
        if (cuurentTheme == 'lightTheme') {  
     
        $('.showLight').show()
        $('.showdark').hide()

    } else {
        $('.showdark').show()
        $('.showLight').hide()
    }

    
    
    $(".right-images-slider").slick({
        dots: true,
        infinite: true,
        autoplay:true,
        arrows: false,
        speed: 2000,
        slidesToShow: 1,
        slidesToScroll: 1,
    });
    
    $(".dashpoardslider").slick({
        dots: true,
        infinite: true,
        autoplay:true,
        arrows: false,
        speed: 2000,
        slidesToShow: 1,
        slidesToScroll: 1,
    });
    $('.nav-tabs > li a[title]').tooltip();
    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target);
        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });
   
    $(".prev-step").click(function (e) {
        let complete = $('.nav-tabs .completeTab');
        let count = complete.attr('data-count');
        complete.removeClass('completeTab').find('.round-tab').html(count);
        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);

    });
})
    
   function nextFunction(e) {
       if($('#step1').hasClass('active')){
              e.preventDefault()
       }
           var active = $('.wizard .nav-tabs li.active'); 
        $('.tab-pane.active input').each(function(i){
            console.log(i)
            if($(this).val() == null){
               return toastr.warning("Please complete the field before proceeding to the next step.");
            }
        });
        
        active.addClass('completeTab').find('.round-tab').html('<i class="fa fa-solid fa-check"></i>')
        active.next().removeClass('disabled');
        nextTab(active);
       
   }
     $(".next-step").click(function (e) {

         nextFunction(e)

    });
   $("body").on("keydown", function(event) {
        // Check if the pressed key is Enter (key code 13)
        if (event.keyCode === 13 && $('#step1').hasClass('active')) {
            nextFunction(event)
        }
      });


// Theme Button 
$(document).on('click', '.switch-icon-button', function () {
    let cuurentTheme = $('html').attr('theme');
    if (cuurentTheme == 'lightTheme') {
        $('html').attr('theme', 'darkTheme');
        localStorage.setItem('theme', 'darkTheme');
           $('.showdark').show()
        $('.showLight').hide()
    } else {
        $('html').attr('theme', 'lightTheme');
        localStorage.setItem('theme', 'lightTheme');
        
        $('.showLight').show()
        $('.showdark').hide()
    }
})
// ------------step-wizard-------------
function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
$('.nav-tabs').on('click', 'li', function () {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});
