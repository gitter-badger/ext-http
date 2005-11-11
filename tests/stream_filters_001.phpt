--TEST--
stream filters
--SKIPIF--
<?php
include 'skip.inc';
?>
--FILE--
<?php
echo "-TEST\n";

define('F', 'http.test_stream_filters');

$f = fopen(F, 'w');
stream_filter_append($f, 'http.chunked_encode');

fwrite($f, "Here ");
fwrite($f, "we");
fwrite($f, " go!\n");
fclose($f);

var_dump(file_get_contents(F));

$f = fopen(F, 'r');
stream_filter_append($f, 'http.chunked_decode');
var_dump(fread($f, 256));

echo "Done\n";
--EXPECTF--
%sTEST
string(27) "5
Here 
2
we
5
 go!

"
string(12) "Here we go!
"
Done