@foreach ($pbarcodes as $key => $value)
    <tr>
      <td class="no" style="text-align:center;padding-top:15px;width:60px;">
        {{ ++$key }}
      </td>
      <td>
        <input type="text" class="form-control barcode canenter" style="height:40px;width:200px;" name="barcode[]" required autocomplete="off">
      </td>
      <td>
        <select class="form-control unit" style="height:40px;width:120px;" name="unit[]" id="unit{{ $key }}" required>
          @foreach ($units as $u)
            <option value="{{ $u->name }}" {{ $u->name==$value->unit?'selected':'' }}>{{ $u->name }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="text" class="form-control price canenter" name="price[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->price,2,'.',','):number_format($value->price) }}" autocomplete="off">
      </td>
      <td>
        <select name="cur[]" class="form-control" style="height:40px;width:80px;">
          <option value="R" {{ $value->cur=='R'?'selected':'' }}>R</option>
          <option value="B" {{ $value->cur=='B'?'selected':'' }}>B</option>
          <option value="$" {{ $value->cur=='$'?'selected':'' }}>$</option>

        </select>
      </td>
      <td><input type="text" class="form-control price canenter" name="dealer[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->dealer,2,'.',','):number_format($value->dealer) }}" autocomplete="off">
      </td>
      <td><input type="text" class="form-control price canenter" name="member[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->member,2,'.',','):number_format($value->member) }}" autocomplete="off">
      </td>
      <td><input type="text" class="form-control price canenter" name="vip[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->vip,2,'.',','):number_format($value->vip) }}" autocomplete="off">
      </td>
      <td><input type="text" class="form-control price canenter" name="suppervip[]" required style="text-align:right;height:40px;font-size:16px;width:120px;" value="{{ $value->cur=='$'?number_format($value->suppervip,2,'.',','):number_format($value->suppervip) }}" autocomplete="off">
      </td>
      <td>
        <input type="text" class="form-control multi canenter" style="height:40px;width:80px;" name="multi[]" value="{{ $value->multiple }}" required autocomplete="off">
      </td>
      <td>
        <a href="#" class="btn btn-danger remove" style="border-radius:15px;margin-top:5px;"><i class="fa fa-minus"></i></a>
      </td>
    </tr>
  @endforeach