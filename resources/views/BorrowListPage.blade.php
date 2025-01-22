<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liceo-LogEase</title>
    <link href="https://db.onlinewebfonts.com/c/26afb49b8b7dda2c10686589d6fc7b55?family=Architype+Aubette+W90" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>


</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gray-100" style="background-image: url('/image/bg.jpg'); background-size: cover; background-position: center;">
        <div class="w-full max-w-[80%] h-[80%] pt-5 pb-10 bg-[#ecdbdc] rounded-[80px] shadow-md border-2 border-[#8a211b]">
            <div class="grid grid-cols-4 gap-4 items-center justify-items-center">
            <div class="col-span-1">
                <img src="/image/logo.png" alt="Logo" class="w-24 h-24">
            </div>
            <div class="col-span-2 text-center">
                <h2 class="text-[35px] font-semibold text-[#8a211b] border-b border-[#8a211b] tracking-widest" style="font-family: 'Architype Aubette W90'">LICEO LOGEASE</h2>
            </div>
            <div class="col-span-1">
                <img src="/image/liceo.png" alt="Logo" class="w-24 h-24">
            </div>
            </div>

            <div class="overflow-hidden mx-4 md:mx-10 mt-5">
                <div class="p-4">
                  <input
                    type="text"
                    id="searchBar"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search..."
                    oninput="filterTable()"
                  />
                </div>
                <div class="overflow-x-auto">
                  <table class="table-auto w-full border-collapse border">
                    <thead>
                      <tr class="bg-gray-100 text-left">
                        <th class="text-[#8a211b] px-4 py-2">Key</th>
                        <th class="text-[#8a211b] px-4 py-2">Teacher</th>
                        <th class="text-[#8a211b] px-4 py-2">Status</th>
                        <th class="text-[#8a211b] px-4 py-2">Date</th>
                        <th class="px-4 py-2">Action</th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                      @foreach ($models as $item)
                      <tr>
                        <td class="border-b border-[#8a211b] px-4 py-2">{{ $item->key->key_name}}</td>
                        <td class="border-b border-[#8a211b] px-4 py-2">{{ $item->teacher->firstname }} {{ $item->teacher->lastname }}</td>
                        <td class="border-b border-[#8a211b] px-4 py-2">
                            <div class="bg-{{ $item->status === 'Returned' ? 'green' : 'red' }}-500 text-white rounded-[50px] w-[82px] px-2 py-1 text-center">
                                {{ $item->status }}
                            </div>
                        </td>
                        <td class="border-b border-[#8a211b] px-4 py-2">{{ $item->date}}</td>
                        <td class="border-b border-[#8a211b] px-4 py-2">Return</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="flex justify-between items-center p-4">
                  <button
                    id="prevPage"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed"
                    onclick="changePage(-1)"
                    disabled
                  >
                    Previous
                  </button>
                  <span id="currentPage" class="text-gray-700">Page 1</span>
                  <button
                    id="nextPage"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed"
                    onclick="changePage(1)"
                  >
                    Next
                  </button>
                </div>
              </div>
        </div>

        <form action="{{ route('guard.logout') }}" method="POST" class="absolute top-0 right-0 p-4">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-4">
                <img src="/image/logout.svg" alt="Logo" class="w-6 h-6">
                <div class="text-white font-semibold text-lg">Logout</div>
            </button>
        </form>
    </div>
    <script>
        const rowsPerPage = 5;
        let currentPage = 1;

        function renderTable() {
          const tableBody = document.getElementById("tableBody");
          const rows = Array.from(tableBody.querySelectorAll("tr"));
          const filteredRows = rows.filter(row => {
            const query = document.getElementById("searchBar").value.toLowerCase();
            return row.innerText.toLowerCase().includes(query);
          });

          rows.forEach(row => (row.style.display = "none"));
          filteredRows
            .slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage)
            .forEach(row => (row.style.display = ""));

          document.getElementById("currentPage").textContent = `Page ${currentPage}`;
          document.getElementById("prevPage").disabled = currentPage === 1;
          document.getElementById("nextPage").disabled =
            currentPage * rowsPerPage >= filteredRows.length;
        }

        function filterTable() {
          currentPage = 1;
          renderTable();
        }

        function changePage(direction) {
          currentPage += direction;
          renderTable();
        }

        // Initial rendering
        renderTable();
      </script>
</body>
</html>
