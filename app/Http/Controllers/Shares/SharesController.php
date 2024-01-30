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
    private $storeData;

    private $shares;

    public $data;

    public function __construct(ServiceShares $service, ModelsShares $shares)
    {
        $this->service = $service;
        $this->shares = $shares;
    }

    public function getData() {
        $this->data = DB::table('shares')->get()->toArray();
        dd($this->data);
        return $this->data;
    }

    public function store() : bool {
        $this->storeData = $this->service->getDataStore();
        $result =  DB::table('shares')->insert($this->storeData);
        return $result;
    }

    public function destroy() : void {
        
    }
}
