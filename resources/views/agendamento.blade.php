<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Agendamento</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    @include('layouts.navbar')
    <div>
        <h2 class="title mt-2"> Agendamento de Consultas</h2>
    </div>
    <hr>
    @if (count($agendamentos) === 0)
        <h4 class="title mt-5"> Você não possui agendamentos </h4>
    @else
        <div>
            <table class="table table-striped-columns mt-5 mb-4">
                <thead>
                    <tr>
                        <td>Deletar</td>
                        <td>Nome</td>
                        <td>Data</td>
                        <td>Telefone</td>
                        <td>Forma de Pagamento</td>
                        <td>Pago?</td>
                        <td>Observações</td>
                        @if($agendamentos->count() > 0)
                        <td>
                        <button class="btn btn-danger" id="bulk_delete" data-toggle="modal" data-target="#bulkModal" disabled>Deletar Todos </button>
                        </td>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td><input type="checkbox" value="{{$agendamento->id}}" name="id"></td>
                            <td>{{ $agendamento->name }}</td>
                            @php
                                $date = explode(' ', $agendamento->date);
                                $expdate = explode('-', $date[0]);
                                $fixdate = $expdate[2] . '/' . $expdate[1] . '/' . $expdate[0];

                            @endphp
                            <td>{{ $fixdate }}</td>
                            <td>{{ $agendamento->cel }}</td>
                            <td>{{ $agendamento->typepayment }}</td>
                            @if ($agendamento->paid == '1')
                                <td>Sim</td>
                            @else
                                <td>Não</td>
                            @endif
                            <td>{{ $agendamento->note }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Default button group">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                        data-bs-target="#editarAgendamento{{ $agendamento->id }}">Editar</button>
                                    <button type="button" class="btn btn-outline-dark disabled" data-bs-toggle="modal"
                                        data-bs-target="#delAgendamento{{ $agendamento->id }}">Excluir</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal Editar Agendamento -->
                        <div class="modal fade" id="editarAgendamento{{ $agendamento->id }}" tabindex="-1"
                            aria-labelledby="editarAgendamentoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="agendamentoLabel">Editar Registro de Agendamento
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('agendamento.edit', ['id' => $agendamento->id]) }}">

                                        @csrf
                                        <div class="modal-body">

                                            <div class="modal-body form-control">

                                                <input class="form-control" type="date" id="editardata"
                                                    value="{{ $agendamento->date }}" name="editarDate">
                                                <br>
                                                <input class="form-control" type="text" id="editarnome"
                                                    value="{{ $agendamento->name }}" name="editarName">
                                                <br>
                                                <input class="form-control" type="text" id="editarcel"
                                                    value="{{ $agendamento->cel }}" name="editarCel">
                                                <br>
                                                <input class="form-control" type="text" id="editartype"
                                                    value="{{ $agendamento->typepayment }}" name="editarType">
                                                <br>
                                                <input class="form-control" type="textarea" id="editarnote"
                                                    value="{{ $agendamento->note }}" name="editarNote">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Salvar</button>
                                                <button type="reset" id="limpar"
                                                    class="btn btn-light">Limpar</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Fim Editar Agendamento -->

                        <!-- Exclui Agendamento-->
                        <div class="modal fade" id="delAgendamento{{ $agendamento->id }}" tabindex="-1"
                            aria-labelledby="delAgendamentoLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title" id="modalDelCategoriasLabel">Têm certeza excluir esta
                                            categoria?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Clique em sim para continuar</div>
                                    <div class="modal-footer">
                                        <a href="<?php echo route('agendamento.remove', ['id' => $agendamento->id]); ?>"><button type="submit"
                                                class="btn btn-danger">Sim</button></a>
                                        <button class="btn btn-secondary" type="button"
                                            data-dismiss="modal">Não</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
    @endif
    </tbody>
    </table>
    </div>

    <!-- Button trigger modal -->

    <div class="btn-group mt-2" role="group" aria-label="Default button group">
        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
            data-bs-target="#cadastraAgendamento">Cadastrar consulta</button>
    </div>

    <!-- Modal Agendamento -->
    <div class="modal fade" id="cadastraAgendamento" tabindex="-1" aria-labelledby="cadastraAgendamentoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastroLabel">Registro de Agendamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {!! Form::open(['route' => 'agendamento.create', 'method' => 'post']) !!}
                @csrf
                <div class="modal-body">

                    <div class="modal-body form-control">

                        <input class="form-control" type="date" id="data" placeholder="Data do agendamento"
                            name="date">
                        <br>
                        <input class="form-control" type="text" id="nome" placeholder="Nome do paciente"
                            name="name">
                        <br>
                        <input class="form-control" type="text" id="cel" placeholder="Telefone"
                            name="cel">
                        <br>
                        <input class="form-control" type="text" id="type" placeholder="Forma de Pagamento"
                            name="type">
                        <br>
                        <input class="form-control" type="textarea" id="note" placeholder="Observações"
                            name="note">

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-dark">Salvar</button>
                        <button type="reset" id="btnlimpar" class="btn btn-light">Limpar</button>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <!-- Fim Cadastro de Agendamento -->
</body>

</html>
