

$( document ).ready(function() {




 //  $('.products').hover(function(){
  //   var s= "#" + this.id;
 //   alert(this.id);
//},function(){
    
//});
//$(this).closest('.box').children('.something1')

$(".products").mouseenter(function() {
    $(this).css("overflow", "visible").css("position","relative");

}).mouseleave(function() {
     $(this).css("overflow", "hidden").css("position","static");
});


});

var slideWidth=1370;
var sliderTimer;
$(function(){
$('.slidewrapper').width($('.slidewrapper').children().size()*slideWidth);
    sliderTimer=setInterval(nextSlide,3000);
    $('.viewport,.dot').hover(function(){
        clearInterval(sliderTimer);
    },function(){
        sliderTimer=setInterval(nextSlide,3000);
    });
    $('#next_slide').click(function(){
        clearInterval(sliderTimer);
        nextSlide();
        sliderTimer=setInterval(nextSlide,3000);
    });
    $('#prev_slide').click(function(){
        clearInterval(sliderTimer);
        prevSlide();
        sliderTimer=setInterval(nextSlide,3000);
    });
    $('.dot').click(function(){
        $('.dot.active').removeClass('active');
        $(this).addClass('active');
        var n=$('.dot').index(this);
        certainSlide(n);
    });
});

function nextSlide(){
    var currentSlide=parseInt($('.slidewrapper').data('current'));
    currentSlide++;
    if(currentSlide>=$('.slidewrapper').children().size())
    {
        currentSlide=0;   
    }
    $('.dot.active').removeClass('active');
    $('.dot').eq(currentSlide).addClass('active');
    $('.slidewrapper').animate({left: -currentSlide*slideWidth},1600).data('current',currentSlide);
}

function prevSlide(){
    var currentSlide=parseInt($('.slidewrapper').data('current'));
    currentSlide--;
    if(currentSlide<0)
    {
        currentSlide=$('.slidewrapper').children().size()-1;   
    }
    $('.dot.active').removeClass('active');
    $('.dot').eq(currentSlide).addClass('active');
    $('.slidewrapper').animate({left: -currentSlide*slideWidth},1600).data('current',currentSlide);
}

function certainSlide(n){
    var currentSlide=n;
    $('.slidewrapper').animate({left: -currentSlide*slideWidth},1600).data('current',currentSlide);
}




/*Функции для скрытия отображения товара 
(скрытие отображение div)*/


function hideDiv(){
    $(".hide").click(function(){
    var s= "#" + this.parentNode.id;
    $(s).hide();
});
}
function showDiv(){
    $(".show").click(function(){
    alert(this.parentNode.id);
});
}

