@extends('layouts.app')

@section('content')
    <div class="bg-white relative lg:py-20">
        <div
            class=" flex flex-col items-center justify-between pt-0 pr-10 pb-0 pl-10 mt-0 mr-auto mb-0 ml-auto max-w-7xl xl:px-5 lg:flex-row w-full h-full">
            <div class="flex flex-col items-center w-full pt-5 pr-10 pb-20 pl-10 lg:pt-20 lg:flex-row" id="containerForm">
                <div class="w-full bg-cover relative max-w-md lg:max-w-2xl lg:w-7" id="bgLogo">
                    <div class="flex flex-col items-center justify-center w-full h-full relative lg:pr-10" id="bgLogo">
                        <img src="../img/gcccsLogo.png" />
                    </div>
                </div>
                <div class="w-full mt-20 mr-0 mb-0 ml-0 relative z-10 max-w-2xl lg:mt-0 lg:w-5/12">
                    <div class="flex flex-col items-start justify-start pt-10 pr-10 pb-10 pl-10 bg-white shadow-2xl rounded-xl relative z-10 "
                        id="formInput">
                        <p class="w-full text-4xl font-medium text-center leading-snug font-serif">Sign up for an account
                        </p>
                        <div class="w-full mt-6 mr-0 mb-0 ml-0 relative space-y-8">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="relative">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        First Name</p>
                                    <input id="fname" type="text"
                                        class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('fname') is-invalid @enderror"
                                        name="fname" value="{{ old('fname') }}" required autocomplete="name" autofocus>
                                    @error('fname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        Last Name</p>
                                    <input id="lname" type="text"
                                        class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('lname') is-invalid @enderror"
                                        name="lname" value="{{ old('lname') }}" required autocomplete="name" autofocus>
                                    @error('lname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        Phone Number</p>
                                    <input id="contact" type="text"
                                        class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('contact') is-invalid @enderror"
                                        name="contact" value="{{ old('contact') }}" required autocomplete="name" autofocus>
                                    @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <p class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">Program</p>
                                    <select id="program" name="course_id" class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('program') is-invalid @enderror">
                                        <option value="">Select Program</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('program')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        Year</p>
                                    <select id="year" name="year_id" class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('year') is-invalid @enderror">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->id }}">{{ $year->level }}</option>
                                        @endforeach
                                    </select>
                                    @error('year')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        Email</p>
                                    <input id="email" type="email"
                                        class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        Password</p>
                                    <input id="password" type="password"
                                        class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="relative ">
                                    <p
                                        class="bg-white pt-0 pr-2 pb-0 pl-2 -mt-3 mr-0 mb-0 ml-2 font-medium text-gray-600 absolute">
                                        Confirm Password</p>
                                    <input id="password-confirm" type="password"
                                        class="border placeholder-gray-400 focus:outline-none focus:border-black w-full pt-4 pr-4 pb-4 pl-4 mt-2 mr-0 mb-0 ml-0 text-base block bg-white border-gray-300 rounded-md"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="relative ">
                                    <button type="submit"
                                        class="w-full inline-block pt-4 pr-5 pb-4 pl-5 text-xl font-medium text-center text-white ">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <svg viewBox="0 0 91 91"
                        class="absolute top-0 left-0 z-0 w-32 h-32 -mt-12 -ml-12 text-yellow-300 fill-current">
                        <!-- SVG content omitted for brevity -->
                    </svg>
                    <svg viewBox="0 0 91 91"
                        class="absolute bottom-0 right-0 z-0 w-32 h-32 -mb-12 -mr-12 text-indigo-500 fill-current">
                        <!-- SVG content omitted for brevity -->
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <style>
        #containerForm {
            margin-top: -80px;
            ;
            padding: 0px;


        }

        #bgLogo {

            margin-right: 80px;
            width: 60vh;
        }

        button {
            background: orange;
            border-radius: 3px;
            color: white;

        }

        button:hover {
            font-size: 18px;
            background-color: #ffc457;
            transition: 0.2s ease;

        }

        .relative {
            margin-top: 20px;
        }

        /* Media Query */
        /* Phones (up to 767px) */
        @media only screen and (max-width: 767px) {

            /* Styles for phones */
            #bgLogo {
                margin-right: 0;
                width: 20vh;
            }
        }

        /* Tablets (768px to 1023px) */
        @media only screen and (min-width: 768px) and (max-width: 1023px) {

            /* Styles for tablets */
            #bgLogo {
                margin-right: 0;
                width: 30vh;
            }

        }

        /* Laptops (1024px to 1279px) */
        @media only screen and (min-width: 1024px) and (max-width: 1599px) {

            /* Styles for laptops */
            #containerForm {

                padding-left: 10%;
                height: 30%;

            }

            #formInput {
                height: 90vh;


            }

            #formInput .relative #fname,
            #lname,
            #contact,
            #email,
            #password,
            #password-confirm {
                height: 0px;
                padding-top: 4px;

            }
        }

        /* Desktops (1280px and above) */
        @media only screen and (min-width: 1600px) {

            /* Styles for desktops */
            #containerForm {
                margin-top: -80px;
                ;



            }
        }
    </style>
@endsection
