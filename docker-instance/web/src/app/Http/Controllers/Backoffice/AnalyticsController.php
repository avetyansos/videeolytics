<?php

namespace App\Http\Controllers\Backoffice;


use Aginev\Datagrid\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Analytics;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

    public function index(Request $request) {
        /** @var Analytics $model */

        $filter = $request->query('f', []);
        $filterHelper = $request->query('h_f', []);

        $model = Analytics::getModel();

        $filter['order_by'] = $model->checkColumn($filter['order_by'] ?? 'updated_at', 'updated_at');
        $filter['order_dir'] = $filter['order_dir'] ?? 'DESC';

        $builder = Analytics::orderBy($filter['order_by'], $filter['order_dir']);

        $builder->addWhereCondition([
            'dates' => ['startTime'],
            'strings' => ['userIdentifier', 'platform'],
        ], $filter, $filterHelper);

        $grid = new Datagrid($builder->get(), $filter);


        $grid
            ->setColumn('id', 'ID', [
                'hasFilters' => false,
                'sortable'    => false,
            ])
            ->setColumn('userIdentifier', 'User')
            ->setColumn('startTime', 'Date', [
                'sortable' => true,
                'wrapper' => function ($value, $row) {
                    return $row->getData()->startTime->diffForHumans();
                }
            ])
            ->setColumn('duration', 'Session duration', [
                'sortable' => true,
                'wrapper' => function ($value, $row) {
                    $value /= 1000;
                    $minutes = (int) ($value / 60);
                    $seconds = round($value - $minutes * 60);
                    return $minutes . ' min ' . ($seconds ? $seconds . ' sec' : '');
                }
            ])
            ->setColumn('deviceModel', 'Device model')
            ->setColumn('platform', 'Operation system', [
                'sortable' => true,
                'wrapper' => function ($value, $row) {
                    return $row->platform . ' ' . $row->osVersion;
                }
            ])
            ->setActionColumn([
                'wrapper' => function ($value, $row) {
                    return '<a href="' . route('backoffice.analytics.show', ['id' => $row->id]) . '" class="btn btn-primary">Show</a>'
                        . '<button type="button" data-method="delete" data-href="' . route('backoffice.analytics.delete', ['id' => $row->id]) . '" class="btn btn-danger ml-2" data-confirm="Are you sure to delete analytics data?">Delete</button>';
                }
            ]);

        return view('backoffice.analytics.list', [
            'grid' => $grid
        ]);
    }

    public function show(Request $request, $id) {
        $model = Analytics::findOrFail($id);

        return view('backoffice.analytics.show', [
            'model' => $model,
        ]);
    }

    public function destroy(Request $request, $id) {
        if (!$request->isXmlHttpRequest()) {
            abort(400, 'Do not repeat this request again');
        }

        $model = Analytics::findOrFail($id);

        if ($model->delete()) {
            return response()->json([
                'status' => 'success',
                'redirect' => route('backoffice.analytics'),
                'message' => 'Analytics data deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Analytics data deletion failed.'
            ]);
        }
    }

}