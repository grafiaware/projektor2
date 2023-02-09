<?php
// https://learn.microsoft.com/en-us/cpp/c-runtime-library/country-region-strings?view=msvc-170
// https://learn.microsoft.com/en-us/cpp/c-runtime-library/locale-names-languages-and-country-region-strings?source=recommendations&view=msvc-170
// https://learn.microsoft.com/en-us/cpp/c-runtime-library/reference/setlocale-wsetlocale?view=msvc-170#utf-8-support

$localeCode = ['cs-CZ.UTF8', 'cs_CZ.UTF8', 'cs-CZ.UTF8', 'cs_CZ.UTF8'];
$locale = setlocale(LC_ALL, $localeCode);
//$lac2 = setlocale(LC_ALL, '');  // vrací "Czech_Czechia.1250"
if ($locale) {

$string = "lowers +ěščřžýáíé= UPP123,.?:_/()[]}{;\|_789!!ERS +ĚŠČŘŽÝÁÍÉ=";
$exchnged = "";

for($i=0;$i<strlen($string);$i++){
    if (ctype_alpha($string[$i])) {
        if(ctype_upper($string[$i])){
            $exchnged[$i] = strtolower($string[$i]);
        }
        else {
            $exchnged[$i] = strtoupper($string[$i]);
        }
    } else {
        $exchnged[$i] = $string[$i];
    }
}

echo "<h5>Locale nastaveno: $locale</h5>";
echo "<code>";
echo "<p>$string</p>";
echo "<p>$exchnged</p>";
echo "</code>";


} else {
echo "<h5>Nerozpoznán kód pro locale: $localeCode</h5>";

}