<form method="POST" action="{{ isset($purchaseAgreement) ? route('purchase-agreements.update', $purchaseAgreement) : route('purchase-agreements.store') }}">
    @csrf
    @if(isset($purchaseAgreement))
        @method('PUT')
    @endif

    <div>
        <label for="property_id">Property</label>
        <select name="property_id" id="property_id" required>
            @foreach($properties as $property)
                <option value="{{ $property->id }}" {{ old('property_id', $purchaseAgreement->property_id ?? '') == $property->id ? 'selected' : '' }}>
                    {{ $property->address }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="seller_name">Seller Name</label>
        <input type="text" name="seller_name" id="seller_name" value="{{ old('seller_name', $purchaseAgreement->seller_name ?? '') }}" required>
    </div>

    <div>
        <label for="purchase_price">Purchase Price</label>
        <input type="number" name="purchase_price" id="purchase_price" step="0.01" value="{{ old('purchase_price', $purchaseAgreement->purchase_price ?? '') }}" required>
    </div>

    <div>
        <label for="earnest_money">Earnest Money</label>
        <input type="number" name="earnest_money" id="earnest_money" step="0.01" value="{{ old('earnest_money', $purchaseAgreement->earnest_money ?? '') }}" required>
    </div>

    <div>
        <label for="closing_date">Closing Date</label>
        <input type="date" name="closing_date" id="closing_date" value="{{ old('closing_date', $purchaseAgreement->closing_date ?? '') }}" required>
    </div>

    <div>
        <label for="possession_date">Possession Date</label>
        <input type="date" name="possession_date" id="possession_date" value="{{ old('possession_date', $purchaseAgreement->possession_date ?? '') }}" required>
    </div>

    <div>
        <label>Contingencies</label>
        <div>
            <input type="checkbox" name="contingencies[]" id="financing" value="financing" {{ in_array('financing', old('contingencies', $purchaseAgreement->contingencies ?? [])) ? 'checked' : '' }}>
            <label for="financing">Financing</label>
        </div>
        <div>
            <input type="checkbox" name="contingencies[]" id="inspection" value="inspection" {{ in_array('inspection', old('contingencies', $purchaseAgreement->contingencies ?? [])) ? 'checked' : '' }}>
            <label for="inspection">Inspection</label>
        </div>
        <div>
            <input type="checkbox" name="contingencies[]" id="appraisal" value="appraisal" {{ in_array('appraisal', old('contingencies', $purchaseAgreement->contingencies ?? [])) ? 'checked' : '' }}>
            <label for="appraisal">Appraisal</label>
        </div>
        <div>
            <input type="checkbox" name="contingencies[]" id="sale" value="sale" {{ in_array('sale', old('contingencies', $purchaseAgreement->contingencies ?? [])) ? 'checked' : '' }}>
            <label for="sale">Sale of Existing Home</label>
        </div>
    </div>

    <div>
        <label for="additional_terms">Additional Terms</label>
        <textarea name="additional_terms" id="additional_terms">{{ old('additional_terms', $purchaseAgreement->additional_terms ?? '') }}</textarea>
    </div>

    <div>
        <input type="checkbox" name="agree_terms" id="agree_terms" value="1" {{ old('agree_terms', $purchaseAgreement->agree_terms ?? false) ? 'checked' : '' }} required>
        <label for="agree_terms">I agree to the terms and conditions</label>
    </div>

    <button type="submit">{{ isset($purchaseAgreement) ? 'Update' : 'Submit' }} Purchase Agreement</button>
</form>
