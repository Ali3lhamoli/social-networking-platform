<?php


function get_file_url(?string $path = null) {
    return ($path) ? asset($path) : asset('assets/users/default_user.png');
}