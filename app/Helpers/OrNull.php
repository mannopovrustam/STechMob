<?php

function orZero($arg){
    return isset($arg) ? $arg : 0;
}
function orNull($arg){
    return isset($arg) ? $arg : null;
}
