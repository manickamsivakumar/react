import _ from 'underscore';
import { DateTime } from 'luxon';

const ChartValuesFunc = (datetimefilterid, nodatacheck, datetimevalue, postdetails) => {
    //console.log(datetimefilterid);
    //console.log(postdetails);
    //console.log(datetimevalue);
    var getDaysArray = function (s, e) { for (var a = [], d = new Date(s); d <= new Date(e); d.setDate(d.getDate() + 1)) { a.push(new Date(d)); } return a; };
    var emptydata = [];
    function amountmaker(mode, maketype, datetimevalue) {
        var amountvalues = {};
        // console.log(mode)
        // console.log(maketype)
        // console.log(datetimevalue)
        if (mode == "today") {
            _.each(maketype, function (idkey) {
                amountvalues[idkey] = 0;
            });
            var detail = {};
            _.each(datetimevalue, function (dvalue) {
                detail = dvalue;
            });
            var donecheck = 0;
            _.each(detail, function (amount, timekey) {
                if (amount) {
                    _.each(amountvalues, function (amountvalue, idkey) {
                        if (Number(timekey) <= Number(idkey) && donecheck == 0) {
                            amountvalues[idkey] += amount;
                            donecheck = 1;
                        }
                    });
                    donecheck = 0;
                }
            });
        }
        else if (mode == "week") {
            _.each(maketype, function (idkey) {
                amountvalues[idkey] = 0;
            });
            //console.log(amountvalues);
            _.each(datetimevalue, function (values, datekey) {
                //console.log(datekey);
                _.each(values, function (amount, timekey) {
                    //console.log(amount);
                    amountvalues[datekey] += amount;
                });
            });
        } else if (mode == "last30days") {
            _.each(maketype, function (idvalues, idkey) {
                amountvalues[idkey] = 0;
            });
            var eachamount;
            _.each(datetimevalue, function (values, datekey) {
                eachamount = 0;
                _.each(values, function (amount, timekey) {
                    eachamount += amount;
                });
                _.each(maketype, function (idvalues, idkey) {
                    if (idvalues.includes(datekey)) {
                        amountvalues[idkey] += eachamount;
                    }
                });
            });
            //console.log(amountvalues)
        } else if (mode == "currentmonth") {

        } else if (mode == "currentyear") {
            _.each(maketype, function (idkey) {
                amountvalues[idkey.toLowerCase()] = 0;
            });
            //var eachamount;
            _.each(datetimevalue, function (values, datekey) {
                var rolldate = DateTime.fromISO(datekey).toFormat('ff');
                rolldate = rolldate.split(',');
                var month = rolldate[0].split(' ')[0].slice(0, -1);
                if (Number(rolldate[0].split(' ')[0].slice(0, -1))) {
                    month = rolldate[0].split(' ')[1].slice(0, -1);
                }
                month = month.slice(0, 2);
                _.each(values, function (amount, timekey) {
                    amountvalues[month.toLowerCase()] += amount;
                });
            });
            //console.log(amountvalues);
        }
        return _.values(amountvalues);
    }

    let markerobj = {}

    //console.log(datetimefilterid)

    if (datetimefilterid == 0) {//Today
        markerobj.xaxis = [6, 8, 10, 12, 14, 16, 18, 20, 22, 24];
        markerobj.labels = ['6a', '8a', '10a', '12p', '2p', '4p', '6p', '8p', '10p', '12p'];
        markerobj.chartmode = 'line';
        markerobj.mdata = nodatacheck == 0 ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : amountmaker("today", markerobj.xaxis, datetimevalue);
        return markerobj;
    } else if (datetimefilterid == 1) {//Last 7 days
        markerobj.xaxis = [1, 2, 3, 4, 5, 6, 7];
        var fromdate = new Date(postdetails.fromdate);
        var todate = new Date(postdetails.todate);
        var Difference_In_Time = todate.getTime() - fromdate.getTime();
        var diffdays = Difference_In_Time / (1000 * 3600 * 24);
        var days = [postdetails.fromdate];
        var rolldate = postdetails.fromdate;
        _.times(diffdays, function (n) {
            rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
            days.push(rolldate);
        });
        markerobj.labels = [];
        _.each(days, function (day) {
            day = day.split('-');
            markerobj.labels.push(day[2] + '/' + day[1])
        });
        markerobj.chartmode = 'line';
        markerobj.mdata = nodatacheck == 0 ? [0, 0, 0, 0, 0, 0, 0] : amountmaker("week", days, datetimevalue);
        //console.log(markerobj.mdata);
        return markerobj;
    } else if (datetimefilterid == 2) {//Last 30 days
        //markerobj.xaxis = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
        markerobj.xaxis = [1, 2, 3, 4, 5];
        var rolldate = postdetails.fromdate;
        var weekdays = [];
        var days = [];

        _.times(5, function (n) {
            days = [rolldate];
            _.times(6, function (n) {
                rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                if (postdetails.todate >= rolldate) {
                    days.push(rolldate);
                }
            });
            weekdays.push(days);
            rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
        });

        var weekdays_obj = {};
        var loopkey = 1;
        _.each(weekdays, function (weekday) {
            var key = 'Wk' + loopkey
            weekdays_obj[key] = weekday;
            loopkey++;
        });
        markerobj.labels = _.keys(weekdays_obj);
        var emptydata = [];
        _.times(15, function (n) {
            emptydata.push(0);
        });
        markerobj.chartmode = 'line';
        markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("last30days", weekdays_obj, datetimevalue);
        return markerobj;
    } else if (datetimefilterid == 3) {//Current Month
        var fromdate = new Date(postdetails.fromdate);
        var todate = new Date(postdetails.todate);
        var Difference_In_Time = todate.getTime() - fromdate.getTime();
        var diffdays = Difference_In_Time / (1000 * 3600 * 24);
        //console.log(diffdays)
        if (diffdays >= 10) {
            var keydays = ((diffdays + 1) / 5);
            //var remainder = (diffdays % 5);
            var roundval = Math.round(keydays);
            var rolldate = DateTime.fromISO(postdetails.fromdate).minus({ days: 1 }).toISODate();
            var rollcount = 0;
            var weekdays_obj = {};
            var weekdays = [];
            var days = [];
            while (rolldate <= postdetails.todate) {
                rollcount++;
                if (rollcount < 5) {
                    _.times(roundval, function (n) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    });
                    weekdays.push(days);
                    days = [];
                }
                else {
                    while (rolldate <= postdetails.todate) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    }
                    weekdays.push(days);
                    days = [];
                }
            }
            //console.log(weekdays);
            var ikey = 1;
            _.each(weekdays, function (weekday) {
                var firstdate = weekday[0];
                var lastdate = weekday[weekday.length - 1];
                var rolldate = DateTime.fromISO(firstdate).toFormat('ff');
                rolldate = rolldate.split(',');
                var month = rolldate[0].split(' ')[0];
                firstdate = rolldate[0].split(' ')[1];
                if (Number(month)) {
                    firstdate = rolldate[0].split(' ')[0];
                    month = rolldate[0].split(' ')[1];
                }
                var rolldate = DateTime.fromISO(lastdate).toFormat('ff');
                rolldate = rolldate.split(',');
                lastdate = rolldate[0].split(' ')[1];
                if (Number(rolldate[0].split(' ')[0])) {
                    lastdate = rolldate[0].split(' ')[0];
                }
                var key = month.slice(0, 3) + ikey + '_|_' + month.slice(0, 3) + ' (' + firstdate + ' - ' + lastdate + ')';
                ikey++;
                weekdays_obj[key] = weekday;
            });
            markerobj.labels = _.keys(weekdays_obj);
            var emptydata = [];
            _.times(_.keys(weekdays_obj).length, function (n) {
                emptydata.push(0);
            });
            //markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("currentmonth", weekdays_obj, datetimevalue);
            var amountvalues = {};
            _.each(weekdays_obj, function (idvalues, idkey) {
                amountvalues[idkey] = 0;
            });
            var eachamount;
            _.each(datetimevalue, function (values, datekey) {
                eachamount = 0;
                _.each(values, function (amount, timekey) {
                    eachamount += amount;
                });
                _.each(weekdays_obj, function (idvalues, idkey) {
                    if (idvalues.includes(datekey)) {
                        amountvalues[idkey] += eachamount;
                    }
                });
            });
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? emptydata : _.values(amountvalues);
            //console.log(amountvalues)
            return markerobj;
        } else {
            //markerobj.xaxis = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
            markerobj.xaxis = [1, 2, 3, 4, 5];
            var rolldate = postdetails.fromdate;
            var weekdays = [];
            var days = [];

            _.times(5, function (n) {
                days = [rolldate];
                _.times(6, function (n) {
                    rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                    if (postdetails.todate >= rolldate) {
                        days.push(rolldate);
                    }
                });
                weekdays.push(days);
                rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
            });

            var weekdays_obj = {};
            var loopkey = 1;
            _.each(weekdays, function (weekday) {
                var key = 'Wk' + loopkey
                weekdays_obj[key] = weekday;
                loopkey++;
            });
            markerobj.labels = _.keys(weekdays_obj);
            var emptydata = [];
            _.times(15, function (n) {
                emptydata.push(0);
            });
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("last30days", weekdays_obj, datetimevalue);
            return markerobj;
        }
    } else if (datetimefilterid == 4) {//Last Month
        markerobj.xaxis = [1, 2, 3, 4, 5];
        var rolldate = postdetails.fromdate;
        var weekdays = [];
        var days = [];

        _.times(5, function (n) {
            days = [rolldate];
            _.times(6, function (n) {
                rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                if (postdetails.todate >= rolldate) {
                    days.push(rolldate);
                }
            });
            weekdays.push(days);
            rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
        });

        var weekdays_obj = {};
        var loopkey = 1;
        _.each(weekdays, function (weekday) {
            var key = 'Wk' + loopkey
            weekdays_obj[key] = weekday;
            loopkey++;
        });
        markerobj.labels = _.keys(weekdays_obj);
        var emptydata = [];
        _.times(15, function (n) {
            emptydata.push(0);
        });
        markerobj.chartmode = 'line';
        markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("last30days", weekdays_obj, datetimevalue);
        return markerobj;
    } else if (datetimefilterid == 5) {//current year
        markerobj.xaxis = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        var firstdate = postdetails.fromdate;
        var months = [];
        var rolldate = DateTime.fromISO(firstdate).toFormat('ff');
        var irolldate;
        irolldate = rolldate.split(',');
        var month = irolldate[0].split(' ')[0];
        //var rollcount = DateTime.fromISO(postdetails.todate).get('month');
        months = [month];
        rolldate = firstdate;
        _.times(11, function (n) {
            rolldate = DateTime.fromISO(rolldate).plus({ month: 1 });
            irolldate = rolldate.toFormat('ff');
            irolldate = irolldate.split(',');
            months.push(irolldate[0].split(' ')[0]);
        });
        months = ["Ja", "Fe", "Ma", "Ap", "Ma", "Ju", "Jl", "Au", "Se", "Oc", "No", "De"];
        markerobj.labels = months;
        markerobj.chartmode = 'bar';
        markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("currentyear", months, datetimevalue);
        return markerobj;
    } else if (datetimefilterid == 6) {//daterange
        var fromdate = new Date(postdetails.fromdate);
        var todate = new Date(postdetails.todate);
        var Difference_In_Time = todate.getTime() - fromdate.getTime();
        var diffdays = Difference_In_Time / (1000 * 3600 * 24);
        if (diffdays == 0) {
            markerobj.xaxis = [6, 8, 10, 12, 14, 16, 18, 20, 22, 24];
            markerobj.labels = ['6a', '8a', '10a', '12p', '2p', '4p', '6p', '8p', '10p', '12p'];
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0] : amountmaker("today", markerobj.xaxis, datetimevalue);
            return markerobj;
        } else if (diffdays == 7) {
            markerobj.xaxis = [1, 2, 3, 4, 5, 6, 7];
            var fromdate = new Date(postdetails.fromdate);
            var todate = new Date(postdetails.todate);
            var Difference_In_Time = todate.getTime() - fromdate.getTime();
            var diffdays = Difference_In_Time / (1000 * 3600 * 24);
            var days = [postdetails.fromdate];
            var rolldate = postdetails.fromdate;
            _.times(diffdays, function (n) {
                rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                days.push(rolldate);
            });
            markerobj.labels = [];
            _.each(days, function (day) {
                day = day.split('-');
                markerobj.labels.push(day[2] + '/' + day[1])
            });
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? [0, 0, 0, 0, 0, 0, 0] : amountmaker("week", days, datetimevalue);
            //console.log(markerobj.mdata);
            return markerobj;
        } else if (diffdays >= 10 && diffdays < 32) {
            var keydays = ((diffdays + 1) / 5);
            //var remainder = (diffdays % 5);
            var roundval = Math.round(keydays);
            var rolldate = DateTime.fromISO(postdetails.fromdate).minus({ days: 1 }).toISODate();
            var rollcount = 0;
            var weekdays_obj = {};
            var weekdays = [];
            var days = [];
            while (rolldate <= postdetails.todate) {
                rollcount++;
                if (rollcount < 5) {
                    _.times(roundval, function (n) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    });
                    weekdays.push(days);
                    days = [];
                }
                else {
                    while (rolldate <= postdetails.todate) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    }
                    weekdays.push(days);
                    days = [];
                }
            }
            var ikey = 1;
            _.each(weekdays, function (weekday) {
                var firstdate = weekday[0];
                var lastdate = weekday[weekday.length - 1];
                var rolldate = DateTime.fromISO(firstdate).toFormat('ff');
                rolldate = rolldate.split(',');
                var month = rolldate[0].split(' ')[0];
                firstdate = rolldate[0].split(' ')[1];
                if (Number(month)) {
                    firstdate = rolldate[0].split(' ')[0];
                    month = rolldate[0].split(' ')[1];
                }
                var rolldate = DateTime.fromISO(lastdate).toFormat('ff');
                rolldate = rolldate.split(',');
                lastdate = rolldate[0].split(' ')[1];
                if (Number(rolldate[0].split(' ')[0])) {
                    lastdate = rolldate[0].split(' ')[0];
                }
                var key = month.slice(0, 3) + ikey + '_|_' + month.slice(0, 3) + ' (' + firstdate + ' - ' + lastdate + ')';
                ikey++;
                weekdays_obj[key] = weekday;
            });
            markerobj.labels = _.keys(weekdays_obj);

            _.times(_.keys(weekdays_obj).length, function (n) {
                emptydata.push(0);
            });
            //markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("currentmonth", weekdays_obj, datetimevalue);
            var amountvalues = {};
            _.each(weekdays_obj, function (idvalues, idkey) {
                amountvalues[idkey] = 0;
            });
            var eachamount;
            _.each(datetimevalue, function (values, datekey) {
                eachamount = 0;
                _.each(values, function (amount, timekey) {
                    eachamount += amount;
                });
                _.each(weekdays_obj, function (idvalues, idkey) {
                    if (idvalues.includes(datekey)) {
                        amountvalues[idkey] += eachamount;
                    }
                });
            });
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? emptydata : _.values(amountvalues);
            //console.log(amountvalues)
            return markerobj;
        } else if (diffdays < 10 && diffdays < 32) {
            //markerobj.xaxis = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];3
            if (diffdays > 6) {
                markerobj.xaxis = [1, 2, 3, 4, 5];
                var rolldate = postdetails.fromdate;
                var weekdays = [];
                var days = [];

                _.times(5, function (n) {
                    days = [rolldate];
                    _.times(6, function (n) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    });
                    weekdays.push(days);
                    rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                });

                var weekdays_obj = {};
                var loopkey = 1;
                _.each(weekdays, function (weekday) {
                    var key = 'Wk' + loopkey
                    weekdays_obj[key] = weekday;
                    loopkey++;
                });
                markerobj.labels = _.keys(weekdays_obj);
                var emptydata = [];
                _.times(15, function (n) {
                    emptydata.push(0);
                });
                markerobj.chartmode = 'line';
                markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("last30days", weekdays_obj, datetimevalue);
                return markerobj;
            } else {
                markerobj.xaxis = [];
                var emptydata = [];
                _.times(diffdays, function (n) {
                    emptydata.push(0);
                });
                var fromdate = new Date(postdetails.fromdate);
                var todate = new Date(postdetails.todate);
                var Difference_In_Time = todate.getTime() - fromdate.getTime();
                var diffdays = Difference_In_Time / (1000 * 3600 * 24);
                var days = [postdetails.fromdate];
                var rolldate = postdetails.fromdate;
                _.times(diffdays, function (n) {
                    rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                    days.push(rolldate);
                });
                markerobj.labels = [];
                _.each(days, function (day) {
                    day = day.split('-');
                    markerobj.labels.push(day[2] + '/' + day[1])
                });
                markerobj.chartmode = 'line';
                markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("week", days, datetimevalue);
                //console.log(markerobj.mdata);
                return markerobj;
            }

        } else if (diffdays > 31 && diffdays < 367) {
            var keydays = ((diffdays + 1) / 5);
            //var remainder = (diffdays % 5);
            var roundval = Math.round(keydays);
            var rolldate = DateTime.fromISO(postdetails.fromdate).minus({ days: 1 }).toISODate();
            var rollcount = 0;
            var weekdays_obj = {};
            var weekdays = [];
            var days = [];
            while (rolldate <= postdetails.todate) {
                rollcount++;
                if (rollcount < 5) {
                    _.times(roundval, function (n) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    });
                    weekdays.push(days);
                    days = [];
                }
                else {
                    while (rolldate <= postdetails.todate) {
                        rolldate = DateTime.fromISO(rolldate).plus({ days: 1 }).toISODate();
                        if (postdetails.todate >= rolldate) {
                            days.push(rolldate);
                        }
                    }
                    weekdays.push(days);
                    days = [];
                }
            }
            _.each(weekdays, function (weekday) {
                var firstdate = weekday[0];
                var lastdate = weekday[weekday.length - 1];
                var rolldate = DateTime.fromISO(firstdate).toFormat('ff');
                rolldate = rolldate.split(',');
                var month = rolldate[0].split(' ')[0];
                firstdate = rolldate[0].split(' ')[1];
                var rolldate = DateTime.fromISO(lastdate).toFormat('ff');
                rolldate = rolldate.split(',');
                var lmonth = rolldate[0].split(' ')[0];
                lastdate = rolldate[0].split(' ')[1];
                var key = month.charAt(0) + '' + firstdate + ' - ' + lmonth.charAt(0) + '' + lastdate;
                weekdays_obj[key] = weekday;
            });
            markerobj.labels = _.keys(weekdays_obj);
            var emptydata = [];
            _.times(_.keys(weekdays_obj).length, function (n) {
                emptydata.push(0);
            });
            //markerobj.mdata = nodatacheck == 0 ? emptydata : amountmaker("currentmonth", weekdays_obj, datetimevalue);
            var amountvalues = {};
            _.each(weekdays_obj, function (idvalues, idkey) {
                amountvalues[idkey] = 0;
            });
            var eachamount;
            _.each(datetimevalue, function (values, datekey) {
                eachamount = 0;
                _.each(values, function (amount, timekey) {
                    eachamount += amount;
                });
                _.each(weekdays_obj, function (idvalues, idkey) {
                    if (idvalues.includes(datekey)) {
                        amountvalues[idkey] += eachamount;
                    }
                });
            });
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? emptydata : _.values(amountvalues);
            //console.log(amountvalues)
            return markerobj;
        } else if (diffdays > 364) {
            //console.log(diffdays);
            //console.log(datetimevalue);
            var fyear = Number(DateTime.fromISO(postdetails.fromdate).get('year'));
            var lyear = Number(DateTime.fromISO(postdetails.todate).get('year'));
            var years = [fyear];
            var year = fyear;
            var emptydata = [0];
            _.times((lyear - fyear), function (n) {
                year = year + 1;
                years.push(year);
                emptydata.push(0);
            });
            markerobj.labels = years;
            var amountvalues = {};
            _.each(years, function (idkey) {
                amountvalues[idkey] = 0;
            });
            var eachamount;
            _.each(datetimevalue, function (values, datekey) {
                var datekeyvalues = datekey.split('-');
                //console.log(datekeyvalues);
                var year = datekeyvalues[0];
                eachamount = 0;
                _.each(values, function (amount, timekey) {
                    eachamount += amount;
                });
                amountvalues[year] += eachamount;
            });
            markerobj.chartmode = 'line';
            markerobj.mdata = nodatacheck == 0 ? emptydata : _.values(amountvalues);
            //console.log(markerobj)
            return markerobj;
        }
    }
}

export default ChartValuesFunc;

