<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-sm text-gray-600">Selamat datang di dashboard. Kamu berhasil login.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('notes.index') }}"
                   class="block p-4 bg-blue-50 hover:bg-blue-100 transition rounded-lg shadow-sm border border-blue-200">
                    <h4 class="font-semibold text-blue-700">📝 Catatan Kamu</h4>
                    <p class="text-sm text-blue-600 mt-1">Lihat atau kelola catatan yang sudah kamu buat.</p>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="block p-4 bg-green-50 hover:bg-green-100 transition rounded-lg shadow-sm border border-green-200">
                    <h4 class="font-semibold text-green-700">👤 Profil</h4>
                    <p class="text-sm text-green-600 mt-1">Ubah informasi akunmu dan keamanan login.</p>
                </a>
            </div>

            <div class="mt-6 text-sm text-gray-500 text-center">
                Semangat terus belajarnya, jangan cuma login terus bengong 😄
            </div>
        </div>
    </div>
</x-app-layout>
