@extends('layout')
@section('content')
<x-card class="p-10 max-w-lg mx-auto mt-24">
<header class="text-center">
    <h2 class="text-2xl font-bold mb-1">
        OTP Verification
    </h2>
    {{-- <p class="mb-4">Please verify your identity.</p> --}}
</header>

<form method="POST" action="/products/send-otp">
    @csrf

    {{-- <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2"
            >Email</label
        >
        <input
            type="email"
            class="border border-gray-200 rounded p-2 w-full"
            name="email"
            value="{{old('email')}}"
        />
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label
            for="password"
            class="inline-block text-lg mb-2"
        >
            Password
        </label>
        <input
            type="password"
            class="border border-gray-200 rounded p-2 w-full"
            name="password"
        />

        @error('password')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror

    </div> --}}

    <div class="flex items-center justify-center">
        <form>
            @csrf
            <button id="sendOtpButton" type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="sendOtp()">Send OTP to your email</button>
        </form>
        <div id="otpInput" style="display: none; margin-top: 20px;">
            <input id="otpText" type="text" placeholder="Enter OTP" class="outline-none border border-gray-500 p-2">
            <button id="verifyOtpBtn" type="button" class="outline-none border border-gray-500 p-2">Submit</button>
        </div>
    </div>

    <div class="flex items-center justify-center">
        <div id="errorMessage" style="display: none; margin-top: 10px;">
            <p style="color:red">Failed to send OTP.</p>
        </div>
    </div>

    <div class="flex items-center justify-center">
        <div id="verifyErrorMessage" style="display: none; margin-top: 10px;">
            <p style="color:red" id="verifyErrorMessageText"></p>
        </div>
    </div>



    <script>
        async function sendOtp() {
            // Get the user's email
            const email = '{{auth()->user()->email}}';

            const options = {method: 'GET'};

            // Send a GET request to the OTP endpoint with the email param
            const response = await fetch('https://helpful-starburst-e40e46.netlify.app/.netlify/functions/otp?email='+email, options)
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if(response.result == "Success"){

                    document.querySelector('#otpInput').style.display = 'block';
                    document.querySelector('#sendOtpButton').style.display = 'none';
                    document.querySelector('#errorMessage').style.display = 'none';

                    // sessionStorage.setItem('token', response.token);
                    // sessionStorage.setItem('time', response.time);

                    console.log('time received: ' + response.time);

                    window.token = response.token;
                    window.time = response.time;

                    // location.reload();

                }else{

                    document.querySelector('#otpInput').style.display = 'none';
                    document.querySelector('#sendOtpButton').style.display = 'block';
                    document.querySelector('#errorMessage').style.display = 'block';

                }
            })
            .catch(err => console.error(err));
        }

        // async function verifyOtp() {
        //     // Get the user's email
        //     const email = '{{auth()->user()->email}}';

        //     const options = {method: 'GET'};

        //     const otp = document.querySelector('#verifyErrorMessageText').innerHTML;

        //     // Send a GET request to the OTP endpoint with the email param
        //     const response = await fetch('https://helpful-starburst-e40e46.netlify.app/.netlify/functions/otp?email='+email+'&otp='++'&token=7b8518df0a620dec88a74018ab67dc6d8eda6e35593ee465aa74d89fe8d7998d&time=Fri%20Feb%2003%202023%2009%3A22%3A44%20GMT%2B0000%20(Coordinated%20Universal%20Time)', options)
        //         .then(response => response.json())
        //         .then(response => console.log(response))
        //         .catch(err => console.error(err));
        // }

        function getCookie(name) {
            let value = "; " + document.cookie;
            let parts = value.split("; " + name + "=");
            if (parts.length == 2) return parts.pop().split(";").shift();
        }

        document.querySelector("#verifyOtpBtn").addEventListener("click", async function() {
            const email = '{{auth()->user()->email}}';
            const otp = document.querySelector("#otpText").value;
            const options = {
                method: 'POST',
                body: new URLSearchParams({
                    email: email,
                    otp: otp,
                    token: window.token,
                    time: window.time
                })
            };

            console.log('time to send: ' + window.time);

            const response = await fetch('https://helpful-starburst-e40e46.netlify.app/.netlify/functions/otp', options)
                .then(async function(response) {
                    console.log(response.json());
                    if (response.status == 200) {
                        document.querySelector('#verifyErrorMessage').style.display = 'none';
                        document.querySelector('#verifyErrorMessageText').innerHTML = '';

                        location.assign('/products/{{$product->id}}/buy');

                        // let csrfToken = getCookie('CSRF_TOKEN');

                        // const options = {
                        //     method: 'POST',
                        //     headers: {
                        //         'X-CSRF-TOKEN': csrfToken
                        //     }
                        // };

                        // const response = await fetch('/products/{{$product->id}}', options)
                        //     .then(function(response) {
                        //         console.log("response: " + response);

                        //         if (response == 1){

                        //             location.assign('/success');

                        //         } else {

                        //             location.assign('/fail');

                        //         }
                        //     })
                        //     .catch(err => console.error(err));

                    } else if (response.status == 410) {
                        document.querySelector('#verifyErrorMessage').style.display = 'block';
                        document.querySelector('#verifyErrorMessageText').innerHTML = 'OTP has expired';
                    } else if (response.status == 400) {
                        document.querySelector('#verifyErrorMessage').style.display = 'block';
                        document.querySelector('#verifyErrorMessageText').innerHTML = 'Invalid OTP';
                    } else {
                        document.querySelector('#verifyErrorMessage').style.display = 'block';
                        document.querySelector('#verifyErrorMessageText').innerHTML = 'Unknown error';
                    }
                })
                .catch(error => console.error(error));
        });
    </script>


    {{-- <div class="mt-8">
        <p>
            Don't have an account?
            <a href="/login" class="text-laravel"
                >Register</a
            >
        </p>
    </div> --}}
</form>
</x-card>
@endsection
