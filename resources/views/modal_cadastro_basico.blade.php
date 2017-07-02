<div class="modal fade" id="{!!$modal!!}" tabindex="-1" role="dialog" aria-labelledby="id_modal_base" data-backdrop="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            <h4 class="modal-title" id="id_modal_base">Inclusão de Novo Registro</h4>
          </div>
          <div class="modal-body">

           <div class="row">
               <div class="col-xs-10">
               <!-- autocomplete="off" autofocus spellcheck="false   tt-query" -->
                   <input type="text" id="novo_valor_{!!$qual_campo!!}" name="novo_valor_{!!$qual_campo!!}" autofocus class="novo_valor_{!!$qual_campo!!} tt-query"  placeholder="Preencha a Descrição / Nome">
               </div>
         </div>

       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="cancelou('{!!$qual_campo!!}');" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="confirmar_cadastro('{!!$qual_campo!!}, {!!$tabela!!}');" data-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>