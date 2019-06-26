<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateSaleRequest;
use App\Http\Requests\Admin\UpdateSaleRequest;
use App\Repositories\Admin\SaleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Auth;
use App\Models\Admin\Sale;

class SaleController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->hasRole('admin'))
        {
            $sales = Sale::all();
        }else{
            $sales = $user->sales;
        }

        /**
         * Must be fixed
         * Remove Sales records if pending is 1
         */
        foreach($sales as $key=>$sale)
        {
            if($sale->pending == 1)
                unset($sales[$key]);
        }
        return view('admin.sales.index')
            ->with('sales', $sales);
    }

    /**
     * Show the form for creating a new Sale.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.sales.create');
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param CreateSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateSaleRequest $request)
    {
        $input = $request->all();

        $sale = $this->saleRepository->create($input);

        Flash::success('Sale saved successfully.');

        return redirect(route('admin.sales.index'));
    }

    /**
     * Display the specified Sale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sale = $this->saleRepository->findWithoutFail($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('admin.sales.index'));
        }
        $sale->personalInfo = unserialize($sale->personalInfo);
        return view('admin.sales.show')->with('sale', $sale);
    }

    /**
     * Show the form for editing the specified Sale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sale = $this->saleRepository->findWithoutFail($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('admin.sales.index'));
        }

        return view('admin.sales.edit')->with('sale', $sale);
    }

    /**
     * Update the specified Sale in storage.
     *
     * @param  int              $id
     * @param UpdateSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaleRequest $request)
    {
        $sale = $this->saleRepository->findWithoutFail($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('admin.sales.index'));
        }

        $sale = $this->saleRepository->update($request->all(), $id);

        Flash::success('Sale updated successfully.');

        return redirect(route('admin.sales.index'));
    }

    /**
     * Remove the specified Sale from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sale = $this->saleRepository->findWithoutFail($id);

        if (empty($sale)) {
            Flash::error('Sale not found');

            return redirect(route('admin.sales.index'));
        }

        $this->saleRepository->delete($id);

        Flash::success('Sale deleted successfully.');

        return redirect(route('admin.sales.index'));
    }
}
