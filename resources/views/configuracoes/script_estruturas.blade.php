<script type="text/javascript">

    $(document).ready(function()
    {
        /*Hierarquia do primeiro nivel ao ultimo*/
        /*Quando selecionar item no combo nivel1, carrega combo nivel2 com dados relacionados*/
        $("#nivel1_up").change(function()
        {

            //Pegar codigo, pois conteudo vem "1|EXEMPLO"
            var campo = $("#nivel1_up").val().split('|');

            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel1_up/" + campo[0] + "') !!}";

            $.getJSON(urlRoute, function(data)
            {
                var $stations = $("#nivel2_up"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';

                html += '<option value="0"></option>';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'|' + value +'">' + value + '</option>';
                });


                $stations.append(html);
                //$("#nivel2_up").trigger("change");
            });
        });

        /*Quando selecionar item no combo nivel1, carrega combo nivel2 com dados relacionados*/
        $("#nivel2_up").change(function()
        {

            //Pegar codigo, pois conteudo vem "1|EXEMPLO"
            var campo = $("#nivel2_up").val().split('|');

            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel2_up/" + campo[0] + "') !!}";

            $.getJSON(urlRoute, function(data)
            {
                var $stations = $("#nivel3_up"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';
                html += '<option value="0"></option>';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'|' + value +'">' + value + '</option>';
                });


                $stations.append(html);
                //$("#nivel3_up").trigger("change");
            });
        });


  /*Quando selecionar item no combo nivel1, carrega combo nivel2 com dados relacionados*/
        $("#nivel3_up").change(function()
        {
            //Pegar codigo, pois conteudo vem "1|EXEMPLO"
            var campo = $("#nivel3_up").val().split('|');

            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel3_up/" + campo[0] + "') !!}";

            $.getJSON(urlRoute, function(data)
            {
                var $stations = $("#nivel4_up"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';
                html += '<option value="0"></option>';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'|' + value +'">' + value + '</option>';
                });


                $stations.append(html);
                //$("#nivel4_up").trigger("change");
            });
        });


         /*Quando selecionar item no combo nivel1, carrega combo nivel2 com dados relacionados*/
        $("#nivel4_up").change(function()
        {
            //Pegar codigo, pois conteudo vem "1|EXEMPLO"
            var campo = $("#nivel4_up").val().split('|');

            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel4_up/" + campo[0] + "') !!}";

            $.getJSON(urlRoute, function(data)
            {
                var $stations = $("#nivel5_up"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';
                html += '<option value="0"></option>';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'|' + value +'">' + value + '</option>';
                });


                $stations.append(html);
                //$("#nivel5_up").trigger("change");
            });
        });

       /*Hierarquia inversa, do nivel 5 para baixo*/
       /*Quando selecionar item no combo nivel5, carrega combo nivel4 com dados relacionados*/
        $("#nivel5").change(function()
        {
            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel5/" + $("#nivel5").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {
                var $stations = $("#nivel4"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                html +='<option value=""></option>';

                $stations.append(html);
                $("#nivel4").trigger("change");
            });
        });


        /*Quando selecionar item no combo nivel4, carrega combo nivel3 com dados relacionados*/
        $("#nivel4").change(function()
        {
            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel4/" + $("#nivel4").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#nivel3"); //Instancia o objeto combo nivel3
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                html +='<option value=""></option>';

                $stations.append(html);
                $("#nivel3").trigger("change");
            });
        });

        /*Quando selecionar item no combo nivel3, carrega combo nivel2 com dados relacionados*/
        $("#nivel3").change(function()
        {
            //route para chamada funcao passando ID do nivel 4
            var urlRoute = "{!! url('/nivel3/" + $("#nivel3").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#nivel2"); //Instancia o objeto combo nivel2
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                html +='<option value=""></option>';

                $stations.append(html);
                $("#nivel2").trigger("change");
            });
        });

        /*Quando selecionar item no combo nivel3, carrega combo nivel2 com dados relacionados*/
        $("#nivel2").change(function()
        {
            //route para chamada funcao passando ID do nivel 3
            var urlRoute = "{!! url('/nivel2/" + $("#nivel2").val() + "') !!}";

            $.getJSON(urlRoute, function(data)
            {

                var $stations = $("#nivel1"); //Instancia o objeto combo nivel2
                $stations.empty();

                var html='';

                $.each(data, function(index, value)
                {
                    html += '<option value="' + index +'">' + value + '</option>';
                });

                html +='<option value=""></option>';

                $stations.append(html);
            });
        });

    });
</script>