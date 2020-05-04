$(document).ready(function() {
			$('select').formSelect();
			$(".datepicker").datepicker({
    			format: "dd-mm-yyyy",
				autoClose: true,
				firstDay: 1,
				minDate:new Date(),
				setDefaultDate:new Date()
				
  			});
			
			$(".datepicker2").datepicker({
    			format: "dd-mm-yyyy",
				autoClose: true,
				firstDay: 1,
				minDate: new Date(),
				setDefaultDate:new Date()
				
  			});
			
			
  			$(".button-collapse").sideNav();
			$(".dropdown-trigger").dropdown();
        
});