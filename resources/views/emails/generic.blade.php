@extends('emails._partials.layout')

@section('content')
<tr>
<td>{!! nl2br($body) !!}</td>
</tr>

@endsection