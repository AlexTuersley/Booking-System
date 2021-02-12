/*!
 * Author:  Mark Allan B. Meriales
 * Name:    Mark Your Calendar v0.0.1
 * License: MIT License
 */

(function($) {
    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }

    $.fn.markyourcalendar = function(opts) {
        var curr = new Date(); // get current date
        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        var firstday = new Date(curr.setDate(first));
        var prevHtml = `
            <div id="myc-prev-week">
                <
            </div>
        `;
        var nextHtml = `<div id="myc-next-week">></div>`;
        var defaults = {
            availability: [[], [], [], [], [], [], []],
            bookings:[],
            isMultiple: false,
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            prevHtml: prevHtml,
            nextHtml: nextHtml,
            selectedDates: [],
            startDate: firstday,
            weekdays: ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        };
        var settings = $.extend({}, defaults, opts);
        var html = ``;

        var onClick = settings.onClick;
        var onClickNavigator = settings.onClickNavigator;
        var instance = this;

        // Get the name of the Month
        this.getMonthName = function(idx) {
            return settings.months[idx];
        };
        //Make the date display in a certain way
        var formatDate = function(d) {
            var date = '' + d.getDate();
            var month = '' + (d.getMonth() + 1);
            var year = d.getFullYear();
            if (date.length < 2) {
                date = '0' + date;
            }
            if (month.length < 2) {
                month = '0' + month;
            }
            return date + '/' + month + '/' + year;
        };

        // Controller to change 
        this.getNavControl = function() {
            var previousWeekHtml = ``;
            var nextWeekHtml = ``;
            var curr = new Date(); // get current date
            var first = curr.getDate() - curr.getDay();
            var firstDay = new Date(curr.setDate(first));
            var nextDay = new Date(settings.startDate.addDays(1));
            var monthYearHtml = `
                <div id="myc-current-month-year-container">
                    ` + this.getMonthName(settings.startDate.getMonth()) + ' ' + settings.startDate.getFullYear() + `
                </div>
            `;
            if(settings.startDate.getTime() > firstDay.getTime()){
                previousWeekHtml = `<div id="myc-prev-week-container">` + settings.prevHtml + `</div>`;
            }
            else{
                previousWeekHtml = `<div id='myc-prev-week-container'></div>`;
            }
            
            if(firstDay.addDays(30).getTime() > nextDay.getTime()){
                nextWeekHtml = `<div id="myc-next-week-container">` + settings.nextHtml + `</div>`;
            }
            else{
                nextWeekHtml = `<div id="myc-next-week-container"></div>`;
            }

            var navHtml = `
                <div id="myc-nav-container">
                    ` + previousWeekHtml + `
                    ` + monthYearHtml + `
                    ` + nextWeekHtml + `
                    <div style="clear:both;"></div>
                </div>
            `;
            return navHtml;
        };

        this.getDatesHeader = function() {
            var tmp = ``;
            for (i = 0; i < 7; i++) {
                var d = settings.startDate.addDays(i);
                tmp += `
                    <div class="myc-date-header" id="myc-date-header-` + i + `">
                        <div class="myc-date-number">` + d.getDate() + `</div>
                        <div class="myc-date-display">` + settings.weekdays[d.getDay()] + `</div>
                    </div>
                `;
            }
            var ret = `<div id="myc-dates-container">` + tmp + `</div>`;
            return ret;
        }

        this.getAvailableTimes = function() {
            var tmp = ``;
            var today = new Date();    
           
           
                     

            for (i = 0; i < 7; i++) {
                var tmpAvailTimes = ``;
                
                $.each(settings.availability[i], function() {  
                    var booked = 0;
                    var newDate = new Date(settings.startDate.addDays(i).toDateString()+" "+ this);
                    
                    
                   
                    
                    for(j = 0; j < settings.bookings.length; j++){                        
                        if(newDate.getTime() / 1000 >= parseInt(settings.bookings[j][0]) && newDate.getTime() / 1000 < parseInt(settings.bookings[j][1])){
                            booked = 1;
                        }
                    }
                    if(newDate.getTime() > today.getTime() && booked == 0){
                        tmpAvailTimes += `
                        <a href="javascript:;" class="myc-available-time" data-time="` + this + `" data-date="` + formatDate(settings.startDate.addDays(i)) + `">
                            ` + this + `
                        </a>
                    `;
                    }                
                });
               
                tmp += `
                    <div class="myc-day-time-container" id="myc-day-time-container-` + i + `">
                        ` + tmpAvailTimes + `
                        <div style="clear:both;"></div>
                    </div>
                `;
            }    
            return tmp
        }

        this.setAvailability = function(arr) {
            settings.availability = arr;
            render();
        }

        this.setBookings = function(arr) {
            settings.bookings = arr;
            render();
        }

        this.clearAvailability = function() {
            settings.availability = [[], [], [], [], [], [], []];
        }

        this.on('click', '#myc-prev-week', function() {
            settings.startDate = settings.startDate.addDays(-7);
            instance.clearAvailability();
            render(instance);

            if ($.isFunction(onClickNavigator)) {
                onClickNavigator.call(this, ...arguments, instance);
            }
        });

        this.on('click', '#myc-next-week', function() {
            settings.startDate = settings.startDate.addDays(7);
            instance.clearAvailability();
            render(instance);
            if ($.isFunction(onClickNavigator)) {
                onClickNavigator.call(this, ...arguments, instance);
            }
        });

        this.on('click', '.myc-available-time', function() {
            var date = $(this).data('date');
            var time = $(this).data('time');
            var tmp = date + ' ' + time;
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                var idx = settings.selectedDates.indexOf(tmp);
                if (idx !== -1) {
                    settings.selectedDates.splice(idx, 1);
                }
            } else {
                if (settings.isMultiple) {
                    $(this).addClass('selected');
                    settings.selectedDates.push(tmp);
                } else {
                    settings.selectedDates.pop();
                    if (!settings.selectedDates.length) {
                        $('.myc-available-time').removeClass('selected');
                        $(this).addClass('selected');
                        settings.selectedDates.push(tmp);
                    }
                }
            }
            if ($.isFunction(onClick)) {
                onClick.call(this, ...arguments, settings.selectedDates);
            }
        });

        var render = function() {
            ret = `
                <div id="myc-container">
                    <div id="myc-nav-container">` + instance.getNavControl() + `</div>
                    <div id="myc-week-container">
                        <div id="myc-dates-container">` + instance.getDatesHeader() + `</div>
                        <div id="myc-available-time-container">` + instance.getAvailableTimes() + `</div>
                    </div>
                </div>
            `;
            instance.html(ret);
           
        };
        
        render();
    };
})(jQuery);