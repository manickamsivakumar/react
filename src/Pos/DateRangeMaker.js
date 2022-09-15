import { DateTime } from 'luxon';

const DateRangeMaker = (datefilterid, daterangeobj = 0) => {

    var today = DateTime.now().setZone('Asia/Kolkata').toSQL().split(' ')[0];

    if (daterangeobj == 0) {
        var dateobj = {
            fromdate: today,
            todate: today,
            value: datefilterid,
            rangeclsname: 'hideme'
        }
    } else {
        var dateobj = {
            fromdate: daterangeobj.fromdate,
            todate: daterangeobj.todate,
            value: datefilterid,
            rangeclsname: 'nohideme'
        }
    }

    if (datefilterid == 0) {//today
        dateobj.fromdate = today;
        dateobj.todate = today;
    } else if (datefilterid == 1) {//Last 7 days
        dateobj.fromdate = DateTime.fromISO(today).minus({ days: 6 }).toISODate();
        dateobj.todate = today;
    } else if (datefilterid == 2) {//Last 30 days
        dateobj.fromdate = DateTime.fromISO(today).minus({ days: 30 }).toISODate();
        dateobj.todate = today;
    } else if (datefilterid == 3) {//Current Month
        dateobj.fromdate = DateTime.fromISO(today).set({ days: 1 }).toISODate();
        dateobj.todate = today;
    } else if (datefilterid == 4) {//Last Month
        let month = DateTime.fromISO(today).minus({ month: 1 }).get('month');
        let year = DateTime.fromISO(today).minus({ month: 1 }).get('year');
        var getDaysInMonth = function (month, year) {
            return new Date(year, month, 0).getDate();
        };
        let lastday = getDaysInMonth(month, year);
        dateobj.fromdate = DateTime.fromISO(today).set({ days: 1, month: month, year: year }).toISODate();
        dateobj.todate = DateTime.fromISO(today).set({ days: lastday, month: month, year: year }).toISODate();
    } else if (datefilterid == 5) {//Current Year
        let year = DateTime.now(today).get('year');
        dateobj.fromdate = DateTime.fromISO(today).set({ days: 1, month: 1, year: year }).toISODate();
        dateobj.todate = DateTime.fromISO(today).set({ days: 31, month: 12, year: year }).toISODate();
    }
    return dateobj;
};

export default DateRangeMaker;

