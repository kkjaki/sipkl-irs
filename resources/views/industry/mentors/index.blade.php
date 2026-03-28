@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">
        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Pendamping Industri') }}
                </h2>
            </div>
        </header>

        <div class="w-full mx-auto">
            <div
                class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">

                <!-- Header Data -->
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 flex justify-between items-center relative rounded-t-xl text-white">
                <div class="flex items-center gap-2.5 text-white">
                    <x-heroicon-o-users class="w-6 h-6"/>
                    <h2 class="font-bold text-lg m-0">Data Pendamping</h2>
                </div>
                    <a href="{{ route('mentors.create') }}" class="bg-white text-teal-600 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-semibold flex items-center gap-2 transition-colors shadow-sm">
                        <x-heroicon-o-plus class="w-4 h-4"/> Tambah Pendamping
                    </a>
                </div>

                <!-- Grid Data Pendamping -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t-0 rounded-b-lg">
                    @forelse ($mentors as $mentor)
                        <div class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col h-full">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-700 font-bold shrink-0">
                                        {{ strtoupper(substr($mentor->user->name, 0, 1)) }}
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $mentor->user->name }}</h3>
                                </div>
                                <span class="bg-teal-50 text-teal-600 px-3 py-1 rounded-full text-xs font-semibold border border-teal-100">{{ $mentor->position }}</span>
                            </div>
                            
                            <div class="flex items-center gap-3 mb-6 flex-1">
                                <x-heroicon-o-envelope class="w-5 h-5 text-gray-400 shrink-0" />
                                <span class="text-sm text-gray-600">{{ $mentor->user->email }}</span>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                                <a href="{{ route('mentors.edit', ['mentor' => $mentor->id]) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                    <x-heroicon-o-pencil class="w-4 h-4" /> Edit
                                </a>
                                <section x-data="{ open: false }" class="flex-1">
                                    <button @click="open = true"
                                        class="w-full h-full flex justify-center items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                        <x-heroicon-o-x-mark class="w-4 h-4" /> Nonaktif
                                    </button>
                                    {{-- Modal --}}
                                    <template x-if="open">
                                        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div class="w-fit px-16 sm:px-32 py-7 bg-white rounded-md flex flex-col justify-center items-center gap-8">
                                                <section class="flex flex-col">
                                                    <span class="text-center text-neutral-800 text-xl">Apakah Anda yakin ingin menonaktifkan</span>
                                                    <span class="text-center text-neutral-800 text-xl font-bold">Pendamping ini?</span>
                                                </section>
                                                <div class="flex justify-center items-center gap-8 w-full mt-4">
                                                    <button @click="open = false" type="button" class="px-5 py-2 rounded-md outline outline-1 outline-stone-300 hover:bg-gray-400 hover:text-white hover:outline-none text-lg">
                                                        Tidak
                                                    </button>
                                                    <button @click="open = false" type="button" class="px-7 py-2 rounded-md text-white bg-brand-primary hover:bg-teal-500 hover:text-white text-lg">
                                                        Ya
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </section>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full w-full text-center py-10 rounded-xl bg-gray-50 border border-gray-100 mt-4"><p class="text-gray-500">Tidak ada data ditemukan.</p></div>
                    @endforelse
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection