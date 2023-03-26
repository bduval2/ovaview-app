(function($) {

	"use strict";

	// Setup the calendar with the current date
$(document).ready(function(){

    

    setTimeout(function() {
        var date = new Date();
        var today = date.getDate();
        // Set click handlers for DOM elements
        $(".right-button").click({date: date}, next_year);
        $(".left-button").click({date: date}, prev_year);
        $(".month").click({date: date}, month_click);
        $("#add-button").click({date: date}, new_event);
        // Set current month as active
        $(".months-row").children().eq(date.getMonth()).addClass("active-month");
        init_calendar(date);
        var events = check_events(today, date.getMonth()+1, date.getFullYear());
        show_events(events, months[date.getMonth()], today);
   }, 1000);
    
});

// function startCalendar(){
//     var date = new Date();
//     var today = date.getDate();
//     // Set click handlers for DOM elements
//     $(".right-button").click({date: date}, next_year);
//     $(".left-button").click({date: date}, prev_year);
//     $(".month").click({date: date}, month_click);
//     $("#add-button").click({date: date}, new_event);
//     // Set current month as active
//     $(".months-row").children().eq(date.getMonth()).addClass("active-month");
//     init_calendar(date);
//     var events = check_events(today, date.getMonth()+1, date.getFullYear());
//     show_events(events, months[date.getMonth()], today);
// };



// Initialize the calendar by appending the HTML dates
function init_calendar(date) {
    $(".tbody").empty();
    $(".events-container").empty();
    var calendar_days = $(".tbody");
    var month = date.getMonth();
    var year = date.getFullYear();
    var day_count = days_in_month(month, year);
    var row = $("<tr class='table-row'></tr>");
    var today = date.getDate();
    // Set date to 1 to find the first day of the month
    date.setDate(1);
    var first_day = date.getDay();
    // 35+firstDay is the number of date elements to be added to the dates table
    // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
    for(var i=0; i<35+first_day; i++) {
        // Since some of the elements will be blank, 
        // need to calculate actual date from index
        var day = i-first_day+1;
        // If it is a sunday, make a new row
        if(i%7===0) {
            calendar_days.append(row);
            row = $("<tr class='table-row'></tr>");
        }
        // if current index isn't a day in this month, make it blank
        if(i < first_day || day > day_count) {
            var curr_date = $("<td class='table-date nil'>"+"</td>");
            row.append(curr_date);
        }   
        else {
            var curr_date = $("<td class='table-date'>"+day+"</td>");
            var events = check_events(day, month+1, year);
            if(today===day && $(".active-date").length===0) {
                curr_date.addClass("active-date");
                show_events(events, months[month], day);
            }
            // If this date has any events, style it with .event-date
            if(events.length!==0) {
                curr_date.addClass("event-date");
            }
            // Set onClick handler for clicking a date
            curr_date.click({events: events, month: months[month], day:day}, date_click);
            row.append(curr_date);
        }
    }
    // Append the last row and set the current year
    calendar_days.append(row);
    $(".year").text(year);
}

// Get the number of days in a given month/year
function days_in_month(month, year) {
    var monthStart = new Date(year, month, 1);
    var monthEnd = new Date(year, month + 1, 1);
    return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);    
}

// Event handler for when a date is clicked
function date_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    $(".active-date").removeClass("active-date");
    $(this).addClass("active-date");
    show_events(event.data.events, event.data.month, event.data.day);
};

// Event handler for when a month is clicked
function month_click(event) {
    $(".events-container").show(250);
    $("#dialog").hide(250);
    var date = event.data.date;
    $(".active-month").removeClass("active-month");
    $(this).addClass("active-month");
    var new_month = $(".month").index(this);
    date.setMonth(new_month);
    init_calendar(date);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()+1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
    $("#dialog").hide(250);
    var date = event.data.date;
    var new_year = date.getFullYear()-1;
    $("year").html(new_year);
    date.setFullYear(new_year);
    init_calendar(date);
}

// Event handler for clicking the new event button
function new_event(event) {
    // if a date isn't selected then do nothing
    if($(".active-date").length===0)
        return;
    // remove red error input on click
    $("input").click(function(){
        $(this).removeClass("error-input");
    })
    // empty inputs and hide events
    $("#dialog input[type=checkbox]").prop('checked',false);
    $("#dialog input[type=radio]").prop('checked',false);
    document.getElementById("note").value = "";
    $(".events-container").hide();
    $("#dialog").show();
    // Event handler for cancel button
    $("#cancel-button").click(function() {
        $("#mood").removeClass("error-input");
        $("#count").removeClass("error-input");
        $("#dialog").hide();
        $(".events-container").show();
    }); 


    // Event handler for ok button
    $("#ok-button").unbind().click({date: event.data.date}, function() {

        console.log("OK BUTTON PRESSED LOLLLL");
        var date = event.data.date;

        var mood = "";
        if (document.getElementById('Happy').checked) {
            mood = "Happy"
        }
        else if (document.getElementById('Sad').checked) {
            mood = "Sad"
        }
        else if (document.getElementById('Angry').checked) {
            mood = "Angry"
        }
        else {
            mood = "Anxious"
        }

        var symptoms = "";
        if (document.getElementById('Spotting').checked) {
            symptoms += "Spotting "
        }
        if (document.getElementById('Hunger').checked) {
            symptoms += "Hunger "
        }
        if (document.getElementById('Ovulation-pain').checked) {
            symptoms += "Ovulation-pain "
        }
        if (document.getElementById('Diarrhea').checked) {
            symptoms += "Diarrhea "
        }
        if (document.getElementById('Acne').checked) {
            symptoms += "Acne "
        }
        if (document.getElementById('Irritability').checked) {
            symptoms += "Irritability "
        }
        if (document.getElementById('Bloated').checked) {
            symptoms += "Bloated "
        }
        if (document.getElementById('Gas').checked) {
            symptoms += "Gas "
        }
 

        var note = $("#note").val();
        var day = parseInt($(".active-date").html());
        // Basic form validation
        $("#dialog").hide();
        console.log("new event");
        new_event_json(mood, symptoms, note, date, day);
        date.setDate(day);
        init_calendar(date);

        
    });
}

