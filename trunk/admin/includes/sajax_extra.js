<!--

/* Sajax Extra functions */

function parseGET(result) {
FORM_DATA = new Object();

keypairs = new Object();
numKP = 1;
separator = ',';

while( result.indexOf('&') > -1 ) {
keypairs[numKP] = result.substring(0,result.indexOf('&'));
result = result.substring((result.indexOf('&'))+1);
numKP++;
}
keypairs[numKP] = result;

for ( i in keypairs ) {
keyName = keypairs[i].substring(0,keypairs[i].indexOf('='));
keyValue = keypairs[i].substring((keypairs[i].indexOf('='))+1);
while( keyValue.indexOf('+')>-1) {
keyValue = keyValue.substring(0,keyValue.indexOf('+'))+' '+keyValue.substring(keyValue.indexOf('+') + 1);
}
keyValue = unescape(keyValue);
if ( FORM_DATA[keyName]) {
if ( isArray(FORM_DATA[keyName])) {
FORM_DATA[keyName][FORM_DATA[keyName].length] = keyValue;
} else {
tempVal = FORM_DATA[keyName];
FORM_DATA[keyName] = new Array();
FORM_DATA[keyName][0] = tempVal;
FORM_DATA[keyName][1] = keyValue;
}
// FORM_DATA[keyName] = FORM_DATA[keyName] + separator + keyValue;
} else {
FORM_DATA[keyName] = keyValue;
}
}

return FORM_DATA;
}
-->