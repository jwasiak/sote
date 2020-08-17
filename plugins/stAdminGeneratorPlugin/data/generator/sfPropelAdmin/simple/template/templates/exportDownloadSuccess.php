[?php
if ($handle) {
    while (!feof($handle)) {
        print fread($handle, 8192);
    }
    fclose($handle);
}
?]