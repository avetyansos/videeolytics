<?php

namespace App\Http\Controllers\Backoffice;


use Aginev\Datagrid\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Analytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

    public function index(Request $request) {
        $models = Analytics::all();

        $grid = new Datagrid($models, $request->get('f', []));

        $grid
            ->setColumn('id', 'ID', [
                'hasFilters' => false,
                'sortable'    => false,
            ])
            ->setColumn('userIdentifier', 'User')
            ->setColumn('startTime', 'Date', [
                'wrapper' => function ($value, $row) {
                    return $row->getData()->startTime->diffForHumans();
                }
            ])
            ->setColumn('duration', 'Session duration', [
                'wrapper' => function ($value, $row) {
                    $value /= 1000;
                    $minutes = (int) ($value / 60);
                    $seconds = round($value - $minutes * 60);
                    return $minutes . ' min ' . ($seconds ? $seconds . ' sec' : '');
                }
            ])
            ->setColumn('deviceModel', 'Device model')
            ->setColumn('platform', 'Operation system', [
                'wrapper' => function ($value, $row) {
                    return $row->platform . ' ' . $row->osVersion;
                }
            ])
            ->setActionColumn([
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route('backoffice.analytics.show', ['id' => $row->id]) . '" class="btn btn-primary">Show</a>';
                }
            ]);

        return view('backoffice.analytics.list', [
            'models' => $models,
            'grid' => $grid
        ]);
    }

    public function show(Request $request, $id) {
        $model = Analytics::findOrFail($id);

        return view('backoffice.analytics.show', [
            'model' => $model,
        ]);
    }

}