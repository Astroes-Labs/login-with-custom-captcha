<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Login With Custom Captcha</title>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-96">
            <h1 class="text-2xl font-bold text-center mb-8">Login</h1>
            <!-- Display Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Display Error Messages -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email" type="email" name="email" placeholder="Enter your email" required autofocus
                        value="{{ old('email') }}">
                </div>

                <!-- Password Input -->
                <div class="mb-6 relative">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline pr-10"
                            id="password" type="password" name="password" placeholder="Enter your password" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                            <i class="fas fa-eye text-gray-500 hover:text-gray-700" id="togglePassword"></i>
                        </div>
                    </div>
                </div>

                <!-- Custom Captcha -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="captcha">
                        Captcha
                    </label>
                    <div id="captcha-text" class="flex items-center justify-center bg-gray-100 p-4 rounded-lg"
                        style="user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none;">
                        <!-- Captcha characters will be dynamically inserted here -->
                    </div>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-2 leading-tight focus:outline-none focus:shadow-outline"
                        id="captcha" type="text" name="captcha" placeholder="Enter captcha" required>
                    <button type="button" id="refresh-captcha" class="mt-2 p-2 bg-gray-200 rounded hover:bg-gray-300">
                        Refresh Captcha
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Sign In
                    </button>
                </div>
            </form>

            <!-- JavaScript to Load and Refresh Captcha -->
            <script>
                // Function to load the captcha
                function loadCaptcha() {
                    fetch('{{ route('captcha') }}')
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to fetch captcha');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Captcha data:', data); // Debugging: Log the captcha data
                            const captchaText = document.getElementById('captcha-text');
                            captchaText.innerHTML = ''; // Clear previous captcha

                            // Split the captcha into individual characters and style them randomly
                            data.captcha.split('').forEach((char, index) => {
                                const span = document.createElement('span');
                                span.textContent = char;
                                span.style.marginLeft = index === 0 ? '0' :
                                    `${Math.random() * 20}px`; // Random horizontal spacing
                                span.style.transform = `rotate(${Math.random() * 20 - 10}deg)`; // Random rotation
                                span.style.fontSize = `${Math.random() * 10 + 20}px`; // Random font size
                                captchaText.appendChild(span);
                            });
                        })
                        .catch(error => {
                            console.error('Error loading captcha:', error); // Debugging: Log any errors
                        });
                }

                // Load the captcha on page load
                document.addEventListener('DOMContentLoaded', loadCaptcha);

                // Refresh the captcha when the refresh button is clicked
                document.getElementById('refresh-captcha').addEventListener('click', loadCaptcha);
            </script>

        </div>
    </div>



    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
