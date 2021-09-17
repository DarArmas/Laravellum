
var url = 'http://localhost:8080/portafolio/laravellum/public/';
//este evento se desata al cargar la página
window.addEventListener("load", function(){
    //ESTO ES JQUERY
    //
 //class        atributo     valor
   //$('body').css('background', 'gray');
   
   
   
   $('.btn-like').css('cursor', 'pointer');
   $('.btn-dislike').css('cursor', 'pointer');
   
   
   
   //Boton de like
   function like(){
         $('.btn-like').unbind('click').click(function(){
       console.log('like');
       $(this).addClass('btn-dislike').removeClass('btn-like');
       $(this).attr('src', url+'/img/heart-red.png');
       
       //peticion ajax: me sirve para enviar y recibir datos al servidor sin recargar la pagina
       $.ajax({
                            //$(this) -> a lo que le di like
           url: url+'/like/'+$(this).data('id'), //recuerda que esta funcion me regresa una response->json
           type: 'GET',
           success: function(response){
               if(response.like){
                   console.log('Has dado like a la publicacion');
               }else{
                   console.log('Error al dar like')
               }
               
           }
       });
       
       dislike(); //los bindeos del click se acumulan
   }); 
   }

    like();
   
   
   //Boton de dislike
   function dislike(){
        $('.btn-dislike').unbind('click').click(function(){
       console.log('dislike');
       $(this).addClass('btn-like').removeClass('btn-dislike');
       $(this).attr('src', url+'/img/heart-black.png');
       
         $.ajax({
                            //$(this) -> a lo que le di like
           url: url+'/dislike/'+$(this).data('id'), 
           type: 'GET',
           success: function(response){
               if(response.like){ //la funcion en mi controlador solo  me regresa el objeto like si no hubo errores
                   console.log('Has dado dislike a la publicacion');
               }else{
                   console.log('Error al dar like')
               }
               
           }
       });
       
       
       like();
   });
   }
   
   dislike();
   
   
   //BUSCADOR (esto es JQuery)
   //cuando se mande el submit del form con id "buscador"   
   $('#buscador').submit(function(){
       //    from action="http://proyecto-laravel:8080/gente/nombre"
      $(this).attr('action', url+'/gente/'+$('#buscador #search').val()); 
   });
    
});