<?php

namespace App\Http\Controllers;

use App\HomeHeader;
use App\Page;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Auth::check()) {
        $pages = Page::all()->sortBy('order');

        $header = HomeHeader::find(1);
        $headerImage = $header ? 'header/' . $header->image : NULL;

        return view('admin/pages/index', ['pages' => $pages, 'headerImage' => $headerImage]);
    } else {
        return redirect()->route('login');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Auth::check()) {
        $images = Image::where('type','=','header')->get();

        $header = HomeHeader::find(1);
        $headerImage = $header ? 'header/' . $header->image : NULL;

        return view('admin/pages/create', ['images' => $images, 'headerImage' => $headerImage]);
    } else {
        return redirect()->route('login');
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    if (Auth::check()) {
        $page = new Page;

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'link' => 'required|unique:pages|max:50',
            'body' => 'required',
        ]);

        if (request()->upload) {
            $image = new Image;

            $request->validate([
                'type' => 'required',
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'_'.request()->upload->getClientOriginalName();
            request()->upload->move(public_path('images/header'), $imageName);
            $image->filename = $imageName;
            $image->type = $request->get('type');
            $image->save();

            $page->image = $imageName;
        } else {
            if (request()->image) {
                $page->image = $request->get('image');
            }
        }
        $page->title = $request->get('title');
        $page->link = $request->get('link');
        $page->body = $request->get('body');
        $page->color = $request->get('color');
        $page->font_color = $request->get('font');
        $order = count(Page::all());
        $page->order = $order+1;

        $page->save();
        Session::flash('message', 'De pagina is succesvol aangemaakt.');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('pages.show', [$slug = str_replace(' ', '-', $page->link)]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  string $slug
   *
   * @return \Illuminate\Http\Response
   */
  public function show($slug) {
      $link = str_replace('-', ' ', $slug);
      $page = Page::where('link', $link)->firstOrFail();

      $header = HomeHeader::find(1);
      $headerImage = (!empty($page['image'])) ? 'header/'.$page['image'] : (($header) ? $headerImage = 'header/' . $header->image : NULL);
      return view('pages/slugpage', ['page' => $page, 'headerImage' => $headerImage]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    if (Auth::check()) {
        $page = Page::find($id);
        $images = Image::where('type','=','header')->get();

        $header = HomeHeader::find(1);
        $headerImage = (!empty($page['image'])) ? 'header/'.$page['image'] : (($header) ? $headerImage = 'header/' . $header->image : NULL);
        return view('admin/pages/edit', ['page' => $page, 'headerImage' => $headerImage, 'images' => $images]);
    } else {
        return redirect()->route('login');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    if (Auth::check()) {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'link' => 'required|unique:pages,'.$id.'|max:50',
            'body' => 'required',
        ]);

        $page = Page::find($id);
        if (request()->upload) {
            $image = new Image;

            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imageName = time().'_'.request()->upload->getClientOriginalName();
            request()->upload->move(public_path('images/header'), $imageName);
            $image->filename = $imageName;
            $image->type = 'header';
            $image->save();

            $page->image = $imageName;
        } else {
            if(!empty($request->get('image'))) $page->image = $request->get('image');
        }
        $page->title = $request->get('title');
        $page->link = $request->get('link');
        $page->body = $request->get('body');
        $page->color = $request->get('color');
        $page->font_color = $request->get('font');
        $page->save();

        Session::flash('message', 'De pagina is succesvol gewijzigd.');
        Session::flash('alert-class', 'alert-success');

        return redirect()->route('pages.show', [$slug = str_replace(' ', '-', $page->link)]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int $id
   *
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    if (Auth::check()) {
        Page::destroy($id);
        Session::flash('message', 'De pagina is succesvol verwijderd.');
        Session::flash('alert-class', 'alert-success');
        return redirect('admin/pages');
    }
  }

    /**
     * Update the order of the pages.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateOrder(Request $request){
        if(Auth::check()) {
            $pageIds = DB::table('pages')->pluck('id');
            $orderIds = [];
            foreach($pageIds as $id){
                if(!in_array($request->get($id), $orderIds)){
                    $orderIds[] = $request->get($id);
                }
            }

            if(count($orderIds) === count($pageIds)){
                foreach($pageIds as $id){
                    $page = Page::find($id);
                    $page->order = $request->get($id);
                    $page->save();

                }
            }else{
                Session::flash('message', 'Volgorde mag niet twee dezelfde waarden bevatten.');
                Session::flash('alert-class', 'alert-danger');
                return redirect('admin/pages');
            }
            Session::flash('message', 'Volgorde is aangepast.');
            Session::flash('alert-class', 'alert-success');
            return redirect('admin/pages');
        }
    }

  public function admin_page() {
      if (Auth::check()) {
          return redirect()->route('home');
      }
      else {
          return redirect()->route('login');
      }
  }
}
