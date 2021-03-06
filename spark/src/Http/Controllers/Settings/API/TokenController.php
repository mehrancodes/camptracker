<?php

namespace Laravel\Spark\Http\Controllers\Settings\API;

use Illuminate\Http\Request;
use Laravel\Spark\Contracts\Repositories\TokenRepository;
use Laravel\Spark\Http\Controllers\Controller;
use Laravel\Spark\Http\Requests\Settings\API\CreateTokenRequest;
use Laravel\Spark\Http\Requests\Settings\API\UpdateTokenRequest;
use Laravel\Spark\Spark;
use Laravel\Spark\Token;

class TokenController extends Controller
{
    /**
     * The token repository instance.
     *
     * @var \Laravel\Spark\Contracts\Repositories\TokenRepository
     */
    protected $tokens;

    /**
     * Create a new controller instance.
     *
     * @param  \Laravel\Spark\Contracts\Repositories\TokenRepository  $tokens
     * @return void
     */
    public function __construct(TokenRepository $tokens)
    {
        $this->tokens = $tokens;

        $this->middleware('auth');
    }

    /**
     * Get all of the tokens generated by the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        return $this->tokens->all($request->user());
    }

    /**
     * Create a new API token for the user.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\API\CreateTokenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTokenRequest $request)
    {
        $data = count(Spark::tokensCan()) > 0 ? ['abilities' => $request->abilities] : [];

        return response()->json(['token' => $this->tokens->createToken(
            $request->user(), $request->name, $data
        )->token]);
    }

    /**
     * Update the given API token.
     *
     * @param  \Laravel\Spark\Http\Requests\Settings\API\UpdateTokenRequest  $request
     * @param  string  $tokenId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTokenRequest $request, $tokenId)
    {
        $token = $request->user()->tokens()->where('id', $tokenId)->firstOrFail();

        if (class_exists('Laravel\Passport\Passport')) {
            $token = new Token([
                'id' => $token->id,
                'name' => $token->name,
                'metadata' => ['abilities' => $token->scopes],
            ]);
        }

        $this->tokens->updateToken(
            $token, $request->name, (array) $request->abilities
        );
    }

    /**
     * Delete the given token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $tokenId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->firstOrFail()->delete();
    }
}
