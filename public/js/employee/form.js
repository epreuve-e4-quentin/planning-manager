$(document).ready(function() {
  
    if(document.getElementById("checkenddate").checked == true){
      $("#endDate").show();
    } else {
      $("#endDate").hide();
    }
    
});

function checkCheckBox(idCheck){
    if(document.getElementById(idCheck).checked == true){
      $("#endDate").show();
    }
    else{
      $("#endDate").hide();
   }
}