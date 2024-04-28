<?php

namespace App\Http\Controllers;

use App\Models\Skils;
use App\Models\Resume;
use App\Models\Portfolio;
use App\Models\PortImage;
use App\Models\Information;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function index (){
      $information = Information::first();
      $skills= Skils::all();
      $resume= Resume::all();
      $category= Portfolio::select('category')->distinct()->orderBy('id')->get();

      

      $portfolio = Portfolio::join('port_images', 'portfolios.id', '=', 'port_images.portid')
      ->select('portfolios.name', 'portfolios.category', 'portfolios.slug', DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(port_images.image), ",", 1) as image'))
      ->groupBy('portfolios.id', 'portfolios.name', 'portfolios.category', 'portfolios.slug')
      ->get();

    
        return view('index', compact('information','skills','resume','portfolio','category'));
    }
    public function detail($slug){
      $portfolio= Portfolio::whereSlug($slug)->first();
      $image = DB::table('portfolios')
      ->join('port_images', 'portfolios.id', '=', 'port_images.portid')
      ->select('port_images.image', 'port_images.portid')
      ->where('portfolios.slug', $slug)
      ->get();
  

      return view('portflolio-details', compact('portfolio','image'));
    }
}
