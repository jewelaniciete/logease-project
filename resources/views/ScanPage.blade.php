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
        <div class="w-full max-w-[877px] h-auto pt-5 pb-10 bg-[#ecdbdc] rounded shadow-md rounded-[80px] border-2 border-[#8a211b]">
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

            <div class="grid grid-cols-2 items-center justify-items-center">
                <div class="flex flex-col justify-center items-center w-full">
                    <img src="/image/scan.svg" alt="" class="w-auto h-80 mb-4">
                    <h1 class="text-[24px] font-semibold text-black" style="font-family: 'Poppins', sans-serif;">Scan Barcode</h1>
                </div>
                <div class="w-[80%] p-3">
                    <form action="{{ route('guard.borrow') }}" method="POST" class="mx-auto flex flex-col align-center mb-14">
                        @csrf

                        <!-- General Error Message -->
                        @if(session('error'))
                            <div class="mb-4 text-red-500 text-sm font-semibold">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Key Field -->
                        <div class="mb-4">
                            <label for="key" class="block mb-2 text-md font-semibold tracking-widest" style="font-family: 'Poppins', sans-serif;">Keys:</label>
                            <select id="key" name="key" required
                                class="w-full px-4 py-2 border rounded focus:ring-1 focus:ring-[#8a201a] focus:outline-none border-[#8a211b] border-2">
                                <option value="" disabled selected>Select Available Keys</option>
                                @foreach($keys as $key)
                                    <option value="{{ $key->id }}">{{ $key->key_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Barcode Field -->
                        <div class="mb-6">
                            <label for="barcode" class="block mb-2 text-md font-semibold tracking-widest" style="font-family: 'Poppins', sans-serif;">Teachers's Barcode:</label>
                            <input type="text" id="barcode" name="barcode" required placeholder="Scan the teacher's barcode here"
                                class="w-full px-4 py-2 border rounded focus:ring-1 focus:ring-[#8a201a] focus:outline-none border-[#8a211b] border-2" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit" class="w-24 border-[#8a211b] border-2 text-black font-semibold tracking-widest px-4 hover:bg-[#8a211b] hover:text-white" style="font-family: 'Poppins', sans-serif;">
                                Submit
                            </button>
                        </div>
                    </form>
                    <div class="flex justify-between mt-4">
                        <div>
                            <a href="" class="text-[#8a211b] font-semibold text-sm">Borrowed Keys</a>
                        </div>

                        <div>
                            <a href="" class="text-[#8a211b] font-semibold text-sm">Returned Keys</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</body>
</html>
