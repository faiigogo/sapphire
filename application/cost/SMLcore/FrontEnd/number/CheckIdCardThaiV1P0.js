/*
 * Check ID Card Thai
 * Version: 1.0
 */

function CheckIdCardIsNumeric(input) {
    var RE = /^-?(0|INF|(0[1-7][0-7]*)|(0x[0-9a-fA-F]+)|((0|[1-9][0-9]*|(?=[\.,]))([\.,][0-9]+)?([eE]-?\d+)?))$/;
    return (RE.test(input));
}

function CheckIdCardThai(id) {

    id = id.toString();
    id = id.replace('-', '');
    // for support jquery masked input
    id = id.replace('-', '');
    id = id.replace('-', '');
    id = id.replace('-', '');

    if (!CheckIdCardIsNumeric(id))
        return false;
    if (id.substring(0, 1) == 0)
        return false;
    if (id.length != 13)
        return false;
    for (i = 0, sum = 0; i < 12; i++)
        sum += parseFloat(id.charAt(i)) * (13 - i);
    if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
        return false;
    return true;
}
