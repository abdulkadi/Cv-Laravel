<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Information;
use App\Models\Resume;
use App\Models\Skils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller
{
    public function contact(Request $request){



        $valiondate =$request->validate([
             'name'=>'required|string|min:3',
             'email'=>'required|email',
             'subject'=>'required',
             'message'=>'required'
         ]);

         $data = $request->all();
         $data['ip']= request()->ip();
       $sonkaydedilen = Contact::create($data);
       //return redirect()->route('direct')->withSuccess('Başarı ile mesajını bize gönderdik.');
       return back()->withSuccess('Başarı ile mesajını bize gönderdik.');



     }
     public function personal(Request $request)
     {
  
    $data = $request->all();
    $sonkaydedilen = Information::latest()->first();

    $request->validate([
      'short_image' => 'image|mimes:png,jpg,jpeg|max:2048',
      'full_image' => 'image|mimes:png,jpg,jpeg|max:2048',
      
  ]);

  if ($request->hasFile('full_image')) {

    $imageName = 'fullimage.' . $request->file('full_image')->getClientOriginalExtension();
    $request->file('full_image')->move(public_path('assets/img'), $imageName);
    $data['full_image'] = $imageName;
}

    if ($request->hasFile('short_image')) {
        $imageName = 'profile.' . $request->file('short_image')->getClientOriginalExtension();
        $request->file('short_image')->move(public_path('assets/img'), $imageName);
        $data['short_image'] = $imageName;
    }


    $sonkaydedilen->update($data);
    return back()->withSuccess('Your records have been updated');
     
     }

     public function resume(Request $request){

     $data = $request->all();
     $data['qualification']= $data['qualification1'];
    $sonkaydedilen = Resume::create($data);

    return back()->withSuccess('your resumes are saved');

     }
     
     public function skil(Request $request)
     {
      $data=$request->all();
      $save= Skils::create($data);
      return back()->withSuccess('Your skills are saved');
     }

     public function skilupdate(Request $request)
{
    $data = $request->all();
    $update = Skils::where('id', $data['id'])->update([
        'skil' => $data['skil'],
        'percent' => $data['percent']
    ]);
    return back()->withSuccess('Your skills are saved');
}

public function skildelete(Request $request)
{
    $id = $request->input('id');
    $skil = Skils::find($id);
    if ($skil) {
        $skil->delete();
        return back()->withSuccess('Skill deleted successfully');
    } else {
        return back()->withErrors('Skill not found');
    }
}

public function resumedelete(Request $request)
{
    $id = $request->input('id');
    $resume = Resume::find($id);
    if ($resume) {
        $resume->delete();
        return back()->withSuccess('Resume deleted successfully');
    } else {
        return back()->withErrors('Resume not found');
    }
}
public function resumeupdate(Request $request)
{
    $data = $request->all();
    $update = Resume::where('id', $data['id'])->update([
        'company' => $data['company'],
        'date' => $data['date'],
        'mission' => $data['mission'],
        'qualification' => $data['qualification'],
        'city' => $data['city'],
        'resume' => $data['resume'],
    ]);
    return back()->withSuccess('Your resume are saved');
}

}
