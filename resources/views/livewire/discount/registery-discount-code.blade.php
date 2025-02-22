<div>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Enter Phone Number</h2>
        <form wire:submit.prevent="submit">
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" wire:model="phone" class="form-control" placeholder="Enter phone number">
                @error('phone') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>

            @if ($discount_code)
                <div class="mb-3">
                    <label for="discount_code" class="form-label">Your Discount Code:</label>
                    <input type="text" id="discount_code" value="{{ $discount_code }}" class="form-control" readonly>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        @if (session()->has('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
    </div>
</div>
