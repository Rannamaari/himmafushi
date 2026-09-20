<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request {{ $guesthouse->name }} | Himmafushi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    <main class="mx-auto max-w-2xl px-6 py-12">
        <a href="{{ route('guesthouses.index') }}" class="text-sm text-gray-500">Guesthouses</a>
        <h1 class="mt-4 text-3xl font-bold">{{ $guesthouse->name }}</h1>
        @if (session('success'))<div class="mt-6 rounded-lg border border-green-300 bg-green-100 p-4">{{ session('success') }}</div>@endif
        @if ($errors->any())<div class="mt-6 rounded-lg bg-red-100 p-4"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="POST" action="{{ route('guesthouse-bookings.store') }}" class="mt-8 space-y-5 rounded-lg bg-white p-6 shadow">
            @csrf
            <input type="hidden" name="guesthouse_id" value="{{ $guesthouse->id }}">
            <div><label class="mb-2 block font-medium" for="customer_type">I am</label><select id="customer_type" name="customer_type" class="w-full rounded-lg border p-3" required><option value="tourist">International Guest</option><option value="local">Maldives Local / Resident</option></select></div>
            <div><label class="mb-2 block font-medium" for="name">Full Name</label><input id="name" type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border p-3" required></div>
            <div><label class="mb-2 block font-medium" for="whatsapp">WhatsApp Number</label><input id="whatsapp" type="text" name="whatsapp" value="{{ old('whatsapp') }}" class="w-full rounded-lg border p-3" required></div>
            <div><label class="mb-2 block font-medium" for="email">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border p-3"></div>
            <div><label class="mb-2 block font-medium" for="country">Country</label><input id="country" type="text" name="country" value="{{ old('country') }}" class="w-full rounded-lg border p-3"></div>
            <div class="grid grid-cols-2 gap-4"><div><label class="mb-2 block font-medium" for="check_in">Check-in</label><input id="check_in" type="date" name="check_in" value="{{ old('check_in') }}" min="{{ now()->toDateString() }}" class="w-full rounded-lg border p-3" required></div><div><label class="mb-2 block font-medium" for="check_out">Check-out</label><input id="check_out" type="date" name="check_out" value="{{ old('check_out') }}" class="w-full rounded-lg border p-3" required></div></div>
            <div class="grid grid-cols-2 gap-4"><div><label class="mb-2 block font-medium" for="adults">Adults</label><input id="adults" type="number" name="adults" value="{{ old('adults', 1) }}" min="1" class="w-full rounded-lg border p-3" required></div><div><label class="mb-2 block font-medium" for="children">Children</label><input id="children" type="number" name="children" value="{{ old('children', 0) }}" min="0" class="w-full rounded-lg border p-3"></div></div>
            <div><label class="mb-2 block font-medium" for="room_preference">Room Preference</label><input id="room_preference" type="text" name="room_preference" value="{{ old('room_preference') }}" class="w-full rounded-lg border p-3"></div>
            <div><label class="mb-2 block font-medium" for="meal_plan">Meal Plan</label><input id="meal_plan" type="text" name="meal_plan" value="{{ old('meal_plan') }}" class="w-full rounded-lg border p-3"></div>
            <div><label class="mb-2 block font-medium" for="notes">Notes</label><textarea id="notes" name="notes" rows="4" class="w-full rounded-lg border p-3">{{ old('notes') }}</textarea></div>
            <button type="submit" class="w-full rounded-lg bg-black py-4 font-semibold text-white">Request Accommodation</button>
        </form>
    </main>
</body>
</html>
