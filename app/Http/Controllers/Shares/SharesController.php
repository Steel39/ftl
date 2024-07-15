<?php

namespace App\Http\Controllers\Shares;

use App\Services\InstrumentService\Shares as ServiceShares;
use App\Http\Controllers\Controller;
use App\Models\Shares as ModelsShares;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SharesController extends Controller
{
    private $service;
    private $shares;

    public $data;

    public function __construct(ServiceShares $service, ModelsShares $shares)
    {
        $this->service = $service;
        $this->shares = $shares;
    }

    public function show() : array
    {
        $this->data = DB::table('shares')->get()->toArray();
       // dd($this->data);
        return $this->data;
    }

    public function store() : string 
    {
        $this->service->setShares();
        return 'Акции успешно загружены с сервера Т в базу данных';
    }

    public function destroy() : string 
    {
        DB::table('shares')->delete();
        return 'Акции удалены из базы данных';
    }
}
