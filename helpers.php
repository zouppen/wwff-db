<?php

// Behaves like errx(3) from glibc and BSD
function errx($exit, $msg, ...$va) {
    warnx($msg, ...$va);
    exit($exit);
}

// Behaves like warnx(3) from glibc and BSD
function warnx($msg, ...$va) {
    error_log(vsprintf($msg, $va));
}
