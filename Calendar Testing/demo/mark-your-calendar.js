/*!
 * Author:  Mark Allan B. Meriales
 * Name:    Mark Your Calendar v0.0.1
 * License: MIT License
 */

(function($) {
    // https://stackoverflow.com/questions/563406/add-days-to-javascript-date
    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }

    $.fn.markyourcalendar = function(opts) {
        var defaults = {
            availability: [[], [], [], [], [],],
            isMultiple: false,
            startDate: new Date(),
            selectedTimes: [],
            weekdays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
        };
        var settings = $.extend({}, defaults, opts);
        var onClick = settings.onClick;
        var instance = this;

        // kuhanin at ipakita ang mga araw
        this.getDaysHeader = function() {
            var tmp = ``;
            for (i = 0; i < 5; i++) {
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
                        <a href="javascript:;" class="myc-available-time" data-time="` + this + `" data-date="` + settings.startDate.addDays(i) + `">
                            ` + this + `
                        </a>
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
            settings.availability = [[], [], [], [], []];
        }

        // pag namili ng oras
        this.on('click', '.myc-available-time', function() {
            var time = $(this).data('time');
            var tmp =  time;
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
                var idx = settings.selectedTimes.indexOf(tmp);
                if (idx !== -1) {
                    settings.selectedTimes.splice(idx, 1);
                }
            } else {
                if (settings.isMultiple) {
                    $(this).addClass('selected');
                    settings.selectedTimes.push(tmp);
                } else {
                    settings.selectedTimes.pop();
                    if (!settings.selectedTimes.length) {
                        $('.myc-available-time').removeClass('selected');
                        $(this).addClass('selected');
                        settings.selectedTimes.push(tmp);
                    }
                }
            }
            if ($.isFunction(onClick)) {
                onClick.call(this, ...arguments, settings.selectedTimes);
            }
        });

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