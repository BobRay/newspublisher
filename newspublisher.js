//set local blank image
    Ext.BLANK_IMAGE_URL = '/gitclone/manager/assets/ext3/resources/images/default/s.gif';

//define function to be executed when page loaded

    Ext.onReady(function() {
        //define select handler
        var selectHandler = function(myDP, date) {
        //get the text field
        var field = document.getElementById('dateField');
        //add the selected date to the field
       field.value = date.format('Y-m-d');
       //field.value = date.format('[[++manager_date_format]]');
        //hide the date picker
        myDP.hide();
    };

//create the date picker
    var myDP = new Ext.DatePicker(
{
    startDay: 1,
    listeners: {
    'select':selectHandler
    }
}
);


//render the date picker
myDP.render('calendar');

//hide date picker straight away
myDP.hide();

//define click handler

var clickHandler = function() {
    //show the date picker
    myDP.show();
    return false;
};

//add listener for button click
Ext.EventManager.on('openCalendar', 'click', clickHandler);

});
