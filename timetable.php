    <?php
session_start();
include_once 'config.php';
$dbcon = new mysqli($host, $username, $pass, $database);

if (isset($_SESSION['userSession'])) { 
$uid = $_SESSION['userSession'] ;



$query = $dbcon->query("SELECT * FROM user WHERE UserID=".$_SESSION['userSession']);
$userRow=$query->fetch_array();

if($userRow['Admin'] == '0'){
    ?>
<style type="text/css">#adminPageLink{
display:none;
}</style>
<?php
}
}
else{ ?>
<style type="text/css">#adminPageLink{
display:none;
}</style>
<?php
}



$dbcon->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>
<?php if (isset($_SESSION['userSession'])) { echo $userRow['Fname']. "'s Timetable";} else { echo "UU Classmate"; } ?>
</title>
<link rel="shortcut icon" href="favicon.ico" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='stylesheet' href='fullcalendar/fullcalendar.min.css' />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<link rel='stylesheet' href='css/styles.css' />
<link rel='stylesheet' href='css/jquery.timepicker.css' />
<link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script src='scripts/jquery.timepicker.min.js'></script>
<script src='scripts/bootstrap-datepicker.js'></script>
<script src='scripts/datepair.js'></script>
<script src='scripts/jquery.timepicker.min.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container" id="pageContainer">
<div id="setting box" class="topcorner">
</div>
    <div id="pageBanner">
      <img id="bannerLogo" src="images/UULogo.png">
      <div id="bannerText"><h1> Class Mate </h1></div>
    </div>
<div id="loginNav">
<?php if (isset($_SESSION['userSession'])) { echo "<p>Welcome, " . $userRow['Fname'] . "! <a href='logout.php?logout'>Logout</a></p> ";} else { echo "<a href='login.php?login'>Sign in! </a> Don't have an account? Register <a href='register.php?register'> now! </a>"; } ?>
</div>
<div id="adminPageLink" class="adminFunction">
<a href="admin.php"><button id="adminButton" class="btn-xs btn-primary">Admin</button></a>
</div>
<br>
<br>
<div class="jumbotron" id="modules">
    <div id="yearSelect">
    <p> Select Year </p>
        <label><input type="radio" name="year" value="1"> 1</label>
        <label><input type="radio" name="year" value="2"> 2</label>
        <label><input type="radio" name="year" value="4"> 4</label>
    </div>
    
    <div id="year1" class="moduleList">
    <p>Select modules: </p>
        <input type="checkbox" id="cbCOM180" store="checkbox1" class="chk" />
        <label for="cbCOM180">COM180</label>
    </div>
    
    <div id="year2" class="moduleList">
    <p>Select your modules: </p>
        <input type="checkbox" id="cbCOM337" store="checkbox2" class="chk" />
        <label for="cbCOM337">COM337</label>
    </div>
    <div id="year4" class="moduleList">
    <p>Select your modules: </p>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM554" store="checkbox3" class="chk" />
            <label for="cbCOM554">COM554</label> 
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM548" store="checkbox4"  class="chk" />
            <label for="cbCOM548">COM548</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM606" store="checkbox5" class="chk" />
            <label for="cbCOM606">COM606</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM562" store="checkbox6" class="chk" />
            <label for="cbCOM562">COM562</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM583" store="checkbox7" class="chk" />
            <label for="cbCOM583">COM583</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM641" store="checkbox8" class="chk" />
            <label for="cbCOM641">COM641</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM582" store="checkbox9" class="chk" />
            <label for="cbCOM582">COM582</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM577" store="checkbox10" class="chk" />
            <label for="cbCOM577">COM577</label>
        </span>
        <span class="moduleOption">
            <input type="checkbox" id="cbCOM527" store="checkbox11" class="chk" />
            <label for="cbCOM527">COM527</label>
        </span>
    </div>

</div>

