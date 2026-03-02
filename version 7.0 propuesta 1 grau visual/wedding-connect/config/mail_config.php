<?php
// config/mail_config.php - VERSIÓN PARA GMAIL
// USA TU CONTRASEÑA DE APLICACIÓN: ooht cqkq chjr wffi

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargar PHPMailer
$phpmailer_path = __DIR__ . '/../admin/phpmailer/src/';
if (file_exists($phpmailer_path . 'PHPMailer.php')) {
    require_once $phpmailer_path . 'PHPMailer.php';
    require_once $phpmailer_path . 'SMTP.php';
    require_once $phpmailer_path . 'Exception.php';
} else {
    error_log("PHPMailer no encontrado en: " . $phpmailer_path);
    die("Error de configuración de correo");
}

function enviarCorreoRecuperacion($destinatario, $codigo) {
    
    // ============ CONFIGURACIÓN PARA GMAIL ============
    // USA TU CONTRASEÑA DE APLICACIÓN (NO la contraseña normal)
    $config = [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'weddingconnectaguascalientes@gmail.com',
        'password' => 'gwiq nuvn brgs wssy', // ← CONTRASEÑA DE APLICACIÓN
        'from_email' => 'weddingconnectaguascalientes@gmail.com',
        'from_name' => 'Wedding Connect'
    ];
    
    try {
        $mail = new PHPMailer(true);
        
        // Configuración SMTP
        $mail->SMTPDebug = 0; // 0 = No mostrar nada en pantalla
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = $config['encryption'];
        $mail->Port = $config['port'];
        $mail->CharSet = 'UTF-8';
        
        // Configuración SSL para Gmail
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        // Remitente y destinatario
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($destinatario);
        
        // Asunto
        $mail->Subject = '=?UTF-8?B?' . base64_encode('🔐 Código de Verificación - Wedding Connect') . '?=';
        
        // Cuerpo del mensaje (HTML)
        $mail->isHTML(true);
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
        </head>
        <body style='font-family:Arial,sans-serif;background:#f5f5f5;padding:20px;margin:0;'>
            <table width='100%' cellpadding='0' cellspacing='0' style='max-width:500px;margin:0 auto;background:#fff;border-radius:8px;box-shadow:0 2px 4px rgba(0,0,0,0.1);border:1px solid #e0e0e0;'>
                <tr><td style='padding:20px;text-align:center;border-bottom:3px solid #c49a6c;'><h1 style='margin:0;font-size:24px;color:#333;'>WEDDING CONNECT</h1></td></tr>
                <tr><td style='padding:25px;'>
                    <p style='margin:0 0 15px 0;color:#555;'>Estimada Cristina,</p>
                    <p style='margin:0 0 15px 0;color:#555;'>Tu código de verificación es:</p>
                    <table width='100%' cellpadding='0' cellspacing='0' style='background:#f8f8f8;border-radius:6px;margin:15px 0;'>
                        <tr><td style='padding:15px;text-align:center;'><span style='font-family:monospace;font-size:42px;font-weight:bold;color:#c49a6c;letter-spacing:8px;'>{$codigo}</span></td></tr>
                    </table>
                    <p style='margin:10px 0 5px 0;color:#666;font-size:14px;'><strong>Instrucciones:</strong></p>
                    <p style='margin:0 0 3px 0;color:#666;font-size:13px;'>1. Ingresa este código en la página</p>
                    <p style='margin:0 0 3px 0;color:#666;font-size:13px;'>2. Crea una nueva contraseña</p>
                    <p style='margin:0 0 15px 0;color:#666;font-size:13px;'>3. Confirma tu nueva contraseña</p>
                    <p style='margin:10px 0 0 0;color:#999;font-size:13px;'>⏱️ Este código expirará en 15 minutos por razones de seguridad.</p>
                </td></tr>
                 </td></tr>
                <tr><td style='background:#fafafa;padding:15px;text-align:center;border-top:1px solid #eaeaea;'><p style='margin:0 0 5px 0;color:#999;font-size:12px;'>© <?php echo date('Y'); ?> Wedding Connect. Todos los derechos reservados.</p><p style='margin:0;color:#bbb;font-size:11px;'>Este es un mensaje automático, por favor no responder.</p></td></tr>
            </table>
        </body>
        </html>
        ";
        
        // Versión texto plano
        $mail->AltBody = "Wedding Connect - Código de verificación: {$codigo}\n\nVálido por 15 minutos.";
        
        // Enviar
        $mail->send();
        
        // Registrar éxito
        error_log("✅ Correo GMAIL enviado a: {$destinatario} - Código: {$codigo}");
        
        return [
            'success' => true,
            'message' => 'Se ha enviado un código de verificación a tu correo'
        ];
        
    } catch (Exception $e) {
        // Registrar error
        error_log("❌ Error GMAIL: " . $mail->ErrorInfo);
        
        return [
            'success' => false,
            'message' => 'Error al enviar el correo. Intenta más tarde.'
        ];
    }
}
?>