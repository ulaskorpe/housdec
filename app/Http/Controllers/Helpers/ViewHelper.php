<?php


function isSetNotNull($array, $index, $property)
{
    if (!isset($array[$index])) return false;
    if ($array[$index]->$property == null) return false;
    return true;
}

function isNotNull($item)
{
    if (!isset($item))
        return false;
    if ($item == null)
        return false;
    if ($item == "")
        return false;
    if ($item == 0)
        return false;
    return true;
}

function makePrivateFileUrl(string $path, int $width = 0, int $height = 0, int $aspect = 0)
{
    $parameterString = "?u=" . $path;
    if ($width > 0)
        $parameterString .= "&w=" . $width;
    if ($height > 0)
        $parameterString .= "&h=" . $height;
    // if (($width > 0 || $height > 0))
    $parameterString .= "&a=" . $aspect;
    return route("pfiles") . $parameterString;
}


function makeCommonFileUrl(string $path, int $width = 0, int $height = 0, int $aspect = 0)
{
    $parameterString = "?u=" . $path;
    if ($width > 0)
        $parameterString .= "&w=" . $width;
    if ($height > 0)
        $parameterString .= "&h=" . $height;
    // if (($width > 0 || $height > 0))
    $parameterString .= "&a=" . $aspect;
    return route("get_file") . $parameterString;
}


function action_exists($action)
{
    try {
        action($action);
    } catch (\Exception $e) {
        return false;
    }

    return true;
}