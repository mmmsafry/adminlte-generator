<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;

class AuthController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'];

            //get user
            $user = User::where('email', '=', $username)->firstOrFail();

            //issuetoken
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getBody()->__toString();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add access token to user
            $user = collect($user);
            $user->put('access_token', $data['access_token']);

            return Response::json(array($user));
        }
        catch (ModelNotFoundException $e) { // email notfound
            //return error message
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
        }
        catch (Exception $e) {
            ////return error message
        }
    }
}
