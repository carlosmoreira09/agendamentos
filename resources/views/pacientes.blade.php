@include('layouts.head')

<body class="antialiased">
    @include('layouts.navbar')
    <div>
        <h2 class="title mt-2"> Lista de Pacientes</h2>
    </div>

    <table class="table table-striped-columns mt-3 mb-4">

        <thead>
            <tr>
                <td>Nome</td>
                <td>Aniversário</td>
                <td>Ultíma Consulta</td>
                <td>Contato</td>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $paciente)
            @php
            $date = explode(' ', $paciente->birthday);
            $expdate = explode('-', $date[0]);
            $fixdate = $expdate[2] . '/' . $expdate[1] . '/' . $expdate[0];

            $date2 = explode(' ', $paciente->ultimaconsulta);
            $expdate2 = explode('-', $date2[0]);
            $fixdate2 = $expdate2[2] . '/' . $expdate2[1] . '/' . $expdate2[0];

            
        @endphp
            <tr>
                <td>{{$paciente->name}}</td>
                <td>{{$fixdate}}</td>
                <td>{{$fixdate2}}</td>
                <td>{{$paciente->celphone}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Default button group">
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#editarpaciente{{ $paciente->idpaciente }}">Editar</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                            data-bs-target="#delpaciente{{ $paciente->idpaciente }}">Excluir</button>
                    </div>
                </td>
            </tr>

            
                        <!-- Modal Editar Paciente -->
                        <div class="modal fade" id="editarpaciente{{ $paciente->idpaciente }}" tabindex="-1"
                            aria-labelledby="editarpacienteLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pacienteLabel">Editar Registro de paciente
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('paciente.edit', ['id' => $paciente->idpaciente]) }}">

                                        @csrf
                                        <div class="modal-body">

                                            <div class="modal-body form-control">

                                                <label for="editarnome">Nome</label>
                                                <input class="form-control" type="text" id="editarnome"
                                                    value="{{ $paciente->name }}" name="editarName">

                                                <label for="editarcel">Contato</label>
                                                <input class="form-control" type="text" id="editarcel"
                                                    value="{{ $paciente->celphone }}" name="editarCel">
                                                <br>
                                                <input class="form-control" type="text" id="editarbirthday"
                                                    value="{{ $fixdate }}" name="editarbirthday">
                                                <br>
                                                <input class="form-control" type="textarea" id="editarultima"
                                                    value="{{ $fixdate2 }}" name="editarultima">

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
                        <!-- Fim Editar paciente -->

                        <!-- Exclui paciente-->
                        <div class="modal fade" id="delpaciente{{ $paciente->idpaciente }}" tabindex="-1"
                            aria-labelledby="delpacienteLabel" aria-hidden="true">
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
                                        <a href="<?php echo route('paciente.remove', ['id' => $paciente->idpaciente]); ?>"><button type="submit"
                                                class="btn btn-danger">Sim</button></a>
                                        <button class="btn btn-secondary" type="button"
                                            data-dismiss="modal">Não</button>

                                    </div>
                                </div>

                            </div>
                        </div>
            @endforeach
        </tbody>       

    </table>

</body>
</html>