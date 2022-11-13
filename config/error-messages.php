<?php
return array(
    "404" => array(
        "title" => "Page not found",
        "description" => "The page you are looking for does not exist.",
        "code" => "404"
    ),
    "500" => array(
        "title" => "Internal server error",
        "description" => "Something went wrong on our end. Please try again later.",
        "code" => "500"
    ),
    "403" => array(
        "title" => "Forbidden",
        "description" => "You do not have permission to access this page.",
        "code" => "403"
    ),
    "401" => array(
        "title" => "Unauthorized",
        "description" => "You are not logged in.",
        "code" => "401"
    ),
    "400" => array(
        "title" => "Bad request",
        "description" => "The request you sent to the server was invalid.",
        "code" => "400"
    ),
    "default" => array(
        "title" => "Something went wrong",
        "description" => "Something went wrong on our end. Please try again later.",
        "code" => "500"
    ),
    "rickroll" => array(
        "title" => "Never gonna give you up",
        "description" => "Never gonna let you down",
        "code" => "200"
    ),
    "redirect" => array(
        "title" => "Redirecting...",
        "description" => "You are being redirected to another page.",
        "code" => "302"
    ),
    "redirects" => array(
        "rickroll" => "https://www.youtube.com/watch?v=dQw4w9WgXcQ",
        "google" => "https://www.google.com",
        "home" => "/"
    )
);
?>