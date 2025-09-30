<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Templates Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-6">

    <div class="max-w-6xl mx-auto">
        <h1 class="text-4xl font-extrabold text-gray-900 text-center mb-12">
            📧 Email Templates Preview
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach ($templates as $template)
                <div class="rounded-2xl shadow-lg overflow-hidden transform transition hover:scale-105">
                    <div class="{{ $template['bg'] }} p-6 text-white h-32 flex items-center justify-center">
                        <h2 class="text-lg font-bold text-center">{{ $template['title'] }}</h2>
                    </div>
                    <div class="bg-white p-6 flex flex-col justify-between h-40">
                        <p class="text-sm text-gray-600 flex-1">{{ $template['description'] }}</p>
                        <a href="{{ $template['route'] }}"
                           class="mt-4 inline-block text-center bg-gray-900 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-700">
                           Preview
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>