<div id="weekNoTitle">
</div>
<div id='calendar'>
</div>
<div id="createEventModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">

    <?php
    include_once 'config.php';
    $dbcon = new mysqli($host, $username, $pass, $database);

    if (isset($_SESSION['userSession'])) { 
        $uid = $_SESSION['userSession'] ;
     ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
        <h3 id="myModalLabel1"> Create your own event</h3>
    </div>
    <form action="insert.php" method="post" id="userEventForm" class="form-horizontal">
 <div class="modal-body">
      <input type="hidden" name="userEventUid" value="<?php echo"$uid";?>">
        
          <div id="eventDateTime">
            <div class="form-group row">
              <label class="col-sm-1 control-label" for="userEventName">Title:</label>
              <div class="col-sm-11">
                <input class="form-control" type="text" name="userEventName" placeholder="Required" required id="userEventName">
              </div>
            </div>
            
            <div class="form-group row">
              <label class="col-sm-1 control-label" for="timeStart">Starts:</label>
              <div class="col-sm-2">
               <input type="text" class="form-control time start" name="timeStart" id="timeStart" />
              </div>
              <label class="col-xs-1 control-label" for="dateStart">on:</label>
              <div class="col-sm-3">
                <input type="text" class="form-control date start" name="dateStart" id="dateStart"/>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-1 control-label" for="timeEnd">Ends:</label>
              <div class="col-sm-2">
               <input type="text" class="form-control time end" name="timeEnd" id="timeEnd" />
              </div>
              <label class="col-xs-1 control-label" for="dateEnd">on:</label>
              <div class="col-sm-3">
                <input type="text" class="form-control date end" name="dateEnd" id="dateEnd"/>
              </div>            
            </div>
            <div class="form-group row">
              <label class="col-sm-1 control-label" for="userEventDescription">Info:</label>
              <div class="col-sm-11">
                <textarea class="form-control" type="text" name="userEventDescription" id="userEventDescription" rows="3" placeholder="Optional"></textarea>
              </div>
            </div>
          </div>
    </div>


    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
    </div>
    </form>

<?php
}
else{ ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
        <h3>Sorry...</h3>
    </div>
    <div class="modal-body">

    <p> But you must either sign in or register an account  to add events! </p>



    </div>
    <div class="modal-footer">
    <div class="form-group">
   <a style="float:left;" href="login.php" class="btn btn-default" name="btn-login" id="btn-login">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
   </a> 
       <a href="register.php" class="btn btn-default" style="float:right;">Register Now </a>
    </div>
    </div>
<?php
}



$dbcon->close();

?>

    </div>
    </div>
</div>


<div id="fullCalModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
        <h4 id="modalTitle" class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div id="modalBody">
        </div>
      </div>
      <div class="modal-footer">
      <span id="modalFooter"> </span>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
</div>



<script type="text/javascript">

//Delcaring range start and end dates for recurring events
var repeatingEvents; 

var getEvents = function( start, end ){
    return repeatingEvents;
}

//Forcing time axis at h:15 (bugfix)
function TimeFix(durationInMinutes, minTime) {
        var hour = moment(minTime, "HH:mm");
        $(".fc-body .fc-slats table tr").each(function (index) {
            $(this).find("td.fc-widget-content").eq(0).html("<span>" + hour.format("HH:mm") + "</span>")
            hour.add(durationInMinutes, "minutes");
        });     
}



