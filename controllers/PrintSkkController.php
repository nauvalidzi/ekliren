<?php

namespace PHPMaker2021\eclearance;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * print_skk controller
 */
class PrintSkkController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PrintSkk");
    }
}
