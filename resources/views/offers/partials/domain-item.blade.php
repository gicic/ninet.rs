@if(empty($data['validatorErrors']))
    @foreach($data['domains'] as $domain)
        <tr class="status{{ $domain['available'] ? '1' : '3' }}">
            <td>
                {{ $domain['name'] }}
                @if(!empty($domain['errors']))
                    @foreach($domain['errors'] as $error)
                        <span class="text-danger">{{ $error }}</span>
                    @endforeach
                @endif
            </td>
            <td>{{ $domain['price'] }} {!! App::getLocale() === 'sr-Latn' ? 'RSD' : '&euro;' !!}</td>
            <td>
                @if($domain['available'])
                    <span class="checkbox right" data-checkbox="block">
                        <input type="checkbox" style="overflow: hidden !important; width: 0;" id="domains_selection_{{ $loop->iteration }}" class="domains_selection_item" name="domain_tlds[]" value="{{ $domain['id'] }}" data-domain-price="{{ $domain['price'] }}">
                        <label for="domains_selection_{{ $loop->iteration }}"></label>
                    </span>
                @endif
            </td>
        </tr>
    @endforeach
@else
    @foreach($data['validatorErrors'] as $error)
        <tr class="status3"><td>{{ $error }}</td></tr>
    @endforeach
@endif

<input type="hidden" name="domain_sld" value="{{ $data['sld'] }}">