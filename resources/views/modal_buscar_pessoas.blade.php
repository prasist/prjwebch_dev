<div class="modal fade" id="{!!$modal!!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Buscar Pessoas</h4>
          </div>
          <div class="modal-body">

           <div class="row">
              <div class="col-xs-12">
                   <p class="text-info">A pesquisa retornará os 50 primeiros registros. Digite um termo o mais completo possível.</p>
                   <input type="text" name="typeahead[]" class="typeahead tt-query"  autocomplete="off" spellcheck="false" placeholder="Digite o nome ou parte dele...">
             </div>
         </div>

       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="confirmar('{!!$qual_campo!!}');" data-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>