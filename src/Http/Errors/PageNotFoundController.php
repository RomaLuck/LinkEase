<?php

namespace Src\Http\Errors;

use Src\Http\Controller;
use Symfony\Component\HttpFoundation\Response;

class PageNotFoundController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('Errors.404', [], 404);
    }
}