<div class="bg-white overflow-hidden shadow rounded-lg border">
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Profil Masyarakat
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
        </p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            <!-- Tambahkan avatar di sini -->
            <div class="">
                <div class="sm:col-span-1 flex sm:justify-center mt-2 mb-2">
                    <img class="h-24 w-24 rounded-full" src="<?= BASEURL . '/src/foto/fotoprofil.png' ?>"
                        alt="Foto Profil">
                </div>
            </div>
            <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Nama Lengkap
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <?= $user['name']; ?>
                </dd>
            </div>
            <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Alamat Email
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <?= $user['email']; ?>
                </dd>
            </div>
            <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    Nomor HP
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <?= $user['nomor_hp']; ?>
                </dd>
            </div>
        </dl>
    </div>
    <div class="flex"><a href="profil/add"><button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ubah
                Profil</button></a></div>
</div>