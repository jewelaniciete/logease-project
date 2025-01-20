<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liceo-LogEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://db.onlinewebfonts.com/c/26afb49b8b7dda2c10686589d6fc7b55?family=Architype+Aubette+W90" rel="stylesheet">
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100" style="background-image: url('/image/bg.jpg'); background-size: cover; background-position: center;">
        <div class="w-full max-w-xl pt-5 pb-10 bg-[#ecdbdc] rounded shadow-md rounded-[80px] border border-[#8a211b]">
            <div class="grid grid-cols-4 gap-4 items-center justify-items-center">
                <div class="col-span-1">
                    <img src="/image/logo.png" alt="Logo" class="w-24 h-24">
                </div>
                <div class="col-span-2">
                    <h2 class="text-[35px] font-semibold text-[#8a211b] border-b border-[#8a211b] tracking-widest" style="font-family: 'Architype Aubette W90">LICEO LOGEASE</h2>
                </div>
                <div>
                    <img src="/image/liceo.png" alt="Logo" class="w-24 h-24">
                </div>
            </div>

            <form action="#" method="POST" class="max-w-sm mx-auto flex flex-col align-center">
                <!-- Email Field -->
                <div class="mb-4">
                    <label for="email" class="block mb-2 text-md font-semibold tracking-widest" style="font-family: 'Poppins', sans-serif;">Email:</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded focus:ring-1 focus:ring-[#8a201a] focus:outline-none border-[#8a211b] border-2" />
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-md font-semibold tracking-widest" style="font-family: 'Poppins', sans-serif;">Password:</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border rounded focus:ring-1 focus:ring-[#8a201a] focus:outline-none border-[#8a211b] border-2" />
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="w-24 border-[#8a211b] border-2 text-black font-semibold tracking-widest px-4 rounded hover:bg-[#8a211b] hover:text-white" style="font-family: 'Poppins', sans-serif;">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
