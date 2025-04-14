<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $whatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
    $interests = filter_input(INPUT_POST, 'interests', FILTER_SANITIZE_STRING);
    
    // Validações básicas
    if (empty($name) || empty($email) || empty($whatsapp) || empty($interests)) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'E-mail inválido.']);
        exit;
    }
    
    // Configurações do e-mail
    $to = 'shakaw3dprint@hotmail.com'; // Seu e-mail aqui
    $subject = 'Novo interesse em produtos - Shakaw 3D Print';
    
    $message = "
    <html>
    <head>
      <title>Novo interesse em produtos</title>
      <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        h1 { color: #0057b7; }
        .product { margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
      </style>
    </head>
    <body>
      <h1>Novo Interesse em Produtos</h1>
      <p><strong>Nome:</strong> $name</p>
      <p><strong>E-mail:</strong> $email</p>
      <p><strong>WhatsApp:</strong> $whatsapp</p>
      <h2>Produtos de Interesse:</h2>
      <div>".nl2br($interests)."</div>
      <p><em>Este e-mail foi enviado automaticamente pelo catálogo online.</em></p>
    </body>
    </html>
    ";
    
    // Cabeçalhos do e-mail
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    
    // Envia o e-mail
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Mensagem enviada com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao enviar mensagem.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
}
?>
