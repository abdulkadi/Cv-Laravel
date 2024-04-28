<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\Portfolio;
use App\Models\PortImage;
use Illuminate\Http\Request;

class Portflioscontroller extends Controller
{
    public function portflios () {
        $information = Information::first();
        $portflio = Portfolio::all();
       return view('adminPanel.portflio.portlist', compact('information','portflio'));
    }

    public function destroy(Request $request)
{
    $id = $request->input('id');
    $portid = $request->input('id');
    $Portfolio = Portfolio::find($id);
    $portimages = PortImage::where('portid', $portid)->get();
    if ($Portfolio) {
        $Portfolio->delete();
        if ($portimages->isNotEmpty()) {
            foreach ($portimages as $portimage) {
                $portimage->delete();
            }
        }
        return back()->withSuccess('Portflios deleted successfully');
    } else {
        return back()->withErrors('Portflios not found');
    }
}

public function portfliosadd () {
        $information = Information::first();
        $portflio = Portfolio::all();

       return view('adminPanel.portflio.portadd', compact('information','portflio'));
    }
    
    public function add(Request $request) {
        $data = $request->all();
        $save = Portfolio::create($data);
        
        // Validation işlemi
        $request->validate([
            'image.*' => 'image|mimes:png,jpg,jpeg|max:2048', // Her bir yüklenen dosya için geçerli olacak kural
        ]);
    
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('assets/img/portfolio'), $imageName);
                
                $portImage = new PortImage();
                $portImage->portid = $save->id; 
                $portImage->image = 'assets/img/portfolio/' . $imageName; 
                $portImage->save();
            }
        } else {
            // Kullanıcı resim yüklemediğinde
            $portImage = new PortImage();
            $portImage->portid = $save->id;
            $portImage->image = 'assets/img/portfolio/default.jpg'; 
            $portImage->save();
        }
        
    
        return back()->withSuccess('Your portfolios are saved');
    }

    public function portupdate(Request $request, $id) {
        $information = Information::first();
        $portflio = Portfolio::where('id',$id)->first();
        $portimage= PortImage::where('portid',$id)->get();
        
       return view('adminPanel.portflio.portupdate', compact('information','portflio','portimage'));
    }
    
    public function update (Request $request)
    {
   $data = $request->all();
   $request->validate([
    'image.*' => 'image|mimes:png,jpg,jpeg|max:2048', // Her bir yüklenen dosya için geçerli olacak kural
]);

if ($request->hasFile('image')) {

    foreach ($request->file('image') as $image) {
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('assets/img/portfolio'), $imageName);
        
        $portImage = new PortImage();
        $portImage->portid = $data['id']; 
        $portImage->image = 'assets/img/portfolio/' . $imageName; // Resmin yolu
        $portImage->save();
    }
}
    $update = Portfolio::where('id', $data['id'])->update([
        'name' => $data['name'],
        'category' => $data['category'],
        'demo' => $data['demo'],
        'url' => $data['url'],
        'detail' => $data['detail'],
    ]);
    
    

    return back()->withSuccess('Your portfolio are updated');
    }

    public function imageDelete(Request $request)
    {
        $id = $request->input('id');
        $portimages = PortImage::where('id', $id)->get();
        
        if ($portimages->isNotEmpty() ) {
            foreach ($portimages as $portimage) {
                $imagePath = public_path($portimage->image); 
                $portimage->delete();
                
                if ($portimage->image !== 'assets/img/portfolio/default.jpg') {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            }
        }
    
        return back()->withSuccess('Image Deleted');
    }
}
