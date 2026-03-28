@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-brand-bg px-10">

        {{-- Header --}}
        <header>
            <div class="w-full py-6">
                <h2 class="font-black text-3xl text-gray-800 leading-tight">
                    {{ __('Sekolah') }}
                </h2>
            </div>
        </header>

        <article
            class="w-full bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 px-5 py-5 flex flex-col gap-4">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-4 flex justify-between items-center relative rounded-t-xl text-white">
                <div class="flex items-center gap-2.5 text-white">
                    <x-heroicon-o-building-library class="w-6 h-6"/>
                    <h2 class="font-bold text-lg m-0">Data Sekolah</h2>
                </div>
                <a href="{{ route('schools.create') }}" class="bg-white text-teal-600 hover:bg-gray-50 px-4 py-2 rounded-md text-sm font-semibold flex items-center gap-2 transition-colors shadow-sm">
                    <x-heroicon-o-plus class="w-4 h-4"/> Tambah Sekolah
                </a>
            </div>

            <article class="w-full mx-auto">
                {{-- Cards --}}
                <article class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse ($schools as $school)
                        <section class="bg-white rounded-xl border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-200 p-5 flex flex-col h-full">
                            <div class="flex items-start gap-3 mb-4">
                                <x-heroicon-s-building-library class="w-6 h-6 text-teal-600 shrink-0 mt-0.5" />
                                <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $school->name }}</h3>
                            </div>
                            
                            <div class="flex flex-col gap-3 mb-6 flex-1">
                                <div class="flex items-start gap-3">
                                    <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400 shrink-0" />
                                    <span class="text-sm text-gray-600">{{ $school->address ?: 'Alamat belum diatur' }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-heroicon-o-phone class="w-5 h-5 text-gray-400 shrink-0" />
                                    <span class="text-sm text-gray-600">{{ $school->phone ?: 'Nomor belum diatur' }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                                <a href="{{ route('schools.edit', $school->id) }}"
                                    class="flex-1 flex justify-center items-center gap-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                    <x-heroicon-o-pencil class="w-4 h-4" /> Edit
                                </a>
                                <section x-data="{ open: false }" class="flex-1">
                                    <button @click="open = true"
                                        class="w-full h-full flex justify-center items-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 py-2 px-3 rounded-lg text-sm font-medium transition-colors">
                                        <x-heroicon-o-trash class="w-4 h-4" /> Hapus
                                    </button>
                                    {{-- Modal --}}
                                    <template x-if="open">
                                        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                            <div class="w-fit px-16 sm:px-32 py-7 bg-white rounded-md flex flex-col justify-center items-center gap-8">
                                                <section class="flex flex-col">
                                                    <span class="text-center text-neutral-800 text-xl">Apakah Anda Yakin ingin</span>
                                                    <span class="text-center text-neutral-800 text-xl font-bold">Menghapus Sekolah Ini?</span>
                                                </section>
                                                <div class="flex justify-center items-center gap-8 w-full mt-4">
                                                    <button @click="open = false" type="button" class="px-5 py-2 rounded-md outline outline-1 outline-stone-300 hover:bg-gray-400 hover:text-white hover:outline-none text-lg">
                                                        Tidak
                                                    </button>
                                                    <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="m-0">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-7 py-2 rounded-md text-white bg-brand-primary hover:bg-teal-500 hover:text-white text-lg">
                                                            Ya
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </section>
                            </div>
                        </section>
                    @empty
                        <div class="col-span-full w-full text-center py-10 rounded-xl bg-gray-50 border border-gray-100 mt-4"><p class="text-gray-500">Tidak ada data ditemukan.</p></div>
                    @endforelse
                </article>
            </article>
        </article>
    </main>
@endsection
