<div>
    <div class="field">
        <label class="field-label">المحافظة</label>
        <div class="custom-select">
            <select wire:model.live="governorate_id" name="governorate_id" >
                <option value="">اختر المحافظة</option>
                @if($governorates)
                    @foreach($governorates as $gov)
                <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                    @endforeach
                @endif
            
            </select>
                 @if($governorateMessage)
                        <small class="error-msg">{{ $governorateMessage }}</small>
                 @endif
            <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>


        </div>
    </div>



    <div class="field">
        <label class="field-label">المدينة</label>
        <div class="custom-select">
            <select wire:model.live="city_id" name="city_id" >
                <option value="">اختر المدينة</option>
                @if($cities)
                  @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
                @endif
              
            </select>
             @if($citiesMessage)
                <small class="error-msg">{{ $citiesMessage }}</small>
             @endif
            <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>

        </div>
    </div>



    <div class="field">
        <label class="field-label">المنطقة</label>
        <div class="custom-select">
            <select wire:model.live="location_id" name="location_id" >
                <option value="">اختر الموقع</option>
                @if($locations)
                  @foreach($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
                @endif
              
            </select>
            @if($locationsMessage)
             <small class="error-msg">{{ $locationsMessage }}</small>
            @endif
            <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
    </div>
</div>