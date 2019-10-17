
<label>Language</label>    
<select class="form-control m-b" id="langname" name="langname"  >
    <option value="">--- Select Language ---</option>
    @foreach ($lang as $langs)  
        <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$page->id) selected="selected" @endif> {{ $langs->name}} </option>
    @endforeach
</select> 