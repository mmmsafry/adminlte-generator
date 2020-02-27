<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use App\Models\Users;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;

class AuthController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    /**  @ToDo have to remove it later - practice */
    public function login_no_need(Request $request)
    {

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid username or password']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function login(ServerRequestInterface $request)
    {

        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'];

            //get user
            $user = Users::where('email', '=', $username)->firstOrFail();

            //issuetoken
            $tokenResponse = parent::issueToken($request);


            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array

            $data = json_decode($content, true);
            /** @ToDo not working - */
            if (isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add access token to user
            $user = collect($user);
            $output['auth'] = $data;
            $output['user'] = $user;

            return Response::json(array($output));
        } catch (ModelNotFoundException $e) { // email notfound
            return 'ModelNotFoundException';
            //return error message
        } catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            return 'OAuthServerException';
        } catch (Exception $e) {
            ////return error message
            $data['error'] = 'Authentication fail';
            $data['description'] = 'Invalid username or password';
            $data['message'] = 'Provided username or password invalid';
            return response($data, 401);

        }
    }
}