$('#calendar').fullCalendar({
    defaultDate: moment(),
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listMonth,month,agendaWeek,agendaDay'

    },

    slotLabelFormat:'h(:15)a',
    defaultView: 'agendaWeek',
    allDaySlot: false,
    minTime: "09:15",
    maxTime: "18:15",
    slotDuration: "01:00:00",
    weekends: false,
    nowIndicator: true,
    weekNumbers: true,
    weekNumberCalculation: getWeekNumber,
    height: 'auto',
    selectable: true,
    defaultTimedEventDuration: '01:00:00',
    eventOverlap: false,
    slotEventOverlap: false,

    //Using ranges for recurring events

    eventRender: function(event, element, view){
        if(event.ranges){
        console.log(event.start.format());
        return (event.ranges.filter(function(range){
            return (event.start.isBefore(range.end) &&
                    event.end.isAfter(range.start));
        }).length)>0;
    }
    },

    eventClick:  function(event, jsEvent, view) {

         if(event.moduleCode) { $('#modalTitle').html(event.moduleCode + " " + event.classType + "- " + moment(event.start).format('dddd Do MMM h:mm A') + "- " + moment(event.end).format('h:mm A'));
            $('#modalBody').html('<div> ' + event.moduleCode + " " + event.moduleName + '</div>  <div> <p> Lecturer: ' + event.lecturer + '</p> </div> <div> <p> Room: ' + event.classRoom + '</p> </div> <div> <p>' + moment(event.start).format('h:mm A') + "- " + moment(event.end).format('h:mm A')+ '</p> </div> <div> <p>' + event.classType +   ' </p> </div>');
            $('#modalFooter').html('');
        }
        else if(event.holiday) {$('#modalTitle').html(event.title  + "- " +  moment(event.start).format('dddd Do MMMM'));
             $('#modalBody').html(event.description);
             $('#modalFooter').html('');  
         }
         else{
            $('#modalTitle').html(event.title);
            if(event.end != null){
             $('#modalBody').html('<b>' + moment(event.start).format('dddd Do MMM h:mm A') + "- " + moment(event.end).format('h:mm A')+ '</b> <p> ' + event.description + '</p>'); 
             }else{
                $('#modalBody').html('<b>' + moment(event.start).format('dddd Do MMM h:mm A') + '</b> <p> ' + event.description + '</p>'); 
             }
             $('#modalFooter').html('<a href="delete.php?eid=' + event.id + '"><button type="button" class="btn btn-danger" style="float:left">Delete</button></a>');

         }

            $('#fullCalModal').modal();
        },

    viewRender: function(view, element){

    },

    select: function(start, end, allDay) {

          startdate = $.fullCalendar.moment(start).format("YYYY-MM-DD");
          starttime = $.fullCalendar.moment(start).format("HH:mm");
          enddate = $.fullCalendar.moment(end).format("YYYY-MM-DD");
          endtime = $.fullCalendar.moment(end).format("HH:mm");

        $('#createEventModal').modal('show');

        $('#eventDateTime .time').timepicker({
        'timeFormat': 'H:i',
        'minTime': '09:15' ,
        'step': 5,
        'forceRoundTime': true,
        'maxTime': '18:15',        
    });
        $('#timeStart').timepicker('setTime', starttime);

    $('#eventDateTime .date').datepicker({
        'format': 'yyyy-mm-dd',
        'autoclose': true
    });
      $('#dateStart').datepicker('setDate', startdate);

    // initialize datepair
    var eventdatetimeEl = document.getElementById('eventDateTime');
    var datepair = new Datepair(eventdatetimeEl);
       }, 


    //eventSource for each module
    eventSources: ["userEvents.php", "EventListHolidays.php"],


    //Forcing time axis at h:15 (bugfix)
    viewRender: function (view, element) {
    TimeFix(60, "09:15:00");    

}



});

//Bug fix - Event sources not loading on refresh with local storage and session
window.onload = function() {
    $('#calendar').fullCalendar('prev');
    $('#calendar').fullCalendar('next');
};

   //Resizing agendaView slot size (bugfix)
    $('.fc-view-agendaWeek > div > div').css('overflow-y', 'hidden'); $('.fc-agenda-gutter').css('width', 0);





//Selecting year radio displays modules for that year
$(document).ready(function () {

    $("input[name$='year']").click(function() {
        var test = $(this).val();
        $("div.moduleList").hide();
        $("#year" + test).css('display', 'inline-block');
        $("div.moduleList input[type=checkbox").each(function () {
                if($(this).is(":checked")){
                $(this).trigger('click');
            }

            });
    });
});


