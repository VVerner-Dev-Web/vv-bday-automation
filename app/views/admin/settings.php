<?php defined('ABSPATH') || exit('No direct script access allowed');

$env  = new LeadsZapp\Env();

if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], $_POST['action'])) : 
    $data = $_POST['lz'];

    $env->setApiKey( $data['api_key'] );
    $env->setBotID( (int) $data['bot_id'] );
    $env->setMessageBody( $data['automation_msg'] );
endif;
?>

<div class="wrap">
    <h1>Configurações LeadsZapp</h1>
    <p>O disparo das mensagens acontecem diariamente a partir das <strong>09h da manhã</strong> para os usuários cadastrados no site com compra com status <strong>concluído</strong>.</p>

    <form action="" method="POST">
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="lz_api_key">Chave de API LeadsZapp</label>
                    </th>
                    <td>
                        <input type="text" value="<?= $env->getApiKey() ?>" name="lz[api_key]" id="lz_api_key" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="lz_bot_id">ID do Bot</label>
                    </th>
                    <td>
                        <input type="number" value="<?= $env->getBotID() ?>" min="0" step="1" name="lz[bot_id]" id="lz_bot_id" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="lz_automation_msg">Mensagem da automação</label> <br>
                        <small style="font-weight: normal">Você pode utilizar os placeholders: {nome_completo}, {nome}, {sobrenome} em sua mensagem!</small>
                    </th>
                    <td>
                        <textarea name="lz[automation_msg]" id="lz_automation_msg" cols="30" rows="10" class="regular-text" required><?= $env->getMessageBody() ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td>
                        <?php wp_nonce_field('leadszapp_settings'); ?>
                        <input type="hidden" name="action" value="leadszapp_settings" readonly>
                        <button class="button">Salvar configurações</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>