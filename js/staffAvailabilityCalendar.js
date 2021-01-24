(function($) {
    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }

    $.fn.markyourcalendar = function(opts) {
        var currentDate = new Date(); // get current date
        var first = currentDate.getDate() - currentDate.getDay(); // First day is the day of the month - the day of the week
        var firstday = new Date(currentDate.setDate(first));
        var defaults = {
            availability: [[], [], [], [], [], [], []],
            isMultiple: false,
            selectedDates: [],
            startDate: firstday,
            weekdays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday'],
        };
        var settings = $.extend({}, defaults, opts);
        var instance = this;

        // kuhanin at ipakita ang mga araw
        this.getDaysHeader = function() {
            var tmp = ``;
            for (i = 0; i < 7; i++) {
                tmp += `
                    <div class="myc-date-header" id="myc-date-header-` + i + `">
                        <div class="myc-date-display">` + settings.weekdays[i] + `</div>
                    </div>
                `;
            }
            var ret = `<div id="myc-dates-container">` + tmp + `</div>`;
            return ret;
        }

        // kuhanin ang mga pwedeng oras sa bawat araw ng kasalukuyang linggo
        this.getAvailableTimes = function() {
            var tmp = ``;
            for (i = 0; i < 7; i++) {
                var tmpAvailTimes = ``;
                $.each(settings.availability[i], function() {
                    tmpAvailTimes += `
                        <p class="myc-available-time" data-time="` + this + `"">
                            ` + this + `
                        </p>
                    `;
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

        // clear
        this.clearAvailability = function() {
            settings.availability = [[], [], [], [], [],[],[]];
        }

        var render = function() {
            ret = `
                <div id="myc-container">
                    <div id="myc-week-container">
                        <div id="myc-dates-container">` + instance.getDaysHeader() + `</div>
                        <div id="myc-available-time-container">` + instance.getAvailableTimes() + `</div>
                    </div>
                </div>
            `;
            instance.html(ret);
        };

        render();
    };
})(jQuery);