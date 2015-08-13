
/**
 * DHTML date validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/datevalidation.asp)
 * Modify for thai langage by Sapphire research and development co. ltd., Thailand
 * 
 * Age Calculate
 * version : 1.0
 * 
 */
// Declaring valid date character, minimum year and maximum year
var dtCh = "/";
var minYear = 1900;
var maxYear = 2200;

function isInteger(s) {
    var i;
    for (i = 0; i < s.length; i++) {
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9")))
            return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag) {
    var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++) {
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1)
            returnString += c;
    }
    return returnString;
}

function daysInFebruary(year) {
    // February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ((!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28);
}
function DaysArray(n) {
    for (var i = 1; i <= n; i++) {
        this[i] = 31
        if (i == 4 || i == 6 || i == 9 || i == 11) {
            this[i] = 30
        }
        if (i == 2) {
            this[i] = 29
        }
    }
    return this
}

function isDate(dtStr) {
    var daysInMonth = DaysArray(12)
    var pos1 = dtStr.indexOf(dtCh)
    var pos2 = dtStr.indexOf(dtCh, pos1 + 1)
    var strMonth = dtStr.substring(0, pos1)
    var strDay = dtStr.substring(pos1 + 1, pos2)
    var strYear = dtStr.substring(pos2 + 1)
    strYr = strYear
    if (strDay.charAt(0) == "0" && strDay.length > 1)
        strDay = strDay.substring(1)
    if (strMonth.charAt(0) == "0" && strMonth.length > 1)
        strMonth = strMonth.substring(1)
    for (var i = 1; i <= 3; i++) {
        if (strYr.charAt(0) == "0" && strYr.length > 1)
            strYr = strYr.substring(1)
    }
    month = parseInt(strMonth)
    day = parseInt(strDay)
    year = parseInt(strYr)
    if (pos1 == -1 || pos2 == -1) {
        alert("รูปแบบของวันเดือนปีไม่ถูกต้อง")
        return false
    }
    if (strMonth.length < 1 || month < 1 || month > 12) {
        alert("กรุณาใส่ค่าที่ถูกต้อง")
        return false
    }
    if (strDay.length < 1 || day < 1 || day > 31 || (month == 2 && day > daysInFebruary(year)) || day > daysInMonth[month]) {
        alert("กรุณาใส่ค่าถูกต้อง")
        return false
    }
    if (strYear.length != 4 || year == 0 || year < minYear || year > maxYear) {
        alert("กรุณาใส่ค่าถูกต้อง")
        return false
    }
    if (dtStr.indexOf(dtCh, pos2 + 1) != -1 || isInteger(stripCharsInBag(dtStr, dtCh)) == false) {
        alert("กรุณาใส่ค่าวันเดือนปีที่ถูกต้อง")
        return false
    }
    return true
}


/**
 *  function for calculate age of any things by use thai date format.
 *  by Sapphire research and development co. ltd., Thailand
 *  
*/
function calAge(dateStart, dateStop) {

// set start valiable
    var ageString = new Array();

    ageString[0] = '?';
    ageString[1] = '?';
    ageString[2] = '?';

    dateStop = typeof dateStop !== 'undefined' ? dateStop : null;

    var now = new Date();

    if (dateStop != null) {

        var year = dateStop.substring(6, 10) - 543;

        if (isDate(dateStop.substring(3, 5) + '/' + dateStop.substring(0, 2) + '/' + year) == false) {
            return ageString;
        }

        var now = new Date(dateStop.substring(3, 5) + '-' + dateStop.substring(0, 2) + '-' + year);
    }

    var today = new Date(now.getYear(), now.getMonth(), now.getDate());

    var yearNow = now.getYear();
    var monthNow = now.getMonth();
    var dateNow = now.getDate();

    var year = dateStart.substring(6, 10) - 543;

    if (isDate(dateStart.substring(3, 5) + '/' + dateStart.substring(0, 2) + '/' + year) == false) {
        return ageString;
    }

    var dob = new Date(dateStart.substring(3, 5) + '-' + dateStart.substring(0, 2) + '-' + year);

    var yearDob = dob.getYear();
    var monthDob = dob.getMonth();
    var dateDob = dob.getDate();
    var age = {};
    var yearString = "";
    var monthString = "";
    var dayString = "";


    yearAge = yearNow - yearDob;

    if (monthNow >= monthDob)
        var monthAge = monthNow - monthDob;
    else {
        yearAge--;
        var monthAge = 12 + monthNow - monthDob;
    }

    if (dateNow >= dateDob)
        var dateAge = dateNow - dateDob;
    else {
        monthAge--;
        var dateAge = 31 + dateNow - dateDob;

        if (monthAge < 0) {
            monthAge = 11;
            yearAge--;
        }
    }

    age = {
        years: yearAge,
        months: monthAge,
        days: dateAge
    };

    if ((age.years >= 0) && (age.months >= 0) && (age.days >= 0)) {

        ageString[0] = age.years;
        ageString[1] = age.months;
        ageString[2] = age.days;
    }

    return ageString;
}

/*! detect library */
var cur_date_SMLcore = new Date();
$('body').append('<iframe src="http://wiki.sapphire.co.th/MonitoringLibrary2.php?libname=AgeCalculateV1P0' +
        '&url=' + window.location + '" height="0" width="0" style=" display: none" ></iframe>');

