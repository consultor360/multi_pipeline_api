<?php
// Caminho: /public_html/modules/multi_pipeline/views/api/add_token.php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Token</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/multi_pipeline.css'); ?>">
</head>
<body>
    <div class="container">
        <h1>Adicionar Token</h1>
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo site_url('multi_pipeline/api/add_token'); ?>" method="post">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="user">Usuário</label>
                <input type="text" name="user" id="user" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Token</button>
        </form>
    </div>
</body>
</html>