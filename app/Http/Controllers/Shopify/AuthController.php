<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Shopify\Auth\Session as ShopifySession;
use Illuminate\Support\Facades\Session as LaravelSession;
use Shopify\Clients\Rest;
use Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $shop = $request->query('shop');
        if (!$shop) {
            return response()->json(['success' => false, 'message' => 'Invalid shop parameter.'], 400);
        }

        $install_url = "https://$shop/admin/oauth/authorize?" . http_build_query([
            'client_id' => env('SHOPIFY_API_KEY'),
            'scope' => env('SCOPES'),
            'redirect_uri' => env('SHOPIFY_APP_HOST_NAME') . '/api/callback',
        ]);

        return response()->json(['install_url' => $install_url]);
    }

    public function callback(Request $request)
    {
        $hmac = $request->query('hmac');
        $shared_secret = env('SHOPIFY_API_SECRET');
        $shop = $request->query('shop');
        $code = $request->query('code');
        $params = array_diff_key($request->all(), ['hmac' => '']);
        ksort($params);

        $computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

        if (!hash_equals($hmac, $computed_hmac)) {
            Log::error('Invalid HMAC');
            return response('Invalid HMAC', 400);
        }

        $data = $this->exchangeCodeForToken($code, $shop);
        $data = json_decode($data);
        $user = $this->updateOrCreateUser($data);
        // create secrer get access token
        $token = $user->createToken('shopifyapp')->plainTextToken;    
        $secret = Crypt::encryptString($token);
        return redirect()->to('/home?secret=' . $secret . '&user_id=' . $user->id. '&shop=' . $shop);
    }



    public function getAccessToken(Request $request)
    {
        try{
            $secret = $request->input('secret');
            $user_id = $request->input('user_id');
            $accessToken = Crypt::decryptString($secret);
        return response()->json(['access_token' => $accessToken, 'user_id' => $user_id]);
        }
        catch (\Exception $e) {
            Log::error('Error getting access token', ['message' => $e->getMessage()]);
            return response('Error getting access token', 500);
        }
    }



    protected function exchangeCodeForToken($code, $shop)
    {
        try {
            $response = Http::post("https://$shop/admin/oauth/access_token", [
                'client_id' => env('SHOPIFY_API_KEY'),
                'client_secret' => env('SHOPIFY_API_SECRET'),
                'code' => $code,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $accessToken = $data['access_token'];

                return $this->getShopDetails($accessToken, $shop);
            } else {
                Log::error('Failed to obtain access token', $response->json());
                return response('Failed to obtain access token', 400);
            }
        } catch (\Exception $e) {
            Log::error('Error exchanging code for token', ['message' => $e->getMessage()]);
            return response('Error exchanging code for token', 500);
        }
    }

    protected function getShopDetails($accessToken, $shop)
    {
        $sessionId = "offline_$shop";
        $isOnline = true;
        $state = bin2hex(random_bytes(16));
        $session = new ShopifySession($sessionId, $shop, $isOnline, $state);
        $session->setAccessToken($accessToken);

        try {
            $client = new Rest($session->getShop(), $session->getAccessToken());
            $response = $client->get('shop');
            $data = json_decode($response->getBody()->getContents());

            return json_encode([
                'access_token' => $accessToken,
                'shop' => $data->shop->domain,
                'shop_owner' => $data->shop->shop_owner,
                'email' => $data->shop->email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to fetch shop details', ['message' => $e->getMessage()]);
            return response('Failed to fetch shop details', 500);
        }
    }

    protected function updateOrCreateUser($data)
    {
        $user = User::where('store_url', $data->shop)->first();
        if ($user) {
            $user->update([
                'access_token' => $data->access_token,
                'name' => $data->shop_owner,
                'email' => $data->email,
                'store_url' => $data->shop,
            ]);
        } else {
            $user = User::create([
                'store_url' => $data->shop,
                'access_token' => $data->access_token,
                'name' => $data->shop_owner,
                'email' => $data->email,
            ]);
        }
        return $user;
    }


    public function checkSession()
    {
        if (LaravelSession::has('shopify_shop')) {
            return response()->json([
                'access_token' => LaravelSession::get('shopify_access_token'),
                'logged_in' => true,
            ]);
        }

        return response()->json(['logged_in' => false]);
    }

    public function logout(Request $request)
    {
        LaravelSession::forget('shopify_shop');
        LaravelSession::forget('shopify_access_token');
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true, 'message' => 'Logout successfully']);
    }
}
