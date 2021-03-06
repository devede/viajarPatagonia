@extends('layouts.admin')

@section ('content')

@if (isset($currencies))
<table class="table table-striped table-bordered table-hover table-sm">
    <thead class="thead-dark">
        <tr>
            <th>{{ ucfirst(__('fields.sign')) }}</th>
            <th>{{ ucfirst(__('fields.iso')) }}</th>
            <th>{{ ucfirst(__('fields.currency')) }}</th>
            <th>{{ ucfirst(__('fields.amount')) }}</th>
            <th class="column-action">Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($currencies as $currency)
        <tr>
            <td>{{ $currency->sign }}</td>
            <td>{{ $currency->iso }}</td>
            <td>{{ $currency->currency }}</td>
            <td>{{ $currency->amount }}</td>

            <td class="column-action px-4">
                <div class="row">
                <a href="{{route('admin.currencies.edit', $currency->id)}}" class="btn btn-primary col" title="{{__('buttons.edit')}} {{ $currency->currency }}">{{__('buttons.edit')}}</a>
                
                {!! Form::open(array('route' => array('admin.currencies.destroy', $currency->id), 'method' => 'DELETE', 'class' => 'col modalOpener', 'id' => 'id-' . $currency->id)) !!}
                <button id="button-{{ $currency->id }}" type="submit" class="btn btn-danger modalDelete"
                    title="{{__('buttons.delete')}} {{ $currency->currency }}">
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

<a href="{{route('admin.currencies.create')}}" class="btn btn-primary" title="{{__('buttons.create')}} {{ ucfirst(__('fields.currency')) }}">{{__('buttons.create')}} {{ ucfirst(__('fields.currency')) }}</a>
@endif

@endsection