// Adds a json event to event_data
function new_event_json(mood, symptoms, note, date, day) {
    var event = {
        "mood": mood,
        "symptoms": symptoms,
        "note": note,
        "year": date.getFullYear(),
        "month": date.getMonth()+1,
        "day": day
    };
    event_data["events"].push(event);

    var dataString = JSON.stringify(event);

    // Sending the data to the php file to store in the back end
    $.ajax({
        url: "dashboard.php",
        method: "POST",
        data: {myData:dataString},
        success: function(response) {
          // handle server response here


        },
        error: function(error) {
          // handle error here


        }
    });
}

// Display all events of the selected date in card views
function show_events(events, month, day) {
    // Clear the dates container
    $(".events-container").empty();
    $(".events-container").show(250);
    // If there are no events for this date, notify the user
    if(events.length===0) {
        var event_card = $("<div class='event-card'></div>");
        var event_name = $("<div class='event-name'>There are no entries for "+month+" "+day+".</div>");
        $(event_card).css({ "border-left": "10px solid #FF1744" });
        $(event_card).append(event_name);
        $(".events-container").append(event_card);
    }
    else {
        // Go through and add each event as a card to the events container
        for(var i=0; i<events.length; i++) {
            var event_card = $("<div class='event-card row flex-lg g-5 py-5' style='display:flex; padding: 20px!important; margin:0px!important;'></div>");
            var first_col = $("<div class='col-12 col-sm-12 col-lg-6' style='margin-top:0px!important;'></div>");
            var mood_entry = $("<div class='vstack gap-2'> <h4>Mood</h4> </div>");

            // If we decide to go back to having text under image, fix this:

            // var event_mood = $("<div class='vstack gap-2' align-items-center><img src='./images/moods/"+events[i]["mood"]+".png' class='img-fluid' alt='test' style='width: 90px;'></img><p>"+events[i]["mood"]+"</p></div></div>");
            
            var event_mood = $("<img src='./images/moods/"+events[i]["mood"]+".png' class='img-fluid' alt='test' style='width: 90px;'></img>");
            var symptoms_entry_container = $("<div class='vstack gap-2'> <h4>Symptoms</h4> </div>");
            var symptoms_entry = $("<div class='hstack gap-2'></div>");
            var second_col = $("<div class='col-12 col-sm-12 col-lg-6' style='margin-top:0px!important;'> <h4> Notes</h4> </div>");
            var note_entry = $("<div style='background-color: #FFF6FE; border-radius: 15px; padding: 3%;'></div>");
            var event_note = $("<div class='event-name'><p>"+events[i]["note"]+"</p></div>");
            if(events[i]["cancelled"]===true) {
                $(event_card).css({
                    "border-left": "10px solid #FF1744"
                });
                event_count = $("<div class='event-cancelled'>Cancelled</div>");
            }

            const symptoms = events[i]["symptoms"].split(" ");

            // If we decide to go back to having text under image, fix this:

            // for(var j = 0, length = symptoms.length; j < length; j++){
            //     if(symptoms[j]!= ""){
            //         if(symptoms[j] == "Ovulation-pain"){
            //             $(symptoms_entry).append($("<div class='vstack gap-2 align-items-center'><img src='./images/symptoms/"+symptoms[j]+".png' class='img-fluid' alt='test' style='height: 50px;'><p>Ovu Pain</p></div></img>"));
            //         }
            //         else{
            //             $(symptoms_entry).append($("<div class='vstack gap-2 align-items-center'><img src='./images/symptoms/"+symptoms[j]+".png' class='img-fluid' alt='test' style='height: 50px;'><p>"+symptoms[j]+"</p></div></img>"));
            //         }
            //     }
            // }

            for(var j = 0, length = symptoms.length; j < length; j++){
                if(symptoms[j]!= ""){
                    $(symptoms_entry).append($("<img src='./images/symptoms/"+symptoms[j]+".png' class='img-fluid' alt='test' style='height: 50px;'></img>"));
                }
            }

            $(symptoms_entry_container).append(symptoms_entry);

            $(mood_entry).append(event_mood);
            $(first_col).append(mood_entry).append(symptoms_entry_container);

            // Creating the second col
            $(note_entry).append(event_note);
            $(second_col).append(note_entry);

            // Putting it all together in the card!
            $(event_card).append(first_col).append(second_col);
            $(".events-container").append(event_card);
        }
    }
}

// Checks if a specific date has any events
function check_events(day, month, year) {
    var events = [];
    for(var i=0; i<event_data["events"].length; i++) {
        var event = event_data["events"][i];
        if(event["day"]===day &&
            event["month"]===month &&
            event["year"]===year) {
                events.push(event);
            }
    }
    return events;
}

const months = [ 
    "January", 
    "February", 
    "March", 
    "April", 
    "May", 
    "June", 
    "July", 
    "August", 
    "September", 
    "October", 
    "November", 
    "December" 
];

})(jQuery);
