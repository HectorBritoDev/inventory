<?php

namespace App\Http\Controllers\Auth\Passport;

use App\Traits\ApiResponser;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

class PassportAuthController extends AccessTokenController
{
    use ApiResponser;

    public function __construct(AuthorizationServer $server, TokenRepository $tokens, JwtParser $jwt)
    {
        parent::__construct($server, $tokens, $jwt);
    }

    public function login(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();
        $client = $this->getClient($parsedBody['client_name']);

        $parsedBody['username'] = $parsedBody['email'];
        $parsedBody['grant_type'] = 'password';
        $parsedBody['client_id'] = $client->id;
        $parsedBody['client_secret'] = $client->secret;

        //since is not required by passport
        unset($parsedBody['email'], $parsedBody['client_name']);
        return parent::issueToken($request->withParsedBody($parsedBody));

    }

    public function logout()
    {
        $client = $this->getClient(request()->client_name);
        $token = auth()->user()
            ->tokens
            ->where('client_id', $client->id)
            ->first();

        abort_if(is_null($token), 400, 'token for the given client name does not exist');
        // dd($token);
        $token->delete();

        return $this->successResponse('logged out successfully');
    }

    public function refresh(ServerRequestInterface $request)
    {
        $parsedBody = $request->getParsedBody();

        $client = $this->getClient($parsedBody['client_name']);

        $parsedBody['gran_type'] = 'refresh_token';
        $parsedBody['client_id'] = $client->id;
        $parsedBody['client_secret'] = $client->secret;

        // since it is not required by passport

        unset($parsedBody['client_name']);

        return parent::issueToken($request->withParsedBody($parsedBody));
    }

    private function getClient(string $name)
    {
        return Passport::client()
            ->where([
                ['name', $name],
                ['password_client', 1],
                ['revoked', 0],
            ])
            ->first();

    }

    //ONE APPROACH IS MAKING A SECOND REQUEST DIRECTLY FROM THE SERVER ADDING CLIENT AND SECRET
    // public function login(Request $request)
    // {
    //     $http = new GuzzleHttp\Client;

    //     try {
    //         $response = $http->post(config('service.passport.login_endpont'), [
    //             'form_params' => [
    //                 'grant_type' => 'password',
    //                 'client_id' => config('service.passport.client_id'),
    //                 'client_secret' => config('services.passport.client_secret'),
    //                 'username' => $request->email,
    //                 'password' => $request->password,
    //             ],
    //         ]);

    //         return $response->getBody();
    //     } catch (\Throwable $th) {
    //         $code = $th->getCode();
    //         if ($code === 400) {
    //             return $this->errorResponse('invalid request', $code);
    //         }
    //         if ($code === 401) {
    //             return $this->errorResponse('your credentials are incorrect. Please try again', $code);
    //         }
    //     }

    // }
}
