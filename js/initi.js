  document.write("Debug 0!");

(function($){
	 document.write("1");
  $(function(){
    $('.sidenav').sidenav();
    $(".dropdown-button").dropdown();
	$('.dropdown-trigger').dropdown();
	$('select').formSelect();
  }); // end of document ready
  
  
	 document.write("2");
})(jQuery); // end of jQuery name space


document.write("3");
