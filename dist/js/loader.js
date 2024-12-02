/* window.addEventListener('load', () => {
  const contenedor_loader = document.querySelector('.contenedor')
  contenedor_loader.style.opacity = 0
  contenedor_loader.style.visibility = 'hidden'
}) */

function generateLoader(container){
  let loader = '<div class="container-loader"> ';
  loader += '<div class="loader"></div> ';
  loader += '<span class="text-loader">Cargando...</span> ';
  loader += '</div>';
  $(container).append(loader);
}

function getLoader(){
  let loader = '<div class="container-loader"> ';
  loader += '<div class="loader"></div> ';
  loader += '<span class="text-loader">Cargando...</span> ';
  loader += '</div>';
  return loader;
} 