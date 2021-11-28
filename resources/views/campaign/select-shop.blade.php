<h5>Select Your Shop</h5>
<select class="form-control m-b" name="shop_id">
    @foreach($availableShops as $shop)
        <option value="{{$shop->id}}" @if(count($availableShops) == '1') disabled selected
                @endif @if(old('shop_id') == '{{$shop->id}}') selected @endif>{{$shop->shop_name}}</option>
    @endforeach
</select>
<div class="hr-line-dashed"></div>
