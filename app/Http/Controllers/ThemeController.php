<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Appearance;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ThemeController extends Controller
{
    //Display appearance page
    public function appearance()
    {
        $user = auth()->user();

        $appearance = $user->appearance()->firstOrNew();
        // Check if appearance data exists
        if (!$appearance->exists || $appearance->custom === null) {
            $defaultCustomData = [
                'backgroundColor' => '#2abfe5',
                'backgroundType' => 'flat',
                'buttonColor' => '#EAF08E',
                'fontColor' => '#000000',
                'lastBackgroundColor' => '#2abfe5',
                'font' => 'Arial',
                'gradientDirection' => 'to right'
            ];

            // Set the default custom data for a new appearance record
            $appearance->custom = json_encode($defaultCustomData);
            $appearance->save();
        }

        // Check if appearance data exists
        if ($appearance) {
            $appearanceData = [
                'url_slug' => $appearance->url_slug ?? null,
                'image' => $appearance->image ?? null,
                'profile_title' => $appearance->profile_title ?? null,
                'bio' => $appearance->bio ?? null,
                'theme' => $appearance->theme ?? null,
                'custom' => ($appearance->theme === 'custom') ? json_decode($appearance->custom, true) : null,
            ];
        } else {
            $appearanceData = [
                'url_slug' => null,
                'image' => null,
                'profile_title' => null,
                'bio' => null,
                'theme' => null,
                'custom' => null,
            ];
        }
        return view('pages.appearance', compact('user', 'appearanceData'));
    }

    //Update profile appearance
    public function updateAppearance(Request $request)
    {
        $user = auth()->user();
        $appearance = $user->appearance()->firstOrNew();

        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_slug' => 'nullable|string|max:255|unique:appearances,url_slug,' . $user->id,
            'profile_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        // Handle image upload and save the file path to the 'image' field
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile-images', 'public');
            $appearance->image = $imagePath;
        }
        if ($request->has('url_slug')) {
            $appearance->url_slug = $request->input('url_slug');
        }
        if ($request->has('profile_title')) {
            $appearance->profile_title = $request->input('profile_title');
        }
        if ($request->has('bio')) {
            $appearance->bio = $request->input('bio');
        }
        $appearance->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'image' => $appearance->image,
            'url_slug' => $appearance->url_slug,
            'profile_title' => $appearance->profile_title,
            'bio' => $appearance->bio,
        ]);
    }

    public function removeProfileImage()
    {
        $user = auth()->user();
        $appearance = $user->appearance()->first();

        // Remove the image file if it exists
        if ($appearance && $appearance->image) {
            Storage::delete('public/' . $appearance->image);

            $appearance->image = null;
            $appearance->save();
        }

        return response()->json([
            'message' => 'Profile image removed successfully',
            'profile_title' => $appearance->profile_title,
            'bio' => $appearance->bio,
            'url_slug' => $appearance->url_slug,
        ]);
    }

    //Profile sharing page
    public function index($urlSlug = null)
    {
        // If $urlSlug is provided, attempt to find the user by the given url_slug
        if ($urlSlug) {
            $user = User::whereHas('appearance', function ($query) use ($urlSlug) {
                $query->where('url_slug', $urlSlug);
            })->first();

            if ($user) {
                $appearance = $user->appearance;
                $customColor = json_decode($appearance->custom);
                $theme = $appearance->theme;
                $profile = $user->appearance()->first();
                $profile_image = $profile->image;
                $title = $profile->profile_title;
                $bio = $profile->bio;
                $listing = $user->listing()->first();
                $links = $user->socialLinks()->first();
                if ($listing) {
                    $data = json_decode($listing->list);
                } else {
                    $data = null;
                }
                if (!$links) {
                    $links = null;
                }
                return view('themes.index', compact('theme', 'data', 'links', 'profile_image', 'title', 'bio', 'urlSlug', 'customColor'));
            }
        }

        // If $urlSlug is not provided or the user is not found, use the default theme
        $defaultTheme = 'default';
        return view('themes.notFound', compact('defaultTheme'));
    }

    //Update theme
    public function setTheme(Request $request)
    {
        try {
            $user = auth()->user();
            $theme = $request->input('theme');

            // Update the user's appearance theme
            $user->appearance()->update(['theme' => $theme]);
            $existingCustomData = json_decode($user->appearance->custom, true);

            $appearance = $user->appearance()->firstOrNew();
            $customJson = json_encode($existingCustomData);
            // Update appearance record
            $user->appearance()->update(['custom' => $customJson]);
            $url_slug = $appearance->url_slug;

            // Return a JSON response indicating success
            return response()->json(['status' => 'success', 'theme' => $theme, 'url_slug' => $url_slug, 'existingCustomData' => $existingCustomData]);
        } catch (\Exception $e) {
            // Return a JSON response indicating failure in case of an exception
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    //Update theme data
    public function setCustomTheme(Request $request){
        try {
            $user = auth()->user();
            // Get existing custom data or create an empty array
            $existingCustomData = json_decode($user->appearance->custom, true);

            // Get color values from the request
            $backgroundColor = $request->input('backgroundColor');
            $buttonColor = $request->input('buttonColor');
            $fontColor = $request->input('fontColor');
            $backgroundType = $request->input('backgroundType');
            $lastBackgroundColor = $request->input('backgroundColor');
            $gradientDirection = $request->input('gradientDirection') ?? 'to right';
            $selectedFont = $request->input('font');

            function hexToRgb($hex)
            {
                // Remove the hash sign if it's present
                $hex = str_replace("#", "", $hex);

                // Convert each component to decimal
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));

                // Return an array with RGB values
                return array($r, $g, $b);
            }

            if ($backgroundType === 'gradient') {
                $rgbColor = hexToRgb($backgroundColor);

                // Calculate a lighter version of the color (adjust the factor based on your preference)
                $lightnessFactor = 0.8; // You can adjust this value
                $lighterR = $rgbColor[0] + ($lightnessFactor * (255 - $rgbColor[0]));
                $lighterG = $rgbColor[1] + ($lightnessFactor * (255 - $rgbColor[1]));
                $lighterB = $rgbColor[2] + ($lightnessFactor * (255 - $rgbColor[2]));

                // Ensure values are in the valid range (0-255)
                $lighterR = min(255, $lighterR);
                $lighterG = min(255, $lighterG);
                $lighterB = min(255, $lighterB);

                // Create the lighter background color
                $lighterBackgroundColor = "rgba($lighterR, $lighterG, $lighterB, 1)";
                $backgroundColor = "linear-gradient($gradientDirection, $backgroundColor, $lighterBackgroundColor)";
            }

            // Update the existing custom data with the new values
            $existingCustomData['backgroundColor'] = $backgroundColor ?? '';
            $existingCustomData['backgroundType'] = $backgroundType ?? '';
            $existingCustomData['buttonColor'] = $buttonColor ?? '';
            $existingCustomData['fontColor'] = $fontColor ?? '';
            $existingCustomData['lastBackgroundColor'] = $lastBackgroundColor ?? '';
            $existingCustomData['gradientDirection'] = $gradientDirection ?? '';
            $existingCustomData['font'] = $selectedFont ?? '';

            // Convert updated custom data into JSON format
            $customJson = json_encode($existingCustomData);
            // Update appearance record
            $user->appearance()->update(['custom' => $customJson]);
            $appearance = $user->appearance()->firstOrNew();
            $url_slug = $appearance->url_slug;
            // Return a JSON response indicating success
            return response()->json(['status' => 'success', 'url_slug' => $url_slug, 'existingCustomData' => $existingCustomData]);
        } catch (\Exception $e) {
            // Return a JSON response indicating failure in case of an exception
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
}
