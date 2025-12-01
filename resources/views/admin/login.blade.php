<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CarePro Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="{{ asset('images/logotab.png') }}">
</head>
<body class="bg-blue-800 flex items-center justify-center min-h-screen px-4">

  <div class="w-full max-w-sm">
    <h2 class="text-center text-white text-2xl font-semibold mb-5">CarePro Admin Login</h2>

    <div class="bg-white shadow-lg rounded-xl p-6">
      <p class="text-gray-500 text-sm mb-6 text-center">Please fill in your unique admin login details below</p>

      @if ($errors->any())
        <div class="bg-red-100 text-red-700 text-sm p-2 mb-4 rounded-md text-center">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

     <form method="POST" action="{{ route('admin.login') }}" class="flex flex-col gap-4">
        @csrf
        <div>
          <label class="block text-gray-700 text-sm mb-1">Email address</label> 
          <input type="email" name="email" placeholder="Enter email"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
          <label class="block text-gray-700 text-sm mb-1">Password</label>
          <div class="relative">
            <input type="password" name="password" id="password" placeholder="Enter password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer" onclick="togglePassword()">
              <i class="fa-solid fa-eye" id="toggleIcon"></i>
            </span>
          </div>
        </div>
        
        <button type="submit" name="login"
                class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded-md font-medium transition">
          Sign In
        </button>
      </form>
    </div>
  </div>

  <script>
    function togglePassword() {
      const pass = document.getElementById("password");
      const icon = document.getElementById("toggleIcon");

      if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>

</body>
</html>