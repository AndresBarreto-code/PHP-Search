/*
  Creación de una función personalizada para jQuery que detecta cuando se detiene el scroll en la página
*/
$.fn.scrollEnd = function(callback, timeout) {
  $(this).scroll(function(){
    var $this = $(this);
    if ($this.data('scrollTimeout')) {
      clearTimeout($this.data('scrollTimeout'));
    }
    $this.data('scrollTimeout', setTimeout(callback,timeout));
  });
};
/*
  Función que inicializa el elemento Slider
*/

function inicializarSlider(){
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    prefix: "$"
  });
}



inicializarSlider();



$('.button').click((e)=>{
  $.ajax({
    url: 'index.php',
    type: 'POST',
    data: {action:e.target.id},
    success: (data)=>{
      document.getElementById("contenido").innerHTML = data;
    },
    error: (error)=>{
      console.log(`Error al enviar petición`);
      console.log(error);
    },

  });  
});


function inicializarFiltro(){
  
}

$('#formulario').submit((e)=>{
  alert('ok');
})
