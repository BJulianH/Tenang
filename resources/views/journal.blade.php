<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Jurnal Harian</h1>

        <!-- FORM CREATE -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <form action="{{ route('journal.store') }}" method="POST">
                @csrf

                <label class="block mb-2 text-gray-700 font-semibold">Judul Jurnal</label>
                <input type="text" name="title"
                    class="w-full p-3 border rounded mb-4 focus:ring focus:ring-indigo-200"
                    placeholder="Tulis judul jurnal..." required>

                <label class="block mb-2 text-gray-700 font-semibold">Isi Jurnal</label>
                <textarea name="content" rows="4"
                    class="w-full p-3 border rounded mb-4 focus:ring focus:ring-indigo-200"
                    placeholder="Ceritakan harimu di sini..." required></textarea>

                <button
                    class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 shadow">
                    Simpan
                </button>
            </form>
        </div>

        <!-- LIST JURNAL -->
        <div class="space-y-4">
            @foreach ($jurnals as $jurnal)
                <div class="bg-white shadow rounded-lg p-5 flex justify-between items-start">

                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $jurnal->title }}</h2>
                        <p class="text-gray-600 mt-1">{{ $jurnal->content }}</p>
                        <p class="text-sm text-gray-400 mt-2">Ditulis: {{ $jurnal->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="flex gap-3">
                        <!-- EDIT BUTTON -->
                        <button
                            onclick="openEditModal({{ $jurnal->id }}, '{{ $jurnal->title }}', `{{ $jurnal->content }}`)"
                            class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            Edit
                        </button>

                        <!-- DELETE -->
                        <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST"
                            onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

    </div>


    <!-- MODAL EDIT -->
    <div id="editModal"
         class="fixed inset-0 bg-black bg-opacity-40 hidden justify-center items-center p-4">

        <div class="bg-white w-full max-w-lg rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Jurnal</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <label class="block mb-2 text-gray-700 font-semibold">Judul</label>
                <input id="editTitle" type="text" name="title"
                       class="w-full p-3 border rounded mb-4">

                <label class="block mb-2 text-gray-700 font-semibold">Isi Jurnal</label>
                <textarea id="editContent" name="content" rows="4"
                          class="w-full p-3 border rounded mb-4"></textarea>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Batal
                    </button>

                    <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- SCRIPT MODAL -->
    <script>
        function openEditModal(id, title, content) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editTitle').value = title;
            document.getElementById('editContent').value = content;

            document.getElementById('editForm').action = '/jurnal/' + id;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>

</body>
</html>
