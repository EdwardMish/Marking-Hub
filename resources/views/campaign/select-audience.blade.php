<h5>Set Your Rules</h5>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Target Audience</th>
        <th>Audience Size</th>
        <th>Est. Address Match (30%)</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($audienceSizes as $audienceSize)
        <tr>
            <td>
                <div class="i-checks"><label><input name="audience" type="radio"
                                                    value="{{ $audienceSize->id }}"
                                                    @if ($audienceSize->id == 20)
                                                    checked="checked"
                            @endif
                        ><i></i> {{ $audienceSize->name }}</label>
                </div>
            </td>
            <td>50,000</td>
            <td>15,000</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="hr-line-dashed"></div>
