<script type="text/javascript">
$(document).ready(function(){

    /* Original code by Gregor Šekoranja */

    /*chunk properties */
    var activeButton = '[[+activeButton]]'.toLowerCase();

    /* JSON is validated in snippet */
    var buttonsJsonStr = JSON.stringify([[+buttonsJson]]);
    var buttonsJson = (buttonsJsonStr) ? $.parseJSON(buttonsJsonStr) : null;



  /* CONTINUE if JSON IS not null and IS object */
  if ( (buttonsJson != null) && (typeof buttonsJson == 'object') ){


    /* html for filter buttons */
    var htmlButtons = '';


    /* *************
     CLASSES AND IDS
    ************** */

    /* id for container of filter buttons */
    var filterId = 'filters';

    /* buttons classes */
    var buttonPrefixClass = 'btn-';
    var filterSelected = 'filterSelected';

    /* items classes */
    var filterItemClass = 'filter-item'; //items (having this class) to be shown or hide on filter button click
    var hiddenClass = 'hidden'; //hidden class


    /* *************
     JQ SELECTORS
    ************** */
    /* ignore NewsPublisher's own form inputs */
    var excludeItems = $('.buttons, [name="np_existing"], [name="np_doc_id"], #hidSubmit');
    /* the main container - the NewsPublisher form */
    var form = $('form#newspublisherForm');
     /* element after which buttons will be inserted */
    var insertAfterElement = $('h2#newspublisherHeader').eq(0);


    /* *************
     the code
    ************** */

    /* by default no filter button is selected */
    var jsonFieldsCount = 0; /* used to determine if "Other" option is shown */
    var hasFilterSelected = false;

    $.each(buttonsJson, function(buttonName, aFields) {
       var buttonClass = buttonPrefixClass + buttonName; /* criterion for filtering items */
       var aClass = '';
       if (activeButton==buttonName.toLowerCase()){ /* if button label matches to activeButton property */
         aClass = filterSelected;
         hasFilterSelected = true;
       }
       htmlButtons += '<li style="padding:0;margin:0;"><a class="' +  aClass  + '" data-filter=".' + buttonClass + '" href="#">' + buttonName + '</a></li>';
       $.each(aFields, function(index, fieldName) {
        /* find that element by name (name can be fieldName or fieldName[]) */
        var field = $('[name^="' + fieldName + '"]:last');
        if (field.length > 0){
          /* OK, got it */
          var parent = field;
          while ( parent.parent().get(0).nodeName.toLowerCase() != 'form') {
            parent = parent.parent();

          }
          jsonFieldsCount++;
          parent.addClass(filterItemClass);
          parent.addClass(buttonClass);
          /* console.log('class added to: ' + parent.attr('id')); */
        } else {
          /* warn user */
          alert('[[%np_could_not_find_tab_field]]' + fieldName);
        }

       });
    });

    htmlButtons =   '<section id="options" class="clearfix" style="padding:0;margin:0;">' +
                       '<ul id="' + filterId + '" style="padding:0px;margin:0px; margin-top:10px;">' +
                          htmlButtons +
                    '<li id="other-filter" style="padding:0px;margin:0px;"><a data-filter="!*" href="#">[[%np_tabs_other]]</a></li>' +
                    '<li style="padding:0;margin:0;"><a data-filter="*" href="#" class="' + (hasFilterSelected ? '' : filterSelected) + '">[[%np_tabs_show_all]]</a></li>' +
                        '</ul>' +
                    '</section>';

    /* ****************************
    /* insert filter buttons
    /******************************/

    /* insert filter buttons after insertAfterElement element */
    $(htmlButtons).insertAfter(insertAfterElement);

    /* ****************************
    /* apply filter
    /******************************/

    var filterItems = form.find('.' + filterItemClass);
    /* console.log('filter-items length: ' + filterItems.length);
    console.log(filterItems); */

    /* all form children (tabs property might not have all from elements included) */
    var formChildren = form.children().not(excludeItems);

    var filters_a = $('#' + filterId + ' a');
    filters_a.click(function(){
      var selector = $(this).data('filter');
      console.log(selector);

      if (selector == '*') { /* Show All */
          formChildren.removeClass('hidden');
      }
      else if (selector == '!*') { /* uncategorized/other tab */
        formChildren.addClass(hiddenClass);
        formChildren.not('.' + filterItemClass).removeClass(hiddenClass);
      }
      else { /* custom button /class */
        formChildren.addClass(hiddenClass);
        formChildren.filter(selector).removeClass(hiddenClass);
      }

      $('#' + filterId + ' a.' + filterSelected).removeClass(filterSelected);
      $(this).addClass(filterSelected);
      return false;
    });
    /* hide "Other" btn if no need to show it */
    /* alert ('Children: ' + formChildren.length + ' --- FieldsCount: '  + jsonFieldsCount); */
     if (formChildren.length == jsonFieldsCount){
        $('#other-filter').addClass('hidden');
}
    /* trigger click on active button */
    if (hasFilterSelected){
      filters_a.filter('.' + filterSelected).eq(0).trigger('click');
    }

  } else {
      alert('[[%np_invalid_tabs]]');
  }


});
</script>
