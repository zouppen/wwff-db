<?php

// Behaves like errx(3) from glibc and BSD
function errx($exit, $msg, ...$va) {
    error_log(vsprintf($msg, $va));
    exit($exit);
}
