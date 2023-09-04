<?php

namespace App\Http\Controllers\Pengurusan\HEP\KemahiranInsaniah;

use App\Concerns\InteractsWithResourceController;
use App\DataTables\Pengurusan\HEP\KemahiranInsaniah\SesiPilihanRayaDataTable;
use App\Http\Controllers\Controller;
use App\Models\KemahiranInsaniah\PilihanRaya\Sesi;
use Illuminate\Http\Request;

class PilihanRayaController extends Controller
{
    use InteractsWithResourceController;

    protected $model = Sesi::class;

    protected $compactName = 'sesi';

    protected string $moduleView = 'pages.pengurusan.hep.kemahiran-insaniah.pilihan-raya';

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SesiPilihanRayaDataTable $dataTable)
    {
        $this->authorize('viewAny', $this->model);

        return $dataTable->render($this->getModuleView().'.index');
    }
}
