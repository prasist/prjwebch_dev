@extends('principal.master')
@section('content')
<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div id="tour1_visaogeral"></div>
        <div id="tour3_visaogeral"></div>
        <!-- small box -->

        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_pessoas}}</h3>
                <p>Pessoas Cadastradas</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-stalker"></i>
            </div>
            <!--<a href="#" class="small-box-footer">Mais <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$total_membros}}</h3>
                <p>Membros</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-body"></i>
            </div>

        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$total_aniversariantes}}</h3>
                <p>Aniversariantes no mês</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-star-outline"></i>
            </div>
            <a href="{{ url('/relpessoas/aniversariantes/mes')}}" class="small-box-footer">Listar <i class="fa fa-arrow-circle-right"></i></a>

        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div  class="inner">
                <h3>{{$total_aniversariantes_dia}}</h3>
                <p>Aniversariantes Hoje</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-star"></i>
            </div>
             <a href="{{ url('/relpessoas/aniversariantes/dia')}}" class="small-box-footer">Listar <i class="fa fa-arrow-circle-right"></i></a>

        </div>

        <!--<p>Token : {!! \Session::get('token')!!}</p>-->
    </div><!-- ./col -->
</div><!-- /.row -->

<div class="row">
    <div class="col-md-12">

     <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Visão Geral</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget">

                <div class="box-footer no-padding">

                 <div class="row">
                        <div class="col-xs-4">
                          <h4>&nbsp;&nbsp;&nbsp;&nbsp;Pessoas</h4>
                          <ul class="nav nav-stacked">

                                 @foreach($pessoas_tipos as $item)
                                 <li>
                                    <a href="{{ url('/relpessoas/relatorio_pessoas_tipo/' . $item->id . '/tipo') }}">&nbsp;{!! $item->nome !!}
                                        <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-xs-4">
                          <h4>&nbsp;&nbsp;&nbsp;&nbsp;Sexo</h4>
                          <ul class="nav nav-stacked">
                                @foreach($pessoas_sexo as $item)
                                <li>
                                    <a href="{{ url('/relpessoas/relatorio_pessoas_tipo/' . $item->sexo . '/sexo') }}">&nbsp;{!! ($item->sexo=="M" ? "Homens" : "Mulheres") !!}
                                        <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </div>

                        <div class="col-xs-4">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Estado Civil</h4>
                              <ul class="nav nav-stacked">

                                 @foreach($pessoas_estadoscivis as $item)
                                 <li>
                                    <a href="{{ url('/relpessoas/relatorio_pessoas_tipo/' . $item->id . '/estadoscivis') }}">&nbsp;{!! $item->nome !!}
                                        <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-xs-4">
                          <h4>&nbsp;&nbsp;&nbsp;&nbsp;Status</h4>
                          <ul class="nav nav-stacked">

                                 @foreach($pessoas_status as $item)
                                 <li>
                                    <a href="{{ url('/relpessoas/relatorio_pessoas_tipo/' . $item->id . '/status') }}">&nbsp;{!! $item->nome !!}
                                        <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                            <div class="col-xs-4">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Famílias</h4>
                              <ul class="nav nav-stacked">

                                    <li>
                                        <a href="#">&nbsp;Total
                                            <span class="pull-left badge bg-blue">{!! $total_familias !!}</span>
                                        </a>
                                    </li>

                                </ul>
                            </div>


                </div> <!-- end row-->


</div>
</div>
<!-- /.widget-user -->
</div>

<!-- /.col -->
</div>
<!-- /.row -->
</div>

</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->


</div>

</div>

@endsection