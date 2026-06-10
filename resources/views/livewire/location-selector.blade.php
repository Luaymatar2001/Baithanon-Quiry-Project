<div>
    <div class="field">
        <label class="field-label">المحافظة الحالية <span class="requiredStar">*</span></label>
        <div class="custom-select">
            <select wire:model.live="governorate_id" name="governorate_id" required>
                <option value="">اختر المحافظة</option>
                @foreach($governorates as $gov)
                <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="field">
        <label class="field-label">المدينة الحالية <span class="requiredStar">*</span></label>
        <div class="custom-select">
            <select wire:model.live="city_id" name="city_id" required>
                <option value="">اختر المدينة</option>
                @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="field">
        <label class="field-label">المنطقة الحالية <span class="requiredStar">*</span></label>
        <div class="custom-select">
            <select wire:model.live="location_id" name="location_id" required>
                <option value="">اختر المنطقة</option>
                @foreach($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>