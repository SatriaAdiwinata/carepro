@extends('layouts.app') {{-- Assuming you have a main layout file --}}

@section('title', 'Kontak Kami')

@section('content')



<div class="w-full bg-gray-100 shadow-sm mt-20">
  <div class="max-w-5xl mx-20 py-3 px-4 sm:px-6 lg:px-8 ">
    <h1 class="text-2xl font-medium">Kontak Kami</h1>
  </div>
</div>
<section class="max-w-6xl mx-auto px-6 py-12 flex flex-col md:flex-row items-start md:items-center gap-8 mt-19">
    <div class="flex flex-col space-y-6 md:w-1/3">
        <h2 class="text-2xl font-semibold border-b border-gray-300 pb-2 mb-4">
            carepro 
        </h2>
        <address class="not-italic text-gray-700">
            Jln. Ganetri IV No. 4 DPS 80237 Bali
        </address>
        <div class="flex items-center space-x-3 text-gray-700">
            <span aria-hidden="true" class="text-xl">📧</span>
            <a href="mailto:carepro@gmail.com" class="hover:underline">
                carepro@gmail.com
            </a>
        </div>
        <div class="flex items-center space-x-3 text-gray-700">
            <span aria-hidden="true" class="text-xl">📞</span>
            <a href="tel:+6281223344556" class="hover:underline">
                +62 81223344556
            </a>
        </div>
        <div class="flex items-center space-x-3 text-gray-700">
            <span aria-hidden="true" class="text-xl">🌐</span>
            <a href="https://www.carepro.id" target="_blank" rel="noopener noreferrer" class="hover:underline">
                www.carepro.id
            </a>
        </div>
    </div>

    <div class="md:w-2/3 w-full h-64 md:h-90 rounded-md overflow-hidden shadow-md">
        <iframe
            title="Carepro Location Map"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.034682927927!2d115.2169273147813!3d-8.67099359384733!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2410a7a0a3f1d%3A0x7a3a3a3a3a3a3a3a!2sJln.%20Ganetri%20IV%20No.%204%2C%20Denpasar%20Bali!5e0!3m2!1sen!2sid!4v1697040000000!5m2!1sen!2sid"
            width="100%"
            height="100%"
            style="border: 0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</section>