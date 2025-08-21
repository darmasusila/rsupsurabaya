<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Account</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="container">
          <h1>Sign Up</h1>
          <p>Please fill in this form to create an account.</p>
            {{-- menampilkan error validasi --}}
            @if (count($errors) > 0)
            <div class="alert alert-danger" style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <label for="nik"><b>NIK</b></label>
            <input type="text" name="nik" placeholder="Masukkan NIK yang valid" required>
            
            <label for="nama"><b>Nama Lengkap</b></label>
            <select name="nama" required style="width:100%">
                @foreach ($dtNama as $id => $nama)
                    <option value="{{ $id }}">{{ $nama }}</option>
                @endforeach
            </select>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Masukkan Email" name="email" required>

            
      
          <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
      
          <div class="clearfix">
      
            <button type="submit" class="btn">Sign Up</button>
          </div>
        </div>
      </form>

</body>
</html>