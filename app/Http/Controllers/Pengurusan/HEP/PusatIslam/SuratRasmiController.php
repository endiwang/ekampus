<?php

namespace App\Http\Controllers\Pengurusan\HEP\PusatIslam;

use App\Concerns\InteractsWithResourceController;
use App\DataTables\Pengurusan\HEP\PusatIslam\SuratRasmiDataTable;
use App\Http\Controllers\Controller;
use App\Models\PusatIslam\SuratRasmi;
use Illuminate\Http\Request;

class SuratRasmiController extends Controller
{
    use InteractsWithResourceController;

    protected $model = SuratRasmi::class;

    protected $compactName = 'surat-rasmi';

    protected string $moduleView = 'pages.pengurusan.hep.pusat-islam.surat-rasmi';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SuratRasmiDataTable $dataTable)
    {
        $this->authorize('viewAny', $this->model);

        return $dataTable->render($this->getModuleView().'.index');
    }
}
