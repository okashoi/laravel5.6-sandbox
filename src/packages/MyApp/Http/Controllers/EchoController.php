<?php

namespace MyApp\Http\Controllers;

use MyApp\Http\Requests\EchoRequest;

class EchoController extends BaseController
{
    /**
     * @return mixed
     */
    public function echo(EchoRequest $request)
    {
        return response(['message' => $request->message]);
    }
}
