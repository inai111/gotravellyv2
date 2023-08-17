@foreach($data as $row)
<option value="{{$row['id']}}">{{$row['attributes']['name']}}</option>
@endforeach