<?php
    
namespace App\Http\Controllers;
    
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
    
class AppointmentController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:Appointment-list|Appointment-create|Appointment-edit|Appointment-delete', ['only' => ['index','show']]);
         $this->middleware('permission:Appointment-create', ['only' => ['create','store']]);
         $this->middleware('permission:Appointment-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Appointment-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $appointments = Appointment::latest()->paginate(5);
        return view('appointments.index',compact('appointments'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('appointments.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'details' => 'required',
        ]);
    
        Appointment::create($request->all());
    
        return redirect()->route('appointments.index')
                        ->with('success','Appointment created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $Appointment): View
    {
        return view('appointments.show',compact('Appointment'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $Appointment): View
    {
        return view('appointments.edit',compact('Appointment'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $Appointment): RedirectResponse
    {
         request()->validate([
            'name' => 'required',
            'details' => 'required',
        ]);
    
        $Appointment->update($request->all());
    
        return redirect()->route('appointments.index')
                        ->with('success','Appointment updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $Appointment): RedirectResponse
    {
        $Appointment->delete();
    
        return redirect()->route('appointments.index')
                        ->with('success','Appointment deleted successfully');
    }
}