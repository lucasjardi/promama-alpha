@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Preencha os campos
                        <!-- <a href="{{ url('') }}" class="float-right">Listar Notificações</a> -->
                    </div>

                    <div class="card-body" style="font-size: 18px">
                        @if( Session::has('mensagem_sucesso') )
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ Session::get('mensagem_sucesso') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if( Request::is('*/editar'))
                            {{ Form::model($notificacao, ['method' => 'PATCH', 'url' => 'notificacoes/' . $notificacao->id]) }}
                        @else
                                {!! Form::open(['url' => 'notificacoes/salvar']) !!}
                        @endif
                        
                        {!! Form::label('titulo','Título da notificação') !!}
                        {!! Form::input('text','titulo',null, ['class' => 'form-control', 'placeholder' => 'Título da notificação']) !!}
                        {!! Form::label('texto','Texto da notificação') !!}
                        {!! Form::input('text','texto',null, ['class' => 'form-control', 'placeholder' => 'Texto da notificação']) !!}
                        {!! Form::label('informacao_idadeSemanasInicio','Idade alvo:') !!}

                        <select name="semana" class="form-control" id="caixaIdades">
                            <?php foreach ($idades as $idade): ?>
                                <?php
                                    $selected = null; 
                                    if (Request::is('*/editar')) {
                                        $selected = ($idade->dias == $notificacao->semana) ? "selected=\"selected\"" : null;
                                     } 
                                ?>
                                <option value="<?php echo $idade->dias ?>" <?php echo $selected ?> ><?php echo $idade->idade ?></option>
                            <?php endforeach ?>
                        </select>

                        {!! "<br>" !!}
                        
                        {!! "<div class= 'checkbox'>" !!}
                        {!! "<label>" !!}

                        <?php 
                        $checked = null; 
                        if(isset($notificacao)) 
                            if($notificacao->semana == -1) {
                                $checked = 'checked';

                                echo "<script>document.getElementById('caixaIdades').disabled = true;</script>";

                            }
                        ?>
                        
                        {!! Form::input('checkbox','notificacoesAgora',null,['id' => 'cbNotificar', $checked]) !!}
                        {!! "Notificar o quanto antes" !!}
                        {!! "</label>" !!}
                        {!! "</div>" !!}

                        {!! "<br>" !!}
                        {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('cbNotificar').addEventListener("click", function () {
            document.getElementById('caixaIdades').disabled = document.getElementById('cbNotificar').checked;
        });

    	document.getElementById('labelNotificar').addEventListener("click", function () {
    		document.getElementById('cbNotificar').checked = !document.getElementById('cbNotificar').checked;
    		document.getElementById('caixaIdades').disabled = document.getElementById('cbNotificar').checked;
    	});
    </script>
@endsection