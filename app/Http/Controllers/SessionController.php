<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Auth\FakePartnerUser;
use Illuminate\Support\Facades\DB;
use App\Models\PartnerRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class SessionController extends Controller
{
    public function qr()
    {
        $getUsers = DB::connection('mysql_secondary')->table('users')->get();
        return view('auth.qr', [
            'getUsers' => $getUsers
        ]);
    }

    public function qrredirect($id)
    {
        $getUser = DB::connection('mysql_secondary')
            ->table('partner_registrations')
            ->where('id', $id)
            ->first();

        if (!$getUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $route = $getUser->password
            ? route('login.passkey', [
                'id' => $getUser->id,
                'first_name' => $getUser->first_name,
                'last_name' => $getUser->last_name,
                'extension_name' => $getUser->extension_name,
            ])
            : route('login.registerpasskey', [
                'id' => $getUser->id,
                'first_name' => $getUser->first_name,
                'last_name' => $getUser->last_name,
                'extension_name' => $getUser->extension_name,
            ]);

        return response()->json([
            'success' => true,
            'message' => 'QR matched.',
            'redirect' => $route,
            'fname' => $getUser->first_name // <-- Add this line
        ]);
    }

    public function showPasskeyForm($id, $first_name, $last_name, $extension_name = null)
    {
        return view('auth.passkey', [
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'extension_name' => $extension_name
        ]);
    }

    public function showRegisterPasskeyForm($id, $first_name, $last_name, $extension_name = null)
    {
        return view('auth.registerpasskey', [
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'extension_name' => $extension_name
        ]);
    }

    public function verifyPasskey(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mysql_secondary.partner_registrations,id',
            'password' => 'required|digits:6', // removed 'confirmed'
        ]);

        $user = PartnerRegistration::on('mysql_secondary')
            ->where('id', $request->id)
            ->first();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid passkey.'])->withInput();
        }

        Auth::guard('partner')->login($user);

        return redirect()->route('dashboard.index')->with('success', 'Logged in successfully!');
    }

    public function registerPasskey(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mysql_secondary.partner_registrations,id',
            'password' => 'required|digits:6|confirmed',
        ]);

        $user = PartnerRegistration::on('mysql_secondary')
            ->where('id', $request->id)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::guard('partner')->login($user);
        return redirect()->route('dashboard.index')->with('success', 'Passkey registered and user logged in!');
    }

    public function showPasskeyStep(Request $request)
    {
        $baseUrl = config('app.ah_webapp_url');
        $id = $request->input('id');

        $response = Http::post("$baseUrl/api/login/create", [
            'id' => $id,
        ]);

        if (! $response->successful() || ! $response['success']) {
            return redirect()->back()->withErrors(['id' => 'User not found.']);
        }

        $redirect = $response['redirect'];

        // Decide what to render based on the redirect
        if (str_contains($redirect, 'passkey')) {
            return view('partner.passkey', ['id' => $id]);
        } else {
            return view('partner.register-passkey', ['id' => $id]);
        }
    }

    public function destroy()
    {
        Auth::guard('partner')->logout();

        return redirect('/');
    }
}
