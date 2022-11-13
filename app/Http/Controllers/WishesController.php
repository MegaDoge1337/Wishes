<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Inertia\Inertia;
use Illuminate\Http\Request;

class WishesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageMode = $request->query('page_mode', 'all');
        $wishes = null;

        if ($pageMode == 'all') {
            $wishes = Wish::orderBy('created_at', 'desc')
                ->with('user')
                ->get();

            return Inertia::render('Wishes/List', [
                'wishes' => $wishes,
                'pageMode' => 'all',
                'pageModeLabel' => 'All Wishes'
            ]);
        }

        if ($pageMode == 'personal') {
            $currentUser = $request->user();    

            $wishes = Wish::orderBy('created_at', 'desc')
                ->whereUserId($currentUser->id)
                ->with('user')
                ->get();

            return Inertia::render('Wishes/List', [
                'wishes' => $wishes,
                'pageMode' => 'personal',
                'pageModeLabel' => 'My Wishes'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Wishes/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = $request->user();

        $data = $request->validate([
            'title' => ['required'],
            'description' => ['nullable'],
            'progress' => ['nullable', 'numeric'],
            'url' => ['nullable', 'url'],
        ]);

        $data['user_id'] = $currentUser->id;

        Wish::create($data);

        return redirect()->route('wishes.index', ['page_mode' => 'personal']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Wishes/Edit', [
            'wish' => Wish::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentUser = $request->user();

        $data = $request->validate([
            'title' => ['required'],
            'description' => ['nullable'],
            'progress' => ['nullable', 'numeric'],
            'url' => ['nullable', 'url'],
        ]);

        Wish::find($id)->update($data);

        return redirect()->route('wishes.index', ['page_mode' => 'personal']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Wish::find($id)->delete();
        return redirect()->route('wishes.index', ['page_mode' => 'personal']);
    }
}
