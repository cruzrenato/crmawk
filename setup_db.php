<?php
/**
 * Script de Configuração Inicial do Banco de Dados
 */

$host = 'localhost';
$user = 'root';
$pass = ''; // Altere se necessário
$dbname = 'molas_crm';

try {
    // 1. Conectar sem banco de dados
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 2. Criar banco de dados
    echo "Criando banco de dados '$dbname'...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    
    // 3. Conectar ao banco criado
    $pdo->exec("USE `$dbname` text;");
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 4. Ler e executar schema.sql
    $schemaFile = __DIR__ . '/database/schema.sql';
    if (file_exists($schemaFile)) {
        echo "Executando schema.sql...\n";
        $sql = file_get_contents($schemaFile);
        
        // O schema.sql contém múltiplos comandos, PDO::exec só executa um por vez de forma segura
        // Mas para scripts de setup podemos tentar executar tudo se o driver suportar ou dividir por ';'
        // Vamos usar exec direto pois geralmente o driver mysql suporta multi-queries via PDO se não houver emulação
        $pdo->exec($sql);
        echo "Banco de dados configurado com sucesso!\n";
    } else {
        echo "Erro: Arquivo database/schema.sql não encontrado.\n";
    }
    
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    exit(1);
}
