<?php
$session = \App\Helpers\Session::get('mensagemSistema');
if (!empty($session)) :
    \App\Helpers\Session::pull('mensagemSistema');
    ?>
    <div class="row">
        <div class="col-sm-12">

            <div style="border-radius: 0px !important; margin: 0px;"
                 class="alert alert-<?= $session['class']; ?> alert-dismissible">
                <?php
                $center = empty($session['mensagem']) ? 'text-center' : '';

                if (isset($session['titulo']) && !empty($session['titulo'])) :
                    ?>
                    <h4 class="<?= $center; ?>">
                        <i class="fa <?= $session['icone']; ?> }}"></i> <?= $session['titulo']; ?>
                    </h4>

                <?php
                endif;

                echo $session['mensagem'];
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>