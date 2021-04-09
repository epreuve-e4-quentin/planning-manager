
//Pour chaque double cliques sur une ligne (une entité) du tableau
function dynamicPopup(nameElement, areaId){
  $(document).on('dblclick', nameElement, function (e) {
       const url = $(this).data("href"); //Récupération de la data url edit de l'entité concerné
     
       axios.get(url).then(function(response){
         $("#"+areaId).html(response.data.htmlContent); //Récupération et Affichage de la vue édition employé dans le modal
       });
   })
  ;
}

