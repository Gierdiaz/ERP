<!-- resources/views/laudo_medico.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laudo Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .paciente-info {
            margin-bottom: 20px;
        }
        .paciente-info p {
            margin: 5px 0;
        }
        .exame-info {
            margin-bottom: 20px;
        }
        .exame-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .exame-info th, .exame-info td {
            border: 1px solid #000;
            padding: 8px;
        }
        .assinatura {
            margin-top: 50px;
            text-align: center;
        }
        .assinatura p {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Laudo Médico</h1>
            <p>Data: {{ date('d/m/Y') }}</p>
        </div>
        <div class="paciente-info">
            <h2>Informações do Paciente</h2>
            <p><strong>Nome:</strong> {{ $paciente['nome'] }}</p>
            <p><strong>Idade:</strong> {{ $paciente['idade'] }} anos</p>
            <p><strong>Sexo:</strong> {{ $paciente['sexo'] }}</p>
            <p><strong>CPF:</strong> {{ $paciente['cpf'] }}</p>
            <p><strong>Médico:</strong> {{ $medico }}</p>
        </div>
        <div class="exame-info">
            <h2>Resultados do Exame</h2>
            <table>
                <thead>
                    <tr>
                        <th>Exame</th>
                        <th>Resultado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exames as $exame)
                    <tr>
                        <td>{{ $exame['nome'] }}</td>
                        <td>{{ $exame['resultado'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="assinatura">
            <img src="{{ asset('assinatura_medico.png') }}" alt="Assinatura do Médico">
            <p>{{ $medico }}</p>
            <p>Médico Responsável</p>
        </div>

    </div>
</body>
</html>
