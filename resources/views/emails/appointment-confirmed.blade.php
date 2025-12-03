<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e4a73 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border: 2px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }
        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #2c5aa0;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-row {
            margin: 10px 0;
        }
        .label {
            font-weight: bold;
            color: #2c5aa0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>¡Cita Confirmada!</h1>
        <p>Tu cita ha sido confirmada exitosamente</p>
    </div>

    <div class="content">
        <p>Hola <strong>{{ $appointment->client_name }}</strong>,</p>
        
        <p>Tu cita en <strong>GM Llaves y Cerraduras</strong> ha sido confirmada. A continuación los detalles:</p>

        <div class="info-box">
            <div class="info-row">
                <span class="label">Servicio:</span> {{ $appointment->service->name }}
            </div>
            <div class="info-row">
                <span class="label">Fecha:</span> {{ $appointment->formatted_date }}
            </div>
            <div class="info-row">
                <span class="label">Hora:</span> {{ $appointment->formatted_time }}
            </div>
            <div class="info-row">
                <span class="label">Dirección:</span> {{ $appointment->service_address }}
            </div>
            @if($appointment->estimated_price)
            <div class="info-row">
                <span class="label">Precio Estimado:</span> ${{ number_format($appointment->estimated_price, 0, ',', '.') }}
            </div>
            @endif
        </div>

        @if($appointment->service_details)
        <p><strong>Detalles del servicio:</strong><br>{{ $appointment->service_details }}</p>
        @endif

        <p><strong>Importante:</strong></p>
        <ul>
            <li>Nuestro técnico llegará en el horario indicado</li>
            <li>Si necesitas cancelar o reprogramar, contacta con anticipación</li>
            <li>Ten disponible el acceso al área donde se realizará el servicio</li>
        </ul>

        <center>
            <a href="{{ url('/mis-citas') }}" class="button">Ver Mis Citas</a>
        </center>

        <p>Si tienes alguna pregunta, no dudes en contactarnos:</p>
        <p>
             Teléfono: +57 302 238 70 20<br>
              Email: gmllaves@gmail.com
        </p>
    </div>

    <div class="footer">
        <p>Este es un correo automático, por favor no responder.</p>
        <p>&copy; {{ date('Y') }} GM Llaves y Cerraduras. Todos los derechos reservados.</p>
    </div>
</body>
</html>