<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Appearance;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function testbest(){
        $dummyData = [
            (object)['id' => 1, 'content' => 'Card 1', 'priority' => 1],
            (object)['id' => 2, 'content' => 'Card 2', 'priority' => 2],
            (object)['id' => 3, 'content' => 'Card 3', 'priority' => 3],
            // Add more dummy data as needed
        ];
        $cards = collect($dummyData);
        return view('pages.testbest' , compact('cards'));
    }
    public function testnext(){
        
        return view('pages.testnext');
    }


    /**
     * Display the dashboard page.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $appearance = $user->appearance()->firstOrNew();

        if (!$appearance->exists) {
            $proposedUrlSlug = str_replace(' ', '_', $user->name);
    
            // Check if the proposed url_slug already exists
            while (Appearance::where('url_slug', $proposedUrlSlug)->exists()) {
                // If it exists, append a random number to the user's name
                $proposedUrlSlug = str_replace(' ', '_', $user->name) . '_' . rand(1000, 9999);
            }
    
            $appearance->url_slug = $proposedUrlSlug;
            $appearance->save();
        }

        return view('dashboard');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Generate qr code using url slug
    public function generateQrCode(Request $request)
    {
        $user = auth()->user();
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;
        $url = config('app.url') . $url_slug;
        $filename = 'qrcode-' . $url_slug;

        $qrCodePNG = QrCode::size(200)
            ->style('square')
            ->eye('circle')
            ->color(0, 0, 0)
            ->margin(1)
            ->format('png')
            ->generate($url);

        $qrCodeSVG = QrCode::size(200)
            ->style('square')
            ->eye('circle')
            ->color(0, 0, 0)
            ->margin(1)
            ->format('svg')
            ->generate($url);

        Storage::disk('public')->put("$filename.png", $qrCodePNG);
        Storage::disk('public')->put("$filename.svg", $qrCodeSVG);

        return response()->json([
            'pathPNG' => asset("storage/{$filename}.png"),
            'pathSVG' => asset("storage/{$filename}.svg"),
            'profile_url' => $url,
        ]);
    }
}
