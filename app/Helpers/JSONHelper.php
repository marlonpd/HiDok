<?php

function json_pretty($str)
{
    return \Response::make(json_encode($str, JSON_PRETTY_PRINT))
                    ->header('Content-Type', "application/json");
}

?>