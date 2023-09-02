<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithResourceController;
use App\DataTables\Pengurusan\HEP\PusatIslam\AktivitiDataTable;
use App\Http\Controllers\Controller;
use App\Models\PusatIslam\Aktiviti;
use Illuminate\Http\Request;

class AktivitiController extends Controller
{
    use InteractsWithResourceController;

    protected $model = Aktiviti::class;

    protected $compactName = 'aktiviti';

    protected string $moduleView = 'pages.pengurusan.hep.pusat-islam.aktiviti';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, AktivitiDataTable $dataTable)
    {
        $this->authorize('viewAny', $this->model);

        return $dataTable->render($this->getModuleView().'.index');
    }
}
