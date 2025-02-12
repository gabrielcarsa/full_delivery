<!DOCTYPE html>
<html>

<head>
    <title>Convite {{ $data['store']->name }} - Foomy</title>
</head>

<body>
    <h1>
        Olá {{ $data['username'] }},
    </h1>

    <p>
        Você foi convidado para fazer parte da loja <strong>{{ $data['store']->name }}</strong>.
    </p>
    <p>
        Para aceitar clique no botão abaixa e finalize seu cadastro.
    </p>
    <br>
    <a href="{{ route('register', ['store_id' => $data['store']->id, 'username' => $data['username'], 'email' => $data['email'], 'position' => $data['position'], 'access_level' => $data['access_level'] ]) }}"
        style="background-color: #FD0146; text-decoration: none; color: #FFFF; padding: 10px 15px; border-radius: 1em; margin: 30px 0">
        Aceitar convite
    </a>
    <br>
    <p>
        Caso não funcione o botão acima acesse esse link:
        <a
            href="{{ route('register', ['store_id' => $data['store']->id, 'username' => $data['username'], 'email' => $data['email'], 'position' => $data['position'], 'access_level' => $data['access_level']]) }}">
            {{ route('register', ['store_id' => $data['store']->id, 'username' => $data['username'], 'email' => $data['email'], 'position' => $data['position'], 'access_level' => $data['access_level']]) }}
        </a>
    </p>
</body>

</html>