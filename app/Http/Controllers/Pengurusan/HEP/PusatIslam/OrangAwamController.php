<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithResourceController;
use App\DataTables\Pengurusan\HEP\PusatIslam\KelasOrangAwamDataTable;
use App\Http\Controllers\Controller;
use App\Models\PusatIslam\KelasOrangAwam;
use Illuminate\Http\Request;

class OrangAwamController extends Controller
{
    use InteractsWithResourceController;

    protected $model = KelasOrangAwam::class;

    protected $compactName = 'orang-awam';

    protected string $moduleView = 'pages.pengurusan.hep.pusat-islam.orang-awam';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, KelasOrangAwamDataTable $dataTable)
    {
        $this->authorize('viewAny', $this->model);

        return $dataTable->render($this->getModuleView().'.index');
    }
}
