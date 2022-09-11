<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    protected $updateAbleRows = [];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('menu', [
            'MenuObject' => $this,
            'menulist' => Menu::whereNull('parent_id')->orderBy('sequence','asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        Menu::create($request->validated());
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        return response('Successfully updated',200);
    }

    /**
     * Update all menu
     */

    public function updateAll(Request $request)
    {
        $this->updateAbleRows = [];

        foreach ($request->data as $key => $item) {
            $sequence = $key + 1;
            $parent_id = null;

            $this->updateAbleRows[] = [
                'id' => $item['id'],
                'parent_id' => $parent_id,
                'sequence' => $sequence,
            ];
            $children = $item['children'][0] ?? [];
            if (count($children)) {
                $this->parseChild($children, $item['id']);
            }
        }

        foreach ($this->updateAbleRows as $row) {
            Menu::where('id', $row['id'])->update([
                'parent_id' => $row['parent_id'],
                'sequence' => $row['sequence']
            ]);
        }

        return response('Successfully data updated', 200);
    }


    private function parseChild($data, $parent_id)
    {
        foreach ($data as $key => $item) {
            $sequence = $key + 1;
            $this->updateAbleRows[] = [
                'id' => $item['id'],
                'parent_id' => $parent_id,
                'sequence' => $sequence,
            ];

            $children = $item['children'][0] ?? [];

            if (count($children)) {
                $this->parseChild($children, $item['id']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
