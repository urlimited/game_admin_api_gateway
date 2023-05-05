<?php

namespace App\Ship\Parents\Requests;

use Apiato\Core\Abstracts\Requests\Request as AbstractRequest;
use App\Ship\Parents\Models\User;

/**
 * @method User user($guard = null)
 */
abstract class Request extends AbstractRequest
{

}
