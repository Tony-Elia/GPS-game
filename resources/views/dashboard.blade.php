<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    {{--    @dd($games, $teams, $codes)--}}
    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <x-input-error class="mb-4" :messages="$errors->all()" />

            <!-- Teams Tile -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Teams</h3>

                <!-- Add Team Form -->
                <div class="mt-4">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Add New Team</h4>
                    <form method="POST" action="{{ route('teams.create') }}" class="flex flex-wrap items-center md:flex-row flex-col md:gap-4 gap-3">
                        @csrf
                        <!-- Team Name -->
                        <div class="flex-1">
                            <input type="text" name="name" placeholder="Team Name" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <!-- Team Email -->
                        <div class="flex-1">
                            <input type="text" name="email" placeholder="Team Username" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <!-- Team Password -->
                        <div class="flex-1">
                            <input type="text" name="password" placeholder="Password (Auto-generated)"
                                   value="{{ Str::random(8) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                Add Team
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Teams List -->
                <div class="mt-6">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Teams List</h4>
                    <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-700 dark:text-white/70">
                        <thead>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Name</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Username</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Password</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($teams as $team)
                            <tr>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $team->name }}</td>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $team->email }}</td>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $team->plain_text_password }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Games Tile -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mt-7">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Games</h3>

                <!-- Add GAme Form -->
                <div class="mt-4">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Add New Game</h4>
                    <form method="POST" action="{{ route('games.create') }}" class="flex flex-wrap items-center md:flex-row flex-col md:gap-4 gap-3"  enctype="multipart/form-data">
                        @csrf
                        <!-- Team Name -->
                        <div class="flex-1">
                            <input type="text" name="name" placeholder="Game Name" required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <!-- Game Photo -->
                        <div class="flex-1">
                            <input type="file" name="image" placeholder="Game Image"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:outline-none focus:ring focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                                Add Game
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Game List -->
                <div class="mt-6">
                    <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-2">Game List</h4>
                    <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-700 dark:text-white/70">
                        <thead>
                        <tr>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Name</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Image</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($games as $game)
                            <tr>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $game->name }}</td>
                                @isset($game->image_url)
                                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-2"><img class="max-w-md" src="{{ $game->image_url }}"
                                                                                                           alt="{{ $game->name }}"></td>
                                @endisset
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Codes Table Section -->
        <div class="mx-7 mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Codes</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-700 dark:text-white/70">
                    <thead>
                    <tr>
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">Teams</th>
                        @foreach ($games as $game) <!-- Example for 5 teams -->
                        <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left">{{ $game->name }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($codes as $team_code)
                    <tr>
                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $team_code['team'] }}</td>
                        @foreach ($team_code['codes'] as $code)
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">{{ $code }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
