<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithResourceController;
use App\DataTables\Pengurusan\HEP\PusatIslam\JadualTugasanDataTable;
use App\Http\Controllers\Controller;
use App\Models\PusatIslam\JadualTugasan;
use Illuminate\Http\Request;

class JadualTugasanController extends Controller
{
    use InteractsWithResourceController;

    protected $model = JadualTugasan::class;

    protected $compactName = 'jadual-tugasan';

    protected string $moduleView = 'pages.pengurusan.hep.pusat-islam.jadual-tugasan';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, JadualTugasanDataTable $dataTable)
    {
        $this->authorize('viewAny', $this->model);

        return $dataTable->render($this->getModuleView().'.index');
    }
}
