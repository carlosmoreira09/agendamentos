@include('layouts.head')

<body class="antialiased">
    @include('layouts.navbar')
    <div>
        <h2 class="title mt-2"> Agendamento de Consultas</h2>
    </div>
    <hr>
    
    @if($errors->any())
    <div class="alert alert-danger">
        {{$errors->first()}}
    </div>
    @endif

        <!-- Button trigger modal -->

        <div class="btn-group mt-2" role="group" aria-label="Default button group">
            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                data-bs-target="#cadastraAgendamento">Cadastrar consulta</button>
        </div>
    @if (count($agendamentos) === 0)
        <h4 class="title mt-5"> Você não possui agendamentos </h4>
    @else
    


        <div>
            <table class="table table-striped-columns mt-3 mb-4">
                <thead>
                    <tr>
                        <td>Deletar</td>
                        <td>Nome</td>
                        <td>Data</td>
                        <td>Hora</td>
                        <td>Telefone</td>
                        <td>Forma de Pagamento</td>
                        <td>Pago?</td>
                        <td>Observações</td>
                        @if($agendamentos->count() > 1)
                        <td>
                        <button class="btn btn-danger" id="bulk_delete" data-toggle="modal" data-target="#bulkModal" disabled>Deletar Todos </button>
                        </td>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td><input type="checkbox" name="id" id="deletarconsulta"></td>
                            <td>{{ $agendamento->name }}</td>
                            @php
                                $date = explode(' ', $agendamento->date);
                                $expdate = explode('-', $date[0]);
                                $fixdate = $expdate[2] . '/' . $expdate[1] . '/' . $expdate[0];

                            @endphp
                            <td>{{ $fixdate }}</td>
                            <td>{{ $agendamento->hora }}</td>
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
                                    <button type="button" id="confirmardelete" class="btn btn-outline-dark" data-bs-toggle="modal"
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

                                                <label for="editardata">Data da Consulta</label>
                                                <input class="form-control" type="date" id="editardata"
                                                    value="{{ $agendamento->date }}" name="editarDate">
                                                
                                                <br>

                                                <label for="editarHora">Horário da Consulta</label>
                                                <select name="editarHora" id="editarHora">
                                                    <option value="{{$agendamento->hora}}" selected>{{$agendamento->hora}}</option>
                                                    <option value="8:00">8:00</option>
                                                    <option value="8:30">8:30</option>
                                                    <option value="9:00">9:00</option>
                                                    <option value="9:30">9:30</option>
                                                    <option value="10:00">10:00</option>
                                                    <option value="10:30">10:30</option>
                                                    <option value="11:00">11:00</option>
                                                    <option value="11:30">11:30</option>
                                                    <option value="12:00">12:00</option>
                                                    <option value="12:30">12:30</option>
                                                    <option value="13:00">13:00</option>
                                                    <option value="13:30">13:30</option>
                                                    <option value="14:00">14:00</option>
                                                    <option value="14:30">14:30</option>
                                                    <option value="15:00">15:00</option>
                                                    <option value="15:30">15:30</option>
                                                    <option value="16:00">16:00</option>
                                                    <option value="16:30">16:30</option>
                                                    <option value="17:00">17:00</option>
                                                </select>
                                                <br>
                                                 <br>
                                                <label for="editarnome">Nome do Paciente</label>
                                                <input class="form-control" type="text" id="editarnome"
                                                    value="{{ $agendamento->name }}" name="editarName">

                                                <label for="editarcel">Contato</label>
                                                <input class="form-control" type="text" id="editarcel"
                                                    value="{{ $agendamento->cel }}" name="editarCel">

                                                <label for="editartype">Forma de Pagamento</label>
                                                <input class="form-control" type="text" id="editartype"
                                                    value="{{ $agendamento->typepayment }}" name="editarType">
                                                
                                                <label for="editarnote">Observações</label>
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
                                        {{-- <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button> --}}
                                        <button type="button" onclick="quitBox('quit')" class="btn-close" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">Clique em sim para continuar</div>
                                    <div class="modal-footer">
                                        <a href="<?php echo route('agendamento.remove', ['id' => $agendamento->id]); ?>"><button type="submit"
                                                class="btn btn-danger">Sim</button></a>
                                        <button class="btn btn-secondary" onclick="quitBox('quit')" type="button"
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
                        <label for="date">Data da Consulta</label>
                        <input class="form-control" type="date" id="data" name="date">
                        <br>
                        <br>
                        <label for="hora">Hora da Consulta</label>
                        <select name="hora" id="hora">
                            <option>Selecione o Horário</option>
                            <option value="8:00">8:00</option>
                            <option value="8:30">8:30</option>
                            <option value="9:00">9:00</option>
                            <option value="9:30">9:30</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                        </select>
                        <br>
                        <br>
                        <label for="nome">Nome do Paciente</label>
                        <input class="form-control" type="text" id="nome" name="name">
                        
                        <label for="cel">Contato</label>
                        <input class="form-control" type="text" id="cel" name="cel">
                        
                        <label for="birthday">Data de Nascimento</label>
                        <input class="form-control" type="date" id="birthday" name="birthday">
                        
                        <label for="type">Forma de Pagamento</label>
                        <input class="form-control" type="text" id="type" name="type">

                        <label for="note">Observações</label>
                        <input class="form-control" type="textarea" id="note" name="note">

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
