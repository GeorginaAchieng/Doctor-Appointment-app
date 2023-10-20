@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Appointments</h2>
            </div>
            <div class="pull-right">
                @can('Appointment-create')
                <a class="btn btn-success" href="{{ route('appointments.create') }}"> Create New Appointment</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Date</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($appointments as $Appointment)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $appointments->name }}</td>
	        <td>{{ $appointments->date }}</td>
	        <td>
                <form action="{{ route('appointments.destroy',$Appointment->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('appointments.show',$Appointment->id) }}">Show</a>
                    @can('Appointment-edit')
                    <a class="btn btn-primary" href="{{ route('appointments.edit',$Appointment->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('Appointment-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $appointments->links() !!}


<p class="text-center text-primary"><small>Doctor-Appointment-Management</small></p>
@endsection