<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithResourceController;
use App\DataTables\Pengurusan\HEP\PusatIslam\RekodKehadiranDataTable;
use App\Http\Controllers\Controller;
use App\Models\PusatIslam\RekodKehadiran;
use Illuminate\Http\Request;

class RekodKehadiranController extends Controller
{
    use InteractsWithResourceController;

    protected $model = RekodKehadiran::class;

    protected $compactName = 'rekod-kehadiran';

    protected string $moduleView = 'pages.pengurusan.hep.pusat-islam.rekod-kehadiran';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, RekodKehadiranDataTable $dataTable)
    {
        $this->authorize('viewAny', $this->model);

        return $dataTable->render($this->getModuleView().'.index');
    }
}