//Custom week number function
function getWeekNumber(d) {
    // Copy date so don't modify original
    d = new Date(+d);
    d.setHours(0,0,0,0);
    // Set to nearest Thursday: current date + 4 - current day number
    // Make Sunday's day number 7
    d.setDate(d.getDate() + 4 - (d.getDay()||7));
    // Get first day of year
    var yearStart = new Date(d.getFullYear(),0,1);
    // Calculate full weeks to nearest Thursday
    var weekNo = Math.ceil(( ( (d - yearStart) / 86400000) + 1)/7);
    // Return array of year and week number


    //semester 2 dates are ISO week number - 5
    if (weekNo >= 5 && weekNo <= 18){
       var uniWeekNo = weekNo - 4;
       var semester = 2;
       return [uniWeekNo + '- S' + semester];

    //semester 1 dates are ISO week number - 38  
    } else if(weekNo >= 39 && weekNo <= 50){
        var uniWeekNo = weekNo - 38;
        var semester = 1;
        return [uniWeekNo + ' S' + semester];

    //weeks off timetable    
    } else{
        uniWeekNo = null;
        semester = 0;
        return ["0- Off"];
    }

};


//Saving year radio in local storage
$(document).ready(function(){
  var radios = document.getElementsByName("year");
  var val = localStorage.getItem('year');
  for(var i=0;i<radios.length;i++){
    if(radios[i].value == val){ 
      radios[i].click();

    }
  }
  $('input[name="year"]').on('change', function(){
    localStorage.setItem('year', $(this).val());

  
  });

//Saving chosen modules to local storage
  var boxes = document.querySelectorAll("input[type='checkbox']");

  for (var i = 0; i < boxes.length; i++) {
    var box = boxes[i];
    if (box.hasAttribute("store")) {
      setupBox(box);
    }
  }

  function setupBox(box) {
    var storageId = box.getAttribute("store");
    var oldVal = localStorage.getItem(storageId);
    $(box).on("change", function() {
      localStorage.setItem(storageId, this.checked);
    });
    box.checked = oldVal === "true" ? true : false;
    if (box.checked) {
      $(box).trigger('change');

    }
  }

});

    
    //COM554 Checkbox removing/adding COM554 classes
    $("#cbCOM554").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM554.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM554.php' );
    }

});

    //COM548 Checkbox removing/adding COM548 classes
    $("#cbCOM548").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM548.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM548.php' );
    }

});

        //COM582 Checkbox removing/adding COM582 classes
    $("#cbCOM582").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM582.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM582.php' );
    }

});

        //COM583 Checkbox removing/adding COM583 classes
    $("#cbCOM583").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM583.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM583.php' );
    }

});    

        //COM606 Checkbox removing/adding COM606 classes
    $("#cbCOM606").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM606.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM606.php' );
    }

});

        //COM577 Checkbox removing/adding COM577 classes
    $("#cbCOM577").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM577.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM577.php' );
    }

});

        //COM527 Checkbox removing/adding COM577 classes
    $("#cbCOM527").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM527.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM527.php' );
    }

});

        //COM562 Checkbox removing/adding COM562 classes
    $("#cbCOM562").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM562.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM562.php' );
    }

});    

        //COM641 Checkbox removing/adding COM641 classes
    $("#cbCOM641").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM641.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM641.php' );
    }

});

            //COM180 Checkbox removing/adding COM180 classes
    $("#cbCOM180").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM180.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM180.php' );
    }

});

        //COM337 Checkbox removing/adding COM337 classes
    $("#cbCOM337").change(function() {
    if(this.checked) {
      $('#calendar').fullCalendar( 'addEventSource',  'EventListCOM337.php' );
    }
    else{
    $('#calendar').fullCalendar( 'removeEventSource',  'EventListCOM337.php' );
    }

});




</script>   
</body>
</html>
