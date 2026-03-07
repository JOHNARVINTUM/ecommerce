@extends('layouts.app')
                            <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('scheduled_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="scheduled_time" class="mb-2 block text-sm font-medium text-gray-700">Preferred Time</label>
                            <input type="time" name="scheduled_time" id="scheduled_time" value="{{ old('scheduled_time') }}"
                                   class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('scheduled_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="mb-2 block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Tell the provider anything important about your request...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                            Place Order
                        </button>

                        <a href="{{ route('services.show', $service->slug) }}"
                           class="inline-flex items-center rounded-lg border px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <div class="rounded-2xl border bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-gray-900">Order Summary</h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Service</p>
                        <p class="font-semibold text-gray-900">{{ $service->title }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Provider</p>
                        <p class="font-semibold text-gray-900">{{ $service->provider->name ?? 'Provider' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-semibold text-gray-900">{{ $service->category->name ?? 'General' }}</p>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total</span>
                            <span class="text-2xl font-bold text-gray-900">PHP {{ number_format($service->price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection