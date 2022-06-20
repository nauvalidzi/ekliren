<?php

namespace PHPMaker2021\eclearance;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * cetak_skk controller
 */
class CetakSkkController extends ControllerBase
{

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "CetakSkk");
    }
}
