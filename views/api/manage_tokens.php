<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
// Caminho: /public_html/modules/multi_pipeline/views/api/manage_tokens.php
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h2 class="mb-4"><?php echo _l('manage_api_tokens'); ?></h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo _l('id'); ?></th>
                                        <th><?php echo _l('user'); ?></th>
                                        <th><?php echo _l('name'); ?></th>
                                        <th><?php echo _l('token'); ?></th>
                                        <th><?php echo _l('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($tokens) && count($tokens) > 0): ?>
                                        <?php foreach ($tokens as $token): ?>
                                            <tr>
                                                <td><?php echo $token->id; ?></td>
                                                <td><?php echo $token->user; ?></td>
                                                <td><?php echo $token->name; ?></td>
                                                <td><?php echo $token->token; ?></td>
                                                <td>
                                                    <a href="<?php echo admin_url('api/edit_token/' . $token->id); ?>" class="btn btn-warning btn-icon">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="<?php echo admin_url('api/delete_token/' . $token->id); ?>" class="btn btn-danger btn-icon" onclick="return confirm('<?php echo _l('are_you_sure'); ?>');">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center"><?php echo _l('no_tokens_found'); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <a href="<?php echo admin_url('api/add_token'); ?>" class="btn btn-primary"><?php echo _l('add_token'); ?></a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
