@extends('layouts.admin')

@section ('content')

@if (isset($regions))
<table class="table table-striped table-bordered table-hover table-sm">
    <thead class="thead-dark">
        <tr>
            <th>{{ ucfirst(__('fields.region')) }}</th>
            <th class="column-action">Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($regions as $region)
        <tr>
            <td>{{ $region->region }}</td>

            <td class="column-action px-4">
                <div class="row">
                <a href="{{route('admin.regions.edit', $region->id)}}" class="btn btn-primary col" title="{{__('buttons.edit')}} {{ $region->region }}">{{__('buttons.edit')}}</a>
                
                {!! Form::open(array('route' => array('admin.regions.destroy', $region->id), 'method' => 'DELETE', 'class' => 'col modalOpener', 'id' => 'id-' . $region->id)) !!}
                <button id="button-{{ $region->id }}" type="submit" class="btn btn-danger modalDelete"
                    title="{{__('buttons.delete')}} {{ $region->region }}">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    {{__('buttons.delete') }}</button>
                {!! Form::close() !!}
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include ('admin/widgets/modal-delete')

<a href="{{route('admin.regions.create')}}" class="btn btn-primary" title="{{__('buttons.create')}} {{ ucfirst(__('fields.region')) }}">{{__('buttons.create')}} {{ ucfirst(__('fields.region')) }}</a>
@endif

@endsection