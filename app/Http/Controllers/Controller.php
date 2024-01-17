<?php

namespace Http\Controllers;

class Controller
{
    protected function render($path, $attributes = []): void
    {
        extract($attributes);

        require "views/$path";
    }
}