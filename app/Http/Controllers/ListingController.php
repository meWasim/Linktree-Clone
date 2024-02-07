<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\SocialLink;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function show(){
        // send the listing from database
        $user = auth()->user();
        
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;

        $listing = Listing::where('user_id', $user->id)->first();
        if($listing){
            $decodedData = json_decode($listing->list);
        }
        else{
            $decodedData = null;
        }

        return view('pages.listings', compact('decodedData', 'url_slug'));
    }

    public function create(Request $request){
        $user_id = auth()->user()->id;
        $listing = Listing::where('user_id', $user_id)->first();

        if( $listing && $listing->list != null ){
            $decodedData = json_decode($listing->list, true);
            $title = $request->title;
            $url = $request->url;
            $uniqueId = Str::random(7);
            $decodedData[$uniqueId] = ["title"=> $title, "url" => $url, "visibility" => "true" , "thumbnail" => null];
            $listing->update(['list' => $decodedData]);
        }
        else{
            $listing = new Listing();
            $listing->user_id = auth()->user()->id;
            $title = $request->title;
            $url = $request->url;
            $uniqueId = Str::random(7);
            $data = [
                $uniqueId => ["title"=> $title, "url" => $url, "visibility" => "true" , "thumbnail" => null]
            ];
        
            $listing->list =json_encode($data);
            $listing->save();

        }
        
        return redirect()->back();
    }

    public function update(Request $request){
        $user = auth()->user();

        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;

        $list = json_encode($request->list);
        $listing = Listing::where('user_id', $user->id)->update(['list' => $list]);
        
        return response()->json(['message' => 'List updated successfully', 'url_slug' => $url_slug], 200);
    }

    public function delete(Request $request){
        // dd($request->input());
        $user = auth()->user();
        $listing = Listing::where('user_id', $user->id)->first();
        $data = json_decode($listing->list);
        $key = $request->key;
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;

        if (isset($data-> $key)) {
            unset($data-> $key);   
            $listing->list = json_encode($data);
            $listing->save();
            return response()->json(['message' => "List deleted successfully", 'url_slug' => $url_slug], 200);
        }

        return response()->json(['error' => 'Key not found'], 404);
    }

    public function linksVisibility(Request $request){
        $user = auth()->user();
        $listing = Listing::where('user_id', $user->id)->first();
        $data = json_decode($listing->list);
        $key = $request->key;
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;

        if (isset($data-> $key)) {
            if (isset($data->$key->visibility)){
                if($data->$key->visibility == "true"){
                    $data->$key->visibility = "false";
                }
                else{
                    $data->$key->visibility = "true";
                }
            }
            else{
                $data->$key->visibility = "false";
            }
            $listing->list = json_encode($data);
            $listing->save();
            return response()->json(['message' => "Visibility updated successfully", 'url_slug' => $url_slug], 200);
        }

        return response()->json(['error' => 'key not found'], 404);
    }

    public function uploadThumbnail(Request $request){
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'key' => 'nullable|string|max:255'
        ]);

        if( $request->has('key') ){
            $user = auth()->user();
            $listing = Listing::where('user_id', $user->id)->first();
            $data = json_decode($listing->list);
            $key = $request->key;
            $appearance = $user->appearance()->firstOrNew();
            $url_slug = $appearance->url_slug;

            if ($data->$key && $request->hasFile('thumbnail')) {
                if ( isset($data->$key->thumbnail) ) {
                    Storage::delete('public/' . $data->$key->thumbnail);
                }
                $imagePath = $request->file('thumbnail')->store('thumbnail-images', 'public');
                $data->$key->thumbnail = $imagePath;
            }
            else{
                return response()->json(['error' => 'Data missing'], 400);
            }

            $listing->list = json_encode($data);
            $listing->save();
            return response()->json(['message' => "Image uploaded successfully", 'url_slug' => $url_slug, 'thumbnailUrl' => $data->$key->thumbnail], 200);
        }
        return response()->json(['error' => 'key not found'], 404);
    }

    public function removeThumbnail(Request $request){
        $request->validate([
            'key' => 'nullable|string|max:255'
        ]);
        if( $request->has('key') ){
            $user = auth()->user();
            $listing = Listing::where('user_id', $user->id)->first();
            $data = json_decode($listing->list);
            $key = $request->key;
            $appearance = $user->appearance()->firstOrNew();
            $url_slug = $appearance->url_slug;

            if ( $data->$key && $data->$key->thumbnail ) {
                Storage::delete('public/' . $data->$key->thumbnail);
    
                $data->$key->thumbnail = null;
            }
            $listing->list = json_encode($data);
            $listing->save();

            return response()->json(['message' => "Image uploaded successfully", 'url_slug' => $url_slug, 'thumbnailUrl' => $data->$key->thumbnail], 200);
        }
        return response()->json(['error' => 'key not found'], 404);
    }

    public function showLinks(){
        $user = auth()->user();
        $socialLinks = SocialLink::where('user_id', $user->id)->first();
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;
        return view('pages.socialLinks', compact('socialLinks', 'url_slug'));
    }

    public function updateLinks(Request $request){
        $user = auth()->user();
        $socialLinks = SocialLink::where('user_id', $user->id)->first();
        $col = $request->id;
        $value = $request->value;
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;
        if(! $socialLinks){
            $socialLinks = new SocialLink();
            $socialLinks->user_id = $user->id;
            if( $col == 'facebook' ){
                $socialLinks->facebook = $value;
            }
            elseif( $col == 'instagram' ){
                $socialLinks->instagram = $value;
            }
            elseif( $col == 'whatsapp' ){
                $socialLinks->whatsapp = $value;
            }
            elseif( $col == 'x' ){
                $socialLinks->x = $value;
            }
        }
        else{
            $socialLinks->user_id = $user->id;
            if( $col == 'facebook' ){
                $socialLinks->facebook = $value;
            }
            elseif( $col == 'instagram' ){
                $socialLinks->instagram = $value;
            }
            elseif( $col == 'whatsapp' ){
                $socialLinks->whatsapp = $value;
            }
            elseif( $col == 'x' ){
                $socialLinks->x = $value;
            }
        }
        $socialLinks->save();
        return response()->json(['message' => 'URL updated', 'url_slug'=>$url_slug], 200);
    }

    public function deleteLink(Request $request){
        $user = auth()->user();
        $socialLinks = SocialLink::where('user_id', $user->id)->first();
        $col = $request->id;
        $appearance = $user->appearance()->firstOrNew();
        $url_slug = $appearance->url_slug;
        if($socialLinks){
            if( $col == 'facebook' ){
                $socialLinks->facebook = null;
            }
            elseif( $col == 'instagram' ){
                $socialLinks->instagram = null;
            }
            elseif( $col == 'whatsapp' ){
                $socialLinks->whatsapp = null;
            }
            elseif( $col == 'x' ){
                $socialLinks->x = null;
            }
        }
        $socialLinks->save();
        return response()->json(['message' => 'URL deleted', 'url_slug'=>$url_slug], 200);
    }
}
