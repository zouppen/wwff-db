<?php

// Little naïve frequency to band conversion
function to_band($khz) {
    $bands = [2200, 630, 8, 6, 5, 4, 2, 160, 80, 60, 40, 30, 20, 17, 15, 12, 10, 0.70, 0.33, 0.23, 0.13];
    $best = 0;

    foreach($bands as $wavelength) {
        if ($khz == 0) $khz = 1;
        $comp = 300000/$wavelength/$khz;
        if ($comp > 1) $comp = 1/$comp;
        if ($comp < $best) continue;
        $best = $comp;
        $ret = $wavelength;
    }
    if ($ret >= 1) return $ret.'m';
    return ($ret*100).'cm';
}
