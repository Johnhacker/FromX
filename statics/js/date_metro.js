(function() {
    var $, Calendar, DAYS, DateRangePicker, MONTHS, TEMPLATE;
    $ = jQuery;
    DAYS = ['日', '一', '二', '三', '四', '五', '六'];
    MONTHS = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    TEMPLATE = "<div class=\"drp-popup\" style=\"display:none;\">\n  <div class=\"drp-timeline\">\n    <ul class=\"drp-timeline-presets\"></ul>\n    <div class=\"drp-timeline-bar\"></div>\n  </div>\n  <div class=\"drp-calendars\">\n    <div class=\"drp-calendar drp-calendar-start\">\n      <div class=\"drp-month-picker\">\n        <div class=\"drp-arrow\"><</div>\n        <div class=\"drp-month-title\"></div>\n        <div class=\"drp-arrow drp-arrow-right\">></div>\n      </div>\n      <ul class=\"drp-day-headers\"></ul>\n      <ul class=\"drp-days\"></ul>\n      <div class=\"frm_btn\"><input class=\"btn btn_rst\" type=\"button\" id='timex'  value=\"取消\"><input class=\"btn\" id='timeadd' type=\"button\" value=\"确定\"></div><input class=\"ipt_txt_xl drp-calendar-date\" id='start' type='text' readonly value=''/>\n    </div>\n    <div class=\"drp-calendar-separator\"></div>\n    <div class=\"drp-calendar drp-calendar-end\">\n      <div class=\"drp-month-picker\">\n        <div class=\"drp-arrow\"><</div>\n        <div class=\"drp-month-title\"></div>\n        <div class=\"drp-arrow drp-arrow-right\">></div>\n      </div>\n      <ul class=\"drp-day-headers\"></ul>\n      <ul class=\"drp-days\"></ul>\n      <input class=\"ipt_txt_xl drp-calendar-date\" type='text'  value='' id='end' readonly/>\n    </div>\n  </div>\n </div>";
    DateRangePicker = (function() {
        function DateRangePicker(a) {
            this.$select = a;
            this.$dateRangePicker = $(TEMPLATE);
            this.$select.attr('tabindex', '-1').before(this.$dateRangePicker);
            this.isHidden = true;
            this.customOptionIndex = this.$select[0].length - 1;
            this.initBindings();
            this.setRange(this.$select.val())
        }
        DateRangePicker.prototype.initBindings = function() {
            var c;
            c = this;
            this.$select.on('focus mousedown',
            function(e) {
                var a;
                a = this;
                setTimeout(function() {
                    return a.blur()
                },
                0);
                return false
            });
            this.$dateRangePicker.click(function(a) {
                return a.stopPropagation()
            });
            $('body').click(function(a) {
                if (a.target === c.$select[0] && c.isHidden) {
                    return c.show()
                } else if (!c.isHidden) {
                    return c.hide()
                }
            });
            this.$select.children().each(function() {
                return c.$dateRangePicker.find('.drp-timeline-presets').append($("<li class='" + ((this.selected && 'drp-selected') || '') + "'>" + ($(this).text()) + "<div class='drp-button'></div></li>"))
            });
            return this.$dateRangePicker.find('.drp-timeline-presets li').click(function(a) {
                var b;
                $(this).addClass('drp-selected').siblings().removeClass('drp-selected');
                b = $(this).index();
                c.$select[0].selectedIndex = b;
                c.setRange(c.$select.val());
                if (b === c.customOptionIndex) {
                    return c.showCustomDate()
                }
            })
        };
        DateRangePicker.prototype.hide = function() {
            this.isHidden = true;
            return this.$dateRangePicker.hide()
        };
        DateRangePicker.prototype.show = function() {
            this.isHidden = false;
            return this.$dateRangePicker.show()
        };
        DateRangePicker.prototype.showCustomDate = function() {
            var a;
            this.$dateRangePicker.find('.drp-timeline-presets li:last-child').addClass('drp-selected').siblings().removeClass('drp-selected');
            a = this.formatDate(this.startDate()) + ' - ' + this.formatDate(this.endDate());
            this.$select.find('option:last-child').text(a);
            return this.$select[0].selectedIndex = this.customOptionIndex
        };
        DateRangePicker.prototype.formatDate = function(d) {
            return "" + (d.getFullYear().toString() + "-" + (d.getMonth() + 1) + "-" + (d.getDate()))
        };
        DateRangePicker.prototype.setRange = function(a) {
            var b, startDate;
            if (isNaN(a)) {
                return false
            }
            a -= 1;
            b = new Date();
            startDate = new Date();
            startDate.setDate(b.getDate() - a);
            this.startCalendar = new Calendar(this, this.$dateRangePicker.find('.drp-calendar:first-child'), startDate, true);
            this.endCalendar = new Calendar(this, this.$dateRangePicker.find('.drp-calendar:last-child'), b, false);
            return this.draw()
        };
        DateRangePicker.prototype.endDate = function() {
            return this.endCalendar.date
        };
        DateRangePicker.prototype.startDate = function() {
            return this.startCalendar.date
        };
        DateRangePicker.prototype.draw = function() {
            this.startCalendar.draw();
            return this.endCalendar.draw()
        };
        return DateRangePicker
    })();
    Calendar = (function() {
        function Calendar(b, c, d, e) {
            var f;
            this.dateRangePicker = b;
            this.$calendar = c;
            this.date = d;
            this.isStartCalendar = e;
            f = this;
            this.date.setHours(0, 0, 0, 0);
            this._visibleMonth = this.month2();
            this._visibleYear = this.year();
            this.$title = this.$calendar.find('.drp-month-title');
            this.$dayHeaders = this.$calendar.find('.drp-day-headers');
            this.$days = this.$calendar.find('.drp-days');
            this.$dateDisplay = this.$calendar.find('.drp-calendar-date');
            c.find('.drp-arrow').click(function(a) {
                if ($(this).hasClass('drp-arrow-right')) {
                    f.showNextMonth()
                } else {
                    f.showPreviousMonth()
                }
                return false
            })
        }
        Calendar.prototype.showPreviousMonth = function() {
            if (this._visibleMonth === 1) {
                this._visibleMonth = 12;
                this._visibleYear -= 1
            } else {
                this._visibleMonth -= 1
            }
            return this.draw()
        };
        Calendar.prototype.showNextMonth = function() {
            if (this._visibleMonth === 12) {
                this._visibleMonth = 1;
                this._visibleYear += 1
            } else {
                this._visibleMonth += 1
            }
            return this.draw()
        };
        Calendar.prototype.setDay = function(a) {
            this.setDate(this.visibleYear(), this.visibleMonth(), a);
            return this.dateRangePicker.showCustomDate()
        };
        Calendar.prototype.setDate = function(a, b, c) {
            this.date = new Date(a, b - 1, c);
            return this.dateRangePicker.draw()
        };
        Calendar.prototype.draw = function() {
            var a, _i, _len;
            this.$dayHeaders.empty();
            this.$title.text("" + (this.visibleYear()) + "年" + (this.nameOfMonth(this.visibleMonth())) + "月");
            for (_i = 0, _len = DAYS.length; _i < _len; _i++) {
                a = DAYS[_i];
                this.$dayHeaders.append($("<li>" + (a.substr(0, 2)) + "</li>"))
            }
            this.drawDateDisplay();
            return this.drawDays()
        };
        Calendar.prototype.dateIsSelected = function(a) {
            return a.getTime() === this.date.getTime()
        };
        Calendar.prototype.dateIsInRange = function(a) {
            return a >= this.dateRangePicker.startDate() && a <= this.dateRangePicker.endDate()
        };
        Calendar.prototype.dayClass = function(a, b, c) {
            var d, date;
            date = new Date(this.visibleYear(), this.visibleMonth() - 1, a);
            d = '';
            if (this.dateIsSelected(date)) {
                d = 'drp-day-selected'
            } else if (this.dateIsInRange(date)) {
                d = 'drp-day-in-range';
                if (date.getTime() === this.dateRangePicker.endDate().getTime()) {
                    d += ' drp-day-last-in-range'
                }
            } else if (this.isStartCalendar) {
                if (date > this.dateRangePicker.endDate()) {
                    d += ' drp-day-disabled'
                }
            } else if (date < this.dateRangePicker.startDate()) {
                d += ' drp-day-disabled'
            }
            if ((a + b - 1) % 7 === 0 || a === c) {
                d += ' drp-day-last-in-row'
            }
            if (date > new Date()) {
                d += ' drp-day-disabled'
            }
            return d
        };
        Calendar.prototype.drawDays = function() {
            var c, i, lastDayOfMonth, self, _i, _j, _ref;
            self = this;
            this.$days.empty();
            c = this.firstDayOfMonth(this.visibleMonth(), this.visibleYear());
            lastDayOfMonth = this.daysInMonth(this.visibleMonth(), this.visibleYear());
            for (i = _i = 1, _ref = c - 1; _i <= _ref; i = _i += 1) {
                this.$days.append($("<li class='drp-day drp-day-empty'></li>"))
            }
            for (i = _j = 1; _j <= lastDayOfMonth; i = _j += 1) {
                this.$days.append($("<li class='drp-day " + (this.dayClass(i, c, lastDayOfMonth)) + "'>" + i + "</li>"))
            }
            return this.$calendar.find('.drp-day').click(function(a) {
                var b;
                if ($(this).hasClass('drp-day-disabled')) {
                    return false
                }
                b = parseInt($(this).text(), 10);
                if (isNaN(b)) {
                    return false
                }
                return self.setDay(b)
            })
        };
        Calendar.prototype.drawDateDisplay = function() {
            return this.$dateDisplay.val([this.year(), this.month(), this.day()].join('-'))
        };
        Calendar.prototype.month = function() {
            var a = this.date.getMonth() + 1;
            if (a >= 10) {
                a = a
            } else {
                a = "0" + a
            }
            return a
        };
        Calendar.prototype.month2 = function() {
            var a = this.date.getMonth() + 1;
            return a
        };
        Calendar.prototype.day = function() {
            var a = this.date.getDate();
            if (a < 10) {
                a = "0" + a
            }
            return a
        };
        Calendar.prototype.dayOfWeek = function() {
            return this.date.getDay() + 1
        };
        Calendar.prototype.year = function() {
            return this.date.getFullYear()
        };
        Calendar.prototype.visibleMonth = function() {
            return this._visibleMonth
        };
        Calendar.prototype.visibleYear = function() {
            return this._visibleYear
        };
        Calendar.prototype.nameOfMonth = function(a) {
            return MONTHS[a - 1]
        };
        Calendar.prototype.firstDayOfMonth = function(a, b) {
            return new Date(b, a - 1, 1).getDay() + 1
        };
        Calendar.prototype.daysInMonth = function(a, b) {
            a || (a = this.visibleMonth());
            b || (b = this.visibleYear());
            return new Date(b, a, 0).getDate()
        };
        return Calendar
    })();
    $.fn.dateRangePicker = function() {
        return new DateRangePicker(this)
    }
}).call(this);