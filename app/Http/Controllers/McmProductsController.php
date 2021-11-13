<?php

namespace App\Http\Controllers;

use App\Models\mcmProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use Illuminate\Auth\Events\Validated;

/**
 * @OA\Info(
 *  title="MCM Products API", 
 *  version="0.1"
 * )
 */

/**
 * @OA\Get(
 *   path="/api/products/Aug/sales",
 *   summary="Products",
 *   @OA\Response(
 *     response=200,
 *     description="Products Description"
 *   ),
 *   @OA\Response(
 *     response="default",
 *     description="Error Occurred"
 *   )
 * )
 */

class McmProductsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse(DB::select('SELECT COUNT(ID) AS TOTAL FROM MCM_PRODUCTS')[0]->TOTAL, 'Total Available Products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return 'Store';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mcmProducts  $mcmProducts
     * @return \Illuminate\Http\Response
     */
    public function show(mcmProducts $mcmProducts, $id)
    {
        return 'Show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mcmProducts  $mcmProducts
     * @return \Illuminate\Http\Response
     */
    public function edit(mcmProducts $mcmProducts, $id)
    {
        return 'Edit';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mcmProducts  $mcmProducts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mcmProducts $mcmProducts, $id)
    {
        // $count = mcmProducts::all()->count();
        // for($i = 1; $i <= $count; $i++) {
        //     mcmProducts::where('id', $i)->update([
        //         'name' => 'Product ' . $i
        //     ]);
        // }        
        return 'Update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mcmProducts  $mcmProducts
     * @return \Illuminate\Http\Response
     */
    public function destroy(mcmProducts $mcmProducts, $id)
    {
        return 'Destroy';
    }

    /**
     * Display Best Selling Products
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $range
     */
    public function best(Request $request, $range) 
    {
        $best = $list = array();
        for($i = 1; $i <= DB::select('SELECT COUNT(ID) AS TOTAL FROM MCM_PRODUCTS')[0]->TOTAL; $i++) 
            $list[$i] = DB::select('SELECT COUNT(ID) AS TOTAL FROM MCM_ORDER_ITEMS WHERE PRODUCT_ID = ?', [$i])[0]->TOTAL;
        arsort($list, SORT_REGULAR);
        $limit = max($list) - (int)$range;
        for($i = max($list); $i > $limit; $i--) {
            $best[$i] = array();
            for($j = 1; $j < count($list); $j++) 
                if($list[$j] === $i)    array_push($best[$i], $j);
            if(empty($best[$i])) {
                unset($best[$i]);
                --$limit;
            }
        }   
        return $this->successResponse($best, 'Best Selling Products (Top ' . $range .')');
    }

    /**
     * Display Monthly Sales (by Month)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $month
     */
    public function sales(Request $request, $month) 
    {
        $months = ['Jan' => ['01', 'January'], 'Feb' => ['02', 'February'], 'Mar' => ['03', 'March'], 'Apr' => ['04', 'April'], 'May' => ['05', 'May'], 'Jun' => ['06', 'June'], 'Jul' => ['07', 'July'], 'Aug' => ['08', 'August'], 'Sep' => ['09', 'September'], 'Oct' => ['10', 'October'], 'Nov' => ['11', 'November'], 'Dec' => ['12', 'December']];
        $sales = array();
        foreach(DB::select('SELECT ID FROM MCM_ORDERS WHERE ORDER_DATE LIKE ?', ['%-'.$months[$month][0].'-%']) as $sale)
            array_push($sales, $sale->ID);
        $data = [
            'Total Orders' => DB::select('SELECT COUNT(ID) AS TOTAL FROM MCM_ORDERS')[0]->TOTAL,
            $months[$month][1] . ' Orders' => count($sales),
            'Order IDs' => $sales
        ];
        return $this->successResponse($data, $months[$month][1] . ' Sales');
    }

    /**
     * Validate Address from API
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function validateAddress(Request $request) {
        $request->validate([
            'street' => 'required',
            'locality' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pincode' => 'required'
        ]);
        $unmatched = 0;
        $addresses = DB::select('SELECT OFFICE AS locality, DISTRICT AS city, STATE AS state, PINCODE AS pincode FROM INDIA WHERE PINCODE = ?', [$request['pincode']]);
        if(count($addresses) !== 0) {
            foreach($addresses as $address)
                if( ucwords(strtolower($address->state)) === ucwords(strtolower($request->state)) &&
                    ucwords(strtolower($address->city)) === ucwords(strtolower($request->city)) &&
                    $address->locality === explode('B.O', $request->locality)[0] ?? explode('S.O', $request->locality)[0] ?? explode('H.O', $request->locality)[0] ?? ucwords(strtolower($request->locality))
                )   return $this->successResponse($request->all(), "TRUE - Address Validated");
                else ++$unmatched;
            if($unmatched === count($addresses))
                return $this->successResponse($addresses, "FALSE - Possible Addresses for Pincode");
        }   else return $this->errorResponse('Incorrect Pincode - Please Check Entered Pincode', 200);
    }

}
