<style>
  select {
    width: 70px;
  }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-shopping-bag"></i>
        </span>
        <h5>Insumos</h5>
    </div>
    <div class="span12" style="margin-left: 0">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aInsumos')) : ?>
            <div class="span3 flexxn" style="display: flex;">
                <a href="<?= base_url() ?>index.php/insumos/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2"> Insumos</span>
                </a>
               
            </div>
        <?php endif; ?>
        <form class="span9" method="get" action="<?= base_url() ?>index.php/Insumos" style="display: flex; justify-content: flex-end;">
            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar por Nome..." class="span12" value="<?=$this->input->get('pesquisa')?>">
            </div>
            <div class="span1">
                <button class="button btn btn-mini btn-warning" style="min-width: 30px">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span></button>
            </div>
        </form>
    </div>

    <div class="widget-box">
        <h5 style="padding: 3px 0"></h5>
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered ">
                <thead>
                <tr>
                    <th>Cod.</th>
                    <th>Cod. Barra</th>
                    <th>Nome</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php

                if (!$results) {
                    echo '<tr>
                                    <td colspan="6">Nenhum insumo Cadastrado</td>
                                    </tr>';
                }
                foreach ($results as $r) {
                    echo '<tr>';
                    echo '<td>' . $r->idInsumos . '</td>';
                    echo '<td>' . $r->codDeBarra . '</td>';
                    echo '<td>' . $r->descricao . '</td>';
                    echo '<td>' . $r->estoque . '</td>';
                    echo '<td>' . number_format($r->precoVenda, 2, ',', '.') . '</td>';
                    echo '<td>';
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vInsumos')) {
                        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/insumos/visualizar/' . $r->idInsumos . '" class="btn-nwe" title="Visualizar Insumo"><i class="bx bx-show bx-xs"></i></a>  ';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eInsumos')) {
                        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/insumos/editar/' . $r->idInsumos . '" class="btn-nwe3" title="Editar Insumo"><i class="bx bx-edit bx-xs"></i></a>';
                    }
                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dInsumos')) {
                        echo '<a style="margin-right: 1%" href="#modal-excluir" role="button" data-toggle="modal" insumo="' . $r->idInsumos . '" class="btn-nwe4" title="Excluir Insumo"><i class="bx bx-trash-alt bx-xs"></i></a>';
                    }
                   
                    echo '</td>';
                    echo '</tr>';
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->pagination->create_links(); ?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/insumos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="fas fa-trash-alt"></i> Excluir Insumo</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idInsumo" class="idInsumoo" name="id" value=""/>
            <h5 style="text-align: center">Deseja realmente excluir este insumo?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true">
              <span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<!-- Modal Estoque -->
<div id="atualizar-estoque" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/insumos/atualizar_estoque" method="post" id="formEstoque">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel"><i class="fas fa-plus-square"></i> Atualizar Estoque</h5>
        </div>
        <div class="modal-body">
            <div class="control-group">
                <label for="estoqueAtual" class="control-label">Estoque Atual</label>
                <div class="controls">
                    <input id="estoqueAtual" type="text" name="estoqueAtual" value="" readonly />
                </div>
            </div>

            <div class="control-group">
                <label for="estoque" class="control-label">Adicionar Insumos<span class="required">*</span></label>
                <div class="controls">
                    <input type="hidden" id="idinsumo" class="idinsumo" name="id" value=""/>
                    <input id="estoque" type="text" name="estoque" value=""/>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
          <button class="button btn btn-primary"><span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
          <button class="button btn btn-warning"  data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
        </div>
    </form>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<!-- Modal Etiquetas e Estoque-->
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', 'a', function (event) {
            var insumo = $(this).attr('insumo');
            var estoque = $(this).attr('estoque');
            $('.idinsumo').val(insumo);
            $('#estoqueAtual').val(estoque);
        });

        $('#formEstoque').validate({
            rules: {
                estoque: {
                    required: true,
                    number: true
                }
            },
            messages: {
                estoque: {
                    required: 'Campo Requerido.',
                    number: 'Informe um número válido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function (element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
</script>
