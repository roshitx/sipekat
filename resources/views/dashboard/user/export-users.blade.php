<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users Export data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">


        <h1 align="center">{{ $title }}</h1>
        <p align="center">{{ $description }}</p>
        <p class="mb-5">Tanggal export : {{ $date }}</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="text-center">
                    <th>{{ $loop->iteration }}</th>
                    <td>
                        <div>
                            <p class="text-red-600">{{ $user->name }}</p>
                        </div>
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ Str::ucfirst($user->gender) }}
                    </td>
                    <td>
                        {{ Str::ucfirst($user->role) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
