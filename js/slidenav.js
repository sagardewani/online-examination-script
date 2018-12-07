     function initMenu() {
		// console.log("init");
      $('#menu ul').hide();
      $('#menu ul').children('.current').parent().show();
      //$('#menu ul:first').show();
      $('#menu li a').click(
        function() {
          var checkElement = $(this).next();
          if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            return false;
            }
          if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('#menu ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
            return false;
            }
          }
        );
      }
	  $(function(){
	var m_modal = $('#msgBox'),
					m_body= $("#msgText"),
					m_title = $('#msgTitle');
					initMenu();

		
		
		
		 $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
     $("#menu-toggle-2").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled-2");
        $('#menu ul').hide();
    });			
		$('#addusernavigation').on('click',function(e){
			e.preventDefault();
			if($("#dashboard").hasClass("active"))$("#dashboard").removeClass("active");
			else if($("#view").hasClass("active"))$("#view").removeClass("active");
			else if($("#papereditor").hasClass("active"))$("#papereditor").removeClass("active");
			else if($("#activate").hasClass("active"))$("#activate").removeClass("active");
			$("#add").addClass("active");
			//$(this).addClass("active");
			$.ajax({
				url:'page1.php',
				cache:false,
				success: function(data){
					removejscssfile("js/admin_functions.js?v=1.5","js");
					loadjscssfile("js/functions.js?v=2.1", "js");
					removejscssfile("js/functions_page2.js?v=1.0","js");
					//removejscssfile("js/functions_page3.js","js");
					$('#pages').html(data);
				}
			});
		});
	  });