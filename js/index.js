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
let from = 0;
let to = 0;
function saveResult(data) {
  from = data.from;
  to = data.to;
};
function inicializarSlider(){
  $("#rangoPrecio").ionRangeSlider({
    type: "double",
    grid: false,
    min: 0,
    max: 100000,
    from: 200,
    to: 80000,
    onStart: (dataSlider) => {
      saveResult(dataSlider);
    },
    onChange: saveResult,
    prefix: "$"
  });
}



inicializarSlider();
inicializarFiltros();


$('.button').click((e)=>{
  solicitud('index.php','POST',{action:e.target.id},(data)=>{
    document.getElementById("contenido").innerHTML = data;
  },(error)=>{
    console.log(`Error al enviar petición ${e.target.id}`);
    console.log(error);
  })  
});


function inicializarFiltros(){
  solicitud('index.php','POST',{action:"initFiltros"},(data)=>{
    document.getElementById("selectCiudad").innerHTML += JSON.parse(data).ciudades;
    document.getElementById("selectTipo").innerHTML += JSON.parse(data).tipos;
  },(error)=>{
    console.log(`Error al enviar petición de inicializar filtros`);
    console.log(error);
  });
}

$('#formulario').submit((e)=>{
  e.preventDefault();
  filtro={
    "fromSlide":from,
    "toSlide":to
  }
  
  solicitud('index.php','POST',{action:'filtro',filtro},(data)=>{
    document.getElementById("contenido").innerHTML = data;
  },(error)=>{
    console.log(`Error al enviar petición de filtros`);
    console.log(error);
  });
  
})


function solicitud(url,type,data,success,error){
  $.ajax({
    url: url,
    type: type,
    data: data,
    success: success,
    error: error,
   });  
}