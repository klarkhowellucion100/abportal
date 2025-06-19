<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function settingsindex()
    {
        return view('settings.index');
    }

    public function settingsprofileindex()
    {
        $userId = Auth::guard('partner')->user()->id;

        $personalInfo = DB::connection('mysql_secondary')
            ->table('partner_registrations as a')
            ->join('areas as b', 'a.address_id', '=', 'b.id')
            ->where('a.id', $userId)
            ->select(
                'a.*',
                'b.barangay as barangay',
                'b.municipality as municipality',
                'b.province as province',
                'b.region as region',
            )
            ->first();

        $allAreas = DB::connection('mysql_secondary')
            ->table('areas')
            ->select('areas.*')
            ->orderBy('barangay', 'asc')
            ->get();

        $data = "code={$personalInfo->code}&&id={$personalInfo->id}&&fname={$personalInfo->first_name}";

        // URL encode the query data (excluding &&)
        $encodedData = urlencode($data);

        // Construct the final URL
        $final_url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . $encodedData;

        // Now, fetch the QR code image content
        $qrImageData = file_get_contents($final_url);

        // Base64 encode the image
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImageData);

        return view('settings.profile.index', [
            'personalInfo' => $personalInfo,
            'qrBase64' => $qrBase64,
            'allAreas' => $allAreas,
        ]);
    }

    public function settingsprofileupdate(Request $request)
    {
        $userId = Auth::guard('partner')->user()->id;

        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'extension_name' => 'nullable',
            'specific_location' => 'nullable',
            'birthdate' => 'nullable',
            'sex' => 'nullable',
            'address_id' => 'required',
            'contact_number' => 'nullable',
        ]);

        DB::connection('mysql_secondary')
            ->table('partner_registrations')
            ->where('id', $userId)
            ->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'extension_name' => $request->input('extension_name'),
                'specific_location' => $request->input('specific_location'),
                'birthdate' => $request->input('birthdate'),
                'sex' => $request->input('sex'),
                'address_id' => $request->input('address_id'),
                'contact_number' => $request->input('contact_number'),
            ]);

        return redirect()->route('settings.profile.index')->with('success', 'Profile updated successfully.');
    }

    public function settingsprivacypolicyindex()
    {
        return view('settings.privacypolicy.index');
    }
}
