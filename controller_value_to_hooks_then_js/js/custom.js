(function ($, Drupal, drupalSettings) {

    Drupal.behaviors.MyModuleBehavior = {
      attach: function (context, settings) {
        
        var mydata = drupalSettings.mydata;

        var basePath = drupalSettings.path.baseUrl;
        //alert(basePath);

        $('.testjs').click(function(event) {
          event.preventDefault();

          var argone ="hi";
          var argtwo ="there";
          var url = basePath + 'test_for_ajax_callback/' + argone + '/' + argtwo;
						$.getJSON(url, 
							function(data) {

                console.log(data);
                //alert(data);
                $('#mydiv').hide();

					  });

        });

      }
    };

  })(jQuery, Drupal, drupalSettings);