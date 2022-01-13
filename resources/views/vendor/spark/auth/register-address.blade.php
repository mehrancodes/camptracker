<!-- Address -->
<div class="md:tw-flex md:tw-items-center tw-mb-6">
    <div class="md:tw-w-2/6">
        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="address">
            {{__('Address')}}
        </label>
    </div>
    <div class="md:tw-w-3/6">
        <input
            v-model.lazy="registerForm.address"
            :class="{'tw-border-red-500': registerForm.errors.has('address')}"
            class="tw-form-input tw-block tw-w-full"
            id="address"
            type="text"
            name="address"
            autofocus
        >

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('address')">
            @{{ registerForm.errors.get('address') }}
        </span>
    </div>
</div>

<!-- Address Line 2 -->
<div class="md:tw-flex md:tw-items-center tw-mb-6">
    <div class="md:tw-w-2/6">
        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="addressLine2">
            {{__('Address Line 2')}}
        </label>
    </div>
    <div class="md:tw-w-3/6">
        <input
            v-model.lazy="registerForm.address_line_2"
            :class="{'tw-border-red-500': registerForm.errors.has('address_line_2')}"
            class="tw-form-input tw-block tw-w-full"
            id="addressLine2"
            type="text"
            name="address_line_2"
        >

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('address_line_2')">
            @{{ registerForm.errors.get('address_line_2') }}
        </span>
    </div>
</div>

<!-- City -->
<div class="md:tw-flex md:tw-items-center tw-mb-6">
    <div class="md:tw-w-2/6">
        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="city">
            {{__('City')}}
        </label>
    </div>
    <div class="md:tw-w-3/6">
        <input
            v-model.lazy="registerForm.city"
            :class="{'tw-border-red-500': registerForm.errors.has('city')}"
            class="tw-form-input tw-block tw-w-full"
            id="city"
            type="text"
            name="city"
        >

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('city')">
            @{{ registerForm.errors.get('city') }}
        </span>
    </div>
</div>

<!-- State & ZIP Code -->
<div class="md:tw-flex md:tw-items-center tw-mb-6">
    <div class="md:tw-w-2/6">
        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6">
            {{__('State & ZIP / Postal Code')}}
        </label>
    </div>

    <!-- State -->
    <div class="tw-w-full md:tw-w-3/12 md:tw-pr-2 tw-mb-4 md:tw-mb-0">
        <input
            v-model.lazy="registerForm.state"
            :class="{'tw-border-red-500': registerForm.errors.has('state')}"
            class="tw-form-input tw-block tw-w-full"
            type="text"
            name="state"
            placeholder="{{__('State')}}"
        >

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('state')">
            @{{ registerForm.errors.get('state') }}
        </span>
    </div>

    <!-- Zip Code -->
    <div class="tw-w-full md:tw-w-3/12 md:tw-pl-2 tw-mb-4 md:tw-mb-0">
        <input
            v-model.lazy="registerForm.zip"
            :class="{'tw-border-red-500': registerForm.errors.has('zip')}"
            class="tw-form-input tw-block tw-w-full"
            type="text"
            name="zip"
            placeholder="{{__('Postal Code')}}"
        >

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('zip')">
            @{{ registerForm.errors.get('zip') }}
        </span>
    </div>
</div>

<!-- Country -->
<div class="md:tw-flex md:tw-items-center tw-mb-6">
    <div class="md:tw-w-2/6">
        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="country">
            {{__('Country')}}
        </label>
    </div>
    <div class="md:tw-w-3/6">
        <select
            v-model.lazy="registerForm.country"
            :class="{'tw-border-red-500': registerForm.errors.has('country')}"
            class="tw-form-select tw-block tw-w-full"
        >
            @foreach (app(Laravel\Spark\Repositories\Geography\CountryRepository::class)->all() as $key => $country)
                <option value="{{ $key }}">{{ $country }}</option>
            @endforeach
        </select>

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('country')">
            @{{ registerForm.errors.get('country') }}
        </span>
    </div>
</div>


<!-- European VAT ID -->
<div class="md:tw-flex md:tw-items-center tw-mb-6" v-if="countryCollectsVat">
    <div class="md:tw-w-2/6">
        <label class="tw-block tw-text-gray-700 md:tw-text-right tw-mb-1 md:tw-mb-0 tw-pr-6" for="vat_id">
            {{__('VAT ID')}}
        </label>
    </div>
    <div class="md:tw-w-3/6">
        <input
            v-model.lazy="registerForm.vat_id"
            :class="{'tw-border-red-500': registerForm.errors.has('vat_id')}"
            class="tw-form-input tw-block tw-w-full"
            id="vat_id"
            type="text"
            name="vat_id"
        >

        <span class="tw-mt-1 tw-text-sm tw-text-red-500" v-show="registerForm.errors.has('vat_id')">
            @{{ registerForm.errors.get('vat_id') }}
        </span>
    </div>
</div>
