$(document).ready(function(){
  

  $("#select-image").msDropDown();
  $("#cancel-login").click(function(){
      $("#anonymous-login-panel").hide();
  });
  
});

function show_anonymous_login(){
     $("#anonymous-login-panel").show();
     $("#user-name").focus();
     return false;
}
function validate_anonymous_login(){
    
    if($("#user-name").val() == ''){
        alert('Внесете Име');
        return false;
    }
    
    
    return true;
}