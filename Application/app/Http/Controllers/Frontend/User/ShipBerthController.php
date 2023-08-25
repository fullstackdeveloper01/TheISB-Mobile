<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\ShipBerth;
use App\Http\Requests\StoreShipBerthRequest;
use App\Http\Requests\UpdateShipBerthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class ShipBerthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uid = userAuthInfo()->id;
        $berths = ShipBerth::where('user_id', $uid)->orderByDesc('id')->get();
        return view('frontend.user.berth-space.index', ['berths' => $berths]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $berth_data = new ShipBerth;
        return view('frontend.user.berth-space.create', ['berth_data' => $berth_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShipBerthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShipBerthRequest $request)
    {
        $coordinates = json_decode($request->coordinates);
        $latLng = $coordinates->coordinates[0][0];
        $lat = $latLng->lat;
        $lng = $latLng->lng;

        $additional_params = array_combine($request->additional_params_names, $request->additional_params_values);

        $berth = new ShipBerth;
        $berth->user_id = userAuthInfo()->id;
        $berth->name = $request->name;
        $berth->lat = $lat;
        $berth->lng = $lng;
        $berth->length = $request->length;
        $berth->width = $request->width;
        $berth->depth = $request->depth;
        $berth->rotation = $request->rotation;
        $berth->additional_params = json_encode($additional_params);
        $berth->map_type = $request->map_type;
        $berth->coordinates = $request->coordinates;
        $berth->status = $request->status;

        $berth->save();

        toastr()->success(__('Created Successfully'));
        return redirect()->route('user.berthSpace');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShipBerth  $shipBerth
     * @return \Illuminate\Http\Response
     */
    public function show(ShipBerth $shipBerth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShipBerth  $shipBerth
     * @return 
     */
    public function edit($id)
    {
        $berth_data = ShipBerth::find($id);
        return view('frontend.user.berth-space.edit', compact('berth_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShipBerthRequest  $request
     * @param  \App\Models\ShipBerth  $shipBerth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ShipBerth $shipBerth)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'name' => ['required', 'string', 'max:100'],
            'coordinates' => ['required'],
            'length' => ['required'],
            'width' => ['required'],
            'depth' => ['required'],
            'rotation' => ['required'],
            'additional_params_names' => ['required'],
            'additional_params_values' => ['required'],
            'map_type' => ['required'],
            'status' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $coordinates = json_decode($request->coordinates);
        $latLng = $coordinates->coordinates[0][0];
        $lat = $latLng->lat;
        $lng = $latLng->lng;

        $additional_params = array_combine($request->additional_params_names, $request->additional_params_values);
        $shipBerthData = ShipBerth::find($request->id);
        if($shipBerthData != ''){
            $shipBerthData->name = $request->name;
            $shipBerthData->lat = $lat;
            $shipBerthData->lng = $lng;
            $shipBerthData->length = $request->length;
            $shipBerthData->width = $request->width;
            $shipBerthData->depth = $request->depth;
            $shipBerthData->rotation = $request->rotation;
            $shipBerthData->additional_params = json_encode($additional_params);
            $shipBerthData->map_type = $request->map_type;
            $shipBerthData->coordinates = $request->coordinates;
            $shipBerthData->status = $request->status;

            $shipBerthData->save();

            toastr()->success(__('Updated Successfully'));
            return redirect()->route('user.berthSpace');
        }
        else{
            toastr()->error(__('Record not found'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShipBerth  $shipBerth
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berth = ShipBerth::find($id);
        if($berth != '') {
            $berth->delete();
            toastr()->success(__('Deleted Successfully'));
        }
        return back();
    }
}
