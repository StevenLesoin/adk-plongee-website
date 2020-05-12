$(document).ready(function() {
			$('select').formSelect();
			
			
			// Datepicker lié à la date limite d'inscription. On ne règle pas de date par défaut car elle va être réglée par le datepicker 1 lors de la saisie du champ
			$(".datepicker2").datepicker({
    			format: "dd-mm-yyyy",
				autoClose: true,
				firstDay: 1
  			});
				
			// Datepicker appelé pour la date de l'événement et qui va setter la date limite d'inscription à la veille (Par défaut)
			$(".datepicker3").datepicker({
				autoClose: true,
				format: "dd-mm-yyyy",
				firstDay: 1,
				minDate:new Date(),
				setDefaultDate:new Date(), 
				onSelect: function(dater) {	// Jusque là ça marche
					var veille = new Date();
					veille.setDate(dater.getDate()-1);
					var dd = veille.getDate();
					var mm = veille.getMonth()+1; 
					var yyyy = veille.getFullYear();

					if(dd<10) 
					{
						dd='0'+dd;
					} 
					if(mm<10) 
					{
						mm='0'+mm;
					} 					
					$('.datepicker2').val(dd+'-'+mm+'-'+yyyy);
					$('.datepicker2').datepicker('setDate',veille);
				}
  			});
			
			$(".datepicker4").datepicker({
				autoClose: true,
				format: "dd-mm-yyyy",
				firstDay: 1
  			});
			
  			$(".button-collapse").sideNav();
			$(".dropdown-trigger").dropdown();
			
			$(".datepicker").datepicker({
				format: "dd-mm-yyyy"
  			});
			
			$('.parallax').parallax();
        
});