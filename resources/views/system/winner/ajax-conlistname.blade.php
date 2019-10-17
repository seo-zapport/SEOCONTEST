<label>Search</label>  
<select  id="searchname" name="searchname" data-placeholder="Choose a name..." class="chosen-select form-control m-b" style="width:100%" tabindex="2" onchange="searchfilter(this);"  >
   <option value="">--- Select Contest Name ---</option>
  @if(count($registername)>0)
      @foreach ($registername as $name)
          <option value="{{ucfirst($name->reg_name)}}">{{ucfirst($name->reg_name)}}</option>
      @endforeach
      @else
     
  @endif  
</select>