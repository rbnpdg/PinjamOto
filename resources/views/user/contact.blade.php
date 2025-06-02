@extends('layout.user-nav')

@section('content')
<section class="h-screen flex items-center justify-center relative bg-white overflow-hidden">
    <style>
        #contact-form .form-input,
        #contact-form .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 2px solid #e5e7eb; /* Tailwind gray-200 */
            background-color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        #contact-form .form-input:focus,
        #contact-form .form-textarea:focus {
            outline: none;
            border-color: #ff5a33;
            box-shadow: 0 0 0 3px rgba(255, 90, 51, 0.2);
        }

        #contact-form .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        #contact-form .form-button {
            background-color: #ff2e2e;
            color: white;
            font-weight: bold;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 6px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #contact-form .form-button:hover {
            background-color: #e02626;
            transform: scale(1.05);
        }

        @media (max-width: 640px) {
            #circle-background {
                width: 400px;
                height: 400px;
            }
        }
    </style>

    <div class="container mx-auto px-4 text-center relative z-10">
        <h3 class="text-3xl font-bold mb-8 text-gray-800 tracking-wide">GET IN TOUCH</h3>

        <div class="max-w-xl mx-auto">
            <form id="contact-form" class="space-y-5">
                <input type="text" placeholder="Name" class="form-input" required>
                <input type="email" placeholder="Email" class="form-input" required>
                <input type="text" placeholder="Phone Number" class="form-input" required>
                <textarea placeholder="Message" class="form-textarea" required></textarea>
                <button type="submit" class="form-button">SEND</button>
            </form>
        </div>
    </div>

    <!-- Orange Circle Background -->
    <div class="absolute inset-x-0 top-1/2 transform -translate-y-1/2 flex justify-center z-0">
        <div class="w-[600px] h-[600px] bg-[#FF5A33] rounded-full shadow-2xl" id="circle-background"></div>
    </div>
</section>
@endsection
