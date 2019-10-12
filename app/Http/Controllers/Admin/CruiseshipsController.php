<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Language;
use App\Cruiseships;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use App\Translations\CruiseshipsTranslation;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditCruiseships;
use App\Http\Requests\StoreCruiseships;

class CruiseshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cruiseships = Cruiseships::getAll();
        $languages = Language::getAll();

        return view('admin/cruiseships/index', compact('cruiseships', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cruiseship = new Cruiseships();
        $action = 'create';
        $form_data = array('route' => 'admin.cruiseships.store', 'method' => 'POST');

        $languages = Language::getAll();
        
        return view('admin/cruiseships/form', compact('action', 'cruiseship',  'form_data', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCruiseships  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCruiseships $request)
    {      
        $data = $request->validated();

        $cruiseship = Cruiseships::create();

        $languages = Language::getAll();

        foreach ($languages as $language) {
            if (isset($data['language_' . $language->id]) && isset($data['fk_language_' . $language->id])) {
                CruiseshipsTranslation::create([
                    'fk_language' => $data['fk_language_' . $language->id],
                    'fk_cruiseship_type' => $cruiseship->id,
                    'type' => $data['language_' . $language->id]
                ]);
            }
        }        

        return redirect()->route('admin.cruiseships.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cruiseship = Cruiseships::getEdit($id);

        $action    = 'update';
        $form_data = array('route' => array('admin.cruiseships.update', $cruiseship->id), 'method' => 'PATCH');
        $languages = Language::getAll();

        return view('admin/cruiseships/form', compact('action', 'cruiseship', 'form_data', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditCruiseships  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCruiseships $request, $id)
    {
        $cruiseship = Cruiseships::getEdit($id);

        $data = $request->validated();

        $languages = Language::getAll();

        foreach ($languages as $language) {
            if (isset($data['language_' . $language->id]) && isset($data['fk_language_' . $language->id])) {

                $where = [];
                $where[] = ['fk_language', $data['fk_language_' . $language->id]];
                $where[] = ['fk_cruiseship_type', $id];

                $cruiseshipTranslation = CruiseshipsTranslation::getEdit($where);

                $cruiseshipTranslation->fill([
                    'type' => $data['language_' . $language->id]
                ])->save();
            }
        }  

        return redirect()->route('admin.cruiseships.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cruiseship = Cruiseships::findOrFail($id);

        try {
            CruiseshipsTranslation::where('fk_cruiseship', $id)->delete();
            $cruiseship->delete();
            Alert::success('Registro eliminado correctamente!')->flash();
        } catch (Exception $e) {
            Alert::error('No puedes eliminar el registro!')->flash();
        }  

        return redirect()->route('admin.cruiseships.index');
    }
